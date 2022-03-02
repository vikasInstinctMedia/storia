@if(Session::has('cart') && count(Session::get('cart')['items']) )

<ul class="cart-list">
	@foreach(Session::get('cart')['items'] as $product)
	<li class="product cremove{{ $product['id'] }}">

		<div class="remove cart-remove" data-class="cremove{{ $product['id']}}" data-href="{{ route('product.cart.remove',$product['unique_id'])}}" data-product="{{ json_encode( $product ) }}" title="Remove Product">
			×
		</div>

		<a href="{{ route('front.category',$product['slug']) }}">
			<img src="{{asset('storage/'.$product['thumbnail_image'])}}" alt="" />
			{{ $product['name'] }}&nbsp;
		</a>
		<span class="quantity"><span class="cart-product-qty" id="cqt{{$product['id']}}">{{$product['quantity']}}</span> × ₹<span id="prct{{$product['id']}}">{{ $product['price'] }}</span></span>
	</li>
	@endforeach
</ul>
<p class="total">
	<strong>Subtotal:</strong>

	<span class="amount">₹{{ Session::has('cart') ? Session::get('cart')['sub_total'] : '0.00' }} </span>

</p>


<p class="buttons">
	<a href="{{ route('cart.page') }}" class="view-cart">View cart</a>
	<a href="{{ route('front.checkout') }}" class="checkout">Checkout</a>
</p>

@else
<p class="mt-1 pl-3 text-left">Cart is empty.</p>
@endif