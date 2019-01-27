<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Basket extends Model
{

    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'basket_product', 'basket_id', 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public static function saveBasket(Request $request)
    {
        static::where('customer_id', $request->customer_id)->delete();

        $basket = static::create($request->all('customer_id'));
        $basketProduct = [];

        collect($request->products)->each(function ($product) use (&$basketProduct, $basket) {
            $basketProduct[$product['id']] = [
                'count' => $product['count'],
                'basket_id' => $basket->id
            ];
        });

        $basket->products()->sync($basketProduct);
    }
}
