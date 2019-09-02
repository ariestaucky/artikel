<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use File;

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

    /**S
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Check either username or email.
     * @return string
     */
    public function username()
    {
        return 'username';
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
            $this->username() => [trans('auth.failed')],
        ])->redirectTo('login');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
                        // ->fields(['name', 'first_name', 'last_name', 'email'])
                        // ->scopes(['email'])
                        ->redirect();
    }
    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        if($provider == 'facebook') {
            $driver = Socialite::driver($provider)
                            ->fields(['first_name', 'last_name', 'email', 'name']);
            $user = $driver->user();
            
            $authUser = $this->findOrCreateUser($user, $provider);
            
            if(!empty($authUser->password)) {
                Auth::login($authUser, true);
                return redirect('/dashboard');
            } else {
                Auth::loginUsingId($authUser->id, true);
                return redirect()->route('social');
            }
            
        } else {
            $driver = Socialite::driver($provider);
            $user = $driver->user();
            
            $authUser = $this->findOrCreateUser($user, $provider);dd($user, $driver);
            
            if(!empty($authUser->password)) {
                Auth::login($authUser, true);
                return redirect('/dashboard');
            } else {
                Auth::loginUsingId($authUser->id, true);
                return redirect()->route('social');
            }
            
        }

    }
    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)
                        ->first();dd($user);
        
        if ($authUser) {
            if(empty($authUser->provider_id)) {
                $authUser->provider = $provider;
                $authUser->provider_id = $User->id;
                $authUser->save();
            }
            return $authUser;
        }
        else{
            $newuser = new User;
            $newuser->name = $user->name;
            $newuser->email = !empty($user->user['email'])? $user->user['email'] : '' ;
            $newuser->city  = !empty($user->user['location']['name'])? $user->user['location']['name'] : '';
            $newuser->provider = $provider;
            $newuser->provider_id = $user->id;
            $newuser->username = "user_".trim(strtolower($user->user['first_name'])).trim(substr($user->id, 0,4));
            if(!empty($user->avatar)) {
                $fileContent = file_get_contents($user->avatar);
                $fileNameToStore = "avatar_".trim(strtolower($user->user['first_name'])).trim(substr($user->id, 0,4)) . ".jpg";
                File::put(public_path() . '/public/cover_images/' . $fileNameToStore, $fileContent);
                
                $newuser->profile_image = ("avatar_".trim(strtolower($user->user['first_name'])).trim(substr($user->id, 0,4)) . ".jpg");
            } else {
                $newuser->profile_image = 'default.jpg';
            }
            $newuser->save();

            return $newuser;
        }
        
    }

}
