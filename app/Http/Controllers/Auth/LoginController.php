<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use auth;
use Session;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function mainLogin(){

        return view('layouts.login');
    }

    public function username()
    {
    return 'userId';
    }

//    public function logout(Request $request)
//    {
//        $this->performLogout($request);
//        return redirect()->route('/');
//    }




//    public function login(\Illuminate\Http\Request $request) {
//
//        // If the class is using the ThrottlesLogins trait, we can automatically throttle
//        // the login attempts for this application. We'll key this by the username and
//        // the IP address of the client making these requests into this application.
//        if ($this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//            return $this->sendLockoutResponse($request);
//        }
//
//
//        // This section is the only change
//        if ($this->guard()->validate($this->credentials($request))) {
//            $user = $this->guard()->getLastAttempted();
//
//
//           // $type=strtoupper(Auth::user()->userType->typeName);
//            //return $user;
//            // Make sure the user is active
//            if ($user->active && $this->attemptLogin($request)) {
//                // Send the normal successful login response
//                $type=strtoupper(Auth::user()->userType->typeName);
//                Session::put('userType',$type);
//                $ip = \Request::ip();
//                if ($ip != "::1" ) {
//                    return $this->sendLoginResponse($request);
//                }elseif($type == "ADMIN" && $ip != "::1") {
//                    return $this->sendLoginResponse($request);
//                }
//                else{
//                    return "cvcvcvc";
//                    $this->incrementLoginAttempts($request);
//                    return redirect()
//                        ->back()
//                        ->withInput($request->only($this->username(), 'remember'))
//                        ->withErrors(['active' => 'You must be active to login.']);
//                }
//            } else {
//                // Increment the failed login attempts and redirect back to the
//                // login form with an error message.
//                $this->incrementLoginAttempts($request);
//                return redirect()
//                    ->back()
//                    ->withInput($request->only($this->username(), 'remember'))
//                    ->withErrors(['active' => 'You must be active to login.']);
//            }
//        }
//
//        // If the login attempt was unsuccessful we will increment the number of attempts
//        // to login and redirect the user back to the login form. Of course, when this
//        // user surpasses their maximum number of attempts they will get locked out.
//        $this->incrementLoginAttempts($request);
//
//        return $this->sendFailedLoginResponse($request);
//    }
    public function login(\Illuminate\Http\Request $request) {

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }





        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            $ip = \Request::ip();
//            if ((substr($ip,0,8) == "192.168.") || ($ip == "127.0.0.1")) {
//                // client is local
//            } else {
//                // client is not local
//            }
//

            if (substr($ip,0,8) == "192.168." || $ip == "::1") {

                if ($user->active && $this->attemptLogin($request)) {
                    // Send the normal successful login response
                    $type = strtoupper(Auth::user()->userType->typeName);
                    Session::put('userType', $type);
                    return $this->sendLoginResponse($request);
                } else {
                    // Increment the failed login attempts and redirect back to the
                    // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors(['active' => 'You must be active to login.']);
                }


                return $this->sendLoginResponse($request);
            } elseif ($user->typeId == "1" && substr($ip,0,8) != "192.168.") {

                if ($user->active && $this->attemptLogin($request)) {
                    // Send the normal successful login response
                    $type = strtoupper(Auth::user()->userType->typeName);
                    Session::put('userType', $type);
                    return $this->sendLoginResponse($request);
                } else {
                    // Increment the failed login attempts and redirect back to the
                    // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors(['active' => 'You must be active to login.']);
                }

            }elseif ($user->typeId == "2" && substr($ip,0,8) != "192.168."){

                if ($user->active && $this->attemptLogin($request)) {
                    // Send the normal successful login response
                    $type = strtoupper(Auth::user()->userType->typeName);
                    Session::put('userType', $type);
                    return $this->sendLoginResponse($request);
                } else {
                    // Increment the failed login attempts and redirect back to the
                    // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors(['active' => 'You must be active to login.']);
                }
            }elseif ($user->typeId == "3" && substr($ip,0,8) != "192.168."){
                if ($user->active && $this->attemptLogin($request)) {
                    // Send the normal successful login response
                    $type = strtoupper(Auth::user()->userType->typeName);
                    Session::put('userType', $type);
                    return $this->sendLoginResponse($request);
                } else {
                    // Increment the failed login attempts and redirect back to the
                    // login form with an error message.
                    $this->incrementLoginAttempts($request);
                    return redirect()
                        ->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors(['active' => 'You must be active to login.']);
                }
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            //$this->sendFailedLoginResponse($request);
        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors(['userId' => 'Permission Denied']);
    }



}