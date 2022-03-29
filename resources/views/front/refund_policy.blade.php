@extends('layouts.front')
@section('style')
@if (isset($metadata['meta_title']))
<meta name="title" content="{{ $metadata['meta_title'] }}">
<title>{{ $metadata['meta_title'] }}</title>
@else
<title>Storia Foods &#8211; Home</title>
@endif

@if (isset($metadata['meta_description']))
<meta name="description" content="{{ $metadata['meta_description'] }}">
@else
<meta name="description" content="Storia Foods &#8211; Home">
@endif
    <style>
        .rest {
            font-family: Lato;
        }

        .rest h2 {
            font-family: Lato;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .rest p strong {
            border-bottom: 1px solid #000;
        }

    </style>
@endsection
@section('content')

    <div id="main">
        <div class="container">
            <div class="mb-5 ">
                <div class="rest">
                    <h2 class="pb-2">
                        Refund Policy
                    </h2>
                    <br>
                    <b>Thanks for shopping at www.shop.storiafoods.com,</b> <br><br>
                   <p>
If you find that the product delivered to you is inconsumable owing to quality, packaging
and other related issues, we&#39;re here to help. All products are eligible for refunds if they’re
damaged or have been received after the best before date has passed. All refunds and
cancellations are at the sole discretion of Storia® Foods &amp; Beverages Pvt.Ltd. and shall be
subject to verification of your claim and its confirmation by its employees and
management.</p>
<br>
<p></p>
<b>RETURNS</b>: www.shop.storiafoods.com OR “Storia® Foods &amp; Beverages Pvt.Ltd.” does not
entertain returns after the order is successfully placed and payment is made by the buyer.
Buyers are requested to place the order only if they agree with this term.
                   </p>
                   <br>
                   <p>
<b>REFUNDS : </b>To be eligible for a refund, your item needs to have the receipt or proof of
purchase (email invoice will also be considered valid). Refunds shall be entertained only if
product is damaged or have been received after the best before date has passed or expired
or its non-delivery. Once we inspect and if your claim of refund is approved, we will initiate
a process of refund to your original method of payment. You will receive the credit within
15 days, depending on your card issuer&#39;s policies.</p>
<p>www.shop.storiafoods.com OR “Storia® Foods &amp; Beverages Pvt.Ltd.” will accept your
refund request of the sold products through the website www.shop.storiafoods.com,
subject to the terms and conditions mentioned below:</p>
<ul style="margin-left:30px">
    <li>Refund requests will be entertained only in case the product(s) received by the
        buyer are in damaged or expired condition. Only such cases will be considered for
        refund thereafter.</li>
        <li> Buyer has to inform www.shop.storiafoods.com OR “Storia® Foods &amp; Beverages
            Pvt.Ltd.” of his/her about the damaged products within 2 hrs of receipt of the
            goods at his/her shipping address.</li>
            <li>If your claim of refund request is approved, we will initiate a process of refund to
                your credit card (or original method of payment).</li>
         <li>
            All emails in this regard are to be sent to customercare@storiafoods.com
             </li>
         <li>
            No Refund will be entertained if a customer wants to return the product for the
reason that he/she doesn&#39;t like it after delivery of the product or feels the product
doesn&#39;t match his or her expectations.

         </li>
        </ul>





<p>No refunds will be given in the following cases:</p>
<ul style="margin-left:30px">
<li> Incorrect or insufficient address mentioned by the customer</li>
<li>Non- availability of recipient at the mentioned address and/or premises
</li>
<li>Refusal to accept products</li>
<li> Delivered at the place/to the person specifically mentioned by the customer other
    than the customer himself</li>
    <li> Force majeure events.</li>
    <li> In case the product has undergone any tampering by the customer</li>
</ul>




<br>
<p>
<b>CANCELLATIONS:</b> You cannot cancel the order and demand refund once the order is
successfully placed and processed by the payment gateway. For cancellations please write
to us on customercare@storiafoods.com</p>
<br>
<p>
<b>COUPON TERMS AND CONDITION:</b> Coupons are valid for a limited time only. Storia®
Foods &amp; Beverages Pvt.Ltd. reserves the right to modify or cancel coupons at any time.
The coupon offer will not be valid until it is applied to the qualifying item.</p>
<ul style="margin-left:30px">
    <li>The coupon may only be used on www.shop.storiafoods.com and in conjunction
        with the purchase of products shipped and sold by www.shop.storiafoods.com . The
        coupon is not valid on products sold by third-party sellers or other e-commerce
        websites.
    </li>
    <li> The coupon is limited to one coupon per customer.</li>
    <li>If you demand refund for any of the items purchased with a coupon, the coupon
        discount or value may be subtracted from the return credit.
    </li>
    <li>Prevalent shipping and handling charges apply to all products as per the Shipping &amp;
        Refund Policy. Offer good while supplies last.
    </li>
    <li> Storia® Foods &amp; Beverages Pvt.Ltd. has no obligation for payment of any tax in
        conjunction with the distribution or use of any coupon.
    </li>
    <li> Consumers are required to pay any applicable taxes related to the use of the
        coupon.
    </li>
    <li> Coupons shall be void if they are restricted or prohibited by law.

    </li>
</ul>





<br>
<p>
<b>CONTACT US</b>: If you have any questions write to us on <a href="mailto:customercare@storiafoods.com">customercare@storiafoods.com</a>
</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
