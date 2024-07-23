<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSeo;
use App\Models\Material;
use App\Models\TempPrice;
use App\Models\ProductMaterial;
use Common;
use stdClass;

class ProductController extends Controller
{
    public function allProducts(Request $request){
        $productData = Product::select('product_name','id','price','discount_price','status','category_id','product_fetaure_img')->with('category:id,cat_name')->with('product_seo:id,product_id,feature_image')->whereIn('status',[1,2]);
        $category = !empty($request->category) ? $request->category : 0;
        $str = !empty($request->str) ? $request->str : '';
        if(!empty($request->category)){
            $productData->where('category_id',$request->category);
        }
        if(!empty($request->str)){
            $productData->where('product_name','like','%'.$request->str.'%');
        }
        $productData = $productData->orderBy('id','DESC')->paginate(50);
        $categories = Common::siteCategories();
        return view('admin.product.all-products',compact('productData','categories','category','str'));
    }

    public function addProduct(){
        $categories = Common::siteCategories();
        $getMaterials = Material::get()->groupBy('material_name');
        return view('admin.product.add-product',compact('categories','getMaterials'));
    }

    public function uploadDropzoneFiles(Request $request){
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $targetDir = public_path("uploads/product_images/");
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 15 * 3600; // Temp file age in seconds
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
     
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $request->str.'-'.$_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        } else {
            $fileName =  $request->str.'-'.uniqid("file_");
        }
        if(file_exists(public_path('uploads/product_images/'.$fileName))){
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        }
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "0"}');
        }
    
        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "0"}');
            }
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }
        $arr = [
            'jsonrpc'=>'2.0',
            'error'=>[
                'code'=>'200',
                'message'=>'files uploaded',
                'id'=>$fileName 
            ]
        ];
        die(json_encode($arr));
    }

    public function uploadDropzoneFilesSample(Request $request){
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $targetDir = public_path("uploads/product_images/samples/");
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 15 * 3600; // Temp file age in seconds
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
     
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $request->str.'-'.$_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        } else {
            $fileName =  $request->str.'-'.uniqid("file_");
        }
        if(file_exists(public_path('uploads/product_images/samples/'.$fileName))){
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        }
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "0"}');
        }
    
        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "0"}');
            }
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }
        $arr = [
            'jsonrpc'=>'2.0',
            'error'=>[
                'code'=>'200',
                'message'=>'files uploaded',
                'id'=>$fileName 
            ]
        ];
        die(json_encode($arr));
    }

    public function uploadDropzoneFilesMedia(Request $request){
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        $targetDir = public_path("uploads/product_images/media/");
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 15 * 3600; // Temp file age in seconds
        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }
     
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $request->str.'-'.$_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        } else {
            $fileName =  $request->str.'-'.uniqid("file_");
        }
        if(file_exists(public_path('uploads/product_images/media/'.$fileName))){
            $fileName = $request->str.'-'.$_FILES["file"]["name"];
        }
        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }
            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "0"}');
        }
    
        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "0"}');
            }
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "0"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        if (!$chunks || $chunk == $chunks - 1) {
            rename("{$filePath}.part", $filePath);
        }
        $arr = [
            'jsonrpc'=>'2.0',
            'error'=>[
                'code'=>'200',
                'message'=>'files uploaded',
                'id'=>$fileName 
            ]
        ];
        die(json_encode($arr));
    }

    public function storeProduct(Request $request){
        $request->validate([
            'product_name'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'discount_price'=>'required',
            'product_sku'=>'required'
        ]);



        $path = public_path('uploads/product_images/feature_image');
        if(!\File::isDirectory($path)){
            \File::makeDirectory($path, 0777, true);
        }
        $featureImage = asset('assets/admin/images/logo.png');
        $sampleImg = null;
        $mediaImg = null;
        $originalImg = null;
        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/product_images/feature_image');
            $image->move($destinationPath, $categoryImage);
            $featureImage = $categoryImage;
        }

        if ($request->hasFile('product_fetaure_img')) {
            $image = $request->file('product_fetaure_img');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/product_images/product_feature_image');
            $image->move($destinationPath, $categoryImage);
            $featureImage2 = $categoryImage;
        }
        $slug = \Str::slug($request->product_name);
        $prodCnt = Product::where('product_slug',$slug)->count();
        if($prodCnt){
            $slug = $slug.'-'.($prodCnt + 1);
        }

        if(!empty($request->uploaded_file_str_orig)){
            $arr = explode('@@*@@',$request->uploaded_file_str_orig);
            foreach($arr as $v){
                \File::move(public_path('uploads/product_images/'.$v), storage_path("app/product_images/".$v));
            }
            $originalImg = json_encode($arr);
        }
        if(!empty($request->uploaded_file_str_sample)){
            $sampleImg = json_encode(explode('@@*@@',$request->uploaded_file_str_sample));
        }
        if(!empty($request->uploaded_file_str)){
            $mediaImg = json_encode(explode('@@*@@',$request->uploaded_file_str));
        }

        try{
            \DB::beginTransaction();
                $productObj = new Product();
                $productObj->product_name = $request->product_name;
                $productObj->sku = $request->product_sku;
                $productObj->product_slug = $slug;
                $productObj->category_id  = $request->category_id;
                $productObj->price = $request->price;
                $productObj->discount_price = $request->discount_price;
                $productObj->product_files = $originalImg;
                $productObj->product_demo_files = $sampleImg;
                $productObj->product_media = $mediaImg;
                $productObj->description = $request->description;
                $productObj->status = $request->status_id;
                $productObj->feature_product = $request->featured_product;
                $productObj->product_fetaure_img = $featureImage2;
                $productObj->save();
                $productId = $productObj->id;
                // seo save
                // $seoObj = new ProductSeo();
                // $seoObj->product_id = $productId;
                // $seoObj->meta_title = $request->meta_title;
                // $seoObj->meta_keywords = $request->keyword;
                // $seoObj->meta_description = $request->description;
                // $seoObj->feature_image = $featureImage;
                // $seoObj->save();

                // MATERIAL USED
                if($request->has('quantity')){
                    $quantity = $request->quantity;
                    foreach ($quantity as $key => $value) {
                        if ($value > 0) {
                            $material = new ProductMaterial();
                            $material->product_id = $productId;
                            $material->material_id = $request->purity_grade[$key];
                            $material->quantity_used  = $value;
                            $material->save();
                        }
                    }
                }


            \DB::commit();
            \Cache::forget('product-count');
            return redirect(route('quoatation'))->with('success','New Product Added Successfully...');
        }catch(\Exception $e){
            \DB::rollback();
            echo $e->getMessage();
            return redirect()->back()->with('error','Something went wrong product not saved...');
        }
    }

    public function uploadProductTinymceImage(Request $request){
        $path = public_path('uploads/product_images/tiny/');
        if(!\File::isDirectory($path)){
            \File::makeDirectory($path, 0777, true);
        }
        $location = 'NA';
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $fl = explode(".",$image->getClientOriginalName());
            $filename = $fl[0];
            $extension = $fl[1];
            $name = $filename.'-'.time().'.'.$extension;
            $destinationPath = public_path('/uploads/product_images/tiny/');
            $image->move($destinationPath, $name);
            $location = asset('uploads/product_images/tiny/'.$name);
        }
        return response()->json(['location'=>$location]);
    }

    public function changeProductStatus(Request $request){
        $status = $request->status==1 ? 2 : 1;
        $productId = $this->memberObj['id'];
        Product::where('id',$productId)->update(['status'=>$status]);
        \Cache::forget('product-count');
        return response()->json(['s'=>1,'msg'=>'success']);
    }

    public function editProduct(){
        $categories = Common::siteCategories();
        $id = $this->memberObj['id'];
        $productData = Product::with('product_seo')->findorfail($id);
        $inputObj = new stdClass();
        $inputObj->params = 'id='.$id;
        $inputObj->url = url('admin/update-product');
        $encLink = Common::encryptLink($inputObj);
        return view("admin.product.edit-product",compact('categories','productData','encLink'));
    }

    public function removeDemoFile(Request $request){
        $id = $request->id;
        $file = $request->file;
        $productData = Product::select('product_demo_files')->findorfail($id);
        $data = json_decode($productData->product_demo_files,true);
        $finalData = [];
        foreach($data as $v){
            if($v!=$file){
                array_push($finalData,$v);
            }
        }
        Product::where('id',$id)->update([
            'product_demo_files'=>count($finalData) > 0 ? json_encode($finalData) : null
        ]);
        return redirect()->back()->with('success','Product file removed successfully...');
    }

    public function removeMediaFile(Request $request){
        $id = $request->id;
        $file = $request->file;
        $productData = Product::select('product_media')->findorfail($id);
        $data = json_decode($productData->product_media,true);
        $finalData = [];
        foreach($data as $v){
            if($v!=$file){
                array_push($finalData,$v);
            }
        }
        Product::where('id',$id)->update([
            'product_media'=>count($finalData) > 0 ? json_encode($finalData) : null
        ]);
        return redirect()->back()->with('success','Product file removed successfully...');
    }

    public function removeDigitalFile(Request $request){
        $id = $request->id;
        $file = $request->file;
        $productData = Product::select('product_files')->findorfail($id);
        $data = json_decode($productData->product_files,true);
        $finalData = [];
        foreach($data as $v){
            if($v!=$file){
                array_push($finalData,$v);
            }
        }
        Product::where('id',$id)->update([
            'product_files'=>count($finalData) > 0 ? json_encode($finalData) : null
        ]);
        return redirect()->back()->with('success','Product file removed successfully...');
    }

    public function updateProduct(Request $request){
        $request->validate([
            'product_name'=>'required',
            'category_id'=>'required',
            'price'=>'required',
            'discount_price'=>'required',
            'meta_title'=>'required',
            'keyword'=>'required',
            'description'=>'required',
        ]);
        $path = public_path('uploads/product_images/feature_image');
        if(!\File::isDirectory($path)){
            \File::makeDirectory($path, 0777, true);
        }
        $featureImage = asset('assets/admin/images/logo.png');
        $sampleImg = null;
        $mediaImg = null;
        $originalImg = null;

        $dataUp = [
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->keyword,
            'meta_description'=>$request->description,
        ];

        if ($request->hasFile('feature_image')) {
            $image = $request->file('feature_image');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/product_images/feature_image');
            $image->move($destinationPath, $categoryImage);
            $featureImage = $categoryImage;
            $dataUp['feature_image'] = $featureImage;
        }

        if ($request->hasFile('product_fetaure_img')) {
            $image = $request->file('product_fetaure_img');
            $categoryImage = time().substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,5).'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/product_images/product_feature_image');
            $image->move($destinationPath, $categoryImage);
            $featureImage2 = $categoryImage;
        }

        $slug = \Str::slug($request->product_name);
        $prodCnt = Product::where('product_slug',$slug)->count();
        if($prodCnt){
            $slug = $slug.'-'.($prodCnt + 1);
        }

        if(!empty($request->uploaded_file_str_orig)){
            $originalImg = explode('@@*@@',$request->uploaded_file_str_orig);
        }
        if(!empty($request->uploaded_file_str_sample)){
            $sampleImg = explode('@@*@@',$request->uploaded_file_str_sample);
        }
        if(!empty($request->uploaded_file_str)){
            $mediaImg = explode('@@*@@',$request->uploaded_file_str);
        }
        try{
            $id = $this->memberObj['id'];
            $productData = Product::select('product_files','product_demo_files','product_media')->findorfail($id);

                $dataP = [
                    'product_name'=>$request->product_name,
                    'category_id'=> $request->category_id,
                    'price' => $request->price,
                    'discount_price'=>$request->discount_price,
                    'description'=>$request->description,
                    'feature_product'=>$request->featured_product,
                    'product_fetaure_img'=> $featureImage2
                ];

                if($originalImg!=null){
                    $imgs = $productData->product_files!=null ? json_decode($productData->product_files,true) : [];
                    $fimages = array_merge($originalImg,$imgs);
                    $dataP['product_files'] = $fimages;
                }

                if($sampleImg!=null){
                    $imgs = $productData->product_demo_files!=null ? json_decode($productData->product_demo_files,true) : [];
                    $fimages = array_merge($sampleImg,$imgs);
                    $dataP['product_demo_files'] = $fimages;
                }

                if($mediaImg!=null){
                    $imgs = $productData->product_media!=null ? json_decode($productData->product_media,true) : [];
                    $fimages = array_merge($mediaImg,$imgs);
                    $dataP['product_media'] = $fimages;
                }
                \DB::beginTransaction();
                    Product::where('id',$id)->update($dataP);
                    ProductSeo::where('product_id',$id)->update($dataUp);
                \DB::commit();
                return redirect('admin/all-products')->with('success','Product Data Updated Successfully...');
        }catch(\Exception $e){
            return redirect()->back()->with("error",'Something went wrong ...product not updated');
        }
    }

    public function marketPrice(){
        $material = Material::latest()->get();
        return view('admin.quoatation.material',compact('material'));
    }

    public function updatePrice(Request $request){
        $request->validate([
            'min_price'=>'required',
            'current_price'=>'required'
        ]);
        $currentPrice = $request->current_price;
        $minPrice = $request->min_price;
        foreach ($currentPrice as $key => $value) {
            $material = Material::where('id',$key)->first();
            $material->current_price_per_unit = $value;
            $material->minimun_price = $minPrice[$key];
            $material->save();
        }

        return redirect()->back()->with('success','Price Updated Successfully');
    }

    public function quoatation(Request $request){

        // dd($request->all());

        $filter_productName = "";
        $filter_category = "Select Stock Sheet";
        $filter_material = "Select Material";

        $products = Product::latest()->with('category:id,cat_name', 'materials','product_material');
        // Filter by product name or SKU
        if (isset($request->search) && $request->search != $filter_productName) {
            $filter_productName = $request->search;
            $products = $products->where(function ($query) use ($request) {
                $query->where('product_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if (isset($request->category) && $request->category != $filter_category) {
            $filter_category = $request->category;
            $products = $products->where('category_id', $request->category);
        }

        // Filter by material
        if (isset($request->material) && $request->material != $filter_material) {
            $filter_material = $request->material;
            $products = $products->whereHas('materials', function ($query) use ($request) {
                $query->whereIn('material_id', (array) $request->material);
            });
        }

        // Filter by weight in grams or carats
        $products = $products->whereHas('product_material', function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                // Filter by weight in grams
                if (isset($request->weight_gram)) {
                    $weights = explode(';', $request->weight_gram);
                    $minWeightGram = (float) $weights[0];
                    $maxWeightGram = (float) $weights[1];
                    $q->whereBetween('quantity_used', [$minWeightGram, $maxWeightGram])
                    ->where('weight_type', 'gram');
                }

                // Filter by weight in carats
                if (isset($request->weight_carat)) {
                    $weights = explode(';', $request->weight_carat);
                    $minWeightCarat = (float) $weights[0];
                    $maxWeightCarat = (float) $weights[1];
                    $q->orWhere(function ($q2) use ($minWeightCarat, $maxWeightCarat) {
                        $q2->whereBetween('quantity_used', [$minWeightCarat, $maxWeightCarat])
                        ->where('weight_type', 'carat');
                    });
                }
            });
        });

        // Fetch the filtered products
        $products = $products->get();

        // dd($products);
        
        $catgeory = Category::latest()->where('status',1)->get();
        $data = Material::latest()->get();
        return view('admin.quoatation.index',compact('products','catgeory','data','filter_productName','filter_material','filter_category'));
    }

    public function createQuoatation(Request $request){
        $tempPrice = new TempPrice();
        $tempPrice->product_id = $request->product_id;
        $tempPrice->temp_price = json_encode($request->material);
        $tempPrice->save();

        // ENCRY URL
        $inputObj = new stdClass();
        $inputObj->params = 'id='.$tempPrice->id;
        $inputObj->url = url('product-listing');
        $encLink = Common::encryptLink($inputObj);

        return redirect($encLink)->with('success','Price Updated Successfully');
    }

    // public function genrateTempData(Request $request){
    //     $id = $this->memberObj['id'];
    //     $tempPrice = TempPrice::where('id',$id)->first();
    //     if($tempPrice){
    //         $productId = json_decode($tempPrice->product_id);
    //         $product = Product::latest()->with('category:id,cat_name', 'materials')->whereIn('id',$productId)->get(); 
    //         return view('admin.quoatation.show-product',compact('product','tempPrice'));
    //     }
    // }
}
