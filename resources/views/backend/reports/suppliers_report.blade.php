@extends('backend.layouts.app')
@php  setlocale(LC_MONETARY,"en_US");  @endphp
@section('content')
<style>
.col-md-1.supplier_report.dropdown.right_drop_mune_sec.trans_mi{
	max-width: 90px !important;
	height: 50px;
}
</style>
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Suppliers')}}</h1>
	</div>
</div>
<div class="row">
    <div class="col-md-12 mx-auto">

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form id="sort_products" action="" method="GET">
                <div class="card-header row gutters-5" style="padding-top:0px; padding-right:0px;">
                <div class="col-md-2 ml-auto d-flex" style="margin-bottom: 10px !important;">
                           <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="supplier" id="warehouse_id" data-live-search="true">
                                <option value="" >All Supplier</option>
                                @foreach (App\Seller::all() as $whouse_filter)
                               <option value="{{$whouse_filter->company}}" @if($whouse_filter->company == Request::get('supplier')) selected @endif>{{ $whouse_filter->company }}</option>
                                @endforeach;
                            </select>
                            <button type="submit" id="warehouse_type" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                        </div>
                    <div class="col-md-1 supplier_report dropdown right_drop_mune_sec trans_mi">
                     </form>
                    <div class="list_bulk_btn">
                    <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    <i class="las la-bars fs-20"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                    @if(Auth::user()->user_type == 'admin' || in_array('27', json_decode(Auth::user()->staff->role->inner_permissions)))
                    <form class="" action="{{route('supplier_excel.index')}}" method="post">
                    @csrf
                    <input type="hidden" name="checked_id" id="checkox_pro_export" value="">
                    <button id="product_export" type="submit" class="w-100 exportPro-class" disabled>Bulk export</button>
                    </form>
                    @endif
                   </div>
                    <!--@if(Auth::user()->user_type == 'admin' || in_array('143', json_decode(Auth::user()->staff->role->inner_permissions)))-->
                    <!--<a href="{{Route('supplier_excel.index')}}" id="xls" class="tip" title="" style="text-decoration:none;" data-original-title="Download as XLS">-->
                    <!--<div class="dropdown-menu dropdown-menu-right">-->
                    <!--Excel-->
                    <!--</div>-->
                    <!--</a>-->
                    <!--@endif-->
                    </div>
                    </div>
                </div>
                    <div class="row page_qty_sec product_search_header" style="margin-bottom:15px; margin-top:15px;">
                        <div class="col-2 d-flex page_form_sec" style="padding-left: 0px;">
							<label class="fillter_sel_show">Show</label>
							<select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example" name="pagination_qty">
								<!-- <option value="10" @if($pagination_qty == 10) selected @endif>10</option> -->
								<option value="25" @if($pagination_qty == 25) selected @endif>25</option>
								<option value="50" @if($pagination_qty == 50) selected @endif>50</option>
								<option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                                <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
								<option value="200" @if($pagination_qty == 200) selected @endif>All</option>
							</select>
						</div>
						<div class="col-6 d-flex search_form_sec" style="padding-right: 0px;">
							<label class="fillter_sel_show m-auto"><b>Search</b></label>
                            <input type="text" name="search" class="form-control form-control-sm sort_search_val" style="width:65%;"  @isset($sort_search) value="{{ $sort_search }}" @endisset>
                             <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
                        </div>
                    </div>
				
                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th> <input type="checkbox" class="select_count" id="select_count"  name="all[]"></th>

                            <th>{{ translate('#') }}</th>
                            <th>{{ translate('Company') }}</th>
                            <th>{{ translate('Name ') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Email Address') }}</th>
                            <th>{{ translate('Total Purchases') }}</th>
                            <th>{{ translate('Total Amount') }}</th>
                            <th>{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    @php $count=0; @endphp 
                        @foreach($supplier as $key => $row )
                        <?php $count++; ?>
                        <tr>
                        <td class="text-center"><input type="checkbox" class="pro_checkbox" data-id="{{$row->id}}" name="all_pro[]" value="{{$row->id}}"></td>

                            <td> {{ ($supplier->currentpage()-1) * $supplier->perpage() + $key + 1 }}</td>
                            <td>{{$row->company}} </td>
                            <td> {{$row->name}} </td>
                            <td> {{$row->phone}} </td>
                            <td> {{$row->email}} </td>
                            <td> {{$row->qty}} </td>
                            <td> {{money_format("%(#1n",$row->unit_price)."\n"}} </td>
                            <td> <a href= "{{route('supplier_details_report.index', ['id'=>$row->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}"> View Report </a></td>
                        </tr>
                        @endforeach
                    <tbody>
                       
                    </tbody>

                </table>
                <div class="aiz-pagination">
                    @if($pagination_qty != "all")
                        <p>
                          Showing {{ $supplier->firstItem() }} to {{ $supplier->lastItem() }} of  {{$supplier->total()}} entries
                        </p>
                          {{ $supplier->appends(request()->input())->links() }}
                    @else
                      <p>
                        Showing {{$supplier->count()}} of  {{$supplier->count()}} entries
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
@endsection

