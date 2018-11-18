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
        $page = $request->get('page');
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $products = Product::with('categories')
            ->orderBy('name', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return response()->json($products->map(function ($product) {
            return [
                'name' => $product['name'],
                'cat' => $product
            ];
        }));
    }

    public function getOne(Request $request)
    {
        $product = Product::find($request->get('id'));

        return response()->json([
            'result' => $product
        ]);
    }

    public function createProduct(Request $request)
    {
        $reqData = $request->all();
        $photo = 'image.png';

        $reqData['image'] = $photo;

        $validator = Validator::make($reqData, [
            'name' => ['required'],
            'category_id' => ['required'],
            'image' => ['required']
        ]);

        if (!$validator->failed()) {

            Product::create($reqData);

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'success' => false
        ]);
    }

    public function updateProduct(Request $request)
    {

    }

    public function deleteProduct(Request $request)
    {

    }
}
