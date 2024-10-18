<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('testimonial:read'))  return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        self::query(Testimonial::select(...static::fields()));
        self::filter();
        self::sort();
        return self::response(self::result());
    }

    public static function sort()
    {
        static::query()->orderBy('position');
    }
    
    public static function fields()
    {
        return ['id', 'name', 'designation', 'title','description','rating', 'image'];
    }
}
