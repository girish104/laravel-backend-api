<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService { 

    public function create_product($request){ 

        try {
      
            $validator = validator()->make($request->all(),[ 'title' => 'required|unique:products,title',
                'overview' => 'required','back_image'=>  'required',
            ]);  

            if($validator->fails()) {                         
                throw new \Exception(json_encode($validator->errors()->all()));
            }
    
            DB::beginTransaction();
            if (request()->hasFile('back_image')) {
                $destinationPath = public_path('/storage/product');
                $file = Helper::globalUploadFile($request->back_image, $destinationPath);
                $request['file'] = $file;
            }
            Product::create($request->except('back_image'));
            DB::commit();
            $msg = 'The product created successfully';
            return ['status' => true, 'message' => $msg];
        } catch (\Exception $exe) {
            DB::rollBack();
            return ['status'=>'false','message'=>$exe->getMessage()];
        }
    }

    public function getProducts()
    {
         $data =  Product::latest('id')->get();

        return datatables()::of($data)->addIndexColumn()
        ->editColumn('file', function (Product $single_data) {
            return asset('/storage/product/'.$single_data->file);
        })
        ->editColumn('edit_route', function (Product $single_data) {
            return url('admin/product/show/'.$single_data->id);
        })
        ->editColumn('status', function (Product $single_data) {
            if($single_data->status == 1){
                return 'Active';
            }else{
                return 'Deactive';
            }
        })->make();
    }

    public function update($request)
    {
        try {

            // print_r($request->all());
            // die;
            DB::beginTransaction();
            $sendFile = '';
            if (request()->hasFile('back_image')) {
                // $delFile = public_path('/storage/product/') . $request->back_image;
                // if (!is_dir($delFile) and file_exists($delFile)) {
                //     unlink($delFile);
                // }
                $destinationPath = public_path('/storage/product');
                $file = Helper::globalUploadFile($request->back_image, $destinationPath);
                $request['file'] = $file;
                // $sendFile = asset('/storage/product/' . $file);
            }
            Product::where(['id' => $request->id,])->update($request->except('back_image','_token'));
            DB::commit();
            $msg = 'This product have updated.';
            return ['status' => true, 'message' => $msg];
        } catch (\Exception $exe) {
            DB::rollBack();
            return ['status' => 'false', 'message' => $exe->getMessage()];
        }
    }

    public function delete($request)
    {
        try {
            DB::beginTransaction();
            Product::where(['id' => $request->doc_id])->delete();
            DB::commit();
            return ['status' => true, 'message' => 'This product have deleted.'];
        } catch (\Exception $exe) {
            DB::rollBack();
            return ['status' => false, 'message' => $exe->getMessage()];
        }
    }

  
}


