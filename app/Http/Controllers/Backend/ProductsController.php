<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Product\ProductResource;
use App\Http\Resources\Backend\Product\ProductСollection;
use App\Models\Backend\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{

    public function getAll(Request $request)
    {
        $baseQuery = Product::with('category');

        $products = Product::with('category')
            ->filter($request->all())
            ->orderBy('created_at', $request->order ?? 'desc')
            ->paginate(15, ['*'], ['page'], $request->page);

        $priceRange = $baseQuery->selectRaw('MAX(products.price) as max_price, MIN(products.price) as min_price')->first();
        $responseData = new ProductСollection($products);

        return $responseData->additional([
            "max_price" => $priceRange->max_price,
            "min_price" => $priceRange->min_price
        ]);
    }

    public function getOne(Request $request)
    {
        $product = Product::selectRaw('
        ANY_VALUE(products.id),
        COUNT(order_product.count) as sum_boughts,
        ANY_VALUE(products.price),
        ANY_VALUE(products.image),
        ANY_VALUE(products.name),
        ANY_VALUE(products.created_at),
        ANY_VALUE(products.category_id)
        ')->leftJoin('order_product', 'order_product.product_id', '=', 'products.id')
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
        $productData = $request->all();
        $validator = Validator::make($productData, [
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'required'
        ]);

        $extension = $request->file('image')->extension();
        $photo = Storage::disk('space')->putFileAs('shop/products', $request->image, time() . '.' . $extension, 'public');

        if (!$validator->fails()) {
            $productData['image'] = $photo;
            $product = Product::create($productData);
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
            'price' => 'required|numeric',
            'category_id' => 'required'
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
