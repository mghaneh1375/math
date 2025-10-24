<?php

namespace App\Http\Controllers;

use App\Enums\AccountStatus;
use App\Enums\UserLevel;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivateAccountRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistryRequest;
use App\Models\Activation;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login() {
        if(Auth::check())
            return redirect()->route('root');

        return view('auth.login');
    }

    public function register() {
        if(Auth::check())
            return redirect()->route('root');

        return view('auth.register', ['grades' => Grade::all()]);
    }

    public function doLogin(LoginRequest $request) {
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password], true)) {

            if(Auth::user()->status != 'ACTIVE') {
                $msg = "حساب کاربری شما هنوز فعال نشده است";
                Auth::logout();
                return view('login', array('loginErr' => $msg));
            }

            return redirect()->route('root');
        }
        else {
            $msg = 'نام کاربری و یا رمزعبور اشتباه است';
        }

        return view('auth.login', array('loginErr' => $msg));
    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return redirect()->route('root');
    }

    // public function resendActivation() {

    //     if(myPostIsset("uId") && myPostIsset("phone")) {
    //         $phoneNum = makeValidInput($_POST["phone"]);

    //         if (strlen($phoneNum) == 10)
    //             $phoneNum = '0' . $phoneNum;

    //         $phoneNum = translatePersian($phoneNum);

    //         $activation = Activation::wherePhone($phoneNum)->first();

    //         $uId = makeValidInput($_POST["uId"]);

    //         if ($activation != null) {

    //             if ($activation->send_time >= time() - 300)
    //                 return view("login", ["status" => "step", "phone" => $phoneNum,
    //                     'uId' => $uId,
    //                     'reminder' => 300 - time() + $activation->send_time
    //                 ]);

    //             sendSMS($phoneNum, $activation->code, "registry");

    //             $activation->send_time = time();
    //             $activation->save();

    //             return view("login", ["status" => "step", "phone" => $phoneNum,
    //                 'uId' => $uId, 'reminder' => 300]);
    //         }
    //     }

    //     return Redirect::route('login');
    // }
    
    public function forgetPass(ForgetPasswordRequest $request) {

        $user = User::whereUsername($request['username'])->first();

        if($user == null)
            return view('auth.forget', ['err' => 'شماره همراه وارد شده نامعتبر است.']);

        $newPass = generateActivationCode();

        $user->password = Hash::make($newPass);
        $user->save();

        sendSMS($user->phone, $user->last_name, 'resetPass', $newPass);

        return view('login', ['status' => 'forget', 'err' => 'رمزعبور جدید برای شماره همراه وارد شده، پیامک شد.']);
    }
    
    public function registry(RegistryRequest $request) {

        $user = User::whereUsername($request['username'])->first();
        if($user != null && $user->status !== AccountStatus::PENDING->name) {
            return redirect()
                ->back()
                ->withErrors(['username' => 'این شماره قبلاً ثبت شده است.'])
                ->withInput();
        }
        if($user == null) {
            $user = new User();
            $user->level = UserLevel::STUDENT->name;
            $user->username = $request->username;
            $user->status = AccountStatus::PENDING->name;
        }
        
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->grade_id = $request->grade_id;
        $user->school_name = $request->school_name;
        
        $user->password = Hash::make($request->password);
        $user->save();

        $activation = Activation::whereUserId($user->id)->first();
        if($activation == null || Carbon::parse($activation->expire_at)->isPast()) {
            if($activation != null)
                $activation->delete();
            $activation = new Activation();
            $activationCode = generateActivationCode();
            $activation->user_id = $user->id;
            $activation->code = $activationCode;
            $activation->expire_at = Carbon::now()->addMinutes(2);
            $activation->token = Str::random(30);
            $activation->save();
            
            sendSMS($request['username'], $activationCode, "registry");
        }
        
        return redirect()->route('activate_account', ['activation' => $activation->id]);
    }

    public function activate(Activation $activation) {
        return view('auth.activation', [
            'token' => $activation->token,
            'reminder' => now()->diffInSeconds(Carbon::parse($activation->expire_at), false),
            'id' => $activation->id
        ]);
    }
    
    public function doActivate(ActivateAccountRequest $request, Activation $activation) {

        if($activation->token != $request['token'])
            abort(403);

        if($activation->code != $request['code'])
            return redirect()
                ->back()
                ->withErrors(['code' => 'کد وارد شده، نامعتبر است.'])
                ->withInput();

        if (Carbon::parse($activation->expire_at)->isPast()) {
            return redirect()
                ->back()
                ->withErrors(['code' => 'کد قبلی منقضی شده است.'])
                ->withInput();
        }
         
        $user = $activation->user;
        $activation->delete();
        $user->status = AccountStatus::ACTIVE->name;
        $user->save();

        Auth::login($user);
        return redirect()->route('root');
    }
}
