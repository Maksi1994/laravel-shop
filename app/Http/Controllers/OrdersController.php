<?php

namespace App\Http\Controllers;

use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

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
            ->where('users.id', '=', 1)
            ->groupBy('orders.id')
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

    public function create(Request $request)
    {
        $success = false;
        $orderData = $request->all();
        $orderData['user_id'] = 1;

        $validationOrder = Validator::make($orderData,
            [
                'city_id' => 'required',
                'user_id' => 'required',
                'products.*.product_id' => 'required',
                'products.*.count' => 'required|numeric|min:1'
            ]
        );

        if (!$validationOrder->fails()) {
            $success = true;

            $order = Order::create([
                'city_id' => $orderData['city_id'],
                'user_id' => $orderData['user_id']
            ]);

            $reveicedProductsCollection = collect($orderData['products']);
            $productsIdsInOrder = $reveicedProductsCollection->pluck('product_id');
            $productsInOrder = Product::whereIn('id', $productsIdsInOrder)->get();
            $orderDataForSaving = [];

            $reveicedProductsCollection->eachSpread(function ($product) use ($productsInOrder, &$orderDataForSaving) {
                $orderDataForSaving[$product['product_id']] = [
                    'count' => $product['count'],
                    'price' => $productsInOrder->where('id', $product['product_id'])->first()['price'],
                    'name' => $productsInOrder->where('id', $product['product_id'])->first()['name']
                ];
            })->all();

            $order->products()->sync($orderDataForSaving);
        }

        return response()->json(compact('success'));
    }

    public function getOne(Request $request)
    {
        $order = Order::selectRaw('
             users.first_name,
             users.last_name,
             SUM(order_product.count * order_product.price) as full_price,
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->where('users.id', '=', 1)
            ->where('orders.id', '=', $request->id)
            ->groupBy(['orders.id'])
            ->get();

        $orderProducts = Order::with('products')
            ->find($request->id)
            ->get();

        return response()->json([
            'result' => [
                'order' => $order,
                'products' => $orderProducts->products
            ]
        ]);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Order::destroy($request->id);

        return response()->json(compact('success'));
    }


}
