<?php

namespace App\Http\Controllers\Api\V1;


use App\Models\Business\WhyChooseUs;
use Illuminate\Http\Request;

class WhyChooseUsController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('whychooseus:read'))  return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

        self::query(WhyChooseUs::select(...static::fields()));
        static::filter();
        static::sort();
        static::paginate();

        return self::response(self::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'image', 'description', 'slug'];
    }
}
