<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
	protected $guarded =[];

	public function items(){

		return $this->belongsToMany('App\Models\Product', 'order_items')->withPivot('quantity', 'price');
	}
	public function user(){
		return $this->belongsTo('App\Models\User');
	}

    public function getShippingFullAddressAttribute(){

        return  $this->shipping_fullname."<br>".$this->shipping_address . ', ' . $this->shipping_city . ', ' . $this->shipping_state . ', ' . $this->shipping_zipcode . "<br> phone: " . $this->shipping_phone;
    }

	public function subOrders(){
		return $this->hasMany('App\Models\SubOrder');
	}





	public function generateSubOrders(){
		$orderItems = $this->items;

		foreach($orderItems->groupBy('shop_id') as $shopId => $products){

			$shop = Shop::find($shopId);

			$suborder = $this->subOrders()->create([
				'order_id' => $this->id,
				'seller_id' => $shop->user_id,
				'grand_total' => $products->sum('pivot.price'),
				'item_count' => $products->count()

			]);

			foreach($products as $product){
				$suborder->items()->attach($product->id, ['price' => $product->pivot->price, 'quantity' => $product->pivot->quantity]);
			}

		}
	}

}
