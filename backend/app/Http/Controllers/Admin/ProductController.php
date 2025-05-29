<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->with('product_images')->get();
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

        // save product images
        if (!empty($request->gallery)) {
            foreach ($request->gallery as $key => $tempImageId) {
                $tempImage = TempImage::findOrFail($tempImageId);

                // longer Thumbnail
                $extArray = explode('.', $tempImage->name);
                $ext = end($extArray);

                $imageName = $product->id . '-' . time() . '.' . $ext;
                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/temp/' . $tempImage->name));
                $img->scaleDown(1200);
                $img->save(public_path('uploads/products/large/' . $imageName));

                // Small Thumbnail
                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/temp/' . $tempImage->name));
                $img->coverDown(400, 460);
                $img->save(public_path('uploads/products/small/' . $imageName));

                $productImage = new ProductImage();
                $productImage->image = $imageName;
                $productImage->product_id = $product->id;
                $productImage->save();

                if ($key === 0) {
                    $product->image = $imageName;
                    $product->save();
                }
            }
        }

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
        $product = Product::with('product_images')->findOrFail($id);

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

    public function saveProductImage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()->toArray(),
            ], 400);
        }

        $image = $request->file('image');
        $imageName = $request->product_id . '-' . time() . '.' . $image->extension();

        // longer Thumbnail
        $manager = new ImageManager(Driver::class);
        $img = $manager->read($image->getPathName());
        $img->scaleDown(1200);
        $img->save(public_path('uploads/products/large/' . $imageName));

        // Small Thumbnail
        $manager = new ImageManager(Driver::class);
        $img = $manager->read($image->getPathName());
        $img->coverDown(400, 460);
        $img->save(public_path('uploads/products/small/' . $imageName));

        // insert a record in product_images table
        $productImage = new ProductImage();
        $productImage->image = $imageName;
        $productImage->product_id = $request->product_id;
        $productImage->save();

        return response()->json([
            'status' => 200,
            'message' => 'Image Uploaded Successfully!',
            'data' => $productImage,
        ], 200);
    }
}
