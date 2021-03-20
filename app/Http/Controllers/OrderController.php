<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \ECPay_PaymentMethod as ECPayMethod;

use \ECPay_AllInOne as ECPay;

class OrderController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$input = request()->validate([

			'shipping_fullname' => 'required',
			'shipping_state' => 'required',
			'shipping_city' => 'required',
			'shipping_address' => 'required',
			'shipping_phone' => 'required',
			'shipping_zipcode' => 'required',
		]);

		$order = new Order();
		$order->order_number = uniqid('OrderNumber-'); 

		$order->shipping_fullname = $input['shipping_fullname'];
		$order->shipping_state = $input['shipping_state'];
		$order->shipping_city = $input['shipping_city'];
		$order->shipping_address = $input['shipping_address'];
		$order->shipping_phone = $input['shipping_phone'];
		$order->shipping_zipcode = $input['shipping_zipcode'];
		
		if(!$request->has('billing_fullname')){
			$order->billing_fullname = $input['shipping_fullname'];
			$order->billing_state = $input['shipping_state'];
			$order->billing_city = $input['shipping_city'];
			$order->billing_address = $input['shipping_address'];
			$order->billing_phone = $input['shipping_phone'];
			$order->billing_zipcode = $input['shipping_zipcode'];
		}else{
			$order->billing_fullname = $input['billing_fullname'];
			$order->billing_state = $input['billing_state'];
			$order->billing_city = $input['billing_city'];
			$order->billing_address = $input['billing_address'];
			$order->billing_phone = $input['billing_phone'];
			$order->billing_zipcode = $input['billing_zipcode'];
			
		}

		$order->grand_total = \Cart::session(auth()->id())->getTotal();
		$order->item_count = \Cart::session(auth()->id())->getContent()->count();

		$order->user_id = auth()->id();

		if(request('payment_method') == 'paypal'){
			//redirect to pp
			$order->payment_method = 'paypal';
		}

		$order->save();


		$cartItems = \Cart::session(auth()->id())->getContent();
		foreach($cartItems as $item){
			$order->items()->attach($item->id, ['price'=>$item->price, 'quantity'=>$item->quantity]);
		}

		//Payment
		if(request('payment_method') == 'paypal'){
			//redirect to pp
			return redirect()->route('paypal.checkout', $order->id);
		}
		
		if(request('payment_method') == 'credit_card'){
			// include('App\ECPaySDK\ECPay.Payment.Integration.php');
			return redirect()->route('ecpay.checkout', $order->id);

			
		}
		///send email to customer
		// Mail::to($order->user->email)->send(new OrderPaid($order));
		$order->generateSubOrders();

		//empty cart
		\Cart::session(auth()->id())->clear();
		
	
		//
		//take user to tank you
		return redirect()->route('home')->withMessage('Order has been placed');
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
}
