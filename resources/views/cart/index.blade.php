@extends('layouts.front')
@section('content')

{{-- <div class='container-fluid text-center'> --}}
{{-- <h2>The cart</h2> --}}
{{-- <table class="table"> --}}
{{-- 	<thead> --}}
{{-- 		<tr> --}}
{{-- 			<th>Name</th> --}}
{{-- 			<th>Image</th> --}}
{{-- 			<th>Price</th> --}}
{{-- 			<th>Quantity</th> --}}
{{-- 			<th>Action</th> --}}
{{-- 		</tr> --}}
{{-- 	</thead> --}}
{{-- 	<tbody> --}}
{{-- 		@foreach($cartItems as $item) --}}
{{-- 		<tr> --}}
{{-- 			<td scope="row">{{$item->name}}</td> --}}
{{-- 			<td class="product-thumbnail"> --}}
{{-- 				<a href="#"><img class='img-thumbnail' src="{{$item->image}}" height='30' alt="" ></a> --}}
{{--  --}}
{{-- 			</td> --}}
{{-- 			<td> --}}
{{-- 				{{Cart::session(auth()->id())->get($item->id)->getPriceSum()}} --}}
{{-- 			</td> --}}
{{-- 			<td> --}}
{{-- 				<form action="{{route('cart.update', $item->id)}}"> --}}
{{-- 					<input type='number' name='quantity' value ={{$item->quantity}}> --}}
{{-- 					<input type='submit' value='save'> --}}
{{-- 				</form> --}}
{{-- 			</td> --}}
{{-- 			<td> --}}
{{-- 				 <a href="{{route('cart.destory', $item->id)}} ">Delete</a> --}}
{{-- 			</td> --}}
{{--  --}}
{{-- 		</tr> --}}
{{-- 		@endforeach --}}
{{-- 	</tbody> --}}
{{-- </table> --}}
{{-- <h3> --}}
{{-- 	Total Price : ${{Cart::session(auth()->id())->getTotal()}} --}}
{{-- </h3> --}}
{{-- <a name="" id="" class="btn btn-primary" href="{{route('cart.checkout')}}" role="button">Proceed to checkout</a>	 --}}
{{-- </div> --}}
 <!-- shopping-cart-area start -->
 <livewire:mall-cart />
@endsection
