@extends('backend.layouts.app')

@section('content')
@php
    setlocale(LC_MONETARY,"en_US");
@endphp
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('Past Due Job Report')}}</h1>
        </div>
    </div>
</div>
<div class="row ouder_report_agent">
<div class="col-md-12">
<form class="" id="sort_products" action="" method="GET">
<div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
    <div class="date_year_box" style="margin-left: 0 !important; max-width:28% !important;">
        <i class="las la-calendar"></i>
                      <i class="fa fa-calendar"></i>&nbsp;
                  <input type="hidden" name="startrangedate" class="startrangedate" value="">
                  <input type="hidden" name="endrangedate" class="endrangedate" value="">
                  <input type="text" name="reportrange" id="reportrange" value="01/01/2018 - 01/15/2018" />
              
                      <span></span> <i class="fa fa-caret-down"></i>
                      <i class="las la-angle-down"></i>
                <!--<div id="reportrange" style="background: #fff; cursor: pointer; padding: 10px; border: 1px solid #ccc; width: 100%">
                <i class="las la-calendar"></i>
                    <i class="fa fa-calendar"></i>&nbsp;
                      <span></span> <i class="fa fa-caret-down"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <i class="las la-angle-down"></i>
                </div>-->
                <button type="submit" id="warehouse_type" name="warehouse_type" class="d-none calendar_submit"><i class="las la-search aiz-side-nav-icon" ></i></button>
                <!-- <input type="submit" value="search" name="btn"> -->
    </div>
     </form>
    <div class="list_bulk_btn">
    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="las la-bars fs-20"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                <form class="" action="{{route('pastDueJob_report_export.index')}}" method="post">

                    @csrf

                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">

                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>

                </form>
               @endif
      </div>
</div>
</div>
<!-- <div class="box-header">
    <h2 class="blue"><i class="fa-fw fa fa-barcode"></i>Past Due Job Report
    </h2>
    <div class="box-icon">
        <ul class="btn-tasks">
            <li class="dropdown">
                <a href="{{Route('pastDueJob_report_export.index')}}" id="xls" class="tip" title="" data-original-title="Download as XLS">
                   Excel
                </a>
            </li>
        </ul>
    </div>
</div> -->
<div class="card">
    <!-- <form class="" id="sort_products" action="" method="GET"> -->
        <div class="card-header row gutters-5 purchases_form_sec">
            <input type="hidden" name="search" id="searchinputfield">
            <select class="form-control form-select" id="pagination_qty" name="pagination_qty" style="display:none">
                <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                <option  @if($pagination_qty == "all") selected @endif value="all">All</option>
            </select>
            <div class="col-2 d-flex page_form_sec report_agent_show">
                <label class="fillter_sel_show"><b>Show</b></label>
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
                <input type="text" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}" @endisset>
                    <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
            </div>
        </div>
        <div class="card-body">
        <table class="table aiz-table mb-0 footable footable-1 breakpoint breakpoint-lg list_agent_table" style="">
            <thead>
                <tr class="footable-header">
                    <th data-orderable="false"> <input type="checkbox" class="select_count" id="select_count"  name="all[]"> </th>
                    <th> #</th>
                    <th>Customer</th>
                    <th>Bag Number</th>
                    <th>Job Order Number</th>
                    <th>Model</th>
                    <th>Serial</th>
                    <th>Stock Id</th>
                    <th>Date Entered</th>
                    <th> Estimated Date Of Returned</th>
                    <th>Date Returned</th>
                   <th> Actual Cost</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody> 
                @php $count =0; @endphp
                @foreach($PastDueJob_report as $key => $row)
                    <?php $count++ ; ?>
                    <tr> 
                    <td class="text-center"> <input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"> 
                    </td>
                             <td>{{ ($PastDueJob_report->currentpage()-1) * $PastDueJob_report->perpage() + $key + 1 }}</td>

                        <!--  <td> {{$count}} </td> -->
                         @if($row->company_name==0)
                        <td> Stock </td>
                        @else
                         @if($row->customer_group=="reseller")
                          <td> {{$row->c_name}} </td>
                          @else
                          <td> {{$row->customer_name}}</td>
                          @endif
                        @endif
                        <td> {{$row->bag_number}} </td>
                        <td> {{$row->job_order_number}} </td>
                        <td> {{$row->model_number}} </td>
                        <td> {{$row->serial_number}} </td>
                        <td> {{$row->stock_id}} </td>
                        <td> {{date('m/d/y', strtotime($row->created_at))}} </td>
                        <td> {{date('m/d/y', strtotime($row->estimated_date_return))}}  </td>
                        <td> @if(!empty($row->date_of_return)) {{date('m/d/y', strtotime($row->date_of_return))}} @else {{ $row->date_of_return}} @endif</td>
                        <td> {{ money_format("%(#1n",$row->total_actual_cost)."\n"}}</td>
                        <td><?php
                        if($row->job_status==1)
                        {
                            echo "Post Due";
                        }
                        elseif($row->job_status==2)
                        {
                            echo "Open";
                        }
                        elseif($row->job_status==3)
                        {
                            echo "Pendding";
                        }
                        elseif($row->job_status==4)
                        {
                            echo "On Hold";
                        }
                        elseif($row->job_status==5)
                        {
                            echo "Close";
                        }
                        ?> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
              @if($pagination_qty != "all")
              <p>
                Showing {{ $PastDueJob_report->firstItem() }} to {{ $PastDueJob_report->lastItem() }} of  {{$PastDueJob_report->total()}} entries
              </p>
                {{ $PastDueJob_report->appends(request()->input())->links() }}
                @else
                <p>
                  Showing {{$PastDueJob_report->count()}} of  {{$PastDueJob_report->count()}} entries
                </p>
              @endif
        </div>
        </div>
    </form>
</div>
</div>
</div>

@endsection

@section('modal')

    @include('modals.delete_modal')

@endsection

@section('script')

<script type="text/javascript">
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

