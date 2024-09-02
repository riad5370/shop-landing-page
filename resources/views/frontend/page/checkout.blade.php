@extends('frontend.include.master')
@section('body')
<!--start breadcamp-->
<div class="bg-light" style="font-family: Arial, sans-serif;">
    <div class="container ">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-3 rounded">
                <li class="breadcrumb-item"><a href="{{url('/')}}" class="text-primary text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcamp-->

<!--start billing details-->
<section class="my-4">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="first-name" class="form-label">Name</label>
                                        <input type="text" name="name" id="first-name" class="form-control" value="{{old('name')}}" placeholder="Enter your name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="phone" name="phone" class="form-label">Phone</label>
                                        <input type="number" value="{{old('phone')}}" id="phone" name="phone" class="form-control" placeholder="Enter your Mobile Number">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Address</label>
                                <textarea id="message" name="address" class="form-control" rows="4" placeholder="Enter your Address">{{old('address')}}</textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 orderDetails">
                <aside class="card">
                    <article class="card-body">
                        <header class="mb-4">
                            <h4 class="card-title" style="font-size: 16px;">Details</h4>
                        </header>
                        <div class="row">
                            <div class="table-responsive bg-white">
                                <table class="table border-bottom">
                                    <thead>
                                        <tr>
                                            <th class="product-image">Image</th>
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-price">Qt</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach($carts as $cart)
                                        <tr class="cart-item">
                                            <td class="product-image" style="display: flex; align-items: center;">
                                                <a data-href="" class="btn btn-danger" type="button" style="margin-right: 2px;">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a href="">
                                                    <img class="lazyload" src="{{asset('images/products/preview/'.$cart->product->preview)}}" style="max-width: 50px;">
                                                </a>
                                            </td>
                                            <td class="product-name">
                                                <span class="d-block">{{$cart->product->name}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span class="d-block">৳{{$cart->product->after_discount}}</span>
                                            </td>
                                            <td class="product-price">
                                                <span class="d-block">{{$cart->quantity}}</span>
                                            </td>
                                            <input type="hidden" name="price" value="{{$cart->product->after_discount}}">
                                            <input type="hidden" name="quantity" value="{{$cart->quantity}}">
                                            @php
                                            $subtotal = $cart->product->after_discount * $cart->quantity;
                                            $total += $subtotal;
                                            @endphp
                                            <td class="product-total">
                                                <span>৳{{$subtotal}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </article>
                    <div class="mb-4">
                        <fieldset class="form-group">
                            <legend>Delivery Location</legend>
                            <ul class="no-ul-list">
                                <li>
                                    <input id="c1" class="radio-custom delivery" name="charge" type="radio" value="70">
                                    <label for="c1" class="radio-custom-label">Inside City</label>
                                </li>
                                <li>
                                    <input id="c2" class="radio-custom delivery" name="charge" type="radio" value="150">
                                    <label for="c2" class="radio-custom-label">Outside City</label>
                                </li>
                            </ul>
                        </fieldset>
                    </div>
                    
                    <article class="card-body border-top total_section">
                        <div class="row">
                            <div class="col-md-6 col-6"><p class="h6 text-dark">Subtotal:</p></div>
                            <div class="col-md-6 col-6"><p data_subtotal="{{$total}}" id="sub_total" class="h6 text-dark">৳{{$total}}</p></div>
                            <div class="col-md-6 col-6"><p class="h6 text-dark">Delivery charge:</p></div>
                            <div class="col-md-6 col-6"><p id="charge" class="h6 text-danger delivery_charge">৳0</p></div>
                            <div class="col-md-6 col-6"><p class="h6 text-dark">Total:</p></div>
                            <div class="col-md-6 col-6"><p id="grand_total" class="h6 text-dark total">৳{{$total}}</p></div>
                            <input type="hidden" value="{{$total}}" name="subtotal" id="amount">
                        </div>
                    </article>
                </aside>
            </div>
            
        </form>
        </div>
    </div>
</section>
<!--end billing details-->
@endsection
@push('js')
<script>
    $('.delivery').click(function() {
        var charge = $(this).val();
        var sub_total = $('#sub_total').attr('data_subtotal');
        var grand_total = parseInt(sub_total) + parseInt(charge);
        $('#charge').html(charge);
        $('#grand_total').html(grand_total.toLocaleString('en-US', {
            maximumFractionDigits: 2
        }));
    });
</script>
@endpush