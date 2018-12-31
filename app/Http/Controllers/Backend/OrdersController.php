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
        $ordersCollection = Order::selectRaw('
             orders.created_at,
             SUM(order_product.count) as count,
             SUM(order_product.count * order_product.price) as full_price
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy(['orders.id'])
            ->paginate('10', null, null, $request->page ?? 1);

        return response()->json([
            'result' => $ordersCollection->all(),
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
            $success = true;
            $reveicedProductsCollection = collect($request->products);
            $orderDataForSaving = [];
            $reveicedProductsCollection->eachSpread(function ($product) use (&$orderDataForSaving) {
                $orderDataForSaving[$product['product_id']] = [
                    'count' => $product['count']
                ];
            });

            $order->products()->sync($orderDataForSaving);
        }

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = (boolean)Order::destroy($request->id);

        return response()->json(compact('success'));
    }
}
