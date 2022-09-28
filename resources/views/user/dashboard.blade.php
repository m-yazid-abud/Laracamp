@extends('layouts.front')

@section('title', 'Dashboard User')

@section('content')
    <section class="dashboard my-5">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            <div class="row my-5">
                <table class="table">
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="align-middle">
                                <td width="18%">
                                    <img src="{{ Vite::asset('resources/images/item_bootcamp.png') }}" height="120"
                                        alt="bootcamp preview">
                                </td>
                                <td>
                                    <p class=" mb-2 ">
                                        <strong>{{ $order->camp->title }}</strong>
                                    </p>
                                    <p>
                                        {{ date('F d, Y', strtotime($order->date)) }}
                                    </p>
                                </td>
                                <td>
                                    <strong>${{ $order->camp->price }},000</strong>
                                </td>
                                <td>
                                    <strong><span class="{{ $order->is_paid ? 'text-green' : 'black' }}">
                                            @if ($order->is_paid)
                                                Payment Success
                                            @else
                                                Waiting for payment
                                            @endif
                                        </span></strong>
                                </td>
                                <td>
                                    <a href="# " class="btn btn-primary ">
                                        Get Invoice
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5"><strong>Tidak ada data</strong></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
