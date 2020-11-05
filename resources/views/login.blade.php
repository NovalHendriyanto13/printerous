@extends('layouts.auth')

@section('content')
<form class="form form-horizontal" action="login" method="post">
  <div class="content content-fixed content-auth">
    <div class="container">
      <div class="media align-items-stretch justify-content-center ht-100p pos-relative">
        <div class="media-body align-items-center d-none d-lg-flex">
          <!-- <div class="mx-wd-600">
            <img src="{{asset('assets/img/auth_bg.png')}}" class="img-login" alt="">
          </div> -->
          <div data-label="Example" class="df-example">
            <div id="carouselExample2" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('assets/img/auth_bg.png')}}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="{{asset('assets/img/auth_bg2.png')}}" class="d-block w-100" alt="...">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExample2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"><i data-feather="chevron-left"></i></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExample2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"><i data-feather="chevron-right"></i></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div><!-- df-example -->
        </div><!-- media-body -->
        <div class="sign-wrapper mg-lg-l-50 mg-xl-l-60">
          <div class="wd-100p">
            <h3 class="tx-color-01 mg-b-5">Sign In</h3>
            <p class="tx-color-03 tx-16 mg-b-40">Welcome back! Please signin to continue.</p>
            <x-alert><div class="alert-msg"></div></x-alert>
            <div class="form-group">
              <label>Email address</label>
              <input type="email" class="form-control" placeholder="yourname@yourmail.com" name="username" required="true">
            </div>
            <div class="form-group">
              <div class="d-flex justify-content-between mg-b-5">
                <label class="mg-b-0-f">Password</label>
                <a href="{{URL::to('forgot-password')}}" class="tx-13">Forgot password?</a>
              </div>
              <input type="password" class="form-control" placeholder="Enter your password" name="password" required="true">
            </div>
            <button class="btn btn-brand-02 btn-block">
              <span class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true" style="display: none;"></span>
              Sign In
            </button>
            <!-- <div class="divider-text">or</div>
            <button class="btn btn-outline-facebook btn-block">Sign In With Facebook</button>
            <button class="btn btn-outline-twitter btn-block">Sign In With Twitter</button>
            <div class="tx-13 mg-t-20 tx-center">Don't have an account? <a href="page-signup.html">Create an Account</a></div> -->
          </div>
        </div><!-- sign-wrapper -->
      </div><!-- media -->
    </div><!-- container -->
  </div><!-- content -->
</form>
@endsection