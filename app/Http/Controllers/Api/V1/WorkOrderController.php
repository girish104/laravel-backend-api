<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;

use App\Models\WorkOrder;

use Illuminate\Http\Request;

class WorkOrderController extends BaseController
{
    public function create(Request $request)
    {
        // if (!$request->user()->tokenCan('workorder:create'))  return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        return self::response(array(
            'success' => Helper::safeTransaction(function () use ($request) {
                return WorkOrder::create($request->all());
            })
        ));
        // return self::response(self::result());
    }
}
