<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;

class ProductsController extends Controller
{
    public function getAll(Request $request) {
        
        $categories = [1, 2];
        
        $products = Product::with('category')
            ->whereIn('category_id', $categories)
            ->paginate(10, ['*'], ['page'], ($request->page ?? 1));
        
        return response()->json([
            'result' => $products->values(),
            'meta' => [
                'per_page' => $products->perPage(),
                'page' => $products->currentPage(),
                'last-page' => $products->lastPage()
            ]
        ]); 
    }
    
    public function getOne(Request $request) {
        $product = Product::find($request->id);
        
        return response()->json([
            'result' => $product
        ]);
    }
        
}
