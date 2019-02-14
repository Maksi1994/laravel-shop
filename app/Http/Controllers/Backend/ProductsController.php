<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Product\ProductResource;
use App\Http\Resources\Backend\Product\ProductСollection;
use App\Models\Backend\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{

    public function getAll(Request $request)
    {
        $products = Product::selectRaw('
        ANY_VALUE(products.id) as id,
        COUNT(order_product.order_id) as sum_boughts,
        ANY_VALUE(products.price) as price,
        ANY_VALUE(products.image) as image,
        ANY_VALUE(products.name) as name,
        ANY_VALUE(products.created_at) as created_at,
        ANY_VALUE(categories.id) as category_id,
        ANY_VALUE(categories.name) as category_name
        ')->leftJoin('order_product', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->filter($request->all())
            ->groupBy(['products.id'])
            ->paginate(15, ['*'], ['page'], $request->page);

        $priceRange = Product::with('category')
            ->selectRaw('MAX(products.price) as max_price, MIN(products.price) as min_price')
            ->first();
        $responseData = new ProductСollection($products);


        return $responseData->additional([
            "max_price" => $priceRange->max_price,
            "min_price" => $priceRange->min_price
        ]);
    }

    public function getOne(Request $request)
    {
        $product = Product::selectRaw('
        ANY_VALUE(products.id) as id,
        COUNT(order_product.count) as sum_boughts,
        ANY_VALUE(products.price) as price,
        ANY_VALUE(products.image) as image,
        ANY_VALUE(products.name) as name,
        ANY_VALUE(products.created_at) as created_at,
        ANY_VALUE(products.category_id) as category_id,
        ANY_VALUE(categories.name) as category_name
        ')->leftJoin('order_product', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->groupBY(['products.id'])
            ->find($request->id);
        $responseData = new ProductResource($product);

        return $responseData->additional([
            'sum_boughts' => $product->sum_boughts
        ]);
    }

    public function create(Request $request)
    {
        $success = false;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
        ]);

        if (!empty($request->image)) {
            $extension = $request->file('image')->extension();
            $photo = Storage::disk('space')->putFileAs('shop/products', $request->image, time() . '.' . $extension, 'public');
            $request->merge(['image' => $photo]);
        }

        if (!$validator->fails()) {
            $product = Product::create($request->all());
            $success = true;
        }

        return response()->json([
            'result' => [
                'success' => $success,
                'id' => !empty($product) ? $product->id : null
            ]
        ]);
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);
        $success = false;
        $productData = $request->all();
        $validator = Validator::make($productData, [
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        if ($product && !$validator->fails()) {

            if (Storage::disk('space')->exists($product->image) && $productData['image']) {
                Storage::disk('space')->delete($product->image);
                $extension = $request->file('image')->extension();
                $photo = Storage::disk('space')->putFileAs('shop/products', $request->image, time() . '.' . $extension, 'public');
                $productData['image'] = $photo;
            }
            $success = true;
            $product->update($productData);
        }

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = (boolean)Product::find($request->id);

        return $this->success($success);
    }
}
