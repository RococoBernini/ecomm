<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    use HasFactory;

	protected $guarded =[];

	public function items(){

		return $this->belongsToMany('App\Models\Product', 'sub_order_items')->withPivot('quantity', 'price');
	}

	public function order(){
		return $this->belongsTo('App\Models\Order');
	}

	public function transactions(){
		return $this->hasMany('App\Models\Transaction');
	}
}
