<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\BuyCart;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request) {
        if (!session()->has('customer_id')) {
            $request->session()->put('customer_id', uniqid());
        }

        $customer_id = $request->session()->get('customer_id');
        if ($request->click == 1) {
            BuyCart::where('customer_id', $customer_id)->delete();

            BuyCart::create([
                'customer_id' => $customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
            $carts = BuyCart::where('customer_id', $customer_id)->get();
            $request->session()->put('checkout_source', 'buycart');
        } else {
            $carts = Cart::where('customer_id', $customer_id)->get();
            $request->session()->put('checkout_source', 'cart');
        }
        $request->session()->put('carts', $carts);
        return redirect()->route('checkout.show');
            
    }
    public function checkoutShow(Request $request){
        $carts = $request->session()->get('carts', []);

        return view('frontend.page.checkout', ['carts' => $carts]);
    }
    
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'charge' => 'required',
        ]);
        
        $order_id = '#'.Str::upper(Str::random(3)).'-'.rand(99999999,1000000000);
        $total = $request->subtotal + $request->charge;
        Order::insert([
            'order_id'=>$order_id,
            'sub_total'=>$request->subtotal,
            'total'=>$total,
            'charge'=>$request->charge,
            'created_at'=>Carbon::now(),
        ]);

        BillingDetails::insert([
            'order_id'=>$order_id,
            'name'=>$request->name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'created_at'=>Carbon::now(),
        ]);

        if (!session()->has('customer_id')) {
            session(['customer_id' => uniqid()]);
        }
        
        $customer_id = session('customer_id');
        $checkout_source = session('checkout_source');

        if ($checkout_source == 'buycart') {
            $carts = BuyCart::where('customer_id', $customer_id)->get();
        } else {
            $carts = Cart::where('customer_id', $customer_id)->get();
        }

        foreach($carts as $cart){
            OrderProduct::insert([
                'order_id'=>$order_id,
                'product_id'=>$cart->product_id,
                'price'=>$cart->product->after_discount,
                'quantity'=>$cart->quantity,
                'created_at'=>Carbon::now(),
            ]);
        }

        // Clear the appropriate cart
        if ($checkout_source == 'buycart') {
            BuyCart::where('customer_id', $customer_id)->delete();
        } else {
            Cart::where('customer_id', $customer_id)->delete();
        }

        $abc = substr($order_id, 1,13);
        return redirect()->route('order.success',$abc)->with('success','adaa');
    }
}
