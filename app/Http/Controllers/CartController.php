<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Coupon;
class CartController extends Controller
{
	public function add(Product $product){
		\Cart::session(auth()->id())->add(array(
			'id'=>$product->id,
			'name'=>$product->name,
			'price'=>$product->price,
			'quantity'=>1,
			'image'=>$product->cover_img,
			'attributes'=>array(),
			'associatedModel'=>$product
		));
		return redirect()->route('cart.index');
	}
	
	public function index(){
		$cartItems = \Cart::session(auth()->id())->getContent();
		return view('cart.index', ['cartItems'=>$cartItems]);
	}
	public function destory(Product $product){
		// dd($product->mid);
		\Cart::session(auth()->id())->remove($product->id);
		return back();
	}
	
	public function update(Product $product){
		// dd($product->mid);
		\Cart::session(auth()->id())->update($product->id, [
			'quantity'=>[
				'relative'=>false,
				'value'=>request('quantity')
		]]);
		return back();
	}
    //
	public function checkout(){
		return view('cart.checkout');
	}

	public function applyCoupon(){
		$couponCode = request('coupon_code');
		$couponData = Coupon::where('code', $couponCode)->first();

		if(!$couponData){
			return back()->withMessage('Sorry! Coupon does not exist', 'danger');
		}

		$condition = new \Darryldecode\Cart\CartCondition(array(
			'name' => $couponData->name,
			'type' => $couponData->type,
			'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
			'value' => $couponData->value,
			'attributes' => array( // attributes field is optional
				'description' => 'Value added tax',
				'more_data' => 'more data here'
			)
		));

		\Cart::session(auth()->id())->condition($condition);

		return back()->withMessage('coupon applied');
	}
}
