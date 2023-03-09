@extends('backend.layouts.app')
@section('content')

    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class=" align-items-center">
        <h1 class="h3">{{translate('Short Stock')}}</h1>
        </div>
        <div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
        <div class="list_bulk_btn">
                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="las la-bars fs-20"></i>
                </button>
                 <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                <form class="" action="{{route('short_stock_excel.index')}}" method="post">
                    @csrf
                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">
                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>
                </form>
               @endif
            </div>
                <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('143', json_decode(Auth::user()->staff->role->inner_permissions)))-->
                <!--    <a href="{{Route('short_stock_excel.index')}}" id="xls" class="tip" title="" style="text-decoration:none;" data-original-title="Download as XLS">-->
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
           <div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
            <div class="date_year_box" style="margin-left: 0 !important; max-width: 28% !important; right:23px !important;">
         <i class="las la-calendar"></i>
                      <i class="fa fa-calendar"></i>&nbsp;
                  <input type="hidden" name="startrangedate" class="startrangedate" value="">
                  <input type="hidden" name="endrangedate" class="endrangedate" value="">
                  <input type="text" name="reportrange" id="reportrange" value="" />

                      <span></span> <i class="fa fa-caret-down"></i>
                      <i class="las la-angle-down"></i>
              <!-- <div id="reportrange" style="background: #fff; cursor: pointer; padding: 10px; border: 1px solid #ccc; width: 100%">
                    <i class="las la-calendar"> </i>
                    <i class="fa fa-calendar"> </i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <i class="las la-angle-down"></i>-->
                  </div>

                <button type="submit" id="warehouse_type" name="warehouse_type" class="d-none calendar_submit"><i class="las la-search aiz-side-nav-icon" ></i></button>
                </form>
                </div>
                <!-- <input type="submit" class="calendar_submit" value="search" name="btn"> -->
                        <!-- <form method="get" id="pagination_form" action=""> -->
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
                                    <th>{{ translate('Sold Quantity ') }}</th>
                                    <th>{{ translate('On Hold') }}</th>
                                    <th>{{ translate('Available Quantity') }}</th>
                                    <th>{{ translate('Total Quantity') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                               @foreach($short_stock_data as $key => $row)
                           

                                @php
                                $ModelQty="";
                                $totalModelQty = 0;

                                if(!empty($row->model)){
                                $mt = $row->model;
                                $ModelQty = DB::table('products')
                                            ->leftJoin('product_stocks','products.id','=','product_stocks.product_id')
                                            ->where('model',$mt)
                                            ->select('product_stocks.qty')
                                            ->get();
                                }

                                $sumVal1 = 0;
                                $sumVal2 = 0;
                                if($row->item_status == 2 || $row->item_status == 4 || $row->item_status == 6){
                                $sumVal1 = $row->memoqtysum;
                                }
                                if($row->item_status == 0 || $row->item_status == 1){
                                $sumVal2 = $row->memoqtysum;
                                }
                                $sumQtyVal = $sumVal1 + $sumVal2;
                                @endphp
                                @if($row->model != "")
                                <tr>
                                    
                                    <td class="text-center"><input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"></td>
                                    <td>  @if($pagination_qty != "all") {{ ($short_stock_data->currentpage()-1) * $short_stock_data->perpage() + $key + 1 }} @else {{ $key + 1 }} @endif</td>
                                    <td class="text-center">{{$row->model}} </td>
                                    <td class="text-center">
                                      @if($row->item_status == 2 || $row->item_status == 4 || $row->item_status == 6)
                                        {{$row->memoqtysum}}
                                        @else
                                        {{'0'}}
                                      @endif
                                    </td>
                                    <td class="text-center">
                                      @if($row->item_status == 0 || $row->item_status == 1)
                                       {{$row->memoqtysum}}
                                       @else
                                       {{'0'}}
                                      @endif
                                    </td>
                                    <td class="text-center">
                                      @if (is_array($short_stock_data))
                                      @foreach($ModelQty as $MQtyrow)
                                        @php
                                        $totalModelQty += $MQtyrow->qty;
                                        @endphp
                                      @endforeach
                                      @endif

                                      {{$totalModelQty}}
                                    </td>
                                    <td class="text-center">{{ $sumQtyVal + $totalModelQty}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                        <div class="aiz-pagination">
                            
                            @if($pagination_qty != "all")
                            <p>
                                Showing {{ $short_stock_data->firstItem() }} to {{ $short_stock_data->lastItem() }} of  {{$short_stock_data->total()}} entries
                            </p>
                            {{ $short_stock_data->appends(request()->input())->links() }}
                            @else
                            <p>
                            Showing {{$short_stock_data->count()}} of  {{$short_stock_data->count()}} entries
                            </p>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
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

<script type="text/javascript">



  				$(document).ready(function() {

  						$(document).on('click','.pro_checkbox',function(){



  							productCheckbox();

                              productCheckboxExport();

  						});

  				});

  				function productCheckbox(){

            // alert();

  					var proCheckID = [];

  					$.each($("input[name='all_pro[]']:checked"), function(){

  							proCheckID.push($(this).val());



  					});

                      console.log(proCheckID);

  					var proexpData =	JSON.stringify(proCheckID);

            // alert(proexpData);

  					$('#checkox_pro').val(proexpData);

  					if(proCheckID.length > 0){

  						$('#product_export').removeAttr('disabled');

  					}else{

  						$('#product_export').attr('disabled',true);

  					}

            if(proCheckID.length > 0){

  						$('#product_delete').removeAttr('disabled');

  						$('#product_delete').addClass('hoverProBtn');

  					}else{

  						$('#product_delete').attr('disabled',true);

              $('#product_delete').removeClass('hoverProBtn');

  					}

  				}

                  function productCheckboxExport(){

            // alert();

  					var proCheckID = [];

  					$.each($("input[name='all_pro[]']:checked"), function(){

  							proCheckID.push($(this).val());



  							// alert(proCheckID);

  					});

  					var proexpData =	JSON.stringify(proCheckID);

  					$('#checkox_pro_export').val(proexpData);

  					if(proCheckID.length > 0){

  						$('#product_export').removeAttr('disabled');

  					}else{

  						$('#product_export').attr('disabled',true);

  					}

                      if(proCheckID.length > 0){

  						$('#product_delete').removeAttr('disabled');

  					}else{

  						$('#product_delete').attr('disabled',true);

  					}

  				}





  					$(document).on('click','.select_count',function() {

  				     if($(this).is(':checked')){

  							 $('.pro_checkbox').prop('checked', true);

  						 }else{

  							 $('.pro_checkbox').prop('checked', false);

  						 }

  						 productCheckbox();

                           productCheckboxExport();

  					});



            $(document).on('click','.default-filter-check', function(){

              if ($(this).prop('checked')==true){



              var FilterDefaultVal = $('.default-filter-check-value').val();

              if(FilterDefaultVal != ''){

              var FilterDefaultValData =  JSON.parse(FilterDefaultVal);

              $('.filtered_field').prop('checked',false);



              console.log(FilterDefaultValData);

              $.each( FilterDefaultValData, function( keyFilter, valFilter ) {

                    $('#filteredColOpt .'+keyFilter).prop('checked',true);

                    console.log(valFilter);

                });

              }

            }else{

                $('.filtered_field').prop('checked',false);

            }

            })



  	</script>
@endsection
