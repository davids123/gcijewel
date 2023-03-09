@extends('backend.layouts.app')
<style>
    td
    {
        text-align:center;
    }
</style>
@php  setlocale(LC_MONETARY,"en_US");  @endphp
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate(' Average Cost')}}</h1>
	</div>
	<div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
    <div class="list_bulk_btn">
    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="las la-bars fs-20"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                <form class="" action="{{route('average_report_excel.index')}}" method="post">
                    @csrf
                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">
                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>
                </form>
               @endif
            </div>
    <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('143', json_decode(Auth::user()->staff->role->inner_permissions)))-->
    <!--    <a href="{{Route('product_report_excel.index')}}" id="xls" class="tip" title="" style="text-decoration:none;" data-original-title="Download as XLS">-->
    <!--        <div class="dropdown-menu dropdown-menu-right">-->
    <!--            Excel-->
    <!--        </div>-->
    <!--    </a>-->
    <!--@endif-->
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">

            <form class="warehouse_table" id="sort_products" action="" method="GET">
                <div class="row page_qty_sec product_search_header">
                <div class="col-md-9">
                     <div class="date_year_box" style="margin-left: 0 !important; max-width: 32% !important; right:10px;">
                        <i class="las la-calendar"></i>
                      <i class="fa fa-calendar"></i>&nbsp;
                      @php $startdate =Request::get('startrangedate'); $endDate= Request::get('endrangedate');  @endphp
                      <input type="hidden" name="startrangedate" class="startrangedate" value="{{$startdate}}">
                      <input type="hidden" name="endrangedate" class="endrangedate" value="{{$endDate}}">
                      <input type="text" name="reportrange" id="reportrange" value="{{$startdate}}- {{$endDate}}" />

                      <span></span> <i class="fa fa-caret-down"></i>
                      <i class="las la-angle-down"></i>
                  <button type="submit" id="warehouse_type" name="warehouse_type" class="d-none calendar_submit"><i class="las la-search aiz-side-nav-icon" ></i></button>
                  </div>
                </div>
                <div class="col-md-3">
                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="listing_type" id="product_type" data-live-search="true">
                        <option value="">All Listing Type</option>
                        @foreach (App\SiteOptions::where('option_name', '=', 'listingtype')->get() as $p_type_filter)
                            <option value="{{$p_type_filter->option_value}}" @if($p_type_filter->option_value == Request::get('listing_type')) selected @endif>{{ $p_type_filter->option_value }}</option>
                        @endforeach;
                   </select>
                    <button type="submit" id="pro_type"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                </div>
                </div>
                <div class="row page_qty_sec product_search_header" style="padding-top: 25px;">
                    <input type="hidden" name="search" id="searchinputfield">
                    <select class="form-control form-select" id="pagination_qty" name="pagination_qty" style="display:none">
                        <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                        <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                        <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                        <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                        <option  @if($pagination_qty == "all") selected @endif value="all">All</option>
                    </select>
                    <div class="col-2 d-flex page_form_sec">
                        <label class="fillter_sel_show m-auto"><b>Show</b></label>
                        <select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example">
                            <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                            <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                            <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                            <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                            <option value="all" @if($pagination_qty == "all") selected @endif>All</option>
                        </select>
                    </div>
                    <div class="col-6 d-flex search_form_sec">
                            <label class="fillter_sel_show m-auto"><b>Search</b></label>
                            <input type="text" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}" @endisset style="width:200px;">
                            <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
                        </div>
                </div>
                <div class="card-body">
                 <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" class="select_count" id="select_count"  name="all[]"></th>
                            

                            <th>{{ translate('#') }}</th>
                            <th>{{ translate('Model Number') }}</th>
                            <th>{{ translate('Qty Purchased ') }}</th>
                            <th>{{ translate('Total Purchases Cose') }}</th>
                            <th>{{ translate('Average Cost') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count =0; @endphp
                        @foreach($average_cost_data as $key => $row)

                        @php
                       $totl_qty=$row->totalQty+$row->memo_qty_totl;
                       $totl_cost=$row->totalcost+$row->memo_sub_total;
                        @endphp
                            <tr>
                                <td><input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"></td>


                                <td>  @if($pagination_qty != "all") {{ ($average_cost_data->currentpage()-1) * $average_cost_data->perpage() + $key + 1 }} @else {{ $key + 1 }} @endif</td>
                                <td> {{$row->model}}</td>
                                <td> {{$totl_qty}}</td>
                                <td> {{money_format("%(#1n",$totl_cost)."\n"}}</td>
                                <td>  @php if($totl_qty >0){ $averagecost= $totl_cost/$totl_qty;} else {$averagecost=$totl_cost;} @endphp  {{money_format("%(#1n",$averagecost)."\n"}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                @if($pagination_qty != "all")
                <p>
                    Showing {{ $average_cost_data->firstItem() }} to {{ $average_cost_data->lastItem() }} of  {{$average_cost_data->total()}} entries
                </p>
                    {{ $average_cost_data->appends(request()->input())->links() }}
                    @else
                    <p>
                    Showing {{$average_cost_data->count()}} of  {{$average_cost_data->count()}} entries
                    </p>
                @endif
            </div>
              </div>
            </form>
        </div>
    </div>
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
			if(e.which == 13) {
				prosearchform();
			}
		});
		function prosearchform(){
			var searchVal = $('.sort_search_val').val();
			$('#searchinputfield').val(searchVal);
			$("#sort_products").submit();
		}
		function sort_products(el){
            $('#sort_products').submit();
        }
        $("#pagination_use_qty").change(function(){
            var pageQty = $(this).val();
            $('#pagination_qty').val(pageQty);
            $("#sort_products").submit();
        });

</script>



<script type="text/javascript">
$(function() {
  <?php if($startrangedate != ""){ ?>
    var start = "<?php echo $startrangedate; ?>";
    start = moment(start);
  <?php  }else{ ?>
    var start = moment().subtract(10, "year");
  <?php  }   ?>

  <?php if($endrangedate != ""){ ?>
    var end = "<?php echo $endrangedate; ?>";
    end = moment(end);
  <?php  }else{ ?>
    var end = moment().endOf('year');
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
           'Last fiscal year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
           'Default': [moment().subtract(10, "year"), moment().endOf('year')]
        }
    }, cb);
    $('li[data-range-key="Last 30 Days"]').removeClass("active");
    $('li[data-range-key="This fiscal year"]').addClass("active");
    cb(start, end);
});
$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
		$('.calendar_submit').trigger('click');
});
</script>
@endsection
