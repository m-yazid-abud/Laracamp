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

        $transaction_details = [
            "order_id" => $orderId,
            "gross_amount" => $price,
        ];

        $item_details = [
            "id" => $order->camp_id,
            "price" => $price,
            "quantity" => 1,
            "name" => $order->camp->name,
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
            $transaction_details,
            $customer_details,
            $item_details,
        ];

        try {
            $PaymentUrl = Midtrans\Snap::getSnapToken($snapRequestParams);
            $order->midtrans_url = $PaymentUrl;
            $order->midtrans_booking_code = $orderId;
            $order->save();

            return $PaymentUrl;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
