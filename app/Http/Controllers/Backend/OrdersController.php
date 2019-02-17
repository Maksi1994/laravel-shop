<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Order\OrderCollection;
use App\Http\Resources\Backend\Order\OrderProductsCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{

    public function getList(Request $request)
    {
        $orders = Order::selectRaw('
             orders.id as id,
             orders.created_at as created_at,
             SUM(order_product.count) as count,
             SUM(order_product.count * order_product.price) as full_price,
             CONCAT(users.first_name, " ", users.last_name)  as customer_name,
             users.id as customer_id
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->filter($request->all())
            ->groupBy('orders.id')
            ->paginate('10', null, null, $request->page ?? 1);

        $priceRange = Order::selectRaw('SUM(order_product.count * order_product.price) as max_price')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->groupBy('orders.id')
            ->orderBy('max_price', 'desc')
            ->first();

        return (new OrderCollection($orders))->additional([
            "max_price" => $priceRange->max_price,
        ]);
    }

    public function getOne(Request $request)
    {
        $orderProducts = $orders = Order::selectRaw('
             ANY_VALUE(orders.id) as order_id,
             ANY_VALUE(orders.created_at) as created_at,
             ANY_VALUE(products.id) as id,
             ANY_VALUE(order_product.name) as name,
             ANY_VALUE(categories.name) as category_name,
             ANY_VALUE(categories.id) as categories_id,
             ANY_VALUE(products.image) as image,
             SUM(order_product.count) as count,
             ANY_VALUE(order_product.price) as price_for_one,
             SUM(order_product.count * order_product.price) as full_price,
             ANY_VALUE(CONCAT(users.first_name, " ", users.last_name))  as customer_name,
             ANY_VALUE(users.id) as customer_id
             ')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_product', 'orders.id', '=', 'order_product.order_id')
            ->leftJoin('products', 'order_product.product_id', '=', 'products.id')
            ->leftJoin('categories', 'categories.id' , '=', 'products.category_id')
            ->groupBy(DB::raw(' order_product.product_id with ROLLUP'))
            ->where('order_id', $request->id)
            ->get();

        return new OrderProductsCollection($orderProducts);
    }

    public function update(Request $request)
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

            $order->update($request->all());
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
