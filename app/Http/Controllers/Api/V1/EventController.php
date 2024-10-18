<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Models\Business\Event;
use Illuminate\Http\Request;

class EventController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('event:read'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);
        self::query(Event::select(...static::fields()));
        self::filter();
        self::sort();

        return static::response(static::result());
    }

    public static function fields()
    {
        return ['id', 'title', 'image', 'description', 'slug', 'col_width'];
    }


    public static function sort()
    {
        static::query()->orderBy('position');
    }

    public static function filter()
    {
        parent::filter();
        // if (!empty(request()->all)) 
        //     self::query()->where('status', Helper::STATUS_ACTIVE);

        if (!empty(request()->home))
            self::query()->where('show_on_home_page', Helper::STATUS_ACTIVE);

        if (!empty(request()->top)) {
            self::query()->where('is_featured', Helper::STATUS_ACTIVE);
            self::limit(request()->top);
        }
    }

    public function detail($slug)
    {
        $columns = array('summary', 'tags', 'cancellation_policy', 'price',  'old_price', 'rating', 'reviews', 'meta_title', 'meta_keywords', 'meta_descriptions');
        $event = Event::select(...static::fields(), ...$columns)->where('slug', $slug)->first();

        if (empty($event)) return static::error('Event not found');

        return static::response($event);
    }

    public static function result()
    {
        return self::query()->get()->map(function ($row) {
            $row->uri = '/event/' . $row->slug;
            return $row;
        });   
    }
}
