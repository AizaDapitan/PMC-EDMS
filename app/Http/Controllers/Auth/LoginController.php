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

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return auth()->check() ? redirect()->route('home') : view('auth.login');
    }

    public function login(Request $request)
    {
        $checker = auth()->attempt([
            'username' => $request->username,
            'password' => $request->password,
            'active'   => 1,
            'locked'   => 0
        ]);
        if ($checker) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors('Invalid login credentials.');
        }
    }
    public function logout()
    {
        return auth()->logout() ?? redirect()->route('login');
    }
}
