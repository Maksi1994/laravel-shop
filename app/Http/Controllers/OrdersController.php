<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrdersController extends Controller
{
    public function create(Request $request) {
      $success = false;
      $orderData = $request->all();
      $orderData['user_id'] =

      $validationOrder = Validator::make($orderData,
        [
            'city_id' => 'required',
            'user_id' => 'required',
            'products.*.product_id' => 'required',
            'products.*.count' => 'required|numeric|min:1'
        ]
      );

      if (!$validationOrder->fails()) {
        $order =  Order::create($request->all());
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

    public  function delete(Request $request) {
      $success = false;

      if (!empty($request->id)) {
        $success = (boolean) Order::destroy($request->id);
      }

      return response()->json(compact('success'));
    }


}
