<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'phone_number';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function username()
    {
        return 'phone_number';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            $user->password_attempt_granted = 3;
            $user->save();
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && !$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        $user = User::where('username', '=', $request->username)->first();
        if ($user) {
            $user->password_attempt_granted = $user->password_attempt_granted - 1;
            $user->save();
            if ($user->password_attempt_granted == 0) {
                $user->actived = 0;
                $user->save();
                $user->logs()->save(new \App\UserLog(['log' => 'Lock by login attempt']));
                flash()->overlay('ID Anda telah terblokir, silahkan melakukan reset password pada website jaringan www.sipindonesia.com');
            } else {
                flash()->overlay('Username atau password Anda salah. Anda memiliki ' . $user->password_attempt_granted . ' kali kesempatan lagi.');
            }
        }
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showLoginForm()
    {
        return view('auth.phone-number-login');
    }

    public function getOtp(Request $request)
    {
        $phoneNumber = $request->phone_number;
        $client = new Client();
        $response = $client->get('https://api.smartinpays.com/otp/login?phone_number=' . $phoneNumber, [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'app-version' => '1.0',
                'Locale' => 'id',
                'Lat' => 0,
                'Lng' => 0,
                'Device-Type' => 'web',
                'Device-Model' => 'browser',
                'Device-OS-version' => 'browser',
                'Device-ID' => 'browser',
                'Device-Manufacture' => 'browser'
            ]
        ]);
        if ($response->getStatusCode() === 201) {
            return view('pages.data-verification-otp', compact('phoneNumber'));
        }
        flash()->overlay('Nomor Anda tidak terdaftar. Silahkan lakukan verifikasi data member terlebih dahulu.', 'INFO');
        return redirect()->back()->withInput();
    }
}
