<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Category\CategoryCollection;
use App\Http\Resources\Backend\Category\CategoryResource;
use App\Models\Backend\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function getAll(Request $request)
    {
        $categories = Category::with('parent')->withCount('products')->get();

        return new CategoryCollection($categories);
    }

    public function getOne(Request $request)
    {
        $category = Category::with('parent')->withCount('products')->find($request->id);

        return new CategoryResource($category);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);
        $success = false;

        if (!$validator->fails()) {
            $category = Category::create([
              'name' => $request->name,
              'parent_id' => !empty($request->parentId) ? $request->parentId : 0
            ]);
            $success = true;
        }

        return response()->json([
            'result' => [
                'success' => $success,
                'id' => !empty($category) ? $category->id : null
            ]
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories')->ignore($request->id),
            ],
        ]);
        $success = false;

        if (!$validator->fails()) {
            Category::where('id', $request->id)->update([
                'name' => $request->name,
                'parent_id' => !empty($request->parentId) ? $request->parentId : 0
            ]);

            $success = true;
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Category::destroy($request->id);

        return $this->success($success);
    }

}
