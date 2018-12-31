<?php

namespace App\Http\Controllers;

use App\Models\Backend\Product;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    public function getProductByProomotion(Request $request)
    {
        $baseQuery = Product::with('promotions');
        $products = Product::with('promotions')
            ->filter($request->all())
            ->where('promotions.id', $request->id)
            ->get();

        $priceRange = $baseQuery->selectRaw('MAX(products.price) as max_price, MIN(products.price) as min_price')->first();

        return response()->json([
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'last_page' => $products->lastPage()
            ],
            "max_price" => $priceRange->max_price,
            "min_price" => $priceRange->min_price,
            'result' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'created_at' => $product->created_at->format('Y M d    -   h:m A'),
                    'category' => $product->category->name
                ];
            })
        ]);
    }
}
