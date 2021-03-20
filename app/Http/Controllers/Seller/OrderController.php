<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SubOrder;

class OrderController extends Controller
{
	public function index(){
		// $orders = Order::whereHas('items.shop', function($q){
		// 	$q->where('user_id', auth()->id());
		// })->addSelect([
		// 	'item_count_seller'=>OrderItem::selectRaw('count(*) as item_count')
		// 					->whereColumn('order_id', 'orders.id')
		// 					->whereHas('product.shop', function($q){
		// 						$q->where('user_id', auth()->id());
		// 					})
		// ]
		// )->get();

		// $orders->map(function($order){
		// 	$orderStatus = 'processing';
        //
		// 	$undeliveredItems = $order->items()->whereHas('shop', function($q){
		// 		$q->where('user_id', auth()->id());
		// 	})->whereNull('delivered_at')->count();
		// 	
		// 	if($undeliveredItems == 0){
		// 		$orderStatus = 'Completed';
		// 	}
		// 	$order['seller_order_status']= $orderStatus;
		// 	return $order;
		// });

		$orders = SubOrder::where('seller_id', auth()->id())->get();

		return view('sellers.orders.index', compact('orders'));
	}
    //
	public function show(SubOrder $order){
		// $items = $order->items()->whereHas('shop', function($q){
		// 	$q->where('user_id', auth()->id());
		// })->get();


		$items = $order->items;
		return view('sellers.orders.show', compact('items'));
	}

	public function markDelivered(SubOrder $suborder){
		// $items = $order->items()->whereHas('shop', function($q){
		// 	$q->where('user_id', auth()->id());
		// })->update(['delivered_at'=>now()]);

		$suborder->status = 'completed';
		$suborder->save();

		//check if all suborders complete
		$pendingSubOrders = $suborder->order->subOrders()->where('status', '!=', 'completed')->count();

		if($pendingSubOrders == 0){
			$suborder->order()->update(['status'=>'completed']);
		}
		return redirect('/seller/orders')->withMessage('Order marked complete');

	}
}
