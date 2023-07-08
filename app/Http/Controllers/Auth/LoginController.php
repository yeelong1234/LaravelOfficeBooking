<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enum\UserRoleEnum;
use Illuminate\Support\Facades\Route;
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
    protected function redirectTo() {

        if (Auth::user()->role == UserRoleEnum::User) {
            return '/home';
        } else {
            return '/admin';
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('auth/login');
    }

    public function userLogin(Request $request){
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|password|min:6',
        ]); 

        if(Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            if(Auth::user()->role == UserRoleEnum::Admin){
                return Route::permanentRedirect('/login','/admin');
            }
            else{
                return Route::permanentRedirect('/login','/home');
            }
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
