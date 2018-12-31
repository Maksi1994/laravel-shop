<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function getAll(Request $request)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        return response()->json([
            'result' => $categories->map(function($category) {
               return [
                   'id' => $category->id,
                   'name' => $category->name,
                   'created_at' => $category->create_at
               ];
            })
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);

        if (!$validator->fails()) {
            $success = Category::create($request->all());

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
        $success = Category::where('id', $request->id)->update($request->all());

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = Category::destroy($request->id);

        return response()->json([
            'success' => (boolean)$success
        ]);
    }

}
