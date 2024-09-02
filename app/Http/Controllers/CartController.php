<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){

        if (!session()->has('customer_id')) {
            session(['customer_id' => uniqid()]);
        }
        $customer_id = session('customer_id');
        $carts = Cart::where('customer_id', $customer_id )->get();
        return view('frontend.page.cart',[
            'carts'=>$carts
        ]);
    }
    public function cartStore(Request $request) {
        if (!session()->has('customer_id')) {
            session(['customer_id' => uniqid()]);
        }
        $customer_id = session('customer_id');
        $cartItem = Cart::where('customer_id', $customer_id)
                        ->where('product_id', $request->product_id)
                        ->first();
    
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return back()->with('success', 'Product added to cart successfully!');
    }

    public function cartRemove($id){
        cart::find($id)->delete();
      return back();
    }

    public function cartUpdate(Request $request){
        $carts = $request->all();
        foreach($carts['quantity'] as $cart_id=>$quantity){
          cart::find($cart_id)->update([
              'quantity'=>$quantity,
          ]);
        }
        return back();
     }
}
