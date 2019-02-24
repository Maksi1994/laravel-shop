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
        $products = Product::list($request->all())->paginate(15, ['*'], ['page'], $request->page ?? 1);
        $priceRange = Product::priceRange();

        return (new ProductСollection($products))->additional([
            "max_price" => $priceRange->max_price,
            "min_price" => $priceRange->min_price
        ]);
    }

    public function getOne(Request $request)
    {
        $product = Product::getOne($request->all());

        return (new ProductResource($product))->additional([
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

        if (!$validator->fails()) {
            $product = Product::create($request->all());

            if (!empty($request->image)) {
                $extension = $request->file('image')->extension();
                $photo = Storage::disk('space')->putFileAs('shop/products', $request->image, time() . '.' . $extension, 'public');
                $request->merge(['image' => $photo]);
            }

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

        if ($product) {
            if (Storage::disk('space')->exists($product->image) && !empty($request->image)) {
                Storage::disk('space')->delete($product->image);
                $extension = $request->file('image')->extension();
                $photo = Storage::disk('space')->putFileAs('shop/products', $request->image, time() . '.' . $extension, 'public');

                $request->merge(['image' => $photo]);
            }

            $product->update($request->all());
            $success = true;
        }

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = (boolean)Product::find($request->id);

        return $this->success($success);
    }
}
