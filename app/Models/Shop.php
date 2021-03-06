<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

	protected $guarded =[];
	public function user(){
		return $this->belongsTo('App\Models\User');
	}

	public function products(){
		return $this->hasMany('App\Models\Product');
	}
}
