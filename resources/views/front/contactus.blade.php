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
    .banner-background {
        background-image: url("{{ asset('front/images/static_banner/Contact_us_page.jpg') }}") !important;
        color:red;
    }
</style>
@endsection
@section('content')

<div id="main">
                <div class="section section-bg-10 pt-17 pb-11 banner-background">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="page-title text-center"  style="color:white">Contact Us</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section border-bottom pt-2 pb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="breadcrumbs">
                                    <li><a href="./">Home</a></li>
                                    <li>Contact Us</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section pt-3 pb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="text-center mb-1 section-pretitle">Get in touch</div>
                                <h2 class="text-center section-title mtn-2">Storia Food</h2>
                                <div class="organik-seperator mb-6 center">
                                    <span class="sep-holder"><span class="sep-line"></span></span>
                                    <div class="sep-icon"><i class="organik-flower"></i></div>
                                    <span class="sep-holder"><span class="sep-line"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.6618437166576!2d72.86298601530243!3d19.122485216433983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c826623519c3%3A0xe691b51d20b4af73!2sStoria%20Foods!5e0!3m2!1sen!2sin!4v1625835969505!5m2!1sen!2sin"  height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.723461692287!2d72.86200641461436!3d19.11978388706277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c825662c7fc5%3A0xad3d66ac3ede302c!2sPinnacle%20Business%20Park!5e0!3m2!1sen!2sin!4v1641992045485!5m2!1sen!2sin"  height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                        <div class="row pt-4">
                            <div class="col-sm-4">
                                <div class="contact-info">
                                    <div class="contact-icon">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="contact-inner">
                                        <h6 class="contact-title"> Address</h6>
                                        <div class="contact-content">
                                            S-3, 7th Floor, Pinnacle Business Park, Near Ahura Centre,  &amp;
                                            <br />
                                            Mahakali Caves Road, Andheri East, Mumbai – 400093 (INDIA)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="contact-info">
                                    <div class="contact-icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="contact-inner">
                                        <h6 class="contact-title"> CALL / WHATSAPP</h6>
                                        <div class="contact-content">
                                            <a href="https://wa.me/+917304469307?text=I'm%20interested%20in%20buying%20your%20product%20" target="_blank"> +91 7304469307</a>
                                            </br>
                                            <span> Timings: Monday to Friday 10am to 7pm </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="contact-info">
                                    <div class="contact-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="contact-inner">
                                        <h6 class="contact-title">Grievance Officer</h6>
                                        <div class="contact-content">
                                            <span> Tejas Verma</span></br>
<span>1800223883</span></br>
<span> customercare@storiafoods.com </span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="contact-info">
                                    <div class="contact-icon">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="contact-inner">
                                        <h6 class="contact-title"> Website</h6>
                                        <div class="contact-content">
                                            www.storiafoods.com
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr class="mt-4 mb-7" />
                                <div class="text-center mb-1 section-pretitle">Leave us a message!</div>
                                <div class="organik-seperator mb-6 center">
                                    <span class="sep-holder"><span class="sep-line"></span></span>
                                    <div class="sep-icon"><i class="organik-flower"></i></div>
                                    <span class="sep-holder"><span class="sep-line"></span></span>
                                </div>
                                <div class="contact-form-wrapper">
                                    <form class="contact-form" action="{{ route('contact_us.submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>your name <span class="required">*</span></label>
                                                <div class="form-wrap">
                                                    <input type="text" name="name" value="{{ old('name') }}" size="40" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>your email <span class="required">*</span></label>
                                                <div class="form-wrap">
                                                    <input type="email" name="email" value="{{ old('email') }}" size="40" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>subject</label>
                                                <div class="form-wrap">
                                                    <input type="text" name="subject" value="{{ old('subject') }}"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Contact Number</label>
                                                <div class="form-wrap">
                                                    <input type="text" name="contact_no" value="{{ old('contact_no') }}"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>message</label>
                                                <div class="form-wrap">
                                                    <textarea name="message" value="{{ old('message') }}" cols="40" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-wrap text-center">
                                                    <input type="submit" value="SEND US NOW" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')

@endsection
