<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\review;
use App\Models\Thumnail;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){
        $product_info = Product::first();
        $thamnails = Thumnail::where('product_id',$product_info->id)->get();
        $products = Product::orderBy('created_at', 'desc')->where('id', '!=', $product_info->id)->get();
        $reviews = review::where('product_id',$product_info->id)->whereNotNull('comment')->get();
        return view('frontend.index',[
            'products'=>$products,
            'product_info'=>$product_info,
            'reviews'=> $reviews,
            'thamnails'=>$thamnails,
        ]);
    }
    public function details($slug){
        $product_info = Product::where('slug',$slug)->first();
        $thamnails = Thumnail::where('product_id',$product_info->id)->get();
        $products = Product::orderBy('created_at', 'desc')->where('id', '!=', $product_info->id)->get();
        $reviews = review::where('product_id',$product_info->id)->whereNotNull('comment')->get();
        return view('frontend.page.details',[
            'product_info'=>$product_info,
            'products'=>$products,
            'thamnails'=>$thamnails,
            'reviews'=>$reviews,
        ]);
    }
    public function orderSuccess($abc){
        if(session('success')){
            return view('frontend.page.order_success',[
                'order_id'=>$abc,
            ]);
        }
        else {
            abort(404);
        }
    }

    public function reviewStore(Request $request){
        $rules = [
            'product_id'=>'required',
            'name'=>'required|string',
            'comment'=>'required|string',
            'star'=>'required|string',
        ];
        $validatedData = $request->validate($rules);
        review::create($validatedData);
        return response()->json(['success' => 'Message Sent!']);
    }

}
