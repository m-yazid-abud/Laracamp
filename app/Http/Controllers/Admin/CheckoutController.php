<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\checkout\paid;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function update(Request $request, Order $order)
    {
        $order->is_paid = true;
        $order->save();

        Mail::to($order->user->email)->send(new paid($order));
        return redirect()->route('admin.dashboard')->with('success', "Payment with user id <strong>$order->user_id</strong> has been set to paid");
    }
}
