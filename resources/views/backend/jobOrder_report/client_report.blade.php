@extends('backend.layouts.app')

@section('content')
@php
    setlocale(LC_MONETARY,"en_US");
@endphp
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <h1 class="h3">{{translate('Job Order by Client')}}</h1>
        </div>
    </div>
</div>
<div class="row ouder_report_agent">
    <div class="col-md-12">
<div class="dropdown mb-2 mb-md-0 right_drop_mune_sec trans_mi">
    <div class="list_bulk_btn">
    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
        <i class="las la-bars fs-20"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
                @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                <form class="" action="{{route('client_report_export.index')}}" method="post">

                    @csrf

                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">

                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>

                </form>
               @endif
            </div>
    <!--<a href="{{Route('client_report_export.index')}}" id="xls" class="tip" title="" style="text-decoration:none;" data-original-title="Download as XLS">-->
    <!--    <div class="dropdown-menu dropdown-menu-right">-->
    <!--        Excel-->
    <!--    </div>-->
    <!--</a>-->
</div>
</div>
<!-- <div class="box-header">
    <h2 class="blue"><i class="fa-fw fa fa-barcode"></i>Job Order by Client
    </h2>
    <div class="box-icon">
        <ul class="btn-tasks">
            <li class="dropdown">
                <a href="{{Route('client_report_export.index')}}" id="xls" class="tip" title="" data-original-title="Download as XLS">
                   Excel
                </a>
            </li>
        </ul>
    </div>
</div> -->
<div class="card">
    <form class="" id="sort_products" action="" method="GET">
        <div class="col-md-2 ml-auto d-flex report_agent">
            <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="client_id" id="agent_id" data-live-search="true">
              <option value="">All Clients</option>
              @foreach (App\RetailReseller::all() as $whouse_filter)
                <option value="{{$whouse_filter->id}}" @if($whouse_filter->id == Request::get('client_id')) selected @endif>{{ $whouse_filter->customer_name }}</option>
              @endforeach;
            </select>
            <button type="submit" id="Agent_type" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
        </div>
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
        <table class="table aiz-table mb-0 footable footable-1 breakpoint breakpoint-lg list_agent_table" style="" id="clientReporttbl">
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
                   <th> Total Cost Charged</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody> 
                @php $count =1; @endphp
                @foreach($clientReport as $key => $row)
                    
                    <tr> 
                    <td class="text-center"> <input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"> 
                    </td>
                   <td>{{ $count++ }}</td>

                        <td> {{$row->contact_person}} </td>
                        <td> {{$row->bag_number}} </td>
                        <td> {{$row->job_order_number}} </td>
                        <td> {{$row->model_number}} </td>
                        <td> {{$row->serial_number}} </td>
                        <td> {{$row->stock_id}} </td>
                        <td> {{date('m/d/y', strtotime($row->enter_date))}} </td>
                        <td> {{date('m/d/y', strtotime($row->estimated_date_return))}}  </td>
                        <td> @if(!empty($row->date_of_return)) {{date('m/d/y', strtotime($row->date_of_return))}} @else {{ $row->date_of_return}} @endif</td>
                        <td>{{money_format("%(#1n",$row->total_cost_charged_to_customer)."\n" }}</td>
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
                    <?php $count++ ; ?>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
              @if($pagination_qty != "all")
              <p>
                Showing {{ $clientReport->firstItem() }} to {{ $clientReport->lastItem() }} of  {{$clientReport->total()}} entries
              </p>
                {{ $clientReport->appends(request()->input())->links() }}
                @else
                <p>
                  Showing {{$clientReport->count()}} of  {{$clientReport->count()}} entries
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
    // $(document).ready(function() {
    //     if($('#clientReporttbl').length > 0){
    //         $('#clientReporttbl').DataTable({
    //                 "bPaginate": false,
    //                 "searching": false
    //             });
    //         }
    //     });

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

