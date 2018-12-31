<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product\Product;

class ProductsController extends Controller
{
    public function getAll(Request $request)
    {

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

    public function getOne(Request $request)
    {
        $product = Product::find($request->id);

        return response()->json([
            'result' => $product
        ]);
    }

    public function getMostPopular()
    {
        $products = Product::selectRaw('
            products.id, 
            COUNT(products.id) as orders_count,
            products.price,
            products.image,
            products.name,
            categories.id as category_id,
            categories.name as category_name')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->groupBy('products.id')
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'result' => $products->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category_id' => $item->category->id,
                    'category' => $item->category->name,
                    'image' => env('DO_SPACES_DOMAIN') . $item->image,
                    'price' => $item->price,
                    'orders_count' => $item->orders_count
                ];
            })
        ]);
    }

    public function getLastAdded()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'result' => $products->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'category_id' => $item->category->id,
                    'category' => $item->category->name,
                    'image' => env('DO_SPACES_DOMAIN') . $item->image,
                    'price' => $item->price,
                    'created_at' => $item->created_at->format('Y M d    -   h:m A')
                ];
            })
        ]);
    }

}

