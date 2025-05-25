<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:products,title',
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'sku' => 'required|max:255|unique:products,sku',
            'is_featured' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        // $product->image = $request->image;
        $product->category_id = $request->category;
        $product->brand_id  = $request->brand;
        $product->qty  = $request->qty;
        $product->sku  = $request->sku;
        $product->barcode  = $request->barcode;
        $product->status  = $request->status;
        $product->is_featured  = $request->is_featured;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product Created Successfully!',
            'data' => $product,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found!',
                'data' => [],
            ], 404);
        }


        return response()->json([
            'status' => 200,
            'data' => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found!',
                'data' => [],
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:products,title,' . $id,
            'price' => 'required|numeric',
            'category' => 'required|integer',
            'sku' => 'required|max:255|unique:products,sku,' . $id,
            'is_featured' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }


        $product->title = $request->title;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->description = $request->description;
        $product->short_description = $request->short_description;
        // $product->image = $request->image;
        $product->category_id = $request->category;
        $product->brand_id  = $request->brand;
        $product->qty  = $request->qty;
        $product->sku  = $request->sku;
        $product->barcode  = $request->barcode;
        $product->status  = $request->status;
        $product->is_featured  = $request->is_featured;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product Updated Successfully!',
            'data' => $product,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found!',
                'data' => [],
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Product Deleted Successfully!',
        ], 200);
    }
}
