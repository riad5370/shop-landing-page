@extends('frontend.include.master')
@section('body')
@if(session('success'))
<section class="middle py-5 bg-light" style="margin-top: 35px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                <!-- Icon -->
                <div class="p-4 d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white mx-auto mb-4" style="width: 100px; height: 100px;">
                    <i class="fas fa-check-circle fs-1"></i>
                </div>
                
                <!-- Heading -->
                <h2 class="mb-3 font-weight-bold">Order Completed!</h2>
                
                <!-- Text -->
                <p class="text-muted mb-4">Your order <span class="text-dark">#{{ $order_id }}</span> has been successfully completed. You can view your order details in your personal account.</p>
                
                <!-- Button -->
                <a class="btn btn-primary btn-lg" href="{{ url('/') }}">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>
@endif
@endsection