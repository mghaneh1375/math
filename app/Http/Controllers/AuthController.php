<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistryRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login() {
        if(Auth::check())
            return redirect()->route('root');

        return view('auth.login');
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

    // public function doActive() {

    //     if(myPostIsset("uId") && myPostIsset("phone") && myPostIsset("code")) {

    //         $phoneNum = makeValidInput($_POST["phone"]);

    //         if (strlen($phoneNum) == 10)
    //             $phoneNum = '0' . $phoneNum;

    //         $phoneNum = translatePersian($phoneNum);

    //         $activation = Activation::wherePhone($phoneNum)->first();

    //         $uId = makeValidInput($_POST["uId"]);
    //         $code = makeValidInput($_POST["code"]);

    //         if ($activation != null) {

    //             if($activation->code == $code) {
    //                 $user = User::whereId($uId);

    //                 if ($user != null && $user->phone == $phoneNum) {
    //                     $activation->delete();
    //                     $user->status = 3;
    //                     $user->save();

    //                     Auth::login($user);
    //                     return Redirect::route('home');
    //                 }
    //             }

    //             return view("login", ["status" => "step", "phone" => $phoneNum,
    //                 'uId' => $uId, 'err' => "کد وارد شده نامعتبر است.",
    //                 'reminder' => 300 - time() + $activation->send_time
    //             ]);
    //         }

    //     }

    //     return Redirect::route('login');
    // }

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

        if(myPostIsset("firstname") && myPostIsset("username") && myPostIsset("phone") &&
            myPostIsset("address") && myPostIsset("password") && myPostIsset("rpassword") &&
            myPostIsset("lastname")
        ) {

            $nid = makeValidInput($_POST["username"]);
            $firstname = makeValidInput($_POST["firstname"]);
            $lastname = makeValidInput($_POST["lastname"]);
            $address = makeValidInput($_POST["address"]);
            $phone = translatePersian(makeValidInput($_POST["phone"]));

            if(!_custom_check_national_code($nid))
                return view('login', ['status' => 'err', 'err' => 'کد ملی وارد شده نامعتبر است.',
                    'firstname' => $firstname, 'lastname' => $lastname, 'address' => $address,
                    'username' => $nid, 'phone' => $phone
                ]);

            if(User::whereUsername($nid)->count() > 0)
                return view('login', ['status' => 'err', 'err' => 'کد ملی وارد شده در سامانه موجود است.',
                    'firstname' => $firstname, 'lastname' => $lastname, 'address' => $address,
                    'username' => $nid, 'phone' => $phone
                ]);

            if(User::wherePhone($phone)->count() > 0)
                return view('login', ['status' => 'err', 'err' => 'شماره همراه وارد شده در سامانه موجود است.',
                    'firstname' => $firstname, 'lastname' => $lastname, 'address' => $address,
                    'username' => $nid, 'phone' => $phone
                ]);

            $password = makeValidInput($_POST["password"]);
            $rpassword = makeValidInput($_POST["rpassword"]);

            if($password != $rpassword) {
                return view('login', ['status' => 'err', 'err' => 'رمزعبور و تکرار آن یکسان نیست.',
                    'firstname' => $firstname, 'lastname' => $lastname, 'address' => $address,
                    'username' => $nid, 'phone' => $phone
                ]);
            }

            $tmp = new User();
            $tmp->level = 2;
            $tmp->username = $nid;
            $tmp->status = 1;
            $tmp->first_name = $firstname;
            $tmp->last_name = $lastname;
            $tmp->address = $address;
            $tmp->phone = $phone;
            $tmp->password = Hash::make($password);
            $tmp->save();

            $activation = new Activation();
            $activationCode = generateActivationCode();
            $activation->code = $activationCode;
            $activation->phone = $phone;
            $activation->send_time = time();
            $activation->save();

            sendSMS($phone, $activationCode, "registry");

            return view('login', ['status' => 'step', 'uId' => $tmp->id, 'phone' => $phone, 'reminder' => 300]);
        }

        return view('login', ['status' => 'err', 'err' => 'لطفا تمام اطلاعات لازم را وارد نمایید.']);
    }
}
