<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'DESC')->get();
        return response()->json([
            'status' => 200,
            'data' => $sizes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:sizes,name',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $size = new Size();
        $size->name = $request->name;
        $size->status = $request->status;
        $size->save();

        return response()->json([
            'status' => 200,
            'message' => 'Size Created Successfully!',
            'data' => $size,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $size = Size::findOrFail($id);

        if ($size === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Size Not Found!',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $size = Size::findOrFail($id);

        if ($size === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Size Not Found!',
                'data' => [],
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:sizes,name,' . $id,
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors(),
            ], 400);
        }

        $size->name = $request->name;
        $size->status = $request->status;
        $size->save();

        return response()->json([
            'status' => 200,
            'message' => 'Size Updated Successfully!',
            'data' => $size,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);

        if ($size === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Size Not Found!',
                'data' => [],
            ], 404);
        }

        $size->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Size Deleted Successfully!',
        ], 200);
    }
}
