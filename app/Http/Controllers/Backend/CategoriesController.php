<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Category\CategoryCollection;
use App\Http\Resources\Backend\Category\CategoryResource;
use App\Models\Backend\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function getAll(Request $request)
    {
        $categories = Category::orderBy('created_at', 'desc')->get();

        return new CategoryCollection($categories);
    }

    public function getOne(Request $request)
    {
        $category = Category::find($request->id);

        return new CategoryResource($category);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);

        if (!$validator->fails()) {
            Category::create($request->all());
            $success = true;
        }

        return $this->success($success);
    }

    public function update(Request $request)
    {
        $success = (boolean) Category::where('id', $request->id)->update($request->all());

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean) Category::destroy($request->id);

        return $this->success($success);
    }

}
