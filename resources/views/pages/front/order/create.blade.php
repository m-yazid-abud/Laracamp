@extends('layouts.front')

@section('title', 'Checkout Page Laracamp')

@section('content')
    <section class="checkout">
        <div class="row text-center pb-70">
            <div class="col-lg-12 col-12 header-wrap">
                <p class="story">
                    YOUR FUTURE CAREER
                </p>
                <h2 class="primary-header">
                    Start Invest Today
                </h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12">
                <div class="row">
                    <div class="col-lg-5 col-12">
                        <div class="item-bootcamp">
                            <img src="{{ Vite::asset('resources/images/item_bootcamp.png') }}" alt=""
                                class="cover">
                            <h1 class="package text-uppercase">
                                {{ $camp->title }}
                            </h1>
                            <p class="description">
                                Bootcamp ini akan mengajak Anda untuk belajar penuh mulai dari pengenalan dasar sampai
                                membangun sebuah projek asli
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-1 col-12"></div>
                    <div class="col-lg-6 col-12">
                        <form action="{{ route('order.store', $camp->id) }}" class="basic-form" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control {{ $errors->has('namee') ? 'is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name', Auth()->user()->name) }}">

                                @if ($errors->has('name'))
                                    @foreach ($errors->get('name') as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control  {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email" name="email" value="{{ old('email', Auth()->user()->email) }}">

                                @if ($errors->has('email'))
                                    @foreach ($errors->get('email') as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="occupation" class="form-label">Occupation</label>
                                <input type="text"
                                    class="form-control {{ $errors->has('occupation') ? 'is-invalid' : '' }} "
                                    id="occupation" name="occupation" value="{{ old('occupation') }}">

                                @if ($errors->has('occupation'))
                                    @foreach ($errors->get('occupation') as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>

                            {{-- <div class="mb-4">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="number"
                                    class="form-control {{ $errors->has('card_number') ? 'is-invalid' : '' }}"
                                    id="card_number" name="card_number" value="{{ old('card_number') }}">

                                @if ($errors->has('card_number'))
                                    @foreach ($errors->get('card_number') as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div> --}}

                            {{-- <div class="mb-5">
                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <label for="expired" class="form-label">Expired</label>
                                        <input type="month"
                                            class="form-control {{ $errors->has('expired') ? 'is-invalid' : '' }}"
                                            id="expired" name="expired" value="{{ old('expired') }}">

                                        @if ($errors->has('expired'))
                                            @foreach ($errors->get('expired') as $error)
                                                <p class="text-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="number"
                                            class="form-control {{ $errors->has('cvc') ? 'is-invalid' : '' }}"
                                            id="cvc" name="cvc" value="{{ old('cvc') }}" maxlength="3">

                                        @if ($errors->has('cvc'))
                                            @foreach ($errors->get('cvc') as $error)
                                                <p class="text-danger">{{ $error }}</p>
                                            @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div> --}}
                            <button type="submit" class="w-100 btn btn-primary">Pay Now</button>
                            <p class="text-center subheader mt-4">
                                <img src="{{ Vite::asset('resources/images/ic_secure.svg') }}" alt=""> Your
                                payment is secure and
                                encrypted.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
