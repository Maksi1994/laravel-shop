<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Product\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function getAll(Request $request)
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(15, ['*'], ['page'], $request->page);

        return response()->json([
            'meta' => [
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'last_page' => $categories->lastPage()
            ],
            'result' => $categories->all()
        ]);
    }

    public function create(Request $request)
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'name' => 'required|unique:categories'
        ]);

        if (!$validator->fails()) {
            $success = Category::create($requestData);

            return response()->json([
                'success' => (boolean)$success
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function getOne(Request $request)
    {
        $category = Category::find($request->id);

        return response()->json([
            'result' => $category
        ]);
    }

    public function update(Request $request)
    {

    }

    public function delete(Request $request)
    {
        $success = Category::destroy($request->id);

        return response()->json([
            'success' => (boolean)$success
        ]);
    }

}
