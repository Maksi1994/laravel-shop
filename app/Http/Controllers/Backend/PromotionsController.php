<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Promotion\PromotionCollection;
use App\Http\Resources\Backend\Promotion\PromotionResource;
use App\Models\Backend\Promotion;
use Dotenv\Validator;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionsController extends Controller
{

    public function getList(Request $request)
    {
        $promotions = Promotion::list($request->all())->paginate(15, ['*'], ['page'], $request->page ?? 1);

        return new PromotionCollection($promotions);
    }

    public function create(Request $request)
    {
        $success = false;
        $validator = Validator::make($request->all(), [
            'name' => 'reuired|unique:promotions',
            'image' => 'required',
            'products.*.id' => 'required|exists:products.id',
            'products.*.endDate' => 'required|number'
        ]);

        if (!$validator->fails()) {
            $extension = $request->file('image')->extension();
            $photo = Storage::disk('space')->putFileAs('shop/promotions', $request->image, time() . '.' . $extension, 'public');
            $request->merge(['image' => $photo]);

            Promotion::create($request->all());
            Promotion::attachProducts($request->all());
            $success = true;
        }

        return $this->success($success);
    }

    public function getOne(Request $request)
    {
        $promotion = Promotion::withCount('products')
            ->with([
                'types',
                'products',
                'products.category',
                'products.promotionType'
            ])->find($request->id);
        return response()->json($promotion);
        // return new PromotionResource($promotion);
    }


    public function update(Request $request)
    {
        $promotion = Promotion::find($request->id);
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'products.*.id' => 'required|exists:products.id',
            'products.*.endDate' => 'required|number'
        ]);
        $success = false;

        if ($promotion && !$validator->fails()) {
            $promotion->update($request->all());
            Promotion::attachProducts($request);

            $success = true;
        }

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Promotion::destroy($request->id);

        return $this->success($success);
    }
}
