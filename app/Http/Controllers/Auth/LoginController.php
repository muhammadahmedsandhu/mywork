<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_verified) {
            auth()->logout();
            return redirect()->back()->with(session()->flash('alert-danger', 'Your account is not verified. Please check your email for verification link.'));
        }
        if ($user->is_blocked) {
            auth()->logout();
            return redirect()->back()->with(session()->flash('alert-danger', 'Your account is blocked. Please contact site admin.'));
        }
        return redirect()->intended($this->redirectPath());
    }
}
