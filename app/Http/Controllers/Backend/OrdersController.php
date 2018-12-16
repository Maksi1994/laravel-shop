<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Resources;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{

    public function getList(Request $request)
    {
        $ordersCollection = Order::with(['products', 'user'])
            ->paginate(10, ['*'], ['page'], ($request->page ?? 1));

        $ordersList = $ordersCollection->map(function($order) {
            return [
                'id' => $order->id,
                'user' => [
                    'id' => $order->user->id,
                    'first_name' => $order->user->first_name,
                    'last_name' => $order->user->last_name,
                ],
                'count' => count($order->products)
            ];
        });

        return response()->json([
            'result' => $ordersList->all(),
            'meta' => [
                'per_page' => $ordersCollection->perPage(),
                'last_page' => $ordersCollection->lastPage(),
                'page' => $ordersCollection->currentPage()
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
