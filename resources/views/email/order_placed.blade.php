<meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
  <tbody>
    <tr>
      <td valign="top" style="padding:0cm 0cm 0cm 0cm">
        <p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:12.0pt;font-family:&quot;Times New Roman&quot;,serif"><img  src="{{asset('front/images/logo.png')}}" alt="Storia Foods Online Store" class="CToWUd"><u></u><u></u></span></p>
        <div align="center">
          <table border="1" cellspacing="0" cellpadding="0" width="0" style="width:450.0pt;background:white;border:solid #dedede 1.0pt">
            <tbody>
              <tr>
                <td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
                  <div align="center">
                    <table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;background:#96588a">
                      <tbody>
                        <tr>
                          <td style="padding:27.0pt 36.0pt 27.0pt 36.0pt">
                            <p class="MsoNormal" style="line-height:150%"><span style="font-size:22.5pt;line-height:150%;font-family:&quot;Helvetica Neue&quot;;color:white">Thank you for your order<u></u><u></u></span></p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
              <tr>
                <td valign="top" style="border:none;padding:0cm 0cm 0cm 0cm">
                  <div align="center">
                    <table border="0" cellspacing="0" cellpadding="0" width="0" style="width:450.0pt">
                      <tbody>
                        <tr>
                          <td valign="top" style="background:white;padding:0cm 0cm 0cm 0cm">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                              <tbody>
                                <tr>
                                  <td valign="top" style="padding:36.0pt 36.0pt 24.0pt 36.0pt">
                                    <p class="MsoNormal" style="margin-bottom:12.0pt;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Helvetica Neue&quot;;color:#636363">Hi  {{ $order->customer_name }},<u></u><u></u></span></p>
                                    <p class="MsoNormal" style="margin-bottom:12.0pt;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Helvetica Neue&quot;;color:#636363">Just to let you know — we've received your order #{{ $order->order_number }}, and it is now being processed:<u></u><u></u></span></p>
                                    <p class="MsoNormal" style="margin-bottom:13.5pt;line-height:130%"><b><span style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica Neue&quot;;color:#96588a">[Order #{{ $order->order_number }}]  ( {{ $order->created_at->format('F d,Y') }} )<u></u><u></u></span></b></p>
                                    <p class="MsoNormal" style="margin-bottom:13.5pt;line-height:130%"><b><span style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica Neue&quot;;color:#96588a">AWB Number :  {{ $order->awb_number }}  <u></u><u></u></span></b></p>
                                    <table border="1" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;border:solid #e5e5e5 1.0pt">
                                      <thead>
                                        <tr>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Product<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Quantity<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Price<u></u><u></u></span></b></p>
                                          </td>
                                        </tr>
                                      </thead>
                                      <tbody>


                                        @foreach($order->products as $product)

                                        <tr>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363"> {{ $product['name'] }} <u></u><u></u></span></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363"> {{ $product['quantity'] }} <u></u><u></u></span></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">₹{{ $product['product_total'] }} <u></u><u></u></span></p>
                                          </td>
                                        </tr>

                                        @endforeach



                                        <tr>
                                          <td colspan="2" style="border:solid #e5e5e5 1.0pt;border-top:solid #e5e5e5 3.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Subtotal:<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;border-top:solid #e5e5e5 3.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">₹{{ $order->cart_details['sub_total'] }}<u></u><u></u></span></p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Shipping:<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">₹50.00&nbsp;</span><span style="font-size:10.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">via Flat rate</span><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363"> <u></u><u></u></span></p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Payment method:<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">{{ $order->method }}<u></u><u></u></span></p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><b><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">Total:<u></u><u></u></span></b></p>
                                          </td>
                                          <td style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                            <p class="MsoNormal"><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">₹{{ $order->pay_amount }}<u></u><u></u></span></p>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td width="50%" valign="top" style="width:50.0%;border:none;padding:0cm 0cm 0cm 0cm">
                                            <p class="MsoNormal" style="margin-bottom:13.5pt;line-height:130%"><b><span style="font-size:13.5pt;line-height:130%;font-family:&quot;Helvetica Neue&quot;;color:#96588a">Billing address<u></u><u></u></span></b></p>
                                            <div style="border:solid #e5e5e5 1.0pt;padding:9.0pt 9.0pt 9.0pt 9.0pt">
                                              <p class="MsoNormal" style="border:none;padding:0cm"><i><span style="font-size:12.0pt;font-family:&quot;Helvetica Neue&quot;;color:#636363">{{ $order->customer_name }}<br> {{ $order->customer_address }} <br>{{ $order->shipping_city }} {{ $order->shipping_zip }} <br> <br><a href="tel:+919890044442" rel="noreferrer noreferrer" target="_blank"><span style="color:#96588a">{{ $order->customer_phone }}</span></a> <br><a href="mailto:rohan.gandhi@sysweave.com" rel="noreferrer noreferrer" target="_blank"><span style="color:blue">{{ $order->customer_email }}</span></a> <u></u><u></u></span></i></p>
                                            </div>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <p class="MsoNormal" style="margin-bottom:12.0pt;line-height:150%"><span style="font-size:10.5pt;line-height:150%;font-family:&quot;Helvetica Neue&quot;;color:#636363">Thanks for using <a href="http://shop.storiafoods.com" rel="noreferrer noreferrer" target="_blank" data-saferedirecturl=""><span style="color:blue">shop.storiafoods.com</span></a>!<u></u><u></u></span></p>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
    <tr>
      <td valign="top" style="padding:0cm 0cm 0cm 0cm">
        <div align="center">
          <table border="0" cellspacing="0" cellpadding="0" width="0" style="width:450.0pt">
            <tbody>
              <tr>
                <td valign="top" style="padding:0cm 0cm 0cm 0cm">
                  <table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%">
                    <tbody>
                      <tr>
                        <td style="padding:18.0pt 0cm 18.0pt 0cm">
                          <p class="MsoNormal" align="center" style="margin-bottom:12.0pt;text-align:center;line-height:150%"><span style="font-size:9.0pt;line-height:150%;font-family:&quot;Helvetica Neue&quot;;color:#8a8a8a">Storia Foods Online Store —<u></u><u></u></span></p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
  </tbody>
</table>