<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GoogleSocialiteController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $user = User::where('social_id', $user->id)->first();

            if ($user) {

                Auth::login($user);

                return redirect()->to('students');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id' => $user->id,
                    'social_type' => 'google',
                    'password' => encrypt('my-google')
                ]);

                Auth::login($newUser);

                return redirect()->to('students');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return "Logout Successful";
    }
}
