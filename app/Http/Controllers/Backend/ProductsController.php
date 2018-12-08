<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{


    public function getAll(Request $request)
    {
        $products = Product::with('category')
            ->orderBy('name', 'desc')
            ->paginate(15, ['*'], ['page'], $request->page);


        return response()->json([
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'last_page' => $products->lastPage()
            ],
            'result' => $products->all()
        ]);
    }

    public function getOne(Request $request)
    {
        $product = Product::find($request->id);

        return response()->json([
            'result' => $product
        ]);
    }

    public function create(Request $request)
    {
        $reqData = $request->all();
        $photo = 'image.png';

        $reqData['image'] = $photo;

        $validator = Validator::make($reqData, [
            'name' => ['required'],
            'category_id' => ['required'],
            'image' => ['required']
        ]);

        if (!$validator->fails()) {
            var_dump($reqData);

            Product::create($reqData);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function update(Request $request)
    {
        $success = Product::where('id', $request->id)
            ->update([
                'name' => $request->name
            ]);

        return response()->json([
            'success' => (boolean)$success
        ]);
    }

    public function delete(Request $request)
    {
        $success = Product::destroy($request->id);

        return response()->json([
            'success' => (boolean)$success
        ]);
    }
}
