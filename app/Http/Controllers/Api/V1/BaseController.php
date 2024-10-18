<?php


namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Arr;

class BaseController extends Controller
{
    public static $store = [];
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public static function response($result, $message = false){
        $response = [
            'success' => true,
            'data'    => $result,
        ];

        if(!empty($message)){
            $response['message'] = $message;
        }

        $response = [...$response, ...(static::get('extra_fields') ?? [])];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public static function error($error, $errorMessages = [], $code = 404){
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function sendResponse($result, $message)
    {
        return self::response($result, $message);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	return self::error($error, $errorMessages = [], $code = 404);
    }


    /// helper functions ///
    
    /**
     * set value in temp store
     *
     * @return bool
     */
    public static function set(string $key, $value)
    {
        return self::$store[$key] = $value;
    }

     /**
     * get value from temp store
     *
     * @return any
     */
    public static function get(string | false $key = false)
    {
        if (empty($key)) return Arr::except(self::$store, ['query_instance', 'extra_fields']);

        return self::$store[$key] ?? null;
    }
    
    public static function query($query = false) 
    {
        if (empty($query)) return self::$store['query_instance'];

        return self::$store['query_instance'] = $query;
    }

    public static function fields()
    {
        return ['id', 'title', 'description', 'slug'];
    }

    public static function relations()
    {
        // return array('category' => function ($q) {
        //     return $q->select('title', 'slug', 'id');
        // },  'sub_category' => function ($q) {
        //     return $q->select('title', 'id');
        // }, 'images' => function ($q) {
        //     return $q->select('url', 'product_id');
        // });
    }

    public static function limit(int $limit = 10, int $skip = 0)
    {
        static::query()->skip($skip)->take($limit);
    }

    public static function filter()
    {
        static::query()->where('status', Helper::STATUS_ACTIVE);
    }

    public static function sort()
    {
        static::query()->orderBy('created_at');
    }


    public static function result()
    {
        if (is_array(static::query())) {
            return static::query();
        }
        
        return static::query()->get()->toArray();
    }

    public static function paginate()
    {
        return static::query()->paginate(request()->limit ?? 10);  
    }
}