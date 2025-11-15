<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    
    public function buy(Course $course, Request $request) {
        $user = $request->user();

        $response = zarinpal()
            ->amount($course->price)
            ->request()
            ->description($course->title)
            ->callbackUrl(route('completePayment'))
            ->mobile($user->username)
            ->email('')
            ->send();

        if (! $response->success()) {
            return $response->error()->message();
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $user->id;
        $transaction->course_id = $course->id;
        $transaction->tracking_code = $response->authority();
        $transaction->status = TransactionStatus::INIT->name;
        $transaction->save();
        
        return $response->redirect();
    }

    public function completePayment(Request $request) {
        $authority = request()->query('Authority'); 
        $status = request()->query('Status');

        if ($status != 'OK') {
            return view('public.result', [
                'status' => 'failed',
                'message' => 'پرداخت ناموفق بود. در صورت کسر وجه، طی ۷۲ ساعت بازگشت داده می‌شود.',
                'ref_id' => null
            ]);
        }

        $transaction = Transaction::where('tracking_code', $authority)->first();
        if (!$transaction) {
            Log::error("اطلاعات پرداخت یافت نشد");
            return view('public.result', [
                'status' => 'failed',
                'message' => 'پرداخت ناموفق بود. در صورت کسر وجه، طی ۷۲ ساعت بازگشت داده می‌شود.',
                'ref_id' => null
            ]);
        }

        $response = zarinpal()
            ->amount($transaction->amount)
            ->verification()
            ->authority($authority)
            ->send();

        if (! $response->success()) {
            Log::error($response->error()->message());
            return view('public.result', [
                'status' => 'failed',
                'message' => 'پرداخت ناموفق بود. در صورت کسر وجه، طی ۷۲ ساعت بازگشت داده می‌شود.',
                'ref_id' => null
            ]);
        }

        $transaction->update([
            'ref_id' => $response->referenceId(),
        ]);

        $purchase = new Purchase();
        $purchase->user_id = $transaction->user_id;
        $purchase->course_id = $transaction->course_id;
        $purchase->paid_amount = $transaction->amount;
        $purchase->paid_at = Carbon::now();
        $purchase->save();

        return view('public.result', [
            'status' => 'success',
            'message' => 'پرداخت با موفقیت انجام شد.',
            'ref_id' => $response['RefID']
        ]);
    }
}
