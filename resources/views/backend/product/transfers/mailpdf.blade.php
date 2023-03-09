<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
    <style>
    @media print {
  .mi_inv_pdf{
    width: 100%;
  }
  table.mi_inv_pdf{
      margin-top:30px !important;
  } 
  .mi_inv_pdf tr th, .mi_inv_pdf tr td{
    border:1px solid #000 !important;
    padding: 15px;
    text-align: center;
    font-size: 20px !important;
    color:red !important;
  }
  .mi_inv_pdf tr td.stock_id{
    width: 50%;
    /*border:1px solid #000 !important;*/
  }
  .table-striped{
      color:#000 !important
  }
  table.table-striped.print-table tr th, table.table-striped.print-table tr td{
      border-collapse: collapse !important;
      border:1px solid #000 !important;
      padding:5px !important;
  }
    }
    
    </style>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
     setlocale(LC_MONETARY,"en_US");
  @endphp
<div>
    <div style="max-width:900px;">
        <div class="content">
			<div class="header">
    			<img src="https://gcijewel.com/public/uploads/all/O2yCFLQfu0nitWXPCfza2pYto0xjo8kqGbfusjON.png" class="img-fluid w-25 logo-rem">
                <!-- <h5 class="modal-title">Return Items</h5> -->
            </div>
		    <div class="modal-body" >
			<div id="reModelData">
			    <div class='well well-sm' style='border: 1px solid #ddd;background-color: #f6f6f6;box-shadow: none;border-radius: 0px;padding: 9px;min-height: 20px;margin-bottom:10px;'>
                    <div class='row bold tb-big'>
                        <div class='col-xs-5' style='margin-left: 15px;'>
                            <b>Date: {{date('m/d/20y', strtotime($ReturnProData->date))}}</b><br>
                            <b>Reference:{{$ReturnProData->transfer_no}} </b><br>
                            <b>Transferred To: {{$ReturnProData->to_warehouse_name}} </b><br>
                            <b>Transferred From:{{ $ReturnProData->from_warehouse_name}} </b><br>
                        </div>
                    </div>
                  </div>
                  
			    <table class=" table table-bordered table-hover table-striped print-table order-table table" style="border-collapse: collapse; margin-bottom:10px;">
                    <thead>
                      <tr class="table-striped">
                        <th class="table-striped" style="width:50%;">Description</th>
                        <th class="table-striped" style="width:50%;">Quantity</th>
                        <th class="table-striped" style="width:50%;">Unit Price</th>
                        <th class="table-striped" style="width:50%;">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php $totalqty=0; $totalamount=0; @endphp
                        @foreach($product_data as $row)
                        @php
                        $totalqty=$totalqty+=$row->qty;
                        $totalamount=$totalamount+=$row->product_cost;
                    
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
                              if($row->sku != ""){
                                $sku = $row->sku;
                                $sku = $sku."-";
                              }else{
                                $sku = "";
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
        
                                $quantity=$row->quantity;
                              // $subtotal=$RProItem->memoSubTotal;
                              $row_cost = $row->subtotal;
                              $qty = $row->qty;
                              $unit_cost=$row->product_cost;
                              $name = $row->name;
                              $stock_id = $row->stock_id;
                              $model = $row->model;
                              $weight = $row->weight;
                              $sku = $row->sku;
                              $description= "$model- $sku $weight $paper_cart $custom_1 $custom_2 $custom_3 $custom_4 $custom_5 $custom_6 $custom_7 $custom_8 $custom_9 $custom_10($stock_id)";
                            @endphp
                          <tr class="table-striped">
                            <td class="table-striped">{{$description}}</td>
                            <td class="table-striped">{{$qty}}</td>
                            <td class="stock_id table-striped">
                              <span>{{money_format("%(#1n", $unit_cost)."\n"}}</span>
                            </td>
                            <td class="table-striped">{{money_format("%(#1n", $unit_cost)."\n"}}</td>
                          </tr>
                        @endforeach
                        <tr class="table-striped">
                            <td colsopan="2" class="table-striped">Total Qty</td>
                            <td class="table-striped">{{$totalqty}}</td>
                            <td class="table-striped">Total</td>
                            <td class="table-striped">{{money_format("%(#1n", $totalamount)."\n"}} </td>
                        </tr>
                    </tbody>
                </table>
                <div class='text-right col-4 tb-big-foot'  style='border: 1px solid #ddd;background-color: #f6f6f6;box-shadow: none;border-radius: 0px;padding: 9px;min-height: 20px;margin-bottom:10px;margin-left:67%;'>
                    <b><span class='mr-5'>Created By: {{auth()->user()->name}}</span></b><br>
                    <b><span class='mr-5'>Date:{{date('m/d/20y', strtotime($ReturnProData->date))}}</span></b> 
                </div>
			</div>
		</div>
    </div>
</div>

<!--  </div>-->

<!--</div>-->


</body>
</html>
