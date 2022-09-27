<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.user.login');
    }

    public function handleGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleLoginRedirect()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            [
                "email" => $googleUser->getEmail(),
            ],
            [
                "name" => $googleUser->getName(),
                "email_verified_at" => Date('Y-m-d H:i:s', time()),
                "avatar" => $googleUser->getAvatar(),
            ]
        );

        Auth::login($user);

        return to_route("index");
    }
}
