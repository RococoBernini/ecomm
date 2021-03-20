<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Models\Category as ModelsCategory;

class Category extends ModelsCategory
{
    use HasFactory;
	public function children(){
		return $this->hasMany(Category::class, 'parent_id');
	}
	public function products(){
		return $this->belongsToMany('App\Models\Product', 'product_categories');

	}
	
	public function allProducts(){
		$allProducts = collect([]);

		$mainCategoryProducts = $this->products;

		$allProducts = $allProducts->concat($mainCategoryProducts);

		if($this->children->isNotEmpty()){
			foreach($this->children as $child){
				$allProducts = $allProducts->concat($child->products);
			}
		}
		return $allProducts;
	}
}
