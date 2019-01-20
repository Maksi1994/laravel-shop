<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Order\OrderCollection;
use App\Http\Resources\Backend\Order\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    public function getList(Request $request)
    {
        $orders = Order::selectRaw('
             orders.created_at,
             SUM(order_product.count) as count,
             SUM(order_product.count * order_product.price) as full_price
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy(['orders.id'])
            ->paginate('10', null, null, $request->page ?? 1);

        return new OrderCollection($orders);
    }

    public function getOne(Request $request)
    {
        $order = Order::with(['products', 'user'])->find($request->id);

        return new OrderResource($order);
    }

    public function update(Request $request)
    {
        $success = (boolean)Order::where('id', $request->id)->update($request->all());

        return $this->success($success);
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
            $orderDataForSaving = [];

            collect($request->products)->eachSpread(function ($product) use (&$orderDataForSaving) {
                $orderDataForSaving[$product['product_id']] = [
                    'count' => $product['count']
                ];
            });

            $order->products()->sync($orderDataForSaving);
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Order::destroy($request->id);

        return $this->success($success);
    }
}
