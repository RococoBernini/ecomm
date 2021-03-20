<?php

namespace App\Http\Controllers;

use App\Mail\OrderPaid;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
	public function getExpressCheckout(Order $order){
		$checkoutData = $this->checkoutData($order->id);

		$provider = new ExpressCheckout();

		$response = $provider->setExpressCheckout($checkoutData);

		return redirect($response['paypal_link']);
	}	

	private function checkoutData($orderid){

		$cart =  \Cart::session(auth()->id());
		// $cartItems = [
		// 	[
		// 		'name' => 'Product 1',
		// 		'price' => 9.99,
		// 		'desc'  => 'Description for product 1',
		// 		'qty' => 1
		// 	],
		// 	[
		// 		'name' => 'Product 2',
		// 		'price' => 4.99,
		// 		'desc'  => 'Description for product 2',
		// 		'qty' => 2
		// 	]
		// ];

		dd($cart->getContent());
		$cartItems = array_map(function($item){
			return [
				'name' => $item['name'], 
				'price' => $item['price'], 
				'qty' => $item['quantity']
			];
		}, $cart->getContent()->toarray());
		// dd($cartItems);
		$checkoutData = [
			'items' => $cartItems, 
			'return_url' => route('paypal.success', $orderid),
			'cancel_url' => route('paypal.cancel'),
			'invoice_id' => uniqid(),
			'invoice_description' => 'order description',
			'total' => $cart->getTotal()
		
		];
		return $checkoutData;
	}
    //
	public function cancelPage(){
		dd(';aument failed');
	}
	public function getExpressCheckoutSuccess(Request $request, Order $order){
		$token = $request->get('token');
		$payerId = $request->get('PayerID');
		$provider = new ExpressCheckout();
		$checkoutData = $this->checkoutData($order->id);

		$response = $provider->getExpressCheckoutDetails($token);

		if(in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])){

			$payment_status = $provider->doExpressCheckoutPayment($checkoutData, $token, $payerId);
			// dd($payment_status);
			$status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS']; 
			if(in_array($status, ['Completed', 'Processed'])){
				$order->is_paid = 1;
				$order->save();

				//send mail
				// Mail::to($order->user->email)->send(new OrderPaid($order));

				\Cart::session(auth()->id())->clear();


				return redirect()->route('home')->withMessage('Payment successful');
			}

		}
		
	}
}
