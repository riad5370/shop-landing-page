@extends('frontend.include.master')
@section('body')
<!--start breadcamp-->
<div class="bg-light" style="font-family: Arial, sans-serif;">
    <div class="container ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-3 rounded">
                <li class="breadcrumb-item"><a href="{{url('/')}}" class="text-primary text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcamp-->

@php
if (!session()->has('customer_id')) {
    session(['customer_id' => uniqid()]);
    }
$customer_id = session('customer_id');
@endphp
@if (App\Models\Cart::where('customer_id', $customer_id)->count() == 0)
    <div class="container">
       <div class="text-center" style="margin: 100px 0;">
         <i class="fas fa-cart-plus " style="font-size: 80px;"></i>
          <h2 class="text-danger">Empty Cart</h2>
          <a class="btn btn-dark mt-2" href="{{ url('/') }}">Go To Shop</a>
       </div>
    </div>
@else
<div class="container my-2">
    <form action="{{ route('cart.update') }}" method="POST">
        @csrf
    <div class="table-responsive">
        <table class="table align-middle mt-3">
            <thead class="bg-secondary text-white">
                <tr>
                    <th scope="col"></th>
                    <th scope="col" class="text-uppercase">Product</th>
                    <th scope="col"></th>
                    <th scope="col" class="text-uppercase">Price</th>
                    <th scope="col" class="text-uppercase">Quantity</th>
                    <th scope="col" class="text-uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                
                @php
                $total = 0;
                @endphp
                @foreach($carts as $cart)
                <tr>
                    <td>
                        <div class="remove-product">
                            <a href="{{route('cart.remove',$cart->id)}}" class="text-danger" aria-label="Remove Product">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </td>
                    <td style="width: 60px; height: 60px;">
                        <a href="single-product.php">
                            <img class="img-fluid" src="{{asset('images/products/preview/'.$cart->product->preview)}}" alt="Product Image">
                        </a>
                    </td>
                    <td class="product-title">
                        <a href="single-product.php" class="text-dark fw-bold" style="text-decoration: none;">{{$cart->product->name}}</a>
                    </td>
                    <td class="product-price" data-title="Price">৳{{$cart->product->after_discount}}</td>
                    <td>
                        <div class="quantity-controls d-flex align-items-center">
                            <button type="button" class="btn btn-outline-secondary btn-sm buttonminus" aria-label="Decrease Quantity">-</button>
                            <input type="text" name="quantity[{{ $cart->id }}]" class="form-control text-center mx-2" id="quantity1" value="{{$cart->quantity}}" style="width: 60px;">
                            <button type="button" class="btn btn-outline-secondary btn-sm buttonplus" aria-label="Increase Quantity">+</button>
                        </div>
                    </td>
                    @php
                      $subtotal = $cart->product->after_discount * $cart->quantity;
                      $total += $subtotal; 

                    @endphp
                <td class="product-subtotal" data-title="Subtotal">৳{{ number_format($subtotal, 2) }}</td>
                
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
    <input type="submit" class="btn btn-dark" value="Update Cart">
</form>
</div>

<div class="container">
    <div class="row mb-4">
        <div class="col-xl-5 col-lg-7 offset-xl-7 offset-lg-5 cartsummery">
            <div class="order-summary p-4">
                <h5 class="title">Order Summary</h5>
                <div class="summary-table-wrap">
                    <table class="table summary-table mb--30">
                        <tbody>
                            <tr class="order-subtotal">
                                <td class="label">Subtotal</td>
                                <td class="value">৳ {{ number_format($total, 2) }}</td>
                            </tr>
                            <tr class="order-tax">
                                <td class="label">State Tax</td>
                                <td class="value">$0.00</td>
                            </tr>
                            <tr class="order-total">
                                <td class="label">Total</td>
                                <td class="value total-amount">৳ {{ number_format($total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form action="{{ route('checkout') }}" method="POST" class="w-100">
                    @csrf
                    <button type="submit" name="click" value="2" class="btn w-100 p-2 checkout-btn">Proceed to Checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection