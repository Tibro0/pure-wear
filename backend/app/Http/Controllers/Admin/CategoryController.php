<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category Created Successfully!',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found!',
                'data' => [],
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name,'.$id,
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return response()->json([
            'status' => 200,
            'message' => 'Category Updated Successfully!',
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        if ($category === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found!',
                'data' => [],
            ], 404);
        }

        $category->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Category Deleted Successfully!',
        ], 200);
    }
}
