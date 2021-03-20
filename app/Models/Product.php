<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
	protected $guarded =[];

	public function shop(){
		return $this->belongsTo('App\Models\Shop');
	}

	public function getCoverImgAttribute($value){
        if (strpos($value, 'https://') !== false || strpos($value, 'http://') !== false) {
            return $value;
        }
 
        return asset('storage/' . $value);
    }
}
