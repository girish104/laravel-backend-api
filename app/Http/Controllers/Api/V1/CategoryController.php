<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Business\Category;
use App\Models\Business\Type;
use App\Models\Celebrity;


use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function index(Request $request)
    {
        // return self::response(static::result());

        // if (!$request->user()->tokenCan('category:read'))  return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        self::query(Type::with(static::relations())->select('id', 'title', 'slug', 'position')->where('status', Helper::STATUS_ACTIVE))->orderBy('position','asc');
        // static::filter();
        self::sort();
        return self::response(static::result());
    }

    public function services(Request $request)
    {
        // if (!$request->user()->tokenCan('category:read'))  return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        self::query(Category::select('id', 'title'));
        parent::filter();
        self::sort();
        return self::response(static::result());
    }

    public static function sort(){
        self::query()->orderBy('title', 'asc');
    }

    public static function filter()
    {
        if (!empty(request()->popular)) 
            self::query()->where('is_popular', Helper::STATUS_ACTIVE);
    }

    public static function relations()
    {
        return array('category' => function ($q) {
            return $q->select('title', 'id', 'slug', 'business_type', 'image', 'show_on_home_page')->orderBy('title', 'asc');
        });
    }

}
