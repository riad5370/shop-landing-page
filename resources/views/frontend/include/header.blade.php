<div class="nav naavv">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-6">
                <a href="{{url('/')}}" style="text-decoration: none">
                    <h1 class="text-white">Logo</h1>
                </a>
            </div>
            <div class="col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-end">
                <a href="https://www.facebook.com/SRCodeX" aria-label="Facebook" class="mx-2">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://wa.me/+8801518991321" aria-label="LinkedIn" class="mx-2">
                    <i class="fab fa-whatsapp"></i>
                </a> <span class="mx-3 text-white">|</span>

                <div class="cart-icon" onclick="toggleSidebar()">
                    <a href="{{route('cart')}}"><i class="fas fa-shopping-cart text-white"></i></a>
                    @php
                        if (!session()->has('customer_id')) {
                            session(['customer_id' => uniqid()]);
                        }
                        $customer_id = session('customer_id');
                    @endphp
                    <span class="cart-count">
                        {{ App\Models\Cart::where('customer_id',$customer_id)->count() }}
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>