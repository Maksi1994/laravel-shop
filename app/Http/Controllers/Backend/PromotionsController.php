<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Promotion\PromotionCollection;
use App\Http\Resources\Backend\Promotion\PromotionResource;
use App\Models\Backend\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionsController extends Controller
{

    public function getList(Request $request)
    {
        $promotions = Promotion::paginate(15, ['*'], ['page'], $request->page);

        return new PromotionCollection($promotions);
    }

    public function create(Request $request)
    {
        $success = false;
        $image = 'image.png';
        $request->merge(['image', $image]);

        if (!empty($request->name) && !empty($image)) {
            Promotion::create($request->all());

            $success = true;
        }

        return $this->success($success);
    }

    public function getOne(Request $request)
    {
        $promotion = Promotion::find($request->id);

        return new PromotionResource($promotion);
    }


    public function update(Request $request)
    {
        $success = (boolean)Promotion::where(['id' => $request->id])
            ->update($request->all());

        return $this->success($success);
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

        return $this->success($success);
    }

    public function deleteProduct(Request $request)
    {
      $promotion = Promotion::find($request->promotion_id);
      $success = false;

      if (!empty($promotion) &&
          !empty($request->product_id)) {
          $promotion->products()->detach([$request->product_id]);

          $success = true;
      }

        return $this->success($success);
    }

    public function removeAllProducts(Request $request)
    {
      $promotion = Promotion::find($request->promotion_id);
      $success = false;

      if (!empty($promotion)) {
            $promotion->products()->detach();
            $success = true;
      }

        return $this->success($success);
    }
}
