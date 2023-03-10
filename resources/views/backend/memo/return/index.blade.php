@extends('backend.layouts.app')



@section('content')
 @php
    setlocale(LC_MONETARY,"en_US");
@endphp


<div class="aiz-titlebar text-left mt-2 mb-3">

	<div class="align-items-center">

			<!-- <h1 class="h3">{{translate('All Return')}}</h1> -->

	</div>

</div>
<div class="dropdown mb-2 mb-md-0 hideonprint trans_mi">
    <div class="list_bulk_btn">
	<button class="btn border dropdown-toggle trans_btn" type="button" data-toggle="dropdown">
		<i class="las la-bars fs-20"></i>
	</button>
	<div class="dropdown-menu dropdown-menu-right">
		<form class="" action="{{route('memo_return_export.index')}}" method="post">
			@csrf
			<input type="hidden" name="checked_id" id="checkox_pro_export" value="">
			<button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Export to excel</button>
		</form>
	</div>
	</div>
</div>


<div class="row">

	<div class="col-md-12">

		<div class="card">

		    <div class="card-header row gutters-5">

				<div class="col text-center text-md-left">

					<h5 class="mb-md-0 h6">{{ translate('All Return') }}</h5>

				</div>

		    </div>

		    <div class="mi_custome_table">

		         <form method="get" id="pagination_form" action="{{route('memoreturns.index')}}">



                    <div class="row page_qty_sec product_search_header">



                        <div class="col-2 d-flex page_form_sec">



                                <label class="fillter_sel_show">Show</label>



                                <select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example" name="pagination_qty">



                                <!-- <option value="10" @if($pagination_qty == 10) selected @endif>10</option> -->



                                <option value="25" @if($pagination_qty == 25) selected @endif>25</option>



                                <option value="50" @if($pagination_qty == 50) selected @endif>50</option>



                                <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                                <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>



                                <option value="all" @if($pagination_qty == "all") selected @endif>All</option>



                                </select>







                        </div>



                         <div class="col-6 d-flex search_form_sec">



                            <label class="fillter_sel_show m-auto"><b>Search</b></label>



                            <input type="text" name="search" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}" @endisset>



                             <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>



                        </div>



                    </div>



                </form>



		    <div class="card-body">

		        <table class="table aiz-table mb-0" id="return_datatabl">

		            <thead>

		                <tr>

		                    <th> <input type="checkbox" class="select_count" id="select_count"  name="all[]"></th>

		                    <th>{{translate('Memo Number')}}</th>

		                    <th>{{translate('Customer Name')}}</th>

		                    <th>{{translate('Stock Id')}}</th>

		                    <th>{{translate('Model Number')}}</th>

		                    <th>{{translate('Serial')}}</th>

		                    <th>{{translate('Sub Total')}}</th>

		                    <th>{{translate('Date')}}</th>

		                    <th class="text-right">{{translate('Options')}}</th>

		                </tr>

		            </thead>

		            <tbody>

		                @foreach($memoreturnData  as $key => $return)

		                    <tr>

	                          <td style="text-align:center;"><input type="checkbox" class="pro_checkbox" data-id="{{$return->memodetailsid}}" name="all_pro[]" value="{{$return->memodetailsid}}"></td>

		                        <td>RETURN101{{ $return->memoid}}</td>

		                        @if($return->customer_group=='reseller')
		                        <td>{{ $return->company}}</td>
								@else
								<td>{{ $return->customer_name}}</td>
								@endif  
								
								@php 
                                  
                                  $model=explode(',', $return->model_numbers);  $model_number= implode(", " , $model); 
                                  
                                   $stock=explode(',', $return->stocks);  $stock_number= implode(", " , $stock); 
                                   
                                    $serial=explode(',', $return->skus);  $serial_number= implode(", " , $serial); 
                                  
                                  @endphp

		                        <td> <span class="memo_span_custom" > {{ $stock_number}} </span></td>

		                        <td> <span class="memo_span_custom" > {{ $model_number }} </span></td>

		                        <td> <span class="memo_span_custom" > {{ $serial_number}}</span></td>

		                        <td>{{ money_format("%(#1n", $return->row_total)."\n"}}</td>

		                        <td>{{date('m/d/20y',strtotime($return->status_updated_date))}}</td>

		                        <td class="text-right">

		                            <!-- <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('memo.viewinvoice',['id'=>$return->memoid,'status'=>$return->item_status])}}" title="{{ translate('Edit') }}">

		                                <i class="las la-edit"></i>

		                            </a> -->

																<a href="{{route('memo.generatepdf',['id'=>$return->memoid,'status'=>$return->item_status])}}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('View') }}">

																<i class="las la-print"></i>

																</a>
																<a href="{{route('memo.returnactivity',['id'=>$return->memoid])}}" class="btn btn-soft-success btn-icon btn-circle btn-sm" title="{{ translate('Activity') }}">

																<i class="las la-history"></i>

																</a>

		                        </td>

		                    </tr>

		                @endforeach

		            </tbody>

		        </table>
					

		        <div class="aiz-pagination">

                     @if($pagination_qty != "all")
                    <p>
                        Showing {{ $memoreturnData->firstItem() }} to {{ $memoreturnData->lastItem() }} of  {{$memoreturnData->total()}} entries
                      </p>
                    {{ $memoreturnData->appends(request()->input())->links() }}
                     @else
                        <p>
                          Showing {{$memoreturnData->count()}} of  {{$memoreturnData->count()}} entries
                        </p>
                    @endif
            	</div>

		    </div>

		    </div>

		</div>

	</div>

</div>

@endsection

@section('modal')

    @include('modals.delete_modal')

@endsection

@section('script')

<script type="text/javascript">
	$(document).on("change", ".check-all", function() {
	if(this.checked)
	{
		$('.check-one:checkbox').each(function() {
			this.checked = true;
		});
	}
	else
	{
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


$(document).on('click','.select_count',function() {

if($(this).is(':checked'))

{

	$('.pro_checkbox').prop('checked', true);

}

else

{

	$('.pro_checkbox').prop('checked', false);

}

productCheckbox();

productCheckboxExport();

});

function productCheckbox()

{

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

		proCheckID.push($(this).val());

});

console.log(proCheckID);

var proexpData =JSON.stringify(proCheckID);

// $('#checkox_pro').val(proexpData);

if(proCheckID.length > 0)

{

	$('#product_export').removeAttr('disabled');

}

else

{

	$('#product_export').attr('disabled',true);

}


}

function productCheckboxExport(){

var proCheckID = [];

$.each($("input[name='all_pro[]']:checked"), function(){

		proCheckID.push($(this).val());

});

var proexpData =	JSON.stringify(proCheckID);

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


	// $(document).ready(function() {
	// 	if($('#return_datatabl').length > 0){
	// 		$('#return_datatabl').DataTable({
 //                "bPaginate": false,
 //                "searching": false
	// 		});
	// 	}
	// });
		$(document).ready(function() {
	     $(document).on('click','.search_btn_field',function() {
            prosearchform();
        });
     $(".sort_search_val").keypress(function(e){
           if(e.which == 13) {
                prosearchform();
            }
        });
		$("#pagination_use_qty").change(function(){
           prosearchform();
        });
	});
function prosearchform(){

    $("#pagination_form").submit();
	}

</script>

@endsection
