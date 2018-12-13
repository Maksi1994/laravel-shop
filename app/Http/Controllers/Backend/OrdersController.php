<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    public function getList(Request $request)
    {
        $orders = Order::with(['products', 'user'])
            ->paginate(10, ['*'], ['page'], ($request->page ?? 1));

        return response()->json([
            'result' => $orders->values(),
            'meta' => [
                'per_page' => $orders->perPage(),
                'last_page' => $orders->lastPage(),
                'page' => $orders->currentPage()
            ]
        ]);
    }

    public function getOne(Request $request)
    {
        $order = Order::with(['products', 'user'])
            ->where('id', '=', $request->id)
            ->get();

        return response()->json([
            'result' => $order->values()
        ]);
    }

    public function update(Request $request)
    {
        $success = (boolean)Order::where('id', $request->id)->update($request->all());

        return response()->json(compact('success'));
    }

    public function setProducts(Request $request)
    {
        $success = false;

        $validationProducts = Validator::make($request->all(),
            [
                'products.*.product_id' => 'required',
                'products.*.count' => 'required|numeric|min:1',
                'order_id' => 'required'
            ]
        );

        $order = Order::find($request->order_id);

        if (!$validationProducts->fails() && $order) {
            $currentProducts = $request->products;
            $success = true;
            $products = [];

            array_walk($currentProducts, function ($product) use (&$products)  {
                $products[$product['product_id']] = [
                    'count' => $product['count']
                ];
            });

            $order->products()->sync($products);
        }

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = (boolean)Order::destroy($request->id);

        return response()->json(compact('success'));
    }
}
