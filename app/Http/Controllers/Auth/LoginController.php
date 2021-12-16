<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Auth;
use Exception;
use App\User;
use Hash;

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
        $this->middleware('guest')->except('logout','lockscreen','unlock');
    }

    public function handleGoogleCallback() {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/home');
            } else {
                $newUser = User::create(['name' => $user->name, 'email' => $user->email, 'google_id' => $user->id]);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
        catch(Exception $e) {
            return redirect('auth/google');
        }
    }
    

   /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'username' => [trans('auth.failed')],
        ]);
    }

     /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $login = request()->input('username');
        if(is_numeric($login)){
            $field = 'phone';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        request()->merge([$field => $login]);
        return $field;
    }

    public function lockscreen()
    {
        if(Auth::check()){
            \Session::put('locked', true);
            \Session::put('uri', url()->previous());
            return view('auth.lockscreen');
        }
        return redirect('/login');
    }
    

    public function unlock(Request $request)
    {
    
        $password = $request->password;
        $this->validate($request, [
            'password' => 'required|string',
        ]);
    
        if(\Hash::check($password, \Auth::user()->password)){
            $uri = $request->session()->get('uri');
            $request->session()->forget(['locked', 'uri']);
            return redirect()->route('dashboard')->with(['success' => 'Unlocked successfully!']);
        }
        return back()->withErrors('Password does not match. Please try again.');
    }

    

}
