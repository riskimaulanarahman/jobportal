<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        //
    }

    public function logout(Request $request)
    {
        // Clear session data from the database
        DB::table('sessions')->where('user_id', auth()->id())->delete();

        // Log out the user
        $this->guard()->logout();

        $request->session()->forget('remember_token');
        
        $request->session()->invalidate();

        return redirect()->intended($this->redirectTo);

    }

    // public function logout(Request $request)
    // {
    //     $this->guard()->logout();

    //     $request->session()->invalidate();

    //     return redirect($this->redirectTo);
    // }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}