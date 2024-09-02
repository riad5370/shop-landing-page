<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Photo;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Thumnail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.product.index',[
            'products'=>$products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slug = Str::lower(str_replace(' ', '-', $request->name)) . '-' . rand(0, 100000000);
        $after_discount = $request->price - ($request->price * $request->discount / 100);
        
        $rules = [
            'name' => 'required',
            'category' => 'nullable',
            'brand' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable|numeric',
            'vdo_link' => 'nullable',
            'long_desp' => 'nullable',
            'preview' => 'required|image|mimes:jpg,png,webp,jpeg|max:600',
        ];
        //validate data
        $validatedData = $request->validate($rules);

        // Add additional fields
        $validatedData['after_discount'] = $after_discount;
        $validatedData['slug'] = $slug;

        //preview image manage
        if ($request->hasFile('preview')) {
            $imageName = Photo::uploadImage($request->file('preview'), '/images/products/preview/');
            $validatedData['preview'] = $imageName;
        }
        // Create the product
        $product = Product::create($validatedData);

           // Thumbnail images
        if ($request->hasFile('thumbnail')) {
            foreach($request->thumbnail as $thumbnail) {
                $imageName = Str::random(3).rand(100,999).$product->id.'.'.$thumbnail->getClientOriginalExtension();
            $thumbnail->move(public_path('/images/products/thumbnail/'), $imageName);
            Thumnail::create([
                'product_id' => $product->id,
                'thumbnail' => $imageName,
                'created_at' => Carbon::now(),
            ]);
            }
        }
        return back()->withSuccess('The product has been successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit',[
            'product'=>$product,
            'photos'=>Thumnail::where('product_id',$product->id)->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $slug = Str::lower(str_replace(' ', '-', $request->name)) . '-' . rand(0, 100000000);
        $after_discount = $request->price - ($request->price * $request->discount / 100);
        
        $rules = [
            'name' => 'required',
            'category' => 'nullable',
            'brand' => 'nullable',
            'price' => 'required',
            'discount' => 'nullable|numeric',
            'vdo_link' => 'nullable',
            'long_desp' => 'nullable',
            'preview' => 'image|mimes:jpg,png,webp,jpeg|max:600',
        ];
        //validate data
        $validatedData = $request->validate($rules);

        // Add additional fields
        $validatedData['after_discount'] = $after_discount;
        $validatedData['slug'] = $slug;

        //preview image manage
        if ($request->hasFile('preview')) {
            Photo::deleteImage('/images/products/preview/' . $product->preview);
            $imageName = Photo::uploadImage($request->file('preview'), '/images/products/preview/');
            // dd($imageName); // Uncomment this line if you still want to debug the image name
            $validatedData['preview'] = $imageName;
        }
        // update the product
        $product->update($validatedData);

         // Thumbnail images
         $thumbnails = Thumnail::where('product_id', $product->id)->get();
         if ($request->hasFile('thumbnail')) {
             foreach ($thumbnails as $thumbnail) {
                 // Delete existing thumbnails
                 Photo::deleteImage('/images/products/thumbnail/' . $thumbnail->thumbnail);
                 $thumbnail->delete();
             }
             foreach ($request->file('thumbnail') as $thumbnailFile) {
                 $imageName = Str::random(3) . rand(100, 999) . $product->id . '.' . $thumbnailFile->getClientOriginalExtension();
                 $thumbnailFile->move(public_path('/images/products/thumbnail/'), $imageName);
                 Thumnail::updateOrCreate(
                     ['product_id' => $product->id, 'thumbnail' => $imageName],
                     ['created_at' => Carbon::now()]
                 );
             }
         }
        return redirect()->route('products.index')->withSuccess('The product has been successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->preview) {
            // Delete preview image
            Photo::deleteImage('/images/products/preview/' . $product->preview);
        }
    
        // Thumbnail image delete
        $thumbnails = Thumnail::where('product_id', $product->id)->get();
        foreach ($thumbnails as $thumbnail) {
            $delete_thum = $thumbnail->thumbnail;
            // Rest of the code for deleting thumbnails
            Photo::deleteImage('/images/products/thumbnail/' . $delete_thum);
            $thumbnail->delete();
        }
    
        $product->delete();
        return back()->with('success', 'Your Record Has been deleted');
    }
}
