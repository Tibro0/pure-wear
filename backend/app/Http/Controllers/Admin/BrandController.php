<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:brands,name',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand Created Successfully!',
            'data' => $brand,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand Not Found!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand Not Found!',
                'data' => [],
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:brands,name,' . $id,
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();

        return response()->json([
            'status' => 200,
            'message' => 'Brand Updated Successfully!',
            'data' => $brand,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Brand Not Found!',
                'data' => [],
            ], 404);
        }

        $brand->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Brand Deleted Successfully!',
        ], 200);
    }
}
