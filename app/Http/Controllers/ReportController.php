<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Product;
use App\CommissionHistory;
use App\ReturnItems;
use App\Wallet;
use Illuminate\Support\Facades\DB;
use App\Seller;
use App\MailWatchExcel;
use App\Memo;
use App\User;
use App\MemoDetail;
use App\Search;
use App\CustomerReportExcel;
use Auth;
use App\SupplierExcel;
use App\SupplierDetailsExcel;
use App\ProductReportExcel;
use App\SellerSaleReportExcel;
use App\AverageReportExcel;
use App\ShortStockExcel;
use Excel;
class ReportController extends Controller

{

  public function stock_report(Request $request)
  {
        $arry=array(1,0);
        $available_Product = Product::with('reviews', 'stocks','productType')
                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                    ->groupBy('products.id')
                    ->select('products.*','warehouse.name as warehouse_name','memo_details.product_id','memo_details.item_status','product_types.listing_type','product_types.product_type_name','product_stocks.sku','product_stocks.qty','memo_details.memo_id as memosdetailId','memos.memo_number')
                    ->leftJoin('memo_details','memo_details.product_id','=','products.id')
                    ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
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
                // dd($product_idsb);
                $warehouse= Product::with('reviews', 'stocks','category','productType')
                        ->groupBy('product_types.listing_type')
                        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                        ->select('product_types.listing_type',DB::raw('SUM(products.product_cost) as totalPrice'),'product_types.id as pro_ty_id',DB::raw('COUNT(product_types.listing_type) as total_count'))
                        ->orderBy('product_types.listing_type','ASC')
                        ->whereIn('products.id',$allProducts_id);
                        
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
                              $warehousenetQy= Product::with('reviews', 'stocks','category','productType')
                                                    ->groupBy('product_types.listing_type')
                                                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                                                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                                    ->select('product_types.listing_type as net_listing_type',DB::raw('SUM(products.product_cost)/2  as net_totalPrice'),'product_types.id as net_pro_ty_id',DB::raw('COUNT(product_types.listing_type) as net_total_count'))
                                                    ->whereIn('products.id',$allProducts_id)
                                                    ->orderBy('product_types.listing_type','ASC')
                                                    ->where('products.partner','!=','GCI');
                                                    // dd($warehousenetQy->get());
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
        return view('backend.reports.warehouse_stock_report', compact('all_warehouse','mergedNetAmount','value'));
  }




    public function warehouse_report(Request $request)

    {

        $sort_by =null;

        $products = Product::orderBy('created_at', 'desc');

        if ($request->has('category_id')){

            $sort_by = $request->category_id;

            $products = $products->where('category_id', $sort_by);

        }

        $products = $products->paginate(15);

        return view('backend.reports.stock_report', compact('products','sort_by'));

    }

    public function in_house_sale_report(Request $request)

    {
        $sort_by =null;

       //  $products = Product::orderBy('num_of_sale', 'desc')->where('added_by', 'admin');
          
      $products=Memo::select('products.name',DB::raw('SUM(memo_details.product_qty) as totalQty'))
        ->join('memo_details', 'memo_details.memo_id', '=', 'memos.id')
        ->join('products', 'products.id', '=', 'memo_details.product_id')
        ->where('added_by', 'admin')
        ->orderBy('totalQty','DESC')
        ->groupBy('products.name');       
        
        if ($request->has('category_id')){

            $sort_by = $request->category_id;

            $products = $products->where('category_id', $sort_by);
        
        
        }
   // dd($products);
        $products = $products->paginate(15);

        return view('backend.reports.in_house_sale_report', compact('products','sort_by'));

    }



    public function seller_sale_report(Request $request)
   {

        $sort_by =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
    //   if($pagination_qty < 1){
    //       $pagination_qty = 25;
    //   }
       $arrSt = array(0,1,2,4,6);
        $closeQry =  Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('site_options','site_options.option_value','=','products.model')
        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('memos.*', 'retail_resellers.company','retail_resellers.customer_name as rcustomername','memo_payments.payment_name','retail_resellers.customer_group','product_stocks.sku','memo_details.item_status','product_types.listing_type')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->selectRaw('GROUP_CONCAT(stock_id) as stocks')
        ->selectRaw('GROUP_CONCAT(sku) as skus')
        ->selectRaw('GROUP_CONCAT(model) as model_numbers')
        ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->whereIn('memo_details.item_status',$arrSt)
        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment');
        
  //  dd($closeQry);
    

        $sort_search = isset($request->search) ? $request->search : '';
        $proSearchType =$request->listing_type;
        if($proSearchType != null)
        {
            $closeQry = $closeQry->where('product_types.listing_type', 'LIKE', '%'.$proSearchType.'%');
        }


        $startrangedate=$request->startrangedate;
        $endrangedate=$request->endrangedate;
        $startdate=  date('20y-m-d', strtotime($startrangedate));
        $endate=  date('20y-m-d', strtotime($endrangedate));
        // dd($startdate.' 00:00:00');
        if ($request->startrangedate || $request->endrangedate) {
            $closeQry = $closeQry->whereBetween('memos.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }

        $modelnumber =$request->model_number;
        if($modelnumber != null)
        {
            $closeQry = $closeQry->where('model', 'LIKE', '%'.$modelnumber.'%');
        }
        $customername =$request->customer_name;
        if($customername != null)
        {
            $closeQry = $closeQry->where('retail_resellers.id', 'LIKE', '%'.$customername.'%');
        }
        $memostatus =$request->memo_status;
        if($memostatus != null)
        {
            $closeQry = $closeQry->where('memo_details.item_status', 'LIKE', '%'.$memostatus.'%');
        }
        
        // $memo=1;
        if($sort_search != null){
              $closeQry = $closeQry->where(function($query) use ($sort_search){
                $query->where('memo_number', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('retail_resellers.company', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('retail_resellers.customer_name', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('listing_type', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('memos.reference', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('products.stock_id', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('product_stocks.sku', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('products.model', 'LIKE', '%'.$sort_search.'%');
            });
        }

        
        if( $request->pagination_qty == "all"){
            $closememoData = $closeQry->get();
          }else{
            $closememoData = $closeQry->paginate($pagination_qty);
          }
        
            $total=0;
        return view('backend.reports.seller_sale_report', compact('closememoData','pagination_qty', 'sort_search','startrangedate','endrangedate'));

    }

    public function wish_report(Request $request)

    {

        $sort_by =null;

        $products = Product::orderBy('created_at', 'desc');

        if ($request->has('category_id')){

            $sort_by = $request->category_id;

            $products = $products->where('category_id', $sort_by);

        }

        $products = $products->paginate(10);

        return view('backend.reports.wish_report', compact('products','sort_by'));

    }



    public function user_search_report(Request $request){

        $searches = Search::orderBy('count', 'desc')->paginate(10);

        return view('backend.reports.user_search_report', compact('searches'));

    }



    public function commission_history(Request $request) {

        $seller_id = null;

        $date_range = null;



        if(Auth::user()->user_type == 'seller') {

            $seller_id = Auth::user()->id;

        } if($request->seller_id) {

            $seller_id = $request->seller_id;

        }



        $commission_history = CommissionHistory::orderBy('created_at', 'desc');



        if ($request->date_range) {

            $date_range = $request->date_range;

            $date_range1 = explode(" / ", $request->date_range);

            $commission_history = $commission_history->where('created_at', '>=', $date_range1[0]);

            $commission_history = $commission_history->where('created_at', '<=', $date_range1[1]);

        }

        if ($seller_id){



            $commission_history = $commission_history->where('seller_id', '=', $seller_id);

        }



        $commission_history = $commission_history->paginate(10);

        if(Auth::user()->user_type == 'seller') {

            return view('frontend.user.seller.reports.commission_history_report', compact('commission_history', 'seller_id', 'date_range'));

        }

        return view('backend.reports.commission_history_report', compact('commission_history', 'seller_id', 'date_range'));

    }



    public function wallet_transaction_history(Request $request) {

        $user_id = null;

        $date_range = null;



        if($request->user_id) {

            $user_id = $request->user_id;

        }



        $users_with_wallet = User::whereIn('id', function($query) {

            $query->select('user_id')->from(with(new Wallet)->getTable());

        })->get();



        $wallet_history = Wallet::orderBy('created_at', 'desc');



        if ($request->date_range) {

            $date_range = $request->date_range;

            $date_range1 = explode(" / ", $request->date_range);

            $wallet_history = $wallet_history->where('created_at', '>=', $date_range1[0]);

            $wallet_history = $wallet_history->where('created_at', '<=', $date_range1[1]);

        }

        if ($user_id){

            $wallet_history = $wallet_history->where('user_id', '=', $user_id);

        }



        $wallets = $wallet_history->paginate(10);



        return view('backend.reports.wallet_history_report', compact('wallets', 'users_with_wallet', 'user_id', 'date_range'));

    }




    public function product_repot(Request $request)

    {

        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $PurchasesProduct=Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        // ->leftJoin('site_options','site_options.option_value','=','products.model')
        // ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('products.*','warehouse.name as warehouseName','categories.name as categories_name','users.name as supplienName','memo_details.product_id','memo_details.item_status','product_types.listing_type','brands.name as brandName','product_stocks.sku','product_stocks.qty','memos.customer_name as customer_name_id','retail_resellers.customer_group','retail_resellers.company','retail_resellers.customer_name','product_types.product_type_name')
          ->leftJoin('memo_details','memo_details.product_id','=','products.id')
          ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
          ->leftJoin('retail_resellers','retail_resellers.id' , '=' , 'memos.customer_name');
          $warehouseSrch =$request->warehouse_id;
          $partner=$request->partner;
          $listing_type=$request->producttypee;
          if ($request->search != null){
            $PurchasesProduct->orWhere('listing_type', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('products.stock_id', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('users.name', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('brands.name', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('retail_resellers.customer_name', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('retail_resellers.company', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('categories.name', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('product_types.listing_type', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('product_types.product_type_name', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('products.model', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('products.partner', 'like', '%'.$request->search.'%');
            $PurchasesProduct->orWhere('warehouse.name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

          if($partner>0)
          {
             $PurchasesData=$PurchasesProduct->where('products.id',$partner);
          }
          $category=$request->category;
          if($category>0)
          {
             $category=$PurchasesProduct->where('categories.id',$category);
          }
          $listing_type=$request->listing_type;
          if($listing_type != "")
          {
             $PurchasesData=$PurchasesProduct->where('listing_type',$listing_type);
          }
          $model_number=$request->model_number;
          if($model_number != "")
          {
             $PurchasesData=$PurchasesProduct->where('model',$model_number);
          }
          $brand=$request->brand;
          if($brand != "")
          {
             $PurchasesData=$PurchasesProduct->where('brands.id',$brand);
          }
          $partner=$request->partner;
          if($partner != "")
          {
             $PurchasesData=$PurchasesProduct->where('products.partner',$partner);
          }
          $warehouseSrch=$request->warehouse_id;
          if($warehouseSrch > 0)
          {
           $PurchasesData = $PurchasesProduct->where('warehouse.id', $warehouseSrch);
          }
          $memostatus =$request->memo_status;
        //   echo $memostatus; exit;
          if($memostatus != null)
          {
              $PurchasesData = $PurchasesProduct->where('memo_details.item_status' , '=', $memostatus);
            //   $PurchasesData = $PurchasesProduct->where('product_stocks.qty','>=',1)->where('published', '=', '1');
          }
          if($memostatus=="available")
          {
              $PurchasesData = $PurchasesProduct->where('product_stocks.qty','>=',1)->orWhere('published', '=', '1');
          }
        //   if($memostatus=="available")
        //   {
        //       $PurchasesData = $PurchasesProduct->where('published', '=', '1');
        //   }

        if( $request->pagination_qty == "all"){
            $PurchasesData = $PurchasesProduct->get();
          }else{
            $PurchasesData = $PurchasesProduct->paginate($pagination_qty);
          }
//   dd($PurchasesData);
        return view('backend.reports.product_report', compact('PurchasesData','pagination_qty','sort_search'));

    }
    public function profit_loss(Request $request)
    {
         $arrSt = array(2,4,6);
        $sale_price = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('site_options','site_options.option_value','=','products.model')
        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('memos.*', 'retail_resellers.company','retail_resellers.customer_name as rcustomername','memo_payments.payment_name','retail_resellers.customer_group','product_stocks.sku','memo_details.item_status','product_types.listing_type','products.product_cost')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->selectRaw('GROUP_CONCAT(stock_id) as stocks')
        ->selectRaw('GROUP_CONCAT(sku) as skus')
        ->selectRaw('GROUP_CONCAT(model) as model_numbers')
        ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->whereIn('memo_details.item_status',$arrSt)
        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment');
        $listing_type=$request->listing_type;
        if($listing_type != null)
        {
            $sale_price=$sale_price->where('product_types.listing_type',$listing_type);
        }
          $startrangedate=$request->startrangedate;
            $endrangedate=$request->endrangedate;
            $startdate=  date('20y-m-d', strtotime($startrangedate));
            $endate=  date('20y-m-d', strtotime($endrangedate));
        //     echo $startdate . " --" . $endate ; exit
        if ($request->startrangedate != NULL || $request->endrangedate != NULL) {
            $sale_price = $sale_price->whereBetween('memo_details.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }
        $sales=$sale_price->get();
        $total_sl=0;
        $total_sl_pro=0;
        foreach($sales as $row)
        {
            $total_sl+=$row->sub_total;
            $total_sl_pro+=$row->product_cost;
        }
        $avrg_sale_cost=($total_sl)-($total_sl_pro);
        // dd($total_sl);

         $invoice_price =Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('site_options','site_options.option_value','=','products.model')
        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('memos.*', 'retail_resellers.company','retail_resellers.customer_name as rcustomername','memo_payments.payment_name','retail_resellers.customer_group','product_stocks.sku','memo_details.item_status','product_types.listing_type','products.product_cost')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->selectRaw('GROUP_CONCAT(stock_id) as stocks')
        ->selectRaw('GROUP_CONCAT(sku) as skus')
        ->selectRaw('GROUP_CONCAT(model) as model_numbers')
        ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->where('memo_details.item_status',2)
        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment');




           if($listing_type != null)
        {
            $invoice_price=$invoice_price->where('product_types.listing_type',$listing_type);
        }
          $startrangedate=$request->startrangedate;
            $endrangedate=$request->endrangedate;
            $startdate=  date('20y-m-d', strtotime($startrangedate));
            $endate=  date('20y-m-d', strtotime($endrangedate));
        //     echo $startdate . " --" . $endate ; exit
        if ($request->startrangedate != NULL || $request->endrangedate != NULL) {
            $invoice_price = $invoice_price->whereBetween('memo_details.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }

        $invoice=$invoice_price->get();
        $total_in=0;
        $total_in_pro=0;
        foreach($invoice as $row)
        {
            $total_in+=$row->sub_total;
            $total_in_pro+=$row->product_cost;
            // echo "==========>".$row->product_cost."==========>".$total_in_pro;echo "<br/>";
        }
        // echo $total_in;echo "<br/>";
        // echo $total_in_pro;echo "<br/>";
        $avrg_invoice_cost=$total_in-$total_in_pro;
        // exit;



        $trade_price =  Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('site_options','site_options.option_value','=','products.model')
        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('memos.*', 'retail_resellers.company','retail_resellers.customer_name as rcustomername','memo_payments.payment_name','retail_resellers.customer_group','product_stocks.sku','memo_details.item_status','product_types.listing_type','products.product_cost')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->selectRaw('GROUP_CONCAT(stock_id) as stocks')
        ->selectRaw('GROUP_CONCAT(sku) as skus')
        ->selectRaw('GROUP_CONCAT(model) as model_numbers')
        ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->where('memo_details.item_status',4)
        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment');
        if($listing_type != null)
        {
            $trade_price=$trade_price->where('product_types.listing_type',$listing_type);
        }
          $startrangedate=$request->startrangedate;
            $endrangedate=$request->endrangedate;
            $startdate=  date('20y-m-d', strtotime($startrangedate));
            $endate=  date('20y-m-d', strtotime($endrangedate));
        //     echo $startdate . " --" . $endate ; exit
        if ($request->startrangedate != NULL || $request->endrangedate != NULL) {
            $trade_price = $trade_price->whereBetween('memo_details.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }
        $trade=$trade_price->get();
        $total_trd=0;
        $total_trd_pro=0;
        foreach($trade as $row)
        {
            $total_trd+=$row->sub_total;
            $total_trd_pro+=$row->product_cost;
        }
        $avrg_trd_cost=$total_trd-$total_trd_pro;


        $tradeNGD_price =
        Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->leftJoin('users','users.id','=','products.supplier_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->leftJoin('brands','brands.id','=','products.brand_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('site_options','site_options.option_value','=','products.model')
        ->leftJoin('productconditions','productconditions.id','=','products.productcondition_id')
        ->leftJoin('categories','categories.id','=','products.category_id')
        ->orderBy('products.id', 'DESC')
        ->groupBy('products.id')
        ->select('memos.*', 'retail_resellers.company','retail_resellers.customer_name as rcustomername','memo_payments.payment_name','retail_resellers.customer_group','product_stocks.sku','memo_details.item_status','product_types.listing_type','products.product_cost')
        ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
        ->selectRaw('GROUP_CONCAT(stock_id) as stocks')
        ->selectRaw('GROUP_CONCAT(sku) as skus')
        ->selectRaw('GROUP_CONCAT(model) as model_numbers')
        ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->where('memo_details.item_status',6)
        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment');
      
        if($listing_type != null)
        {
            $tradeNGD_price=$tradeNGD_price->where('product_types.listing_type',$listing_type);
        }
          $startrangedate=$request->startrangedate;
            $endrangedate=$request->endrangedate;
            $startdate=  date('20y-m-d', strtotime($startrangedate));
            $endate=  date('20y-m-d', strtotime($endrangedate));
        //     echo $startdate . " --" . $endate ; exit
        if ($request->startrangedate != NULL || $request->endrangedate != NULL) {
            $tradeNGD_price = $tradeNGD_price->whereBetween('memo_details.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }
        $tradeNGD=$tradeNGD_price->get();
        $total_trdNGD=0;
        $total_trdNGD_pro=0;
        foreach($tradeNGD as $row)
        {
            $total_trdNGD+=$row->sub_total;
            $total_trdNGD_pro+=$row->product_cost;
        }
        $avrg_trdNGD_cost=$total_trdNGD-$total_trdNGD_pro;



        // dd($total_sl);
        return view('backend.reports.profit_loss_report', compact('sales','startrangedate','endrangedate','total_sl','avrg_sale_cost','avrg_invoice_cost','total_in','invoice','avrg_trd_cost','total_trd','trade','avrg_trdNGD_cost','total_trdNGD','tradeNGD'));
    }
    public function customer(Request $request)
    {

        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $customer= Memo::select('memos.*',DB::raw('SUM(memos.sub_total) as memoSubTotal'),'memo_details.item_status','retail_resellers.id as company_id','retail_resellers.phone','retail_resellers.email','retail_resellers.company as c_name','retail_resellers.customer_group','retail_resellers.customer_name as cus_name')
        ->join('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->join('memo_details', 'memos.id', '=', 'memo_details.memo_id')
        // ->leftJoin('products','products.id','memo_details.product_id')
        // ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->groupBy('retail_resellers.company');
        

        $customer_name=$request->customer_name;
        if($customer_name > 0)
        {
         $customer = $customer->where('retail_resellers.id', $customer_name);
        }
        $summary_pagi='';
        if ($request->search != null){
            $customer->orWhere('retail_resellers.company', 'like', '%'.$request->search.'%');
            $customer->orWhere('retail_resellers.customer_name', 'like', '%'.$request->search.'%');
            $customer->orWhere('retail_resellers.email', 'like', '%'.$request->search.'%');
            $customer->orWhere('retail_resellers.phone', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if( $request->pagination_qty == "all"){
            $customer_report = $customer->get();
          }else{
            $customer_report = $customer->paginate($pagination_qty);
          }
        //   dd($customer_report);
        // echo "error";die;
        return view('backend.reports.customer_report_report', compact('pagination_qty','sort_search','customer_report'));

    }
    public function customer_report(Request $request, $id)
    {
        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $memo = Memo::select('memos.id','memos.memo_number','memos.sub_total','memos.due_date','memos.date','memos.tracking','memo_details.item_status','retail_resellers.company','retail_resellers.customer_name','products.stock_id','product_stocks.sku','products.model','job_orders.job_order_number','memo_payments.payment_name','memos.reference')
        ->leftjoin('memo_details', 'memos.id', '=', 'memo_details.memo_id')
        ->leftJoin('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')

        ->leftJoin('memo_payments', 'memo_payments.id', '=', 'memos.payment')
        ->leftJoin('products','products.id','memo_details.product_id')
        ->leftJoin('job_orders','job_orders.company_name','retail_resellers.id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')

        ->where('memos.customer_name',$id);
        if ($request->search != null){
            $memo->orWhere('retail_resellers.company', 'like', '%'.$request->search.'%');
            $memo->orWhere('retail_resellers.customer_name', 'like', '%'.$request->search.'%');
            $memo->orWhere('memo_number', 'like', '%'.$request->search.'%');
            $memo->orWhere('stock_id', 'like', '%'.$request->search.'%');
            $memo->orWhere('model', 'like', '%'.$request->search.'%');
            $memo->orWhere('sku', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
        if( $request->pagination_qty == "all"){
            $memoDashData = $memo->get();
          }else{
            $memoDashData = $memo->paginate($pagination_qty);
          }
        $calculat_amount= Memo::select('memos.*',DB::raw('SUM(memos.sub_total) as memoSubTotal'),'memos.customer_name as memo_customer_name'  ,'retail_resellers.company','retail_resellers.customer_name','memo_details.item_status','retail_resellers.id as company_id','retail_resellers.phone','retail_resellers.email')
        ->join('retail_resellers', 'memos.customer_name', '=', 'retail_resellers.id')
        ->join('memo_details', 'memos.id', '=', 'memo_details.memo_id')
        ->groupBy('memo_details.item_status')->where('memos.customer_name',$id)->get();

        // dd($calculat_amount);

        return view('backend.reports.customer_reports_details', compact('pagination_qty','sort_search','memoDashData','calculat_amount'));

    }
    public function short_stock(Request $request)
    {
        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $arrSt = array(0,1);
        $arrStatus = array(0,1,2,4,6);
        $shortstock = MemoDetail::select('memo_details.id','products.model','memo_details.product_qty',DB::raw('sum(product_stocks.qty) as stockqtysum'),'memo_details.item_status',DB::raw('sum(memo_details.product_qty) as  memoqtysum'),'products.created_at')
                  ->leftJoin('products','products.id','=','memo_details.product_id')
                  ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                  ->groupBy('products.model')
                  ->whereIn('memo_details.item_status',$arrStatus);
                        $search= $request->search;
                  if ($search != null){
                    $shortstock->where('products.model', 'like', '%'.$search.'%');
                    $sort_search = $request->search;
                }
            $startrangedate=$request->startrangedate;
            $endrangedate=$request->endrangedate;
            $startdate=  date('20y-m-d', strtotime($startrangedate));
            $endate=  date('20y-m-d', strtotime($endrangedate));
        //     echo $startdate . " --" . $endate ; exit
        if ($request->startrangedate != NULL || $request->endrangedate != NULL) {
            $shortstock = $shortstock->whereBetween('memo_details.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
        }
        if( $request->pagination_qty == "all"){
            $short_stock_data = $shortstock->get();
          }else{
            $short_stock_data = $shortstock->paginate($pagination_qty);
          }
        //   dd($short_stock_data);
        return view('backend.reports.short_stock', compact('pagination_qty','startrangedate','endrangedate','sort_search','short_stock_data'));

    }
    public function suppliers_report(Request $request)
    {
        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $supplierQry= Seller::select('users.name','users.email','sellers.phone','sellers.company',DB::raw('sum(products.unit_price) as  unit_price'),DB::raw('count(product_stocks.qty) as  qty'),'products.supplier_id','sellers.id')
                    ->leftJoin('users','users.id','=','sellers.user_id')
                    ->leftJoin('products','products.supplier_id','users.id')
                    ->leftJoin('product_stocks','product_stocks.product_id','=','products.id')
                    ->groupBy('sellers.company')
                    ->orderBy('sellers.id','DESC');
                    if ($request->search != null){
                        $supplierQry->orWhere('sellers.company', 'like', '%'.$request->search.'%');
                        $supplierQry->orWhere('users.name', 'like', '%'.$request->search.'%');
                        $supplierQry->orWhere('users.email', 'like', '%'.$request->search.'%');
                        $sort_search = $request->search;
                    }
                    $supplier=$request->supplier;
                    if($supplier != "")
                    {
                       $supplierQry=$supplierQry->where('sellers.company',$supplier);
                    }
                    if( $request->pagination_qty == "all"){
                        $supplier = $supplierQry->get();
                      }else{
                        $supplier = $supplierQry->paginate($pagination_qty);
                      }
                    // dd($supplier);
        return view('backend.reports.suppliers_report', compact('pagination_qty','sort_search','supplier'));
    }
    public function supplier_details_report(Request $request, $id)
    {
        $sort_search =null;
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $supplier_detailsQry= Seller::select('sellers.*','products.stock_id','products.unit_price','products.published','memo_details.item_status','products.model','warehouse.name as warehouse_name','users.name as supplier_name','product_stocks.sku','product_stocks.qty','products.vendor_doc_number')
        ->leftJoin('users','users.id','=','sellers.user_id')
        ->leftJoin('products','products.supplier_id','users.id')
        ->leftJoin('product_stocks','product_stocks.product_id','=','products.id')
        ->leftJoin('memo_details','memo_details.product_id','=','products.id')
        ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
        ->orderBy('sellers.id','DESC')
        ->where('sellers.id',$id);
        if ($request->search != null){
            $supplier_detailsQry->orWhere('products.stock_id', 'like', '%'.$request->search.'%');
            $supplier_detailsQry->orWhere('products.model', 'like', '%'.$request->search.'%');
            $supplier_detailsQry->orWhere('warehouse.name', 'like', '%'.$request->search.'%');
            $supplier_detailsQry->orWhere('users.name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }
      $totalPurchases= $supplier_detailsQry->sum('products.unit_price');
      $count=$supplier_detailsQry->count();
        if( $request->pagination_qty == "all"){
            $supplier_details = $supplier_detailsQry->get();
          }else{
            $supplier_details = $supplier_detailsQry->paginate($pagination_qty);
          }
        // dd($supplier_details);
        return view('backend.reports.supplier_details_report', compact('pagination_qty','sort_search','supplier_details','totalPurchases','count'));
    }
    public function best_sellers_report(Request $request)
    {
        $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
        $best_seller=Memo::select('memo_details.item_status','products.model',DB::raw('SUM(memos.sub_total) as memoSubTotal'),DB::raw('SUM(memo_details.product_qty) as totalQty'),'product_types.listing_type')
        ->join('memo_details', 'memo_details.memo_id', '=', 'memos.id')
        ->join('products', 'products.id', '=', 'memo_details.product_id')
        ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
        ->leftJoin('product_types','product_types.id','=','products.product_type_id')
        ->where('memo_details.item_status','=','2')
        ->orderBy('totalQty','DESC')
        ->groupBy('products.model');
        $sort_search = isset($request->search) ? $request->search : '';
        if($sort_search != null){
              $best_seller = $best_seller->where(function($query) use ($sort_search){
                $query->where('products.model', 'LIKE', '%'.$sort_search.'%')
                ->orWhere('memo_details.product_qty', 'LIKE', '%'.$sort_search.'%');
            });
        }
        $startrangedate=$request->startrangedate;
        // dd($startrangedate);
        $endrangedate=$request->endrangedate;
        $startdate=  date('20y-m-d', strtotime($startrangedate));
        $endate=  date('20y-m-d', strtotime($endrangedate));
        // dd($startdate.' 00:00:00');
      if ($request->startrangedate || $request->endrangedate) {
          $best_seller = $best_seller->whereBetween('memos.created_at', [$startdate.' 00:00:00',$endate.' 23:59:59']);
      }


        $proSearchType =$request->listing_type;
        if($proSearchType != null)
        {
            $best_seller = $best_seller->where('product_types.listing_type', 'LIKE', '%'.$proSearchType.'%');
        }
        // echo $request->pagination_qty; exit;
        if( $request->pagination_qty == "all"){
            $best_seller_report = $best_seller->get();
          }
      else{
            $best_seller_report = $best_seller->paginate($pagination_qty);
          }
        return view('backend.reports.best_sellers_report', compact('pagination_qty','sort_search','best_seller_report','startrangedate','endrangedate'));
    }
    
    public function average_report_excel(Request $request)
    {
        $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new AverageReportExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'AverageReportExcel'.$curntDate.'.xlsx');
    }
    public function seller_sale_report_excel(Request $request)
    {
        // $fetchLiaat = new SellerSaleReportExcel();
        // return Excel::download($fetchLiaat, 'seller_sale_report_excel.xlsx');
        
        $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new SellerSaleReportExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'SellerSaleReportExcel'.$curntDate.'.xlsx');
    }
    public function product_report_excel(Request $request)
    {
        // $fetchLiaat = new ProductReportExcel();
        // return Excel::download($fetchLiaat, 'product_report_excel.xlsx');
        
         $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new ProductReportExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'ProductReportExcel'.$curntDate.'.xlsx');
    }
    public function customer_report_excel(Request $request)
    {
        // $fetchLiaat = new CustomerReportExcel();
        // return Excel::download($fetchLiaat, 'customer_report_excel.xlsx');
        
                  $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new CustomerReportExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'CustomerReportExcel'.$curntDate.'.xlsx');
    }
    public function short_stock_excel(Request $request)
    {
        // $fetchLiaat = new ShortStockExcel();
        // return Excel::download($fetchLiaat, 'short_stock_excel.xlsx');
        
         $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new ShortStockExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'ShortStockExcel'.$curntDate.'.xlsx');
    }
    public function supplier_excel(Request $request)
    {
        // $fetchLiaat = new SupplierExcel();
        // return Excel::download($fetchLiaat, 'supplier_excel.xlsx');
        
        $ids = $request->checked_id;
                //   dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new SupplierExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'SupplierExcel'.$curntDate.'.xlsx');
    }
    public function supplier_details_excel(Request $request)
    {
        $fetchLiaat = new SupplierDetailsExcel();
        return Excel::download($fetchLiaat, 'supplier_details_excel.xlsx');
    }
    
    public function best_seller_excel(Request $request)
    {
        $ids = $request->checked_id;
                  dd($ids);
                  $proID = json_decode($ids, TRUE);
                  $fetchLiaat = new BestSellerExcel($proID);
                  $dt = new \DateTime();
                  $curntDate = $dt->format('m-d-Y');
                  return Excel::download($fetchLiaat, 'BestSellerExcel'.$curntDate.'.xlsx');
    }

    public function warehouseDataAjax(Request $request)
    {
        setlocale(LC_MONETARY,"en_US");
        $listing_type = $request->listing_type;
        $warehouse_values = $request->warehouse_values;
        $warehouse_id = $request->warehouse_id;
        $stock = $request->stock;
        $AppendWareHSTr=array();
        $AppendWareFtr=array();
        $RecordArr = array();
         $arry=array(1,0);
        $available_Product = Product::with('reviews', 'stocks','productType')
                    ->leftJoin('warehouse','warehouse.id','=','products.warehouse_id')
                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                    ->orderBy('products.id', 'DESC')
                    ->groupBy('products.id')
                    ->select('products.*','warehouse.name as warehouse_name','product_types.product_type_name','memo_details.item_status','product_types.listing_type','product_types.product_type_name','product_stocks.qty')
                    ->leftJoin('memo_details','memo_details.product_id','=','products.id')
                    ->leftJoin('memos', 'memos.id', '=', 'memo_details.memo_id')
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
    public function average_cost_report(Request $request)
    {
         $pagination_qty = isset($request->pagination_qty)?$request->pagination_qty:25;
        if($request->input('pagination_qty')!=NULL){
            $pagination_qty =  $request->input('pagination_qty');
        }
            $average_cost=Product::with('reviews', 'stocks')
                                    ->leftJoin('memo_details', 'memo_details.product_id', '=', 'products.id')
                                    ->leftJoin('product_types','product_types.id','=','products.product_type_id')
                                    ->leftJoin('memos', 'memo_details.memo_id', '=', 'memos.id')
                                    ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                    ->select('products.*',DB::raw('SUM(product_stocks.qty) as totalQty'),DB::raw('SUM(products.product_cost) as totalcost'),DB::raw('SUM(memos.sub_total) as memo_sub_total'),DB::raw('SUM(memo_details.product_qty) as memo_qty_totl'))
                                    ->orderBy('products.id', 'DESC')
                                    ->groupBy('products.model');

        $sort_search = isset($request->search) ? $request->search : '';
        if($sort_search != null){
              $average_cost = $average_cost->where(function($query) use ($sort_search){
                $query->where('products.model', 'LIKE', '%'.$sort_search.'%');
            });
        }
        $startrangedate=$request->startrangedate;
        $endrangedate=$request->endrangedate;
        $startdate=  date('20y-m-d', strtotime($startrangedate));
        $endate=  date('20y-m-d', strtotime($endrangedate));
       if ($request->startrangedate || $request->endrangedate) {
          $average_cost = $average_cost->whereBetween('products.dop', [$startdate.' 00:00:00',$endate.' 23:59:59']);
       }
        $proSearchType =$request->listing_type;
        if($proSearchType != null)
        {
            $average_cost = $average_cost->where('product_types.listing_type', 'LIKE', '%'.$proSearchType.'%');
        }
        // echo $request->pagination_qty; exit;
        if( $request->pagination_qty == "all"){
            $average_cost_data = $average_cost->get();
          }
        else{
            $average_cost_data = $average_cost->paginate($pagination_qty);
          }
        //   dd($average_cost_data);
        return view('backend.reports.average_cost_report', compact('pagination_qty','sort_search','average_cost_data','startrangedate','endrangedate'));

    }


}
