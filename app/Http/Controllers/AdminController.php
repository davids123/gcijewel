<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Memo;
use App\Category;
use App\ReturnItems;
use App\JobOrder;
use App\JobOrderDetail;
use App\ProductType;
use App\Product;
use App\RetailReseller;
use App\SiteOptions;
use App\Models\Warehouse;
use Cache;
use Auth;
use App\User;
use App\MemoDetail;
use CoreComponentRepository;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function admin_dashboard(Request $request)
     {
         CoreComponentRepository::initializeCache();
         $joCountQry = JobOrder::where('job_status',2)->count();
         $arrSt = array(0,1);
         $memos= Memo::select(DB::raw('SUM(memos.sub_total) as memoSubTotal'),'memos.id','memos.memo_number','memos.sub_total','memos.date' ,'retail_resellers.company')
                 ->join('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
                 ->join('memo_details', 'memos.id', '=', 'memo_details.memo_id')
                 ->join('products', 'memo_details.product_id', '=', 'products.id')
                  ->join('product_stocks','products.id','=','product_stocks.product_id')
                 ->groupBy('memo_details.memo_id')
                 ->whereIn('memo_details.item_status', $arrSt)
                 ->orderBy('memos.id', 'ASC');
         $sort_search = isset($request->memo_s) ? $request->memo_s : '';
         if($sort_search != null){
               $memos = $memos->where(function($query) use ($sort_search){
                 $query->where('memos.memo_number', 'LIKE', '%'.$sort_search.'%');
               });
         }
         $memo_details=$memos->paginate(25,["*"],'memo');
    $sort_by =null;
         $productQry = Product::leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                ->where('published', '=', '1')
                                ->where('product_stocks.qty','>=',1)
                                ->count();  
                            //  dd($memo_details);
        
        $sumary_d=  Memo::select(DB::raw('SUM(memos.sub_total) as memoSubTotal'),DB::raw('SUM(products.product_cost) as totalProCost'),'retail_resellers.company','retail_resellers.phone','retail_resellers.email')
                            ->join('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
                            ->join('memo_details', 'memos.id', '=', 'memo_details.memo_id')
                            ->leftJoin('products','products.id','memo_details.product_id')
                            ->orderBY('sub_total','DESC')
                            ->groupBy('retail_resellers.company');
        $sort_search = isset($request->Customers_s) ? $request->Customers_s : '';
        if($sort_search != null){
            $sumary_d = $sumary_d->where(function($query) use ($sort_search){
                $query->where('retail_resellers.company', 'LIKE', '%'.$sort_search.'%');
            });
        }
        $summery_details=$sumary_d->paginate($request->suppliers*25);
        // dd($summery_details);
        
          
        $sumary_comp = Product::orderBy('memoSubTotal', 'DESC')
                            ->groupBy('retail_resellers.company')
                            -> select(DB::raw('SUM(memo_details.row_total) as memoSubTotal') ,'retail_resellers.company','retail_resellers.id as company_id')
                            ->Join('memo_details', 'memo_details.product_id', '=', 'products.id')
                            ->Join('memos', 'memos.id', '=', 'memo_details.memo_id')
                            ->Join('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
                            ->whereIn('memo_details.item_status', $arrSt);
        $all_summary = $sumary_comp->paginate(25,["*"],'summarypane');
        // dd($all_summary);
        $low_stock = Product::leftJoin('brands','brands.id','=','products.brand_id')
                   ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                   ->join('product_stocks','products.id','=','product_stocks.product_id')
                   ->join('site_options','site_options.option_value','=','products.model')
                   ->orderBy('products.id', 'DESC')
                   ->select('products.model',DB::raw('SUM(product_stocks.qty) as prostock'),'product_types.listing_type','brands.name as bname','site_options.low_stock')
                   ->where('product_stocks.qty','>=',1)
                   ->groupBy('products.model')
                   ->where('published', '=', '1')
                   ->having('site_options.low_stock', '>=', DB::raw('SUM(product_stocks.qty)'));
                $sort_search = isset($request->low_stock_data_s) ? $request->low_stock_data_s : '';
                    if($sort_search != null){
                    $low_stock = $low_stock->where(function($query) use ($sort_search){
                        $query->where('product_types.listing_type', 'LIKE', '%'.$sort_search.'%');
                        $query->orWhere('brands.name', 'LIKE', '%'.$sort_search.'%');
                    });
                }
                $detailedProduct=$low_stock->paginate(25,['*'],'low_stock_data');
                // dd($detailedProduct);

                $warehouseDataFltr = Warehouse::select('id','name')->get();
                // dd($warehouseDataFltr);

        $jobdetails = JobOrder::select('job_orders.id','job_orders.job_order_number','retail_resellers.customer_group','retail_resellers.customer_name as cu_name','job_orders.estimated_date_return','job_order_details.model_number','job_order_details.estimated_date_return as estimated_date','retail_resellers.company')
                               ->leftJoin('job_order_details', 'job_order_details.job_order_id', '=', 'job_orders.id')
                               ->join('retail_resellers', 'retail_resellers.id', '=', 'job_orders.company_name')
                               ->orderBy('job_orders.id','ASC')
                               ->where('job_status','2');
        $sort_search = isset($request->job_orders_s) ? $request->job_orders_s : '';
        if($sort_search != null){
            $jobdetails = $jobdetails->where(function($query) use ($sort_search){
                $query->where('job_orders.job_order_number', 'LIKE', '%'.$sort_search.'%');
            });
        }
        $jobOrderData=$jobdetails->paginate(25,['*'],'job_orders');
        $lowStockOpt = SiteOptions::where('option_name', 'listingtype')->select('option_value')->get();
        // dd($lowStockOpt);
        $customer_d=Product::leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                            ->orderBy('totalProCost', 'DESC')
                            ->groupBy('retail_resellers.company')
                            ->select(DB::raw('SUM(products.product_cost) as totalProCost'),'retail_resellers.*')
                            ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
                            ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
                            ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id');
                            // dd($customer_d->get());
        $sort_search = isset($request->suppliers_s) ? $request->suppliers_s : '';
        if($sort_search != null){
            $customer_d = $customer_d->where(function($query) use ($sort_search){
                $query->where('retail_resellers.company', 'LIKE', '%'.$sort_search.'%');
            });
        }
         $Customer_details = $customer_d->paginate($request->suppliers*25);
        //  dd($Customer_details);
        $total_memo= $memo_details->count();
        // dd($total_memo);


        $arrSt = array(0,1);
        $memoQuery = Memo::join('memo_details', 'memos.id', '=', 'memo_details.memo_id')
                          ->join('products', 'memo_details.product_id', '=', 'products.id')
                          ->join('product_stocks','products.id','=','product_stocks.product_id')
                          ->groupBy('memo_details.memo_id')
                          ->whereIn('memo_details.item_status', $arrSt)
                          ->orderBy('memos.id', 'DESC')
                          ->get()
                          ->count();
                          
        $average_cost=Product::groupBy('products.model')->get()->count();
        
        $available_Product = Product::with('stocks')
                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                    ->groupBy('products.id')
                    ->select('products.published','products.id','memo_details.item_status','product_stocks.qty')
                    ->leftJoin('memo_details','memo_details.product_id','=','products.id')
                    ->get();
                    // dd($available_Product);
                     $product_idsMemo=array();
                     $productreturn=array();
                     $productvoid=array();
                     $product_qty=array();
                    $returnPro="";
                foreach($available_Product as $avlPro)
                {
                    $return=ReturnItems::where('product_id',$avlPro->id)->first();
                    if($return != "")
                    {
                        $returnPro=$return->product_id;
                    }
                    $memo_detail_status=$avlPro->item_status;
                    if ($avlPro->is_repair=='1') 
                    {
                      $memostatus="Repair";
                    }
                    elseif($returnPro ==$avlPro->id)
                    {
                        $memostatus="Return";
                    }
                    else if($memo_detail_status=='1' || $memo_detail_status=='0' )
                    {
                        $memostatus='Memo';
                        $product_idsMemo[]=$avlPro->id;
                    }
                    else if($memo_detail_status=='2')
                    {
                        $memostatus='Invoice ';
                    }
                    else if($memo_detail_status=='3')
                    {
                        $memostatus='Available';
                        $productreturn[] = $avlPro->id;
                    }
                    else if($memo_detail_status=='4')
                    {
                        $memostatus='Trade ';
                    }
                    else if($memo_detail_status=='5')
                    {
                        $memostatus='Available';
                      $productvoid[] = $avlPro->id;
                    }
                    else if($memo_detail_status=='6')
                    {
                        $memostatus='TradeNGD ';
                    }
                     elseif($avlPro->qty >=1)
                    {
                        $memostatus="Available";
                         $product_qty[] = $avlPro->id;
                    }
                }
                $allProducts_id=array_merge($product_qty,$productvoid,$productreturn,$product_idsMemo);
                // dd($allProducts_id);
                $product_idsA=$product_idsMemo;
                $product_idsb=array_merge($product_qty,$productvoid,$productreturn);
                // dd($product_idsb);
                $warehouse= Product::groupBy('product_types.listing_type')
                                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                    ->select('product_types.listing_type',DB::raw('SUM(products.product_cost) as totalPrice'),'product_types.id as pro_ty_id',DB::raw('COUNT(product_types.listing_type) as total_count'))
                                    ->whereIn('products.id',$allProducts_id);
                                    // dd($warehouse->get());

                        $warehouse_id=$request->warehouse_id;
                        $stock=$request->stock;
                        $value=$request->value;
                        if($warehouse_id !='')
                        {
                            $warehouse=$warehouse->where('products.warehouse_id',$warehouse_id);
                        }
                        if($stock != "")
                        {
                            if($stock==2)
                            {
                            $warehouse=$warehouse->whereIn('products.id',$product_idsb);
                            }
                            elseif($stock==3)
                            {
                                $warehouse=$warehouse->whereIn('products.id',$product_idsA);
                            }
                        }
                        $warehousenet="";
                        $mergedNetAmount="";
                        $TNetSum = array();
                        $TNetCount = array();
                        if($value !="")
                        {
                            if($value==2)
                            {
                              $warehousenetQy= Product::groupBy('product_types.listing_type')
                                                        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                                                        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                                        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                                        ->select('product_types.listing_type as net_listing_type',DB::raw('SUM(products.product_cost)/2  as net_totalPrice'),'product_types.id as net_pro_ty_id',DB::raw('COUNT(product_types.listing_type) as net_total_count'))
                                                        ->whereIn('products.id',$allProducts_id)
                                                        ->where('products.partner','!=','GCI');
                                if($stock != "")
                                {
                                    if($stock==2)
                                    {
                                    $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsb);
                                    }
                                    elseif($stock==3)
                                    {
                                        $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsA);
                                    }


                                }
                                 if($warehouse_id !='')
                                    {
                                        $warehousenetQy=$warehousenetQy->where('products.warehouse_id',$warehouse_id);
                                    }
                                $warehousenet=$warehousenetQy->get();
                                                    // dd($warehousenet);
                              $warehouseaddnet=$warehouse->where('products.partner','GCI')->get();
                              // dd($warehouseaddnet);
                              $netvalueTPrice = array();
                              $netvalueTCount = array();

                              foreach ($warehousenet as $netval) {
                                $netvalueTPrice[$netval->net_listing_type][] = $netval->net_totalPrice;
                                $netvalueTCount[$netval->net_listing_type][] = $netval->net_total_count;
                              }
                              foreach ($warehouseaddnet as $netvalue) {
                                  $netvalueTPrice[$netvalue->listing_type][] = $netvalue->totalPrice;
                                  $netvalueTCount[$netvalue->listing_type][] = $netvalue->total_count;
                              }

                              foreach ($netvalueTPrice as $nvkey => $nvValue) {
                                $TNetSum[$nvkey] = array_sum($nvValue);
                              }

                              foreach ($netvalueTCount as $nvkey => $nvValue) {
                                $TNetCount[$nvkey] = array_sum($nvValue);
                              }
                              $mergedNetAmount = array_merge_recursive($TNetSum,$TNetCount);
                              $warehouse=$warehouse->where('products.partner','GCI');

                              // dd($TNetSum);

                            }
                        }


                $all_warehouse=$warehouse->get();
                // dd($all_warehouse);

         return view('backend.dashboard', compact('productQry','lowStockOpt','warehouseDataFltr','all_summary','average_cost','memoQuery','memo_details','Customer_details','total_memo','detailedProduct','jobOrderData','summery_details','all_warehouse','mergedNetAmount','value','joCountQry'));
     }

    public function getListingTypeId($id)
    {
      echo $id;
    }
    public function memoDaAjax(Request $request)
    {

        $company_id = $request->id;
        // dd($company_id);
        $memoDashData = Memo::select('memos.id','memos.memo_number',DB::raw('sum(memo_details.row_total) as sub_total'),'memo_details.item_status')
                        ->leftjoin('memo_details', 'memos.id', '=', 'memo_details.memo_id')
                        ->join('products', 'memo_details.product_id', '=', 'products.id')
                        ->join('product_stocks','products.id','=','product_stocks.product_id')
                        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment')
                        ->groupBy('memos.memo_number')
                        ->where('customer_name',$company_id)
                        ->where('memo_details.item_status',0)
                        ->get();
        $ReturntableAppend = "<table class='table table-bordered table-hover table-striped print-table order-table table'>
        <thead>
          <tr class='bg-primary text-white'>
            <th scope='col'>Memo Number</th>
            <th scope='col'>Open Balance</th>
            <th scope='col'>Status</th>
          </tr>
        </thead>
        <tbody>";
        foreach ($memoDashData as $RProItem) {
          $memo_number = $RProItem->memo_number;
          $sub_total = $RProItem->sub_total;
          setlocale(LC_MONETARY,"en_US");
          $ReturntableAppend .= "
            <tr>
              <td>$memo_number</td>
              <td>".money_format("%(#1n", $sub_total)."\n"."</td>
              <td>Open Balance</td>
            </tr>";
        }
        $ReturntableAppend .= "</tbody>
      </table>";
      return response()->json(['success' => true,'memoDaHtmlData'=>$ReturntableAppend]);

    }
    public function stockChart(Request $request)
    {
        $listing =  (array)$request->id;
         $listing = ProductType::whereIn('listing_type', $listing)->get();
        // dd($listing);
        $ProTyprID = array();
        foreach ($listing as $ProTypr) {
          $ProTyprID[] = $ProTypr->id;
        }
        // dd($ProTyprID);
        $productStocks = Product::select(DB::raw('SUM(product_stocks.qty) as allqty'),'products.stock_id','products.id','products.model as model_number')
                                ->join('product_stocks','product_stocks.product_id','=','products.id')
                                ->join('product_types','product_types.id','=','products.product_type_id')
                                ->where('product_stocks.qty','>=',1)
                                ->where('products.published','1')
                                ->whereIn('product_types.id',$ProTyprID)
                                ->orderBy('allqty','DESC')
                                ->groupBy('products.model')
                                ->get();
          return response()->json(['success' => true,'stockChart'=>$productStocks]);
    }
    public function stockChart_1(Request $request)
    {
        $listing = (array)$request->id;
        $listing = ProductType::whereIn('listing_type', $listing)->get();
        $ProTyprID = array();
        foreach ($listing as $ProTypr) {
            $ProTyprID[] = $ProTypr->id;
        }
        $productStocks =Product::with( 'stocks', 'category','productType')
                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                    ->where('published', '=', '1')
                    ->where('product_stocks.qty','>',0)
                    ->whereIn('product_types.id',$ProTyprID)
                    ->leftJoin('categories','categories.id','=','products.category_id')
                    ->groupBy('products.category_id')
                    ->select(\DB::raw('SUM(product_stocks.qty) as allqty'),'products.stock_id','products.id','products.model','categories.name as category_name')
                    // ->orderBy('allqty','DESC')
                    ->get();
        //  print_r($productStocks);exit;
         return response()->json(['success' => true,'stockChart'=>$productStocks]);

    }
    function ListingTypeAjax(Request $request)
    {
      $tisting_type_id = $request->id;
      if($tisting_type_id != ""){
      $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
      ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
      ->leftJoin('brands','brands.id','=','products.brand_id')
      ->leftJoin('users','users.id','=','products.supplier_id')
      ->leftJoin('product_types','product_types.id','=','products.product_type_id')
      ->join('product_stocks','products.id','=','product_stocks.product_id')
      ->join('site_options','site_options.option_value','=','products.model')
      ->orderBy('products.id', 'DESC')
      ->select('products.*', DB::raw('SUM(product_stocks.qty) as prostock'),'product_types.listing_type','brands.name as bname','warehouse.name as warehouse_name','users.name as user_name','site_options.low_stock')
      ->where('product_stocks.qty','>=',1)
      ->groupBy('products.model')
      ->where('published', '=', '1')
      ->where('product_types.listing_type', '=',$tisting_type_id )
     ->having('site_options.low_stock', '>=', DB::raw('SUM(product_stocks.qty)'))
      ->get();

      $ReturntableAppend = "<table class='table table-bordered table-hover table-striped print-table order-table table' id='low_stock_filter'>
        <thead>
          <tr class='bg-primary text-white'>
            <th>#</th>
            <th>Listing Type</th>

            <th>Brand</th>

            <th>Model</th>

            <th>Stock</th>

            <th>Product stock</th>

          </tr>

        </thead>

        <tbody>";

        $count = 1;

        foreach($detailedProduct as $row)

        {

          $id=$count;

          $name=$row->bname;

          $model=$row->model;

          $stock=$row->low_stock;

          $listing_type=$row->listing_type;

          $prostock=$row->prostock;

          $count++;

          // echo $listing_type;

          $ReturntableAppend .= "

        <tr>

        <td>$id</td>

        <td>$listing_type</td>

        <td>$name</td>

        <td>$model</td>

        <td>";

            if($stock >  0 && $stock >= $prostock)

            {

              $ReturntableAppend .= "<span class='badge badge-inline badge-danger'>Low</span>($stock)";

            }

            else

            {

               $ReturntableAppend .= $stock;

            }

            $ReturntableAppend .= " </td>

        <td>$prostock</td>

        </tr>";

        }

        $ReturntableAppend .= "</tbody>

        </table>

        ";

      }else{

        $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')

        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')

        ->leftJoin('brands','brands.id','=','products.brand_id')

        ->leftJoin('users','users.id','=','products.supplier_id')

        ->leftJoin('product_types','product_types.id','=','products.product_type_id')

        ->join('product_stocks','products.id','=','product_stocks.product_id')

        ->join('site_options','site_options.option_value','=','products.model')

        ->orderBy('products.id', 'DESC')

        ->select('products.*',DB::raw('SUM(product_stocks.qty) as prostock'),'product_types.listing_type','brands.name as bname','warehouse.name as warehouse_name','users.name as user_name','site_options.low_stock')

        ->where('product_stocks.qty','>=',1)

        ->groupBy('products.model')

        ->where('published', '=', '1')

        ->having('site_options.low_stock', '>=', DB::raw('SUM(product_stocks.qty)'))

        ->get();

        $ReturntableAppend = "<table class='table table-bordered table-hover table-striped print-table order-table table' id='low_stock_filter'>

          <thead>

            <tr class='bg-primary text-white'>

              <th>#</th>

              <th>Listing Type</th>

              <th>Brand</th>

              <th>Model</th>

              <th>Stock</th>

              <th>Product Stock</th>

            </tr>

          </thead>

          <tbody>";

          $count = 1;

          foreach($detailedProduct as $row)

          {

            $id=$count;

            $name=$row->bname;

            $model=$row->model;

            $stock=$row->low_stock;

            $listing_type=$row->listing_type;

            $prostock=$row->prostock;

            $count++;

            // echo $listing_type;

            $ReturntableAppend .= "

          <tr>

          <td>$id</td>

          <td>$listing_type</td>

          <td>$name</td>

          <td>$model</td>

          <td>";

              if($stock >  0 && $stock >= $prostock)

              {

                $ReturntableAppend .= "<span class='badge badge-inline badge-danger'>Low</span>($stock)";

              }

              else

              {

                 $ReturntableAppend .= $stock;

              }

              $ReturntableAppend .= " </td>



          <td>$prostock</td>

          </tr>";

          }

          $ReturntableAppend .= "</tbody>

          </table>

          ";

      }

        return response()->json(['success' => true,'listingTypeData'=>$ReturntableAppend]);
    }
    public function warehouseData(Request $request)
    {
         setlocale(LC_MONETARY,"en_US");
        $listing_type = $request->listing_type;
        $warehouse_values = $request->warehouse_values;
        $warehouse_id = $request->warehouse_id;
        $stock = $request->stock;
        $AppendWareHSTr=array();
        $AppendWareFtr=array();
        $RecordArr = array();
        //  $arry=array(1,0);
        $available_Product = Product::with( 'stocks')
                    // ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                    // ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                    ->orderBy('products.id', 'DESC')
                    ->groupBy('products.id')
                    ->select('products.id','products.published','memo_details.item_status','product_stocks.qty')
                    ->leftJoin('memo_details','memo_details.product_id','=','products.id')
                    // ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
                    ->get();

              $product_idsMemo=array();
                 $productreturn=array();
                 $productvoid=array();
                 $product_qty=array();
                $returnPro="";
                
                foreach($available_Product as $avlPro)
                {
                    $return=ReturnItems::where('product_id',$avlPro->id)->first();
                    if($return != "")
                    {
                        $returnPro=$return->product_id;
                    }
                    $memo_detail_status=$avlPro->item_status;
                    if ($avlPro->is_repair=='1') 
                    {
                      $memostatus="Repair";
                    }
                    elseif($returnPro ==$avlPro->id)
                    {
                        $memostatus="Return";
                    }
                    else if($memo_detail_status=='1' || $memo_detail_status=='0' )
                    {
                        $memostatus='Memo';
                        $product_idsMemo[]=$avlPro->id;
                    }
                    else if($memo_detail_status=='2')
                    {
                        $memostatus='Invoice ';
                    }
                    else if($memo_detail_status=='3')
                    {
                        $memostatus='Available';
                        $productreturn[] = $avlPro->id;
                    }
                    else if($memo_detail_status=='4')
                    {
                        $memostatus='Trade ';
                    }
                    else if($memo_detail_status=='5')
                    {
                        $memostatus='Available';
                      $productvoid[] = $avlPro->id;
                    }
                    else if($memo_detail_status=='6')
                    {
                        $memostatus='TradeNGD ';
                    }
                     elseif($avlPro->qty >=1)
                    {
                        $memostatus="Available";
                         $product_qty[] = $avlPro->id;
                    }
                }
                $allProducts_id=array_merge($product_qty,$productvoid,$productreturn,$product_idsMemo);
                $product_idsA=$product_idsMemo;
                $product_idsb=array_merge($product_qty,$productvoid,$productreturn);
                if($listing_type == '')
                {
                   $warehouse= Product::with('reviews', 'stocks','category','productType')
                        ->groupBy('product_types.product_type_name')
                        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                        ->select('product_types.listing_type','product_types.product_type_name',DB::raw('SUM(products.product_cost) as totalPrice'),'product_types.id as pro_ty_id',DB::raw('COUNT(product_types.listing_type) as total_count'))
                        ->whereIn('products.id',$allProducts_id);
                }
                else
                {
                    $warehouse= Product::with('reviews', 'stocks','category','productType')
                        ->groupBy('product_types.product_type_name')
                        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                        ->select('product_types.listing_type','product_types.product_type_name',DB::raw('SUM(products.product_cost) as totalPrice'),'product_types.id as pro_ty_id',DB::raw('COUNT(product_types.listing_type) as total_count'))
                        ->where('listing_type',$listing_type)
                        ->whereIn('products.id',$allProducts_id);
                }
                   if($warehouse_id !='')
                        {
                            $warehouse=$warehouse->where('products.warehouse_id',$warehouse_id);
                        }
                        if($stock != "")
                        {
                            if($stock==2)
                            {
                            $warehouse=$warehouse->whereIn('products.id',$product_idsb);
                            }
                            elseif($stock==3)
                            {
                                $warehouse=$warehouse->whereIn('products.id',$product_idsA);
                            }
                        }
                        $warehousenet="";
                        if($warehouse_values !="")
                        {
                            if($warehouse_values==2)
                            {
                                if($listing_type =="")
                                {
                                    $warehousenetQy= Product::with('reviews', 'stocks','category','productType')
                                                    ->groupBy('product_types.product_type_name')
                                                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                                                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                                    ->select('product_types.product_type_name as net_listing_type','product_types.listing_type',DB::raw('SUM(products.product_cost)/2  as net_totalPrice'),'product_types.id as net_pro_ty_id',DB::raw('COUNT(product_types.listing_type) as net_total_count'))
                                                    ->whereIn('products.id',$allProducts_id)
                                                    ->where('products.partner','!=','GCI');
                                 if($stock != "")
                                {
                                    if($stock==2)
                                    {
                                        $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsb);
                                    }
                                    elseif($stock==3)
                                    {
                                        $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsA);
                                    }
                                    
                                }
                                 if($warehouse_id !='')
                                    {
                                        $warehousenetQy=$warehousenetQy->where('products.warehouse_id',$warehouse_id);
                                    }
                                      $warehousenet= $warehousenetQy->get();
                                      $warehouseaddnet=$warehouse->where('products.partner','GCI')->get();
                                      // dd($warehouseaddnet);
                                      $netvalueTPrice = array();
                                      $netvalueTCount = array();
        
                                      foreach ($warehousenet as $netval) {
                                        $netvalueTPrice[$netval->net_listing_type][] = $netval->net_totalPrice;
                                        $netvalueTCount[$netval->net_listing_type][] = $netval->net_total_count;
                                      }
                                      foreach ($warehouseaddnet as $netvalue) {
                                          $netvalueTPrice[$netvalue->listing_type][] = $netvalue->totalPrice;
                                          $netvalueTCount[$netvalue->listing_type][] = $netvalue->total_count;
                                      }
        
                                      foreach ($netvalueTPrice as $nvkey => $nvValue) {
                                        $TNetSum[$nvkey] = array_sum($nvValue);
                                      }
        
                                      foreach ($netvalueTCount as $nvkey => $nvValue) {
                                        $TNetCount[$nvkey] = array_sum($nvValue);
                                      }
                                      $mergedNetAmount = array_merge_recursive($TNetSum,$TNetCount);
                                      $warehouse=$warehouse->where('products.partner','GCI');
                                }
                                else
                                {
                                    $warehousenetQy= Product::with('reviews', 'stocks','category','productType')
                                                    ->groupBy('product_types.product_type_name')
                                                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                                                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                                    ->select('product_types.product_type_name as net_listing_type','product_types.listing_type',DB::raw('SUM(products.product_cost)/2  as net_totalPrice'),'product_types.id as net_pro_ty_id',DB::raw('COUNT(product_types.listing_type) as net_total_count'))
                                                    ->whereIn('products.id',$allProducts_id)
                                                    ->where('listing_type',$listing_type)
                                                    ->where('products.partner','!=','GCI');
                                if($stock != "")
                                {
                                    if($stock==2)
                                    {
                                        $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsb);
                                    }
                                    elseif($stock==3)
                                    {
                                        $warehousenetQy=$warehousenetQy->whereIn('products.id',$product_idsA);
                                    }
                                    
                                }
                                 if($warehouse_id !='')
                                    {
                                        $warehousenetQy=$warehousenetQy->where('products.warehouse_id',$warehouse_id);
                                    }
                                      $warehousenet= $warehousenetQy->get();
                                                    // dd($warehousenet);
                                      $warehouseaddnet=$warehouse->where('products.partner','GCI')->get();
                                      // dd($warehouseaddnet);
                                      $netvalueTPrice = array();
                                      $netvalueTCount = array();
        
                                      foreach ($warehousenet as $netval) {
                                        $netvalueTPrice[$netval->net_listing_type][] = $netval->net_totalPrice;
                                        $netvalueTCount[$netval->net_listing_type][] = $netval->net_total_count;
                                      }
                                      foreach ($warehouseaddnet as $netvalue) {
                                          $netvalueTPrice[$netvalue->listing_type][] = $netvalue->totalPrice;
                                          $netvalueTCount[$netvalue->listing_type][] = $netvalue->total_count;
                                      }
        
                                      foreach ($netvalueTPrice as $nvkey => $nvValue) {
                                        $TNetSum[$nvkey] = array_sum($nvValue);
                                      }
        
                                      foreach ($netvalueTCount as $nvkey => $nvValue) {
                                        $TNetCount[$nvkey] = array_sum($nvValue);
                                      }
                                      $mergedNetAmount = array_merge_recursive($TNetSum,$TNetCount);
                                      $warehouse=$warehouse->where('products.partner','GCI');
                                }


                            }
                        }
                        $all_warehouse=$warehouse->get();
                        $totalcount=0;
                        $totalamount=0;
                        $totalamountnet=0;
                        $totalcountnet=0;
                        if($warehouse_values=="2")
                        {
                            foreach($mergedNetAmount as $mrkey => $mrwarehouse)
                            {
                                $lskeynet = $mrkey;
                                $totalcountnet = $totalcountnet += $mrwarehouse[1];
                                $totalamountnet = $totalamountnet += $mrwarehouse[0];
                                $AppendWareHSTr[]='<tr class="catgers_table">
                                                        <td class="cat_name">'.$mrkey.'</td>
                                                        <td class="cat_velu">'.$mrwarehouse[1].'</td>
                                                        <td class="cat_pric">'. money_format("%(#1n", $mrwarehouse[0])."\n".' <br>
                                                        </td>
                                                    </tr>';
                            }
                            $AppendWareFtr='<tr class="catgers_table">
                                            <td class="cat_name"> Total</td>
                                            <td class="cat_velu">'.$totalcountnet.'</td>
                                            <td class="cat_pric">' .money_format("%(#1n", $totalamountnet)."\n".'</td>
                                        </tr>';
                        }
                        else
                        {
                            foreach($all_warehouse as $key=>$warehouse)
                            {
                                $listingtype=$warehouse->product_type_name;
                                $totalcount= $totalcount+=$warehouse->total_count;
                                $totalamount=$totalamount+=$warehouse->totalPrice;
                                $AppendWareHSTr[]='<tr class="catgers_table">
                                                        <td class="cat_name">'.$listingtype.'</td>
                                                        <td class="cat_velu">'.$warehouse->total_count.'</td>
                                                        <td class="cat_pric">'. money_format("%(#1n", $warehouse->totalPrice)."\n".' <br>
                                                        </td>
                                                    </tr>';
                            }
                              $AppendWareFtr='<tr class="catgers_table">
                                            <td class="cat_name"> Total</td>
                                            <td class="cat_velu">'.$totalcount.'</td>
                                            <td class="cat_pric">' .money_format("%(#1n", $totalamount)."\n".'</td>
                                        </tr>';
                        }
                        

          return response()->json(['success' => true,'listingTypeData'=>$AppendWareHSTr,'listingFooter'=>$AppendWareFtr]);
    }
}
