<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BasketsController extends Controller
{

    public function getBasket(Request $request)
    {
        $basket = Basket::selectRaw('
            SUM(products.price * basket_product.count) as price,
            ANY_VALUE(basket_product.count) as count,
            products.id as id,
            ANY_VALUE(products.name) as name,
            ANY_VALUE(products.image) as image,
            ANY_VALUE(baskets.updated_at) as updated_at
            ')
            ->leftJoin('basket_product', 'baskets.id', '=', 'basket_product.basket_id')
            ->leftJoin('products', 'basket_product.product_id', '=', 'products.id')
            ->whereRaw('customer_id = ?', [Auth::id()])
            ->groupBy(DB::raw('products.id with rollup'))
            ->get();

        $last_row = $basket->pop();

        return response()->json([
            'result' => $basket->map(function ($product) use ($last_row) {
                return [
                    'id' => $product->id,
                    'price' => $product->price,
                    'name' => $product->name,
                    'image' => $product->image,
                    'updated_at' => $product->updated_at->format('Y M d    -   h:m A')
                ];
            }),
            'full_price' => $last_row->price
        ]);
    }

    public function saveBasket(Request $request)
    {
        $request->merge(['customer_id' => Auth::id()]);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.count' => 'required|min:1'
        ]);

        $success = false;

        if (!$validator->fails()) {
            Basket::saveBasket($request);
            $success = true;
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        Basket::where('customer_id', $request->customer_id)->delete();

        return $this->success(true);
    }
}
