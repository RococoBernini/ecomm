<?php

namespace App\Services;

use App\Models\Order;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

/**
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
 */

class PaypalService{
	private $client;

	function _construct(){
		$environment = new SandboxEnvironment(env('PAYPAL_SANDBOX_CLIENT_ID'), env('PAYPAL_SANDBOX_CLIENT_SECRET'));
		$this->client = new PayPalHttpClient($enviornment);
	}


	public function createOrder($orderId){

	}

	public function captureOrder($paypalOrderId){

	}









}
// class PayPalClient
// {
//     /**
//      * Returns PayPal HTTP client instance with environment that has access
//      * credentials context. Use this instance to invoke PayPal APIs, provided the
//      * credentials have access.
//      */
//     public static function client()
//     {
//         return new PayPalHttpClient(self::environment());
//     }
//
//     /**
//      * Set up and return PayPal PHP SDK environment with PayPal access credentials.
//      * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
//      */
//     public static function environment()
//     {
//         $clientId = getenv("CLIENT_ID") ?: "PAYPAL-SANDBOX-CLIENT-ID";
//         $clientSecret = getenv("CLIENT_SECRET") ?: "PAYPAL-SANDBOX-CLIENT-SECRET";
//         return new SandboxEnvironment($clientId, $clientSecret);
//     }
// }


?>
