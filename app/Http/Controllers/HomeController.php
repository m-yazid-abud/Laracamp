<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        switch (Auth::user()->is_admin) {
            case true:
                return to_route('admin.dashboard');
                break;

            case false:
                return to_route("user.dashboard");
                break;
        }
    }
}
