@extends('backend.layouts.app')
<style>
    td{
        text-align:center;
    }
</style>
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Sales Report')}}</h1>
	</div>
</div>
<form class="" id="sort_products" action="" method="GET">
    <div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
     <div class="date_year_box row">
            <i class="las la-calendar"></i>
                      <i class="fa fa-calendar"></i>&nbsp;
                  <input type="hidden" name="startrangedate" class="startrangedate" value="">
                  <input type="hidden" name="endrangedate" class="endrangedate" value="">
                  <input type="text" name="reportrange" id="reportrange" value="01/01/2018 - 01/15/2018" />
              
                      <span></span> <i class="fa fa-caret-down"></i>
                      <i class="las la-angle-down"></i>
                      <!--  <input type="hidden" name="startrangedate" class="startrangedate" value="">
                        <input type="hidden" name="endrangedate" class="endrangedate" value="">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 10px; border: 1px solid #ccc; width: 100%">
                            <i class="las la-calendar"></i>
                      <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <i class="las la-angle-down"></i>-->
                        </div>
                        <button type="submit" id="warehouse_type" name="warehouse_type" class="d-none calendar_submit"><i class="las la-search aiz-side-nav-icon" ></i></button>
                        <!-- <input type="submit" value="search" name="btn"> -->
                        </form> 
                             <div class="list_bulk_btn">
    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="las la-bars fs-20"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                <form class="" action="{{route('seller_sale_report_excel.index')}}" method="post">
                    @csrf
                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">
                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>
                </form>
               @endif
            </div>
    <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('143', json_decode(Auth::user()->staff->role->inner_permissions)))-->
    <!--    <a href="{{Route('seller_sale_report_excel.index')}}" id="xls" class="tip" title="" style="text-decoration:none;" data-original-title="Download as XLS">-->
    <!--        <div class="dropdown-menu dropdown-menu-right">-->
    <!--            Excel-->
    <!--        </div>-->
    <!--    </a>-->
    <!--@endif-->
    </div>
                    </div>

</div>

<!-- <div class="box-header">
    <h2 class="blue"><i class="fa-fw fa fa-barcode"></i>Seller Based Selling Report
    </h2>
    <div class="box-icon">
        <ul class="btn-tasks">
            <li class="dropdown">
                <a href="{{Route('seller_sale_report_excel.index')}}" id="xls" class="tip" title="" data-original-title="Download as XLS">
                   Excel
                </a>
            </li>
        </ul>
    </div>
</div> -->
<div>
    <!-- <div class="col-md-12 mx-auto"> -->
        <div class="card" style="width: 100%;">
                <form class="" id="sort_products" action="" method="GET">
                    <div class="card-header row gutters-5">
                    <div class="col-md-3">
                        <!-- <label>Customer</label> -->
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="customer_name" id="agent_id" data-live-search="true">
                            <option value="">All Customer</option>
                            @foreach (App\RetailReseller::all() as $whouse_filter)
                                <option value="{{$whouse_filter->id}}" @if($whouse_filter->id == Request::get('customer_name')) selected @endif>{{ $whouse_filter->customer_name }}</option>
                            @endforeach;
                        </select>
                        <button type="submit" id="Agent_type" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                    </div>
                    <div class="col-md-3">
                        <!-- <label>Listing Type </label> -->
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="listing_type" id="product_type" data-live-search="true">
                        <option value="">All Listing Type</option>
                            @foreach (App\SiteOptions::where('option_name', '=', 'listingtype')->get() as $p_type_filter)
                                <option value="{{$p_type_filter->option_value}}" @if($p_type_filter->option_value == Request::get('listing_type')) selected @endif>{{ $p_type_filter->option_value }}</option>
                            @endforeach;
                        </select>
                        <button type="submit" id="pro_type"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                    </div>
                    <div class="col-md-3">
                        <!-- <lable>Model</label> -->
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="model_number" id="product_model" data-live-search="true">
                            <option value="">All Model</option>
                            @foreach (App\SiteOptions::where('option_name', '=', 'model')->get() as $p_type_filter)
                                <option value="{{$p_type_filter->option_value}}" @if($p_type_filter->option_value == Request::get('model_number')) selected @endif>{{ $p_type_filter->option_value }}</option>
                            @endforeach;
                        </select>
                        <button type="submit" id="btn_model"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                    </div>

                    @php $memo=1; $invoce=2; $trade=4; $tradeNgd=6; @endphp
                    <div class="col-md-3">
                        <!-- <label class="form-control">All Status </label> -->
                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="memo_status" id="memoStatus" data-live-search="true">
                            <option value="">All</option>
                            <option  value="{{$memo}}" @if($memo== Request::get('memo_status')) selected @endif>Memo</option>
                            <option value="{{$invoce}}" @if($invoce== Request::get('memo_status')) selected @endif>Invoice</option>
                            <option value="{{$trade}}"  @if($trade== Request::get('memo_status')) selected @endif>Trade</option>
                            <option value="{{$tradeNgd}}"  @if($tradeNgd== Request::get('memo_status')) selected @endif>TradeNGD</option>
                        </select>
                        <button type="submit" id="memostatusbtn"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                    </div>
                </div>
                <div class="row page_qty_sec product_search_header">
                        <input type="hidden" name="search" id="searchinputfield">
                        <select class="form-control form-select" id="pagination_qty" name="pagination_qty" style="display:none">
                            <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                            <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                            <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                            <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                            <option  @if($pagination_qty == "all") selected @endif value="all">All</option>
                        </select>
                        <div class="col-2 d-flex page_form_sec" style="padding-left: 0px;">
                            <label class="fillter_sel_show m-auto"><b>Show</b></label>
                            <select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example">
                                <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                                <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                                <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                                <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                                <option value="all" @if($pagination_qty == "all") selected @endif>All</option>
                            </select>
                        </div>
                        <div class="col-6 d-flex search_form_sec" style="padding-right: 0px;">
                                <label class="fillter_sel_show m-auto"><b>Search</b></label>
                                <input type="text" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}" @endisset style="width:200px;">
                                <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
                            </div>
                    </div>
                
               </form> 
                <div class="card-body">
                   
                    <table class="table table-bordered aiz-table mb-0">
                        <thead>
                            <tr>
                            <th data-orderable="false"> <input type="checkbox" class="select_count" id="select_count"  name="all[]"> </th>
                                	        
                                <th >#  </th>
                                <th>{{ translate('Date') }}</th>
                                <th>{{ translate('Status') }}</th>
                                <th>{{ translate('Memo Number') }}</th>
                                <th>{{ translate('Customer') }}</th>
                                <th>{{ translate('Stock Id') }}</th>
                                <th>{{ translate('Listing Type') }}</th>
                                <th>{{ translate('Model Number') }}</th>
                                <th>{{ translate('Serial Number') }}</th>
                                <th>{{ translate('Sales Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                setlocale(LC_MONETARY,"en_US");
                            @endphp
                            @foreach($closememoData as$key=> $row)
                            <tr>
                                @php
                                if($row->id == ''){
                                    $row->id = 0;
                                }
                                @endphp

                                    <td><input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"></td>


                                <td> <center>@if($pagination_qty != "all") {{ ($closememoData->currentpage()-1) * $closememoData->perpage() + $key + 1 }} @else {{ $key + 1 }} @endif
                                    <!--<input type="checkbox" class="memo_checkbox" data-checkBoxId="{{ $row->id}}"   value="{{ $row->id}}" name="all_memo[]" >-->
                                    </center></td>
                                <td>   <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{date('m/d/y',strtotime($row->date))}} </a></td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">
                                <?php
                                    if($row->item_status==1 || $row->item_status==0)
                                        {
                                            echo "Memo";
                                        }
                                        elseif($row->item_status==2)
                                        {
                                            echo "INVOICE";
                                        }
                                        elseif($row->item_status==3)

                                        {

                                            echo "RETURN";

                                        }

                                        elseif($row->item_status==4)

                                        {

                                            echo "TRADE";

                                        }

                                        elseif($row->item_status==5)

                                        {

                                            echo "VOID";

                                        }

                                        elseif($row->item_status==6)

                                        {

                                            echo "TRADE NGD";

                                        }

                                    ?></a>
                                    @php 

                                    $row->customer_name = $row->rcustomername;

                                    @endphp
                                </td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{$row->memo_number}} </a> </td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{$row->customer_name}} </a> </td>
                                
                                	@php 
                                  
                                  $model=explode(',', $row->model_numbers);  $model_number= implode(", " , $model); 
                                  
                                   $stock=explode(',', $row->stocks);  $stock_number= implode(", " , $stock); 
                                   
                                    $serial=explode(',', $row->skus);  $serial_number= implode(", " , $serial); 
                                  
                                  @endphp



                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;"> {{$stock_number}} 
                                    </a></td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{$row->listing_type}} </a></td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;"> {{$model_number}}
                                    </a></td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{$serial_number}} 
                                    </a></td>
                                <td> <a href="{{route('memo.edit', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}" style="text-decoration:none;color:#000;">{{money_format("%(#1n", $row->sub_total) }}</a> </td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($pagination_qty != "all")
                            <p>
                                Showing {{ $closememoData->firstItem() }} to {{ $closememoData->lastItem() }} of total {{$closememoData->total()}} entries
                            </p>
                        <span style="margin-left:90%;"> {{ $closememoData->appends(request()->input())->links() }}</span>
                        @else
                        <p>
                        Showing {{$closememoData->count()}} of total {{$closememoData->count()}} entries
                        </p>
                    @endif
                    </div>
        </div>

    <!-- </div> -->

</div>



@endsection
@section('script')
<script>

$(document).on("change", ".check-all", function() {

if(this.checked) {

    $('.check-one:checkbox').each(function() {

        this.checked = true;

    });

} else {

    $('.check-one:checkbox').each(function() {

        this.checked = false;

    });

}



});

$(document).ready(function() {

$(document).on('click','.pro_checkbox',function(){

    productCheckbox();

    productCheckboxExport();

});

});

function productCheckbox()

{

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

    proCheckID.push($(this).val());



});

console.log(proCheckID);

var proexpData =JSON.stringify(proCheckID);

$('#checkox_pro').val(proexpData);

if(proCheckID.length > 0)

{

    $('#product_export').removeAttr('disabled');

}

else

{

    $('#product_export').attr('disabled',true);

}

}
// $('#product_export').on('click',function(){

// })

function productCheckboxExport(){

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

        proCheckID.push($(this).val());

});

var proexpData =JSON.stringify(proCheckID);

$('#checkox_pro_export').val(proexpData);

if(proCheckID.length > 0)

{

    $('#product_export').removeAttr('disabled');

}

else

{

    $('#product_export').attr('disabled',true);

}

}

$(document).on('click','.select_count',function() {

if($(this).is(':checked'))

{

    $('.pro_checkbox').prop('checked', true);

0}

else

{

    $('.pro_checkbox').prop('checked', false);

}

productCheckbox();

productCheckboxExport();

});














 $(document).on('click','.search_btn_field',function() {
        prosearchform();
    });
    $(".sort_search_val").keypress(function(e){
    if(e.which == 13) 
    {
        prosearchform();
    }

});
    $("#pagination_use_qty").change(function(){
        var pageQty = $(this).val();
        $('#pagination_qty').val(pageQty);
        $("#sort_products").submit();
    });
    function prosearchform(){
        var searchVal = $('.sort_search_val').val();
        $('#searchinputfield').val(searchVal);
        $("#sort_products").submit();
    }
</script>

<script type="text/javascript">
$(function() {
  <?php if($startrangedate != ""){ ?>
    var start = "<?php echo $startrangedate; ?>";
    start = moment(start);
  <?php  }else{ ?>
    var start = moment().subtract(29, 'days');
  <?php  }   ?>

  <?php if($endrangedate != ""){ ?>
    var end = "<?php echo $endrangedate; ?>";
    end = moment(end);
  <?php  }else{ ?>
    var end = moment();
  <?php }   ?>

    function cb(start, end) {
        $('#reportrange span').html(start.format('MM/DD/YYYY') + ' - ' + end.format('MM / DD / YYYY'));
        $('.startrangedate').val(start.format('MM/DD/YYYY'));
        $('.endrangedate').val(end.format('MM/DD/YYYY'));

    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This fiscal year': [moment().startOf('year'), moment().endOf('year')],
           'Last fiscal year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    }, cb);
console.log(start);
console.log(end);
    cb(start, end);
    // $('#date_reng').trigger('click');

});
$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
		$('.calendar_submit').trigger('click');
});

</script>
@endsection

