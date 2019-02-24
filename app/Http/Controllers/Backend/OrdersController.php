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
        $orders = Order::list($request->all())->paginate('10', null, null, $request->page ?? 1);
        $priceRange = Order::priceRange();

        return (new OrderCollection($orders))->additional([
            "max_price" => $priceRange->max_price,
        ]);
    }

    public function getOne(Request $request)
    {
        $orderProducts = Order::getOne($request->all());

        return new OrderProductsCollection($orderProducts);
    }

    public function update(Request $request)
    {
        $success = false;
        $validationProducts = Validator::make($request->all(), [
                'products.*.product_id' => 'required',
                'products.*.count' => 'required|numeric|min:1',
                'order_id' => 'required|exists:orders.id'
            ]
        );

        if (!$validationProducts->fails()) {
            Order::find($request->order_id)->update($request->all());
            Order::attachProducts($request->all());

            $success = true;
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Order::destroy($request->id);

        return $this->success($success);
    }
}
