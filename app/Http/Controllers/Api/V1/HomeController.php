<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Models\Business\Festival;
use App\Models\Business\Location;
use App\Models\Business\Type;
use App\Models\Celebrity;
use App\Models\Package\Package;
use App\Models\Service\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function index(Request $request)
    {
        // if (!$request->user()->tokenCan('home:read'))  return self::error('Unauthorised.', ['error' => 'Unauthorised']);
        self::set('service_and_festivals', self::getServiceAndFestivals());
        self::set('popular_packages', self::getPopularPackages());

        self::set('locations', self::getServiceLocations());
        self::set('business_types', self::getServiceLocations());
        self::set('services', self::getServices());

        
        self::setExtraFields();
        return self::response([]);
    }

    
    public function config(){
        self::query(Setting::latest()->exclude(['created_at', 'updated_at', 'deleted_at', 'id'])->first()->toArray());
        return self::response(self::result());
    }

    public static function getServiceLocations(){
        self::query(Location::select('id', 'name', 'is_default as default'));
        self::filter();
        return self::result();
    }

    public static function getServices(){
        $business_types   = Type::onlyActive('category')->get();
        
        $result = [];
        foreach ($business_types as $key => $businessType) {
            $categories = [];
            foreach ($businessType['category'] ?? [] as $categoryKey => $category) {
                $categories[$categoryKey] =  array(
                    'id'    => $category['id'],
                    'title' => $category['title'],
                    'slug'  => $category['slug'],
                );
            }
            $result[$key]  =  array(
                'id'       => $businessType['id'],
                'title'    => $businessType['title'],
                'slug'     => $businessType['slug'],
                'position' => $businessType['position'],
                'category' => $categories
            );
        }
       return $result;
    }

    public static function getServiceAndFestivals(){
        self::query(Festival::select('id', 'title', 'image', 'description', 'slug'));
        self::filter();
        return self::getResultWithUri('festival');
    
        // self::query(Festival::select('id', 'title', 'image', 'description', 'slug'));
        // self::filter();
        // self::limit(5);
        // $festivals = self::getResultWithUri('festival');

        // self::query(Service::with('category')->select('id', 'title', 'icon', 'description', 'slug', 'category_id'));
        // self::filter();
        // self::limit(5);
        // $services = self::getResultWithUri('service');

        // foreach($services as $key => $service):
        //     $service['image'] = $service['icon'];
        //     unset($service['icon']);
        //     $services[$key] = $service;
        // endforeach;

        // $result = array_merge($festivals, $services);
        // array_multisort( array_column($result, "title"), SORT_ASC, $result);

        // return $result;
    }

    public static function getResultWithUri($slug){
        return self::query()->get()->map(function ($row) use ($slug) {
            if ($slug == 'festival') {
                $row->uri = '/festival/' . $row->slug;
            } else if ($slug == 'service')  {
                $row->uri = '/service/' . @$row->category->slug . '/' . $row->slug;
            }

            return $row;
        })->toArray();
    }

    public static function setExtraFields(){
        self::set('extra_fields', self::get());
    }

    public static function getPopularPackages(){
        $packages = Package::with(PackageController::relations())->select(...PackageController::fields());
        $packages->where('status', Helper::STATUS_ACTIVE)->where('is_popular', Helper::STATUS_ACTIVE);
        // static::limit($packages, 5);
        return $packages->get()->toArray();
    }

    public static function relations()
    {
        return array('category' => function ($q) {
            return $q->select('title', 'id');
        },  'sub_category' => function ($q) {
            return $q->select('title', 'id');
        });
    }
}
