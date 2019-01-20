<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BasketsController extends Controller
{

    public function getOne(Request $request)
    {
        $basket = Basket::with('products')->find($request->id);

        // return
    }

    public function create(Request $request)
    {
        $request->merge(['customer_id' => Auth::id()]);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'products.*.id' => 'required|exists:products,id',
            'products.*.count' => 'required|min:1'
        ]);
        $success = false;

        if (!$validator->fails()) {
            $basket = Basket::create($request->all());
            $basketProduct = [];

            collect($request->product)->eachSpread(function($product) use (&$basketProduct) {
                $basketProduct[$product->id] = [
                    'count' => $product->count
                ];
            });
            $basket->products()->sync($basketProduct);

            $success = true;
        }

        return $this->success($success);
    }

    public function update()
    {

    }

    public function delete(Request $request)
    {
        $success = (boolean)Basket::destroy($request->id);

        return $this->success($success);
    }
}
