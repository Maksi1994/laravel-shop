<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionsController extends Controller
{

    public function create(Request $request)
    {
        $success = false;
        $image = 'image.png';

        if (!empty($request->name) && !empty($image)) {
            $success = (boolean)Promotion::create(
                array_merge(
                    $request->all(),
                    ['image' => $image]
                )
            );
        }

        return response()->json(compact('success'));
    }

    public function getOne(Request $request)
    {
        $product = Promotion::find($request->id);

        return response()->json([
            'result' => $product
        ]);
    }


    public function update(Request $request)
    {
        $success = (boolean)Promotion::where(['id' => $request->id])->update($request->all());

        return response()->json(compact('success'));
    }

    public function addProduct(Request $request)
    {
        $promotion = Promotion::find($request->promotion_id);
        $success = false;

        if (!empty($promotion) &&
            !empty($request->product_id) &&
            !empty($request->end_date)) {
            $promotion->products()->syncWithoutDetaching([
                    $request->product_id => ['end_date' => $request->end_date]
                ]);

            $success = true;
        }

        return response()->json(compact('success'));
    }
}

