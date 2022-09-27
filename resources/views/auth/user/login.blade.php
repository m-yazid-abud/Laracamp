@extends('layouts.front')

@section('title', 'Login Page Laracamp')

@section('content')
    <section class="login-user">
        <div class="left">
            <img src="{{ Vite::asset('resources/images/ill_login_new.png') }}" alt="">
        </div>
        <div class="right">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" class="logo" alt="">
            <h1 class="header-third">
                Start Today
            </h1>
            <p class="subheader">
                Because tomorrow become never
            </p>
            <p>
                <a class="btn btn-border btn-google-login" href="{{ route('login.user.google') }}">
                    <img src="{{ Vite::asset('resources/images/ic_google.svg') }}" class="icon" alt=""> Sign In
                    with Google
                </a>
            </p>
            <img src="{{ Vite::asset('resources/images/people.png') }}" class="people" alt="">
        </div>
    </section>
@endsection
