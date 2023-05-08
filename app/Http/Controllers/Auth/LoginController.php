<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function proceedLogin(Request $request)
    {
        $this->validate($request, [
            'contact'   => 'required',
            'password' => 'required|min:6'
        ]);

        if(Str::contains($request->contact,"@")){
            return $this->proceedEmail($request);
        }else{
            return $this->proceedPhone($request);
        }
    }

    private function proceedEmail(Request $request)
    {
        if (Auth::attempt(
            [
                'email' => $request->contact,
                'password' => $request->password
            ],
            $request->get('remember')
        )) {
            return redirect()->intended('/home');
        } else {
            return redirect('login')->withErrors([
                'error' => 'Email Atau Password Salah (Email)'
            ])->withInput($request->only('contact'));
        }
    }

    private function proceedPhone(Request $request)
    {
        if (Auth::attempt(
            [
                'contact' => $request->contact,
                'password' => $request->password
            ],
            $request->get('remember')
        )) {
            return redirect()->intended('/home');
        } else {
            return redirect('login')->withErrors([
                'error' => 'Nomor Telepon Atau Password Salah'
            ])->withInput($request->only('contact'));
        }
    }

}
