<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Order\Store;
use App\Mail\User\Checkout\AfterCheckout;
use App\Models\Camp;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Midtrans;
use Illuminate\Support\Str;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);

        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Camp $camp)
    {
        if ($camp->isRegistered) {
            return redirect("user.dashboard")->with("error", "You are already registered on <strong>$camp->title</strong> camp!");
        }
        return view('pages.front.order.create', [
            "camp" => $camp,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, $campId)
    {
        $data = $request->all();

        $data['camp_id'] = $campId;
        $data['user_id'] = Auth::id();

        $user = User::find(Auth::id());
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->phone = $data['phone'];
        $user->address = $data['address'];
        $user->occupation = $data['occupation'];
        $user->save();

        $order = Order::create($data);

        $this->getSnapMidtransRedirect($order);

        Mail::to($user->email)->send(new AfterCheckout($order->camp->title, $user->name));

        return to_route('order.success');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function success()
    {
        return view('pages.front.order.success');
    }

    protected function getSnapMidtransRedirect(Order $order)
    {
        $orderId = $order->id . "-" . Str::random(5);
        $price = $order->camp->price * 1000;
        $order->midtrans_booking_code = $orderId;

        $transaction_details = [
            "order_id" => $orderId,
            "gross_amount" => $price,
        ];

        $item_details[] = [
            "id" => $order->camp_id,
            "price" => $price,
            "quantity" => 1,
            "name" => $order->camp->title,
        ];

        $userData = [
            "first_name" => $order->user->name,
            "last_name" => "",
            "email" => $order->user->email,
            "phone" => $order->user->phone,
            "address" => $order->user->address,
            "city" => "",
            "postal_code" => "",
            "county_code" => "IDN",
        ];

        $customer_details = [
            "first_name" => $order->user->name,
            "last_name" => "",
            "email" => $order->user->email,
            "phone" => $order->user->phone,
            "billing_address" => $userData,
            "shipping_address" => $userData,
        ];

        $snapRequestParams = [
            "transaction_details" => $transaction_details,
            "customer_details" => $customer_details,
            "item_details" => $item_details,
        ];

        // dd($snapRequestParams);

        try {
            $paymentUrl = Midtrans\Snap::createTransaction($snapRequestParams)->redirect_url;
            $order->midtrans_url = $paymentUrl;
            $order->save();

            return $paymentUrl;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function midtransCallback(Request $request)
    {
        // $notif = $request->method() == "POST" ? new \Midtrans\Notification() : \Midtrans\Transaction::status($request->order_id);
        $notif = new \Midtrans\Notification();

        $transaction_status = $notif->transaction_status;
        $order_id = explode("-", $notif->order_id)[0];

        $order = Order::find($order_id);
        $fraud = $notif->fraud_status;

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                $order->payment_status = "pending";
            } else if ($fraud == 'accept') {
                $order->payment_status = "paid";
            }
        } else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                $order->payment_status = "failed";
            } else if ($fraud == 'accept') {
                $order->payment_status = "failed";
            }
        } else if ($transaction_status == 'deny') {
            $order->payment_status = "failed";
        } else if ($transaction_status == 'settlement') {
            $order->payment_status = "paid";
        } else if ($transaction_status == 'pending') {
            $order->payment_status = "pending";
        } else if ($transaction_status == 'expire') {
            $order->payment_status = "failed";
        }

        $order->save();

        return to_route('order.success');
    }
}
