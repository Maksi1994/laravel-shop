<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Param\Param;
use App\Models\Backend\Param\Value;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ParamsController extends Controller
{

    public function getList(Request $request)
    {
        $params = Param::paginate(15, null, null, $request->page ?? 1);

        return response()->json([
            'result' => $params->values(),
            'meta' => [
                'total' => $params->total(),
                'per_page' => $params->perPage(),
                'last_page' => $params->lastPage()
            ]
        ]);
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

        return response()->json(compact('success'));
    }

    public function setValues(Request $request)
    {
        $success = false;
        $validationValues = Validator::make($request->all(),
            [
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

        return response()->json(compact('success'));
    }

    public function getOne(Request $request)
    {
        $param = Param::with('values')->where('id', '=', $request->id)->get();

        return response()->json([
            'result' => $param
        ]);
    }

    public function update(Request $request)
    {
        $success = Param::where('id', $request->id)->update($request->all());

        return response()->json(compact('success'));
    }

    public function delete(Request $request)
    {
        $success = (boolean)Param::destroy($request->id);

        return response()->json(compact('success'));
    }

}
