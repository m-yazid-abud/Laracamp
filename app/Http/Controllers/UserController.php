<?php

namespace App\Http\Controllers;

use App\Mail\User\AfterRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $data = [
            "email" => $googleUser->getEmail(),
            "name" => $googleUser->getName(),
            "email_verified_at" => Date('Y-m-d H:i:s', time()),
            "avatar" => $googleUser->getAvatar(),
        ];

        $user = User::whereEmail($data['email'])->first();

        if (!$user) {
            $user = User::create($data);
            Mail::to($data['email'])->send(new AfterRegister($user));
        }

        Auth::login($user);

        return to_route("index");
    }
}
