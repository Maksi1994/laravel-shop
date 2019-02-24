<?php

namespace App\Http\Controllers\Backend;

use App\Http\Resources\Backend\Promotion\PromotionCollection;
use App\Http\Resources\Backend\Promotion\PromotionResource;
use App\Models\Backend\Param;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ParamsController extends Controller
{

    public function getList(Request $request)
    {
        $params = Param::paginate(15, null, null, $request->page ?? 1);

        return new PromotionCollection($params);
    }

    public function getOne(Request $request)
    {
        $param = Param::with('values')->where('id', '=', $request->id)->get();

        return new PromotionResource($param);
    }

    public function create(Request $request)
    {
        $success = false;

        $validationParam = Validator::make($request->all(), [
            'name' => 'required|unique:params'
        ]);

        $validationValues = Validator::make($request->all(), ['values.*.name' => 'required']);

        if (!$validationParam->fails()) {
            $param = Param::create($request->all());
            $success = true;

            if (!$validationValues->fails() && count($request->get('values'))) {
                $param->createMany($request->values);
            }
        }

        return $this->success($success);
    }

    public function setValues(Request $request)
    {
        $success = false;
        $validationValues = Validator::make($request->all(), [
                'values.*.value' => 'required',
                'param_id' => 'required'
            ]
        );
        $param = Param::find($request->param_id);

        if (!$validationValues->fails() && $param) {
            $success = true;
            $param->values()->delete();

            if (count($request->values)) {
                $param->createMany($request->values);
            }
        }

        return $this->success($success);
    }

    public function update(Request $request)
    {
        $success = Param::where('id', $request->id)->update($request->all());

        return $this->success($success);
    }

    public function delete(Request $request)
    {
        $success = (boolean)Param::destroy($request->id);

        return $this->success($success);
    }

}
