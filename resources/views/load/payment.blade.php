@if($payment == 'cod') 
<input type="hidden" name="method" value="Cash On Delivery">
@endif

@if($payment == 'razorpay') 
<input type="hidden" name="method" value="Razorpay">
@endif

