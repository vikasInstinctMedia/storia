@extends('layouts.front')

@section('content')

<div id="main">
        <!-- <div class="section section-bg-10 pt-11 pb-17">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <h2 class="page-title text-center">Register</h2>
              </div>
            </div>
          </div>
        </div> -->
        <div class="section border-bottom pt-2 pb-2">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <ul class="breadcrumbs">
                  <li><a href="./">Home</a></li>
                  <li>Register</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="section pt-7 pb-7">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="commerce signin-form">
                  <h2>Register</h2>
                  @include('layouts.form-login')
                  <form class="commerce-login-form" id="registerform" action="{{route('user-register-submit')}}"
                    method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                      <div class="col-md-12">
                        <label>Full Name <span class="required">*</span></label>
                        <div class="form-wrap">
                          <input type="text" name="name" placeholder="Full Name" required="" value="" size="40">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <label>Email address <span class="required">*</span></label>
                        <div class="form-wrap">
                          <input type="email" name="email" placeholder="Email address" required="" value="" size="40">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label>Password <span class="required">*</span></label>
                        <div class="form-wrap">
                          <input type="password" name="password" placeholder="Password" value="" size="40">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-wrap">
                          <input type="submit" value="LOGIN">
                          <!-- <input name="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox" id="rememberme" value="forever" />
                          <span>Remember me</span>  -->
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <a href="#">Lost your password?</a>
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