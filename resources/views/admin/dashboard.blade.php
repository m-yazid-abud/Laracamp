@extends('layouts.front')

@section('title', 'Dashboard User')

@section('content')
    <section class="dashboard my-5">
        <div class="container">
            @include('components.alert')
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
                    <thead>

                        <tr>
                            <th>User Name</th>
                            <th>Camp Title</th>
                            <th>Register Date</th>
                            <th>Price</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr class="align-middle">
                                <td>
                                    <strong>{{ $order->user->name }}</strong>
                                </td>
                                <td>
                                    <strong>{{ $order->camp->title }}</strong>
                                </td>
                                <td>
                                    {{ date('F d, Y', strtotime($order->created_at)) }}
                                </td>
                                <td>
                                    <strong>${{ $order->camp->price }},000</strong>
                                </td>
                                <td>
                                    @if ($order->is_paid)
                                        <span class="badge rounded-pill bg-success text-white py-2 px-4 fs-6">Paid</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning text-dark py-2 px-4 fs-6">Not Paid</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$order->is_paid)
                                        <form action="{{ route('admin.checkout.update', $order->id) }}" method="post">
                                            @csrf

                                            <button type="submit" class="btn btn-success">Set Payment to Paid</button>
                                        </form>
                                    @endif
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
