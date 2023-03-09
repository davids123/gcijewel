<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Search;
use App\Product;
use App\Category;
use App\FlashDeal;
use App\ServiceRequest;
use App\Brand;
use App\Color;
use App\Models\Producttype;
use App\WatchRequest;
use App\Models\SellMyWatche;
use App\Shop;
use App\Attribute;
use App\SiteOptions;
use App\Productcondition;
use Mail;
use App\AttributeCategory;
use App\Utility\CategoryUtility;
use Illuminate\Support\Facades\DB;
use Auth;
class SearchController extends Controller
{
    public function index(Request $request, $category_id = null, $brand_id = null, $listing_type=null,$brandId=null)
    {
        // dd($listing_type);
        // print_r($brandId);
        // dd($request->listing-type);
        $query = $request->keyword;
        $sort_by = $request->sort_by;
        $paperCart_key="";
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $attributes = Attribute::all();
        $selected_attribute_values = array();
        $colors = Color::all();
        $all_product=Product::all();
        $selected_color = null;
        $paperCarts=array();
        $brand_key=array();
        $category_key=array();
        $model_key=array();
        $colors_id=array();
        $metal_key=array();
        $size_key=array();
        $listing_type_uni=$request->listing_type;
        $listingType=array('Jewelry','Watch','Watch Parts','Accessories','Diamonds','Gold Collectibles');
        $partnersData_metal = Product::select('products.metal')
                                        ->join('product_types','product_types.id','=','products.product_type_id')
                                        ->join('product_stocks','product_stocks.product_id','=','products.id')
                                        ->join('brands','brands.id','products.brand_id')
                                         ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                         ->join('categories','categories.id','=','products.category_id')
                                        ->where('products.published','=',1)
                                        ->orderBy('products.metal','ASC')
                                        ->groupBy('products.metal')
                                        ->where('products.metal','!=',null)
                                        ->where('product_stocks.qty','>',0);
        $paperCart = Product::select('products.paper_cart')
                            ->join('product_types','product_types.id','=','products.product_type_id')
                            ->join('product_stocks','product_stocks.product_id','=','products.id')
                            ->join('brands','brands.id','products.brand_id')
                            ->join('productconditions','productconditions.id','=','products.productcondition_id')
                            ->join('categories','categories.id','=','products.category_id')
                            ->where('products.published','=',1)
                            ->groupBy('products.paper_cart')
                            ->orderBy('products.paper_cart','ASC')
                            ->where('products.paper_cart','!=',null)
                            ->where('product_stocks.qty','>',0);
                                        // dd($paperCart->get());
      $product_colors = Product::select('products.colors','colors.name as color_name')
                            ->join('product_types','product_types.id','=','products.product_type_id')
                            ->join('product_stocks','product_stocks.product_id','=','products.id')
                            ->join('brands','brands.id','products.brand_id')
                            ->join('colors','colors.id','products.colors')
                            ->join('productconditions','productconditions.id','=','products.productcondition_id')
                            ->join('categories','categories.id','=','products.category_id')
                            ->where('products.published','=',1)
                            ->groupBy('products.colors')
                            ->orderBy('color_name','ASC')
                            ->where('products.colors','!=',null)
                            ->where('product_stocks.qty','>',0);
        $partnersData = Product::select('products.size')
                                ->join('product_types','product_types.id','=','products.product_type_id')
                                ->join('product_stocks','product_stocks.product_id','=','products.id')
                                ->join('brands','brands.id','products.brand_id')
                                ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                ->join('categories','categories.id','=','products.category_id')
                                ->where('products.published','=',1)
                                ->where('products.size','>',0)
                                ->orderBy('products.size','ASC')
                                ->groupBy('products.size')
                                ->where('products.metal','!=',null)
                                ->where('product_stocks.qty','>',0);
                                        // dd($partnersData);
        $partnersData_model = Product::select('products.model')
                                    ->join('product_types','product_types.id','=','products.product_type_id')
                                    ->join('product_stocks','product_stocks.product_id','=','products.id')
                                    ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                    ->join('brands','brands.id','products.brand_id')
                                    ->where('products.published','=',1)
                                    ->join('categories','categories.id','=','products.category_id')
                                    ->groupBy('products.model')
                                    ->orderBy('products.model','ASC')
                                    ->where('products.metal','!=',null)
                                    ->where('product_stocks.qty','>',0);
        $categories_data=   Product::select('products.category_id','categories.name')
                                    ->join('product_types','product_types.id','=','products.product_type_id')
                                    ->join('product_stocks','product_stocks.product_id','=','products.id')
                                    ->join('categories','categories.id','=','products.category_id')
                                    ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                    ->join('brands','brands.id','products.brand_id')
                                    ->where('products.published','=',1)
                                    ->groupBy('products.category_id')
                                    ->orderBy('categories.name','ASC')
                                    ->where('products.category_id','!=',null)
                                    ->where('product_stocks.qty','>',0);
        $brand_data=   Product::select('products.brand_id','brands.name','productconditions.name as condition')
                                ->join('product_types','product_types.id','=','products.product_type_id')
                                ->join('product_stocks','product_stocks.product_id','=','products.id')
                                ->join('brands','brands.id','products.brand_id')
                                ->join('categories','categories.id','=','products.category_id')
                                ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                ->where('products.published','=',1)
                                ->groupBy('products.brand_id')
                                ->orderBy('brands.name','ASC')
                                ->where('products.brand_id','!=',null)
                                ->where('product_stocks.qty','>',0);
                                        // dd($brand_data->get());
        if($request->listing_type=="Watch" && $request->brand != "")
        {
            // dd($request->brand);
            $partnersData_metal = $partnersData_metal->where('brands.slug',$request->brand)->where('product_types.listing_type','=',$request->listing_type);
                                            // dd($partnersData_metal);
            $partnersData =$partnersData->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
                                            // dd($partnersData);
            $product_colors=$product_colors->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
            $paperCart=$paperCart->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
            $partnersData_model =$partnersData_model->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
            $categories_data=   $categories_data->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
            $brand_data=   $brand_data->where('product_types.listing_type','=',$request->listing_type)->where('brands.slug',$request->brand);
        }
         if($request->model != null)
        {
           $model=(array)$request->model;
            // dd($model);
            $product_colors=$product_colors->whereIn('model',$model);
            $paperCart=$paperCart->whereIn('model',$model);
            $partnersData_metal = $partnersData_metal->whereIn('model',$model);
            $partnersData =$partnersData->whereIn('model',$model);
            $partnersData_model =$partnersData_model->whereIn('model',$model);
            $categories_data=   $categories_data->whereIn('model',$model);
            $brand_data=   $brand_data->whereIn('model',$model);
        }
         if($request->metal != null)
        {
           $metal=(array)$request->metal;
           $product_colors=$product_colors->whereIn('metal',$metal);
           $paperCart=$paperCart->whereIn('metal',$metal);
            // dd($request->brand);
            $partnersData_metal = $partnersData_metal->whereIn('metal',$metal);
            $partnersData =$partnersData->whereIn('metal',$metal);
            $partnersData_model =$partnersData_model->whereIn('metal',$metal);
            $categories_data=   $categories_data->whereIn('metal',$metal);
            $brand_data=   $brand_data->whereIn('metal',$metal);
        }
         if($request->size != null)
        {
           $size=(array)$request->size;
            // dd($request->brand);
            $product_colors=$product_colors->whereIn('size',$size);
            $paperCart=$paperCart->whereIn('size',$size);
            $partnersData_metal = $partnersData_metal->whereIn('size',$size);
            $partnersData =$partnersData->whereIn('size',$size);
            $partnersData_model =$partnersData_model->whereIn('size',$size);
            $categories_data=   $categories_data->whereIn('size',$size);
            $brand_data=   $brand_data->whereIn('size',$size);
        }
         if($request->brand_id != null)
        {
           $brand_id=(array)$request->brand_id;
            // dd($request->brand);
            $product_colors=$product_colors->whereIn('products.brand_id',$brand_id);
            $paperCart=$paperCart->whereIn('products.brand_id',$brand_id);
            $partnersData_metal = $partnersData_metal->whereIn('products.brand_id',$brand_id);
            $partnersData =$partnersData->whereIn('products.brand_id',$brand_id);
            $partnersData_model =$partnersData_model->whereIn('products.brand_id',$brand_id);
            $categories_data=   $categories_data->whereIn('products.brand_id',$brand_id);
            $brand_data=   $brand_data->whereIn('products.brand_id',$brand_id);
        }

         if($request->category_id != null)
        {
           $category_id=(array)$request->category_id;
            // dd($request->brand);
            $product_colors=$product_colors->whereIn('products.category_id',$category_id);
            $paperCart=$paperCart->whereIn('products.category_id',$category_id);
            $partnersData_metal = $partnersData_metal->whereIn('products.category_id',$category_id);
            $partnersData =$partnersData->whereIn('products.category_id',$category_id);
            $partnersData_model =$partnersData_model->whereIn('products.category_id',$category_id);
            $categories_data=   $categories_data->whereIn('products.category_id',$category_id);
            $brand_data=   $brand_data->whereIn('products.category_id',$category_id);
        }

         if($request->paper_cart != null)
        {
           $paper_cart=$request->paper_cart;
            // dd($request->brand);
            $product_colors=$product_colors->where('products.paper_cart',$paper_cart);
             $paperCart=$paperCart->where('products.paper_cart',$paper_cart);
            $partnersData_metal = $partnersData_metal->where('products.paper_cart',$paper_cart);
            $partnersData =$partnersData->where('products.paper_cart',$paper_cart);
            $partnersData_model =$partnersData_model->where('products.paper_cart',$paper_cart);
            $categories_data=   $categories_data->where('products.paper_cart',$paper_cart);
            $brand_data=   $brand_data->where('products.paper_cart',$paper_cart);
        }
          if($request->listing_type != null)
        {
           $listing_type=$request->listing_type;
              if(in_array($listing_type,$listingType))
                {
                    $product_colors=$product_colors->where('product_types.listing_type',$listing_type);
                    $paperCart=$paperCart->where('product_types.listing_type',$listing_type);
                    $partnersData_metal = $partnersData_metal->where('product_types.listing_type',$listing_type);
                    $partnersData =$partnersData->where('product_types.listing_type',$listing_type);
                    $partnersData_model =$partnersData_model->where('product_types.listing_type',$listing_type);
                    $categories_data=   $categories_data->where('product_types.listing_type',$listing_type);
                    $brand_data=   $brand_data->where('product_types.listing_type',$listing_type);
                }
                else
                {
                    $product_colors=$product_colors->where('product_types.product_type_name',$listing_type);
                    $paperCart=$paperCart->where('product_types.product_type_name',$listing_type);
                    $partnersData_metal = $partnersData_metal->where('product_types.product_type_name',$listing_type);
                    $partnersData =$partnersData->where('product_types.product_type_name',$listing_type);
                    $partnersData_model =$partnersData_model->where('product_types.product_type_name',$listing_type);
                    $categories_data=   $categories_data->where('product_types.product_type_name',$listing_type);
                    $brand_data=   $brand_data->where('product_types.product_type_name',$listing_type);
                }
        }

          if($request->condition != null)
        {
           $condition=$request->condition;
            // dd($request->brand);
            $product_colors=$product_colors->where('productconditions.name',$condition);
            $paperCart=$paperCart->where('productconditions.name',$condition);
            $partnersData_metal = $partnersData_metal->where('productconditions.name',$condition);
            $partnersData =$partnersData->where('productconditions.name',$condition);
            $partnersData_model =$partnersData_model->where('productconditions.name',$condition);
            $categories_data=   $categories_data->where('productconditions.name',$condition);
            $brand_data=   $brand_data->where('productconditions.name',$condition);
        }
        if($request->keyword != null)
        {


            $products = filter_products(Product::query());
            $products = $products->where('published', 1)->select("products.*",'product_stocks.sku','brands.name','categories.name','productconditions.name')
                        ->leftJoin('brands','brands.id','=','products.brand_id')
                        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                        ->leftJoin('categories','categories.id','=','products.category_id')
                        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
                        ->where(function ($q) use ($query){
                                $q->orWhere('products.stock_id', 'like', '%'.$query.'%')
                                ->orWhere('product_stocks.sku', 'like', '%'.$query.'%')
                                ->orWhere('products.model', 'like', '%'.$query.'%')
                                ->orWhere('products.metal', 'like', '%'.$query.'%')
                                ->orWhere('brands.name', 'like', '%'.$query.'%')
                                ->orWhere('productconditions.name', 'like', '%'.$query.'%')
                                ->orWhere('categories.name', 'like', '%'.$query.'%')
                                ->orWhere('products.size', 'like', '%'.$query.'%');
                        });

                        foreach($products->get() as $row)
                        {
                            $paperCarts[]=$row->paper_cart;
                            $model_key[]=$row->model;
                            $metal_key[]=$row->metal;
                            $size_key[]=$row->size;
                            $brand_key[]=$row->brand_id;
                            $colors_id[]=$row->colors;
                            $category_key[]=$row->category_id;
                        }
                        $product_colors=$product_colors->whereIn('colors',$colors_id);
                        $brand_data=$brand_data->whereIn('brand_id',$brand_key);
                        $categories_data=$categories_data->whereIn('category_id',$category_key);
                        // dd($brand_data->get());
                        $paperCart_key=array_unique($paperCarts);
                        $model_key=array_unique($model_key);
                        $metal_key=array_unique($metal_key);
                        $size_key=array_unique($size_key);
        }
        $product_colors=$product_colors->get();
        $paperCart=$paperCart->get();
        // dd($paperCart);
        $partnersData_metal=$partnersData_metal->get();
        $partnersData=$partnersData->get();
        $partnersData_model=$partnersData_model->get();
        $categories_data=$categories_data->get();
        if($request->condition != null) {
          $brand_data = $brand_data->where('productconditions.name',$request->condition);
          // dd($brand_data->get());
        }
        $brand_data=$brand_data->get();
        $conditions = ['published' => 1];
        if($brand_id != null)
        {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        elseif ($request->brand != null)
        {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        if($seller_id != null)
        {
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }
        // dd($conditions);
        $products = Product::where($conditions);
        $listingtype=$request->listing_type;
        $listing_type = $request->listing_type;
        //  dd($request->listing_type);
         if($listing_type != null)
         {
            //   dd($listing_type);
                // $listinType = Producttype::where('listing_type', $listing_type)->get();
                if(in_array($listing_type,$listingType))
                {
                    // dd($listing_type);
                    $listinType =  Producttype::where('listing_type', $listing_type)->get();
                    // dd($listinType);
                }
                else
                {
                    $listinType = Producttype::where('product_type_name', $listing_type)->get();
                    // dd($listinType);
                }
            if($request->listing_type=="Bracelet")
            {
                $listingAry=array('Bracelet','Bangle','BraceletY');
                $listinType = Producttype::where('product_type_name', $listingAry)->get();
            }
            $listinTypeId = array();
            foreach ($listinType as $key => $listinTypeval) {
                $listinTypeId[] = $listinTypeval->id;
            }
            // dd($listinTypeId);
            $products->whereIn('product_type_id', $listinTypeId);
         }
        // dd($products->get());




        if($min_price != null && $max_price != null){
            $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }
        if($query != null){
            $searchController = new SearchController;
            // dd($searchController);
            $searchController->store($request);
            $products->where(function ($q) use ($query){

                foreach (explode(' ', trim($query)) as $word) {
                  $q->where('name', 'like', '%'.$word.'%')->orWhere('tags', 'like', '%'.$word.'%')
                    ->orWhereHas('product_translations', function($q) use ($word){
                        $q->where('name', 'like', '%'.$word.'%');
                    });
                }
            });
        }
        switch ($sort_by) {
            case 'newest':
                $products->orderBy('created_at', 'desc');
                break;
                case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
                case 'price-asc':
                $products->orderBy('unit_price', 'asc');
                break;
                case 'price-desc':
                $products->orderBy('unit_price', 'desc');
                break;
                default:
                $products->orderBy('id', 'desc');
                break;
        }
        // if($request->has('color')){
        //     $str = '"'.$request->color.'"';
        //     $products->where('colors', 'like', '%'.$str.'%');
        //     $selected_color = $request->color;
        // }
        if( $request->model != null){
            $strmod = $request->model;
            // dd($strmod);
            $products->where(function ($query) use($strmod) {
             for ($i = 0; $i < count($strmod); $i++){
                $query->where('model',  $strmod[$i] );
             }
          });
            // dd($products->get());
            // $products->whereIn('model', 'like', '%'.$strmod.'%');
            // $selected_model = $request->model;
       }
        if( $request->metal != null){
            $strmetl = $request->metal;
            // dd($strmetl);
             $products->where(function ($query) use($strmetl) {
             for ($i = 0; $i < count($strmetl); $i++){
                $query->orwhere('metal', 'like',  '%' . $strmetl[$i] .'%');
             }
             });
       }

        if( $request->size != null){
            $strsize = $request->size;
             $products->where(function ($query) use($strsize) {
             for ($i = 0; $i < count($strsize); $i++){
                $query->orwhere('size', 'like',  '%' . $strsize[$i] .'%');
             }
             });
        }
        if( $request->paper_cart){
            $str = $request->paper_cart;
             $products->where('paper_cart', 'like', '%'.$str.'%');
            $selected_paperCart = $request->paper_cart;
        }
        if( $request->brand_id != null){
            $strbrandid = $request->brand_id;
             $products->where(function ($query) use($strbrandid) {
             for ($i = 0; $i < count($strbrandid); $i++){
                $query->orwhere('brand_id', 'like',  '%' . $strbrandid[$i] .'%');
             }
             });
            //  $products->where('brand_id', $str);
            // $selected_brand_id = $request->brand_id;
        }
         if( $request->colors != null){
            //  dd($request->colors);
            $strcolorid = $request->colors;
             $products->where(function ($query) use($strcolorid) {
             for ($i = 0; $i < count($strcolorid); $i++){
                $query->orwhere('colors', 'like',  '%' . $strcolorid[$i] .'%');
             }
             });
            //  $products->where('brand_id', $str);
            // $selected_brand_id = $request->brand_id;
        }
        if( $request->category_id != null){
            $strcateg = $request->category_id;
            // $products->where(function ($query) use($strcateg) {
            //  for ($i = 0; $i < count($strcateg); $i++){
            //     $query->orwhere('category_id', 'like',  '%' . $strcateg[$i] .'%');
            //  }
            //  });
             $products->whereIn('category_id',$strcateg);
            // $selected_caregory_id = $request->category_id;
        }
        // if( $request->paper_cart != null)
        // {
        //     $paper_cart = $request->paper_cart;
        //     $products->where('paper_cart',$paper_cart);
        // }

         if($request->has('selected_attribute_values')){
            $selected_attribute_values = $request->selected_attribute_values;
            // dd($selected_attribute_values);
            foreach ($selected_attribute_values as $key => $value) {
                $str = '"'.$value.'"';
                $products->where('choice_options', 'like', '%'.$str.'%');
            }
        }
        $watch_parts=array('Watch Parts','Bands','Band','Dial','Links','Bezel','Crystal','Insert');
        if(in_array($request->listing_type,$watch_parts))
        {
          $products->groupBy('products.model','products.metal');
        }
        // $products->groupBy('model');
        if($request->condition != null) {
          $Product_condition_id = Productcondition::where('name',$request->condition)->first();
          $proConID = $Product_condition_id->id;
          if($request->condition == 'New'){
            $products->where('products.productcondition_id',$proConID);
          }else{
            $products->where('products.productcondition_id',$proConID);
          }
        }
      if($request->condition =='' && $request->category_id=='' && $request->brand_id=='' && $request->size=='' && $request->metal=='' &&  $request->model=='' && $min_price=='' && $max_price=='' && $request->listing_type=='')
        {
          $products = filter_products(Product::query());
            $products = $products->where('published', 1)->where('product_stocks.qty','>',0)
            ->select("products.*",'product_types.listing_type','product_stocks.sku','brands.name as brand_name','categories.name as category_name','productconditions.name as condition_name')
                                  ->leftJoin('brands','brands.id','=','products.brand_id')
                                  ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                  ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                  ->leftJoin('categories','categories.id','=','products.category_id')
                                  ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
                        ->where(function ($q) use ($query){
                              $q->orWhere('products.stock_id', 'like', '%'.$query.'%')
                                ->orWhere('product_stocks.sku', 'like', '%'.$query.'%')
                                ->orWhere('products.model', 'like', '%'.$query.'%')
                                ->orWhere('products.metal', 'like', '%'.$query.'%')
                                ->orWhere('brands.name', 'like', '%'.$query.'%')
                                ->orWhere('productconditions.name', 'like', '%'.$query.'%')
                                ->orWhere('categories.name', 'like', '%'.$query.'%')
                                ->orWhere('products.size', 'like', '%'.$query.'%');
                            // foreach (explode(' ', trim($query)) as $word) {
                            //     $q->where('name', 'like', '%'.$word.'%')->orWhere('tags', 'like', '%'.$word.'%')->orWhereHas('product_translations', function($q) use ($word){
                            //         $q->where('name', 'like', '%'.$word.'%');
                            //     });
                            // }
                        });
                        $row_listing=array();
                        // echo "<pre>";
                        // echo $products;
                        // echo "</pre>";
                        // exit;
                    foreach($products->get() as $row)
                    {
                        $row_listing[]=$row->listing_type;
                    }
                    // dd($products);
                    if(in_array("Watch Parts",$row_listing))
                    {
                        $listing_type_uni="Watch Parts";
                        // dd($listing_type_uni);
                        $products=$products->groupBy('products.metal','products.model');
                    }
                    // dd($row_listing);
        }
        $products = filter_products($products)->with('taxes')->paginate(12)->appends(request()->query());
        return view('frontend.product_listing', compact('products','paperCart','listing_type_uni','product_colors','paperCart_key','size_key','metal_key','model_key','categories_data', 'brand_data','partnersData_model','query','listingtype', 'category_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color','partnersData','partnersData_metal', 'all_product'));
    }
    public function listing(Request $request)
    {
        return $this->index($request);
    }
    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        // dd($category->id);
        if ($category != null) {
            return $this->index($request, $category->id);
        }
        abort(404);
    }
    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->index($request, null, $brand->id);
        }
        abort(404);
    }
    //Suggestional Search
    public function ajax_search(Request $request)
    {
        $keywords = array();
        $query = $request->search;
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$query.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $query) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }
        $products = filter_products(Product::query());
        $products = $products->where('published', 1)
                        ->where(function ($q) use ($query){
                            foreach (explode(' ', trim($query)) as $word) {
                                $q->where('name', 'like', '%'.$word.'%')->orWhere('tags', 'like', '%'.$word.'%')->orWhereHas('product_translations', function($q) use ($word){
                                    $q->where('name', 'like', '%'.$word.'%');
                                });
                            }
                        })
                    ->get();
        $categories = Category::where('name', 'like', '%'.$query.'%')->get()->take(3);
        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$query.'%')->get()->take(3);
        if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
        }
        return '0';
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->keyword);
        $search = Search::where('query', $request->keyword)->first();
        // dd($search);
        if($search != null){
            $search->count = $search->count + 1;
            $search->save();
        }
        else{
            $search = new Search;
            $search->query = $request->keyword;
          $search->save();

        }

    }
    public function listingByListing_type(Request $request,$listing_type)
    {
        // dd($listing_type);
        // if($listing_type=="Bracelet")
        // {
        //     $array=array('Bracelet','Bangle');
        //     $product_type = Producttype::whereIn('listing_type', $array)->first();
        // }
        $listingtype=array('Jewelry','Watch','Watch Parts','Accessories','Diamonds','Gold Collectibles');
        if(in_array($listing_type,$listingtype))
        {
             $product_type = Producttype::where('listing_type', $listing_type)->first();
        }
        else
        {
             $product_type = Producttype::where('product_type_name', $listing_type)->first();
        }

        // dd($product_type->id);
        if ($product_type != null) {
            return $this->index($request, $product_type->id);
        }
        abort(404);
    }
    public function brand_ids(Request $request)
    {
        $brandId=(array)$request->brandId;
        // print_r($brandId);
        return $this->index($request,$brandId);
    }
    public function watch_service(Request $request)
    {
       return view('frontend.partials.watch_service');
    }
    public function watch_service_store(Request $request)
    {
        $service_data= new ServiceRequest();
        $service_data->type=$request->type;
        $service_data->model=$request->model;
        $service_data->brand=$request->brand;
        $service_data->serial=$request->serial;
        $service_data->job_detail=$request->job_details;
        $service_data->imges=$request->image;
        $service_data->description=$request->description;
        if (Auth::check()){
          $email = auth()->user()->email;
        }else {
          $email = "activity@gciwatch.com";
        }
        $array['userIp'] = $request->ip();
        $array['type']= $request->type;
        $array['model']= $request->model;
        $array['job_detail'] = $request->job_detail;
        $array['description']=$request->description;
        $array['brand'] = $request->brand;
        $array['serial'] = $request->serial;
        $array['user_mail_id']=$email;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        Mail::send('frontend.allmails.watch_service_req_mail', $array, function($message) use($array) {
            $message->to(env("StockManager"));
            $message->cc($array['user_mail_id']);
            $message->subject('Watch Service Request Notification');
        });
        $service_data->save();
       flash(translate("Your request sended successfully !!"))->success();
        return back();

    }
    public function sell_my_watch_create()
    {
     return view('frontend.partials.sell_watch');
    }
    public function sell_my_watch_store(Request $request)
    {
          $request->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'text' => 'required',
        'watch_brand' => 'required',
        'model_number' => 'required',
        'amount' => 'required',
        'box_paper' => 'required',
        'image' => 'required',
        'comment' => 'required',
        
    ]);

        $SellWatche= new SellMyWatche();
        $SellWatche->first_name=$request->first_name;
        $SellWatche->last_name=$request->last_name;
        $SellWatche->phone=$request->phone;
        $SellWatche->email=$request->email;
        $SellWatche->watch_brand=$request->watch_brand;
        // $SellWatche->brand_id=$request->brand_id;
        $SellWatche->amount=$request->amount;
        $SellWatche->box_paper=$request->box_paper;
        $SellWatche->model_number=$request->model_number;
        // dd( $SellWatch->model_number);
        $SellWatche->comment=$request->comment;
        $SellWatche->image=$request->image;
        if (Auth::check()){
          $email = auth()->user()->email;
        }else {
          $email = $request->email;
        }
         $array['userIp'] = $request->ip();
        $array['first_name']= $request->first_name;
        $array['last_name']= $request->last_name;
        $array['email'] = $request->email;
        $array['user_mail_id']=$email;
        $array['watch_brand']=$request->watch_brand;
        $array['amount'] = $request->amount;
        $array['box_paper'] = $request->box_paper;
        $array['model_number'] = $request->model_number;
        $array['comment'] = $request->comment;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        Mail::send('frontend.allmails.sell_my_watch', $array, function($message) use ($array){
            $message->to(env("StockManager"));
            $message->cc($array['user_mail_id']);
            $message->subject('Sell Watch Request Notification');
        });
        $SellWatche->save();
        flash(translate("Your request sended successfully !!"))->success();
        return back();
    }
    
    
    
    Public function watch_request(Request $request)
    {
        $WatchRequest=new WatchRequest();
        $WatchRequest->name=$request->name;
        $WatchRequest->phone=$request->phone;
        $WatchRequest->email=$request->email;
        $WatchRequest->model=$request->model;
        $WatchRequest->dial=$request->dial;
        $WatchRequest->bezel=$request->bezel;
        $WatchRequest->description=$request->description;
        $WatchRequest->band=$request->band;
        $WatchRequest->price=$request->price;
        
        if (Auth::check()){
          $email = auth()->user()->email;
        }else {
          $email = "activity@gciwatch.com";
        }
        $array['userIp'] = $request->ip();
        $array['name']= $request->name;
        $array['phone']= $request->phone;
        $array['email'] = $request->email;
        $array['model']=$request->model;
        $array['dial'] = $request->dial;
        $array['bezel'] = $request->bezel;
        $array['description'] = $request->description;
        $array['band'] = $request->band;
        $array['price'] = $request->price;
        $array['user_mail_id']=$email;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        Mail::send('frontend.allmails.watch_request_mail', $array, function($message) use($array) {
            $message->to(env("StockManager"));
            $message->cc($array['user_mail_id']);
            $message->subject(' Request A Watch ');
        });
        
        
        
        
        
        $WatchRequest->save();
        flash(translate('Your request sended successfully !!'))->success();
        return back();
    }
    
    
    
    
    
    
    
    
    
    public function watch_and_jewelry_service(Request $request)
    {
         return view('frontend.partials.watch_and_jewelry_service');
    }

}
