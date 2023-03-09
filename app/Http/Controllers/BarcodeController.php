<?php

namespace App\Http\Controllers;
use App\Product;
use App\Models\Producttype;
use App\ProductTranslation;
use App\ProductStock;
use App\Models\Sequence;
use Illuminate\Support\Facades\DB;
use \InvPDF;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function barcode()
	{
	
    $proarr="";
    //  print_r($proarr);
	    return view('backend.product.products.barcode', compact('proarr'));
	}
   
    public function store(Request $request)

	{



      $proarrData = isset($request->proarrkey) ? $request->proarrkey: "";

      if($proarrData != ""){

        $peoStckkeys = array_keys($proarrData);

        $proarr = Product::whereIn('id',$peoStckkeys)->get();

      }else{

      $proarr = array();

      }

      $ispdfprint = isset($request->ispdfprint) ? $request->ispdfprint: "";

      if($ispdfprint == 1){

        $pdffilename = 'barcodeproduct_'.date('y_m_d').'.pdf';

        $pdf = \App::make('dompdf.wrapper');

        $pdf = InvPDF::loadView('backend.product.products.barcodepdf',compact('proarr'))->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf->stream($pdffilename);

        return view('backend.product.products.barcodepdf', compact('proarr'));

      }else{

        return view('backend.product.products.barcode', compact('proarr'));
     }
	}
	
    public function storeproid(Request $request,$id)
	{
        $proarr =array();
        $proarr[] = Product::findOrFail($id);
        // dd($proarr);
	    return view('backend.product.products.barcode', compact('proarr'));
	}
  public function BarcodeAjaxLabel(Request $request)
  {
    $ids = $request->proId;
    $proID = json_decode($ids, TRUE);
    $limit = $proID['limit'];
    if($limit == "all"){
      $filter = $proID['filter'];
      $filter = explode("|",$filter);
      $typeStr = isset($filter[0]) ? $filter[0] : '';
      $warehouseStr = isset($filter[1]) ? $filter[1] : '';
      $availableStr = isset($filter[2]) ? $filter[2] : '';
      $typeStr = str_replace('type:','',$typeStr);
      $warehouseStr = str_replace('warehouse:','',$warehouseStr);
      $availableStr = str_replace('available:','',$availableStr);
      $proData  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop','category','productcondition','productType')
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
      ->select('products.*');
      if(!empty($typeStr)){
        $proData = $proData->where('product_types.listing_type',$typeStr);
      }
      if(!empty($warehouseStr))
        {
            $proData = $proData->where('products.warehouse_id',$warehouseStr);
        }
      if(!empty($availableStr) && ($availableStr == 'availability'))
      {
        $proData = $proData->where('products.published',1);
      }
      $proData=$proData->get();
    }else{
      $items = $proID['items'];
      if($items != ""){
        $proData = Product::whereIn('products.id', $items)->get();
      }
    }


    $ProTStockHtml = "";
    $stock_id="";
  
        foreach($proData as $key => $row){
            
            $product_cost = $row->product_cost;;
              $name = $row->name;
              $stock_id = $row->stock_id;
              $model = $row->model;
              $weight = $row->weight;
              $paper_cart = $row->paper_cart;
              if($row->custom_1 != ""){
                $custom_1 = $row->custom_1;
                $custom_1 = $custom_1."-";
              }else{
                $custom_1 = "";
              }
              if($row->custom_2 != ""){
                $custom_2 = $row->custom_2;
                $custom_2 = $custom_2."-";
              }else{
                $custom_2 = "";
              }
              if($row->custom_3 != ""){
                $custom_3 = $row->custom_3;
                $custom_3 = $custom_3."-";
              }else{
                $custom_3 = "";
              }
              if($row->custom_4 != ""){
                $custom_4 = $row->custom_4;
                $custom_4 = $custom_4."-";
              }else{
                $custom_4 = "";
              }
              if($row->custom_5 != ""){
                $custom_5 = $row->custom_5;
                $custom_5 = $custom_5."-";
              }else{
                $custom_5 = "";
              }
              if($row->custom_6 != ""){
                $custom_6 = $row->custom_6;
                $custom_6 = $custom_6."-";
              }else{
                $custom_6 = "";
              }
              if($row->custom_7 != ""){
                $custom_7 = $row->custom_7;
                $custom_7 = $custom_7."-";
              }else{
                $custom_7 = "";
              }
              if($row->custom_8 != ""){
                $custom_8 = $row->custom_8;
                $custom_8 = $custom_8."-";
              }else{
                $custom_8 = "";
              }
              if($row->custom_9 != ""){
                $custom_9 = $row->custom_9;
                $custom_9 = $custom_9."-";
              }else{
                $custom_9 = "";
              }
              if($row->custom_10 != ""){
                $custom_10 = $row->custom_10;
                $custom_10 = $custom_10."-";
              }else{
                $custom_10 = "";
              }
              if($row->weight != ""){
                $weight = $row->weight;
                $weight = $weight."-";
              }else{
                $weight = "";
              }
              if($row->paper_cart != ""){
                $paper_cart = $row->paper_cart;
                $paper_cart = $paper_cart."-";
              }else{
                $paper_cart = "";
              }


           $ProTStockHtml .= "<tr><td>$row->name ($model $weight $paper_cart $custom_1 $custom_2 $custom_3 $custom_4 $custom_5  $custom_6 $custom_7 $custom_8 $custom_9 $custom_10 ($stock_id))</td><td><input type='text' class='form-control' name='proarrkey[$row->id]' value='1'></td><td><button type='button' class='btn btn-danger removeStockData' name='button'><i class='las la-trash'></i></button></td></tr>";
           $ProStockHtml['url']=route('products.barcodestorelist', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] );
        }
         foreach($proData as $key => $row){
           $stock_id .= "$row->stock_id  , ";
        }
    $ProStockHtml['status'] = 'success';

    $ProStockHtml['html'] = $ProTStockHtml;
    $ProStockHtml['stock_id'] = $stock_id;

    echo json_encode($ProStockHtml);
    exit;

  }
  public function barcode_return(Request $request)
  {
    // $returnID= $request->id;
    // // echo $returnID; exit;
    //   if($returnID != "")
    //   {
    //       $ReturnProData=Product::findOrFail($returnID);
    //     $currentUser = \Auth::user()->name;
    //     // date("m-d-Y", strtotime($orgDate));
    //     $ReturntableAppend = "<table class='table table-bordered table-hover table-striped print-table order-table table'>
    //     <div class='well well-sm' style='border: 1px solid #ddd;background-color: #f6f6f6;box-shadow: none;border-radius: 0px;padding: 9px;min-height: 20px;margin-bottom:10px;'>
    //       <div class='row bold tb-big'>
    //         <div class='col-xs-5' style='margin-left: 15px;'>
    //          <b>Date: ".date('m/d/20y', strtotime($ReturnProData->created_at))."</b><br>
    //          <b>Type: Return Purchase </b><br>
            
    //         </div>
    //     </div>
    //   </div>
    //     <thead>
    //       <tr class='bg-primary text-white'>
    //         <th scope='col'>No.</th>
    //         <th scope='col'>Description</th>
           
    //         <th scope='col'>Unit Price</th>
    //         <th scope='col'>Subtotal</th>
    //       </tr>
    //     </thead>
    //     <tbody>";
    //     // $ReturnItemData = ReturnItems::select('return_items.*','products.name','product_stocks.sku','products.stock_id','products.model','products.weight','products.paper_cart','products.custom_1','products.custom_2','products.custom_3','products.custom_4','products.custom_5','products.custom_6','products.custom_7','products.custom_8','products.custom_9','products.custom_10')
    //     // ->leftJoin('products', 'products.id', '=', 'return_items.product_id')
    //     // ->leftJoin('product_stocks', 'product_stocks.product_id', '=', 'products.id')
    //     // ->where('return_items.return_id',$returnID)
    //     // ->get();
    //     // dd($ReturnItemData);
    //     // foreach ($ReturnItemData as $RProItem) {
    //       $product_cost = $ReturnProData->product_cost;
    //     //   $qty = $RProItem->qty;
    //       $name = $ReturnProData->name;
    //       $stock_id = $ReturnProData->stock_id;
    //       $model = $ReturnProData->model;
    //       $weight = $ReturnProData->weight;
    //     //   $sku = $RProItem->sku;
    //       $paper_cart = $ReturnProData->paper_cart;
    //       if($ReturnProData->custom_1 != ""){
    //         $custom_1 = $ReturnProData->custom_1;
    //         $custom_1 = $custom_1."-";
    //       }else{
    //         $custom_1 = "";
    //       }
    //       if($ReturnProData->custom_2 != ""){
    //         $custom_2 = $ReturnProData->custom_2;
    //         $custom_2 = $custom_2."-";
    //       }else{
    //         $custom_2 = "";
    //       }
    //       if($ReturnProData->custom_3 != ""){
    //         $custom_3 = $ReturnProData->custom_3;
    //         $custom_3 = $custom_3."-";
    //       }else{
    //         $custom_3 = "";
    //       }
    //       if($ReturnProData->custom_4 != ""){
    //         $custom_4 = $ReturnProData->custom_4;
    //         $custom_4 = $custom_4."-";
    //       }else{
    //         $custom_4 = "";
    //       }
    //       if($ReturnProData->custom_5 != ""){
    //         $custom_5 = $ReturnProData->custom_5;
    //         $custom_5 = $custom_5."-";
    //       }else{
    //         $custom_5 = "";
    //       }
    //       if($ReturnProData->custom_6 != ""){
    //         $custom_6 = $ReturnProData->custom_6;
    //         $custom_6 = $custom_6."-";
    //       }else{
    //         $custom_6 = "";
    //       }
    //       if($ReturnProData->custom_7 != ""){
    //         $custom_7 = $ReturnProData->custom_7;
    //         $custom_7 = $custom_7."-";
    //       }else{
    //         $custom_7 = "";
    //       }
    //       if($ReturnProData->custom_8 != ""){
    //         $custom_8 = $ReturnProData->custom_8;
    //         $custom_8 = $custom_8."-";
    //       }else{
    //         $custom_8 = "";
    //       }
    //       if($ReturnProData->custom_9 != ""){
    //         $custom_9 = $ReturnProData->custom_9;
    //         $custom_9 = $custom_9."-";
    //       }else{
    //         $custom_9 = "";
    //       }
    //       if($ReturnProData->custom_10 != ""){
    //         $custom_10 = $ReturnProData->custom_10;
    //         $custom_10 = $custom_10."-";
    //       }else{
    //         $custom_10 = "";
    //       }
    //     //   if($RProItem->sku != ""){
    //     //     $sku = $RProItem->sku;
    //     //     $sku = $sku."-";
    //     //   }else{
    //     //     $sku = "";
    //     //   }
    //       if($ReturnProData->weight != ""){
    //         $weight = $ReturnProData->weight;
    //         $weight = $weight."-";
    //       }else{
    //         $weight = "";
    //       }
    //       if($ReturnProData->paper_cart != ""){
    //         $paper_cart = $ReturnProData->paper_cart;
    //         $paper_cart = $paper_cart."-";
    //       }else{
    //         $paper_cart = "";
    //       }
    //         setlocale(LC_MONETARY,"en_US");
    //       $ReturntableAppend .= "
    //         <tr>
    //           <th scope='row'>1</th>
    //           <td>$model- $weight $paper_cart $custom_1 $custom_2 $custom_3 $custom_4 $custom_5 $custom_6 $custom_7 $custom_8 $custom_9 $custom_10($stock_id)</td>
              
    //           <td>".money_format("%(#1n", $product_cost)."\n"."</td>
    //           <td>".money_format("%(#1n", $product_cost)."\n"."</td>
    //         </tr>";
    //     // }
    //     $ReturntableAppend .= "</tbody>
    //     <tfoot>
    //   </tfoot>
    //   </table>
    //   <div class='text-right col-4 tb-big-foot'  style='border: 1px solid #ddd;background-color: #f6f6f6;box-shadow: none;border-radius: 0px;padding: 9px;min-height: 20px;margin-bottom:10px;margin-left:67%;'>
    //     <b><span class='mr-5'>Created By:$currentUser</span></b><br>
    //     <b><span class='mr-5'>Date:".date('m/d/20y', strtotime($ReturnProData->created_at))."</span></b>
    //   </div>
    //   ";
    //   }
    //   return response()->json(['success' => true,'returnHtmlData'=>$ReturntableAppend]);
  }
}
