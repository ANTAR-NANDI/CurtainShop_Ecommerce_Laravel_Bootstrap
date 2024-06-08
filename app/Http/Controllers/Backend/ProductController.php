<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::getAllProduct();
        return view('backend.product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = Brand::get();
        $category = Category::where('is_parent', 1)->get();
        // return $category;
        return view('backend.product.create')->with('categories', $category)->with('brands', $brand);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'nullable|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);
        $product = new Product();
        $product->title = $request->title;
        $product->summary = $request->summary;
        $product->description = $request->description;
        $product->is_featured = $request->input('is_featured', 0);
        $product->cat_id = $request->cat_id;
        $product->child_cat_id = $request->child_cat_id;
        $product->price = $request->price;
        $product->discount = $request->discount ? $request->discount : 0;
        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $product->slug = $slug;
        $size = $request->input('size');
        if ($size) {
            $product->size = implode(',', $size);
        } else {
            $product->size = '';
        }
        $product->brand_id = $request->brand_id;
        $product->condition = $request->condition ? $request->condition : 'default';
        $product->stock = $request->stock;
        $product->status = $request->status;
        //upload image
        if ($request->hasfile('photo')) {
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/products/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/products/' . $name_gen));
            $product->photo = $name_gen;
            // $originalImage = $request->file('photo');
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/thumbnail/products/';
            // $originalPath = public_path() . '/uploads/images/products/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $product->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $product->save();
        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
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
    public function edit(string $id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = Category::where('is_parent', 1)->get();
        $items = Product::where('id', $id)->get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'nullable',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|nullable|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);
        $size = $request->input('size');
        if ($size) {
            $product->size = implode(',', $size);
        } else {
            $product->size = '';
        }
        $product->is_featured = $request->input('is_featured', 0);
        $product->title = $request->title;
        $product->summary = $request->summary;
        $product->description = $request->description;

        $product->cat_id = $request->cat_id;
        $product->child_cat_id = $request->child_cat_id;
        $product->price = $request->price;
        $product->discount = $request->discount ? $request->discount : 0;
        if ($request->hasfile('photo')) {
            // dd("Test");
            if (file_exists(public_path() . '/uploads/thumbnail/products/' . $product->photo)) {
                unlink(public_path() . '/uploads/thumbnail/products/' . $product->photo);
            }
            if (file_exists(public_path() . '/uploads/images/products/' . $product->photo)) {
                unlink(public_path() . '/uploads/images/products/' . $product->photo);
            }
            $image = $request->file('photo');
            $manager = new ImageManager(new Driver());
            $name_gen = time() . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img = $img->resize(600, 600);
            $img->toJpeg(80)->save(base_path('public/uploads/thumbnail/products/' . $name_gen));
            $img->toJpeg(80)->save(base_path('public/uploads/images/products/' . $name_gen));
            $product->photo = $name_gen;
            // $originalImage = $request->file('photo');
            // $thumbnailImage = Image::make($originalImage);
            // $time = time();
            // $thumbnailPath = public_path() . '/uploads/images/products/';
            // $originalPath = public_path() . '/uploads/thumbnail/products/';
            // $thumbnailImage->save($originalPath . $time . $originalImage->getClientOriginalName());
            // $thumbnailImage->resize(150, 150);
            // $thumbnailImage->save($thumbnailPath . $time . $originalImage->getClientOriginalName());
            // $product->photo = $time . $originalImage->getClientOriginalName();
        }
        $status = $product->save();
        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
