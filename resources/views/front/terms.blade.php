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
        <div class="mb-5 rest">
            <h2 class="pb-2">Terms of Use</h2>
            <p class="pt-3">Please Read the following Terms of Use and Disclaimers carefully before using this Website: www.shop.storia.com</p>
            <p><strong> Acceptance of Terms :</strong> Your access to and use of this site is subject to the following Terms of Use. </p>


            <p>Storia® Foods and Beverages PVT.LTD. reserves the right to update the Terms of Use at any time without notice to you. The most current version of the Terms of Use may be accessed by clicking on the “Terms of Use” hypertext link located at the bottom of the site.
                By using this site, you accept, without limitation or qualification, these Terms of Use. If you do NOT agree to these Terms of Use, please do NOT use this site.
            </p>
            <p>
                <strong>Accuracy and Completeness of Information</strong> While Storia® Foods and Beverages PVT.LTD. strives to ensure that the information contained in this site is accurate and reliable, Storia® Foods and Beverages PVT.LTD. makes no warranties or representations as to the accuracy, correctness, reliability or otherwise with respect to such information, and assumes no liability or responsibility for any omissions or errors in the content of this site.
            </p>
            <p><strong>Modification of Site : </strong>Storia® Foods and Beverages PVT.LTD. will periodically revise the information, services and the resources contained on this site and reserves the right to make such changes without any obligation to notify past, current or prospective visitors.</p>
            <p><strong>Your Use of the Site : </strong>You may download content for non-commercial, personal use only, provided copyright, trademark or other proprietary notices remain unchanged and visible. No right, title or interest in any downloaded materials is transferred to you as a result of any such downloading or copying. You agree that you will not otherwise copy, modify, alter, display, distribute, sell, broadcast or transmit any material on the site in any manner without the written permission of Storia® Foods and Beverages PVT.LTD.</p>
            <p><strong>No Unlawful or Prohibited Use : </strong>As a condition of use of the site, you will not use the site for any purpose that is unlawful or prohibited by these Terms of Use or any applicable laws.</p>
            <p><strong>Unsolicited Submissions : </strong>Storia® Foods and Beverages PVT.LTD. does not accept or consider any creative ideas, suggestions or materials from the public (“Submissions”) and therefore, you should not make any Submissions to Storia® Foods and Beverages PVT.LTD.. If you do send us a Submission, despite our request not to do so, then such Submission will be considered non-confidential and non-proprietary and shall immediately become the property of Storia® Foods and Beverages PVT.LTD. Storia® Foods and Beverages PVT.LTD. shall exclusively now and hereinafter own all rights, title and interest therein. Storia® Foods and Beverages PVT.LTD. will be free to use any Submissions for any purpose whatsoever.</p>
            <p><strong>Privacy Policy : </strong>Storia® Foods and Beverages PVT.LTD.’s use of any personal data you submit to the site is governed by the site’s Privacy Policy.</p>
            <p><strong>Disclaimers : </strong>Your use of this site is at your sole risk. The site is provided on an “as is” basis. Storia® Foods and Beverages PVT.LTD. expressly disclaims any warranty of any kind, whether expressed or implied, as to any matter whatsoever relating to this site, including without limitation the implied warranty of merchantability, fitness for any particular purpose or non infringement. If you download any material from this site, you do so at your own discretion and risk and you will be responsible for any damage to your computer system or loss of data that results from the download of any such material.</p>
            <p><strong>Limitation of Liability : </strong>In no event and under no legal or equitable theory, whether in tort, contract, strict liability or otherwise, shall Storia® Foods and Beverages PVT.LTD. be liable for any direct, indirect, special, incidental or consequential damages arising out of any use of the information contained herein, including, without limitation, damages for lost profits, loss of goodwill, loss of data, work stoppage, accuracy of results, or computer failure or malfunction.</p>
            <p><strong>Indemnification : </strong>You agree to defend, indemnify and hold Storia® Foods and Beverages PVT.LTD. harmless from and against any and all claims, damages, costs and expenses, including attorney’s fees, arising from and related to your use of the site.</p>
            <p><strong>Copyright Notice : </strong>Unless otherwise noted, the graphic images, buttons and text contained in this site are the exclusive property of Storia® Foods and Beverages PVT.LTD. and its subsidiaries. Except for personal use, these items may not be copied, distributed, displayed, reproduced, or transmitted, in any form or by any means, electronic, mechanical, photocopying, recording, or otherwise without prior written permission of Storia® Foods and Beverages PVT.LTD.</p>
            <p><strong>Trademarks : </strong>This site features logos, brand identities and other trademarks and service marks (collectively, the “Marks”) that are the property of, or are licensed to Storia® Foods and Beverages PVT.LTD. and its subsidiaries. Nothing contained on this site should be construed as granting, by implication, estoppel, or otherwise, any license or right to use any Mark displayed on this site without written permission of Storia® Foods and Beverages PVT.LTD. or any such third party that may own a Mark displayed on the site.</p>
            <p><strong>Links to Third Party Sites : </strong>As a convenience to users, this site may link to other sites owned and operated by third parties and not maintained by Storia® Foods and Beverages PVT.LTD.. However, even if such third parties are affiliated with Storia® Foods and Beverages PVT.LTD., Storia® Foods and Beverages PVT.LTD. has no control over these linked sites, all of which have separate privacy and data collection practices and legal policies independent of Storia® Foods and Beverages PVT.LTD.. Storia® Foods and Beverages PVT.LTD. is not responsible for the content of any linked sites and does not make any representations regarding the content or accuracy of material on such sites. Viewing such third party sites is entirely at your own risk.</p>
            <p><strong>SHIPPING POLICY OF STORIA® FOODS & BEVERAGES PVT. LTD.</strong>STORIA® FOODS & BEVERAGES PVT. LTD. cannot commit any time fixed for delivery. The delivery of our products will be made between 6:00 am to 9:00 am of the date. (Delivery time appears to be little odd. Please confirm) It may get delayed on certain days due to extreme weather conditions or governmental regulatory activities.</p>
            <p>Currently the products will be delivered for addresses in Mumbai and Pune as per the areas exhibited on the site. For other areas please call STORIA® FOODS & BEVERAGES PVT. LTD.</p>
            <p>Orders will be booked for at least third business day delivery.</p>
            <p>While placing the order the customer shall provide the following details.</p>
            <div class="">
                <ol type="number_format">
                    <li>Name of the recipient</li>
                    <li>Flat number/bungalow number</li>
                    <li>Name of the building</li>
                    <li>Name of the road/street/marg</li>
                    <li>Contact number landline/mobile</li>
                    <li>Proper/familiar land mark</li>
                    <li>Email address</li>
                </ol>
            </div>
            <p>After the order is accepted by STORIA® FOODS & BEVERAGES PVT. LTD., a confirmation email will be sent to the customer.</p>
            <p>The delivery will be made on the shipping address mentioned at the time of placing the order. The consignment will not be redirected/redelivered to any other address at any circumstances.</p>
            <p>No Deliveries will be made on Sundays and some Prescribed holidays.</p>
            <p>STORIA® FOODS & BEVERAGES PVT. LTD.’s delivery agent will attempt delivery of the products once. In case the delivery is not executed during the attempt, the customer shall still be charged for the order and no redelivery attempt will be made.</p>
            <p>STORIA® FOODS & BEVERAGES PVT. LTD. will consider the order as “executed” in the following cases :</p>
            <div class="">
                <ol type="number_format">
                    <li>Delivery not done due to wrong address given by the customers</li>
                    <li>Non availability of the recipients at the address</li>
                    <li>Premises locked.</li>
                    <li>Wrong phone number or phone not working or switched off or not reachable, when tried by the delivery agent of STORIA® FOODS & BEVERAGES PVT. LTD.</li>
                    <li>Addressee refused to accept the products.</li>
                    <li>Delivered the product at the security cabin of the building/Reception/Neighbor, based on the instructions from the customer.</li>
                    <li>In case of civil disturbances, floods, Heavy Rains, National Bandh or in happening any other force majeure event, we reserve the right to cancel the order or reschedule the delivery to another date.</li>
                    <li>Request for cancellation of confirmed order can be made up to 72 hours before the delivery time.(This condition is in conflict with Our Retrun / refund policy. Please check.)</li>
                </ol>
            </div>
            <p>All content on this website including the logo, graphics, text, design, belong to Storia® Foods & Beverages Pvt.Ltd. and are the intellectual properties of Storia® Foods & Beverages Pvt.Ltd. are protected by appropriate legislations. No part of the content shall be copied, downloaded, transmitted or published without prior, written permission from Storia® Foods & Beverages Pvt.Ltd.. All trademarks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website. Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offence.</p>
            <p>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</p>
            <p>You may not create a link to this website from another website or document without prior written consent from us.</p>
            <p>Your use of this website and any dispute arising out of such use of the website is subject to the laws of India or other regulatory authority. </p>
            <p>You must not use this website in any way that causes or may cause damage to the website or causes impairment in accessing the website or which is in any way unlawful, illegal or fraudulent.</p>
            <p>We as a merchant shall be under no liability whatsoever in respect of any loss or damage arising directly or indirectly out of the decline of authorization for any Transaction, on Account of the Cardholder having exceeded the preset limit. </p>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
