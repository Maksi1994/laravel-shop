<?php

namespace App\Http\Controllers;

use App\Models\Backend\{
 Promotion, Product
};
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    public function getProductsByPromotion(Request $request)
    {
        $baseQuery = Product::with('promotions');

        $products = Product::selectRaw('
        products.id,
        products.price,
        products.name,
        products.image,
        promotions.name,
        promotions.image,
        product_promotion.created_at as created_at,
        categories.id as category_id,
        categories.name as category_name
        ')->join('product_promotion', 'product_promotion.product_id', '=', 'products.id')
          ->join('promotions', 'promotions.id', '=', 'product_promotion.promotion_id')
          ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
          ->filter($request->all())
          ->whereRaw(
            'product_promotion.promotion_id = ? AND UNIX_TIMESTAMP(product_promotion.end_date) > UNIX_TIMESTAMP(NOW())',
            [
              $request->id,
            ]
          )
          ->orderByRaw('product_promotion.created_at DESC')
          ->paginate(15, ['*'], ['page'], $request->page);

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
                    'image' => $product->image,
                    'price' => $product->price,
                    'created_at' => $product->created_at->format('Y M d    -   h:m A'),
                    'category_name' => $product->category_name,
                    'category_id' => $product->category_id
                ];
            })
        ]);
    }

    public function getLastProducts(Request $request) {
      $products = Product::selectRaw('
      products.id,
      products.price,
      products.name,
      products.image,
      promotions.name,
      promotions.image,
      product_promotion.created_at as created_at,
      categories.id as category_id,
      categories.name as category_name
      ')->join('product_promotion', 'product_promotion.product_id', '=', 'products.id')
        ->join('promotions', 'promotions.id', '=', 'product_promotion.promotion_id')
        ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
        ->filter($request->all())
        ->whereRaw('UNIX_TIMESTAMP(product_promotion.end_date) > UNIX_TIMESTAMP(NOW())')
        ->orderByRaw('product_promotion.created_at DESC')
        ->limit(10)
        ->get();

        return response()->json([
            'result' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'created_at' => $product->created_at->format('Y M d    -   h:m A'),
                    'category_name' => $product->category_name,
                    'category_id' => $product->category_id
                ];
            })
        ]);
    }
}
