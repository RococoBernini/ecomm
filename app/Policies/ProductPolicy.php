<?php

namespace App\Policies;

use App\Models\Shop;
use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

	public function before($user, $ability){
		if($user->hasRole('admin')){
			return true;
		}
	}

	public function browse(User $user){
		return $user->hasRole('seller');
	}
    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function view(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

	public function edit(User $user, Product $product){
		if(empty($product->shop)){
			return false;
		}
		return $user->id ==$product->shop->user_id;
	}

	public function read(User $user, Product $product){
		if(empty($product->shop)){
			return false;
		}
		return $user->id ==$product->shop->user_id;
	}
    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
		return $user->id ==$product->shop->user_id;
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
		if(empty($product->shop)){
			return false;
		}
		return $user->id ==$product->shop->user_id;
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function restore(User $user, Product $product)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function forceDelete(User $user, Product $product)
    {
        //
    }
    public function add(User $user)
    {
		return $user->hasRole('seller');
        //
    }
}
