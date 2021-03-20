<div>
    {{-- In work, do what you enjoy. --}}
	{{-- <form action="{{route('cart.update', $item->id)}}"> --}}
	{{-- 	<input type='number' name='quantity' value ={{$item->quantity}}> --}}
	{{-- 	<input class='button' type='submit' value='save'> --}}
	{{-- </form> --}}
		<input wire:model="quantity" type='number' wire:change="updateCart">
</div>
