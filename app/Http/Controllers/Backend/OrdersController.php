<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\Order;

class OrdersController extends Controller
{
    
    public function getList(Request $request) {
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
    
    public function getOne(Request $request) {
        $order = Order::with(['products', 'user'])
                ->where('id', '=', $request->id)
                ->get();
        
        return response()->json([
            'result' => $order->values()
        ]);
    }
    
    public function edit(Request $request) {
        
    }
    
    public function delete(Request $request) {
        $success = (boolean) Order::destroy($request->id);
        
        return response()->json(compact('success'));
    }
}
