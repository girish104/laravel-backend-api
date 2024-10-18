<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Models\Banner;
use App\Models\Business\Category;
use App\Models\Business\Type;
use App\Models\Service\Service;

use Illuminate\Http\Request;

class BannerController extends BaseController
{


    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('banner:read'))  return static::error('Unauthorised.', ['error'=>'Unauthorised']);
        static::query(Banner::select(...static::fields()));
        static::filter();
        static::sort();
        return static::response(static::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'image', 'video_id', 'description', 'category'];
    }

    public static function filter()
    {
        parent::filter();

        if (!empty(request()->home))
            static::query()->where('business_type_id', Banner::TYPE_HOME);

        if (!empty(request()->type)){
            $category = Type::where('slug', request()->type)->first();
            static::query()->where('business_type_id', $category->id ?? -1);

            static::query()->whereIn('show_on', [empty(request()->category) ? Banner::SHOW_ON_CATEGORY_TYPE : Banner::SHOW_ON_CATEGORY, Banner::SHOW_ON_BOTH]);
        }

        if (!empty(request()->category)){
            static::query()->where('category_id', request()->category);
        }
    }
}
