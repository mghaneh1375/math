<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    
    public function buy(Course $course, Request $request) {
        dd("dwq");
        $user = $request->user();

        $response = zarinpal()
            ->amount($course->price)
            ->request()
            ->description($course->title)
            ->callbackUrl(route('completePayment'))
            ->mobile($user->username)
            ->email('')
            ->send();

            dd($response);
        if (! $response->success()) {
            return $response->error()->message();
        }

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $user->id;
        $transaction->course_id = $course->id;
        $transaction->tracking_code = rand(1000000, 9999999);
        $transaction->status = TransactionStatus::INIT->name;
        $transaction->save();
        
        return $response->redirect();
    }

    public function completePayment(Request $request) {

    }
}
