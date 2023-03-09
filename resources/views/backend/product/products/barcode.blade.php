@extends('backend.layouts.app')
@section('content')
<!-- <div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Listing')}}</h1>
	</div>
</div> -->
<div class="row">
	<div class="col-md-12">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('Print Barcode/Label') }}</h5>
				</div>
				<form class="" action="{{route('barcode_product_excel')}}" method="post">
					@csrf
					<input type="hidden" name="ids" id="checkox_pro" value="">
					<button id="excel_download" type="submit" class="w-100 exportPro-class" >export</button>
				</form>
		        <div class="form-group mb-0">
		            <input type="text" class="form-control form-control-sm" id="search_pro_stock" name="search_pro_stock" size="22" placeholder="{{ translate('Insert Stock Id & Press Enter') }}">
		        </div>
		    </div>
		    <div class="card-body">
				<div class="htmlappend">
				</div>
					<form  action="{{route('products.barcodestore')}}" method="post">
						@csrf
				        <table class="table" id="StockDatahtmlappend">
				            <thead>
				                <tr>
													<th>{{translate('Product Name (Stock Id)')}}</th>
													<th>{{translate('Quantity')}}</th>
				                  <th>{{translate('Options')}}</th>
				                </tr>
				            </thead>
				            <tbody>
									@if(!empty($proarr))
									@foreach($proarr as $proData)
									@php
									  $product_cost = $proData->product_cost;;
                                          $name = $proData->name;
                                          $stock_id = $proData->stock_id;
                                          $model = $proData->model;
                                          $weight = $proData->weight;
                                          $paper_cart = $proData->paper_cart;
                                          if($proData->custom_1 != ""){
                                            $custom_1 = $proData->custom_1;
                                            $custom_1 = $custom_1."-";
                                          }else{
                                            $custom_1 = "";
                                          }
                                          if($proData->custom_2 != ""){
                                            $custom_2 = $proData->custom_2;
                                            $custom_2 = $custom_2."-";
                                          }else{
                                            $custom_2 = "";
                                          }
                                          if($proData->custom_3 != ""){
                                            $custom_3 = $proData->custom_3;
                                            $custom_3 = $custom_3."-";
                                          }else{
                                            $custom_3 = "";
                                          }
                                          if($proData->custom_4 != ""){
                                            $custom_4 = $proData->custom_4;
                                            $custom_4 = $custom_4."-";
                                          }else{
                                            $custom_4 = "";
                                          }
                                          if($proData->custom_5 != ""){
                                            $custom_5 = $proData->custom_5;
                                            $custom_5 = $custom_5."-";
                                          }else{
                                            $custom_5 = "";
                                          }
                                          if($proData->custom_6 != ""){
                                            $custom_6 = $proData->custom_6;
                                            $custom_6 = $custom_6."-";
                                          }else{
                                            $custom_6 = "";
                                          }
                                          if($proData->custom_7 != ""){
                                            $custom_7 = $proData->custom_7;
                                            $custom_7 = $custom_7."-";
                                          }else{
                                            $custom_7 = "";
                                          }
                                          if($proData->custom_8 != ""){
                                            $custom_8 = $proData->custom_8;
                                            $custom_8 = $custom_8."-";
                                          }else{
                                            $custom_8 = "";
                                          }
                                          if($proData->custom_9 != ""){
                                            $custom_9 = $proData->custom_9;
                                            $custom_9 = $custom_9."-";
                                          }else{
                                            $custom_9 = "";
                                          }
                                          if($proData->custom_10 != ""){
                                            $custom_10 = $proData->custom_10;
                                            $custom_10 = $custom_10."-";
                                          }else{
                                            $custom_10 = "";
                                          }
                                          if($proData->weight != ""){
                                            $weight = $proData->weight;
                                            $weight = $weight."-";
                                          }else{
                                            $weight = "";
                                          }
                                          if($proData->paper_cart != ""){
                                            $paper_cart = $proData->paper_cart;
                                            $paper_cart = $paper_cart."-";
                                          }else{
                                            $paper_cart = "";
                                          }
									@endphp
									<tr data-id="{{ $proData->id}}">
										<td class="returnData" >{{ $proData->name }} ({{$model}}{{$weight}} {{$paper_cart}} {{$custom_1}} {{$custom_2}} {{$custom_3}}  {{$custom_4}} {{$custom_5}}  {{$custom_6}}  {{$custom_7}}  {{$custom_8}}  {{$custom_9}} {{$custom_10}}({{$stock_id}}))
										<input type="hidden" class="barcode_id" data-id="{{$proData->id}}" name="all_pro[]" value="{{$proData->id}}"></td>
										<td  class="returnData" ><input type='text' class='form-control' name="proarrkey[{{$proData->id}}]" value='1'></td>
										<td><button type='button' class='btn btn-danger removeStockData' name='button'><i class='las la-trash'></i></button></td>
									</tr>
									@endforeach
									@endif
				            </tbody>
				        </table>
				        
						<button type="submit" id="rmCookiebarcode" class="btn btn-success triggerbarcode" name="update">Get Barcode/Label</button>
						<input type="hidden" name="ispdfprint" class="pdfprint genratepropdf" value="">
						<a href="#" class="genratepropdf" name="button"><button  type="submit" id="" class="btn btn-warning" name="update">Print Pdf</button></a>
					</form>
			    </div>
			</div>
		</div>
	</div>
	<div class="row">
		@if($proarr != "")
			<!--<a href="#" type="button" class="btn btn-primary w-100 genratepropdf" name="button">Pdf</a> <br>-->
			<!-- <a href="{{route('barcode_product_excel')}}" type="button" class="btn btn-primary w-100 " name="button">Excel</a> -->
			<!-- <button  class="excel_download">excel </button> -->
			@foreach($proarr as $proData)
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body custom_barcode_css">
							{!! DNS1D::getBarcodeHTML($proData->stock_id, 'C39+',1,30,'black', true) !!}
						</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>
</div>
@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection

@section('script')
<script>
	$(document).ready(function() {
		$(document).on('click','#excel_download',function(){
            //productCheckbox();
            	var proCheckID = [];
            var ids=$('.barcode_id').val();
    	$.each($("input[name='all_pro[]']"), function(){
		proCheckID.push($(this).val());
            // alert(proCheckID);
            console.log(proCheckID);
            	var proexpData =	JSON.stringify(proCheckID);
		        $('#checkox_pro').val(proexpData);
    	});
		});
	});
	
// 	function productCheckbox(){
// 		var proCheckID = [];
// 		$.each($("input[name='all_pro[]']"), function(){
// 		proCheckID.push($(this).val());
// 	});
// 	console.log(proCheckID);
// 	var proexpData =	JSON.stringify(proCheckID);
// 		$('#checkox_pro').val(proexpData);
// 			if(proCheckID.length > 0){
//   				$('#excel_download').removeAttr('disabled');
//   			}else{
//   				$('#excel_download').attr('disabled',true);
//   			}
// 	}
$("#rmCookiebarcode").on('click', function(){
    window.reload();
});

</script>







<script type="text/javascript">
function micustomPrint(){
	$('.no-print').hide();
	$('.hideonprint').hide();
	$('.micustomclose').hide();
	$('.micustomPrem').addClass("samClass");
	var printContents = document.getElementById("orderRetModal").innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = originalContents;
	window.print();
	$('.hideonprint').show();
	$('.micustomclose').show();
	$('.micustomPrem').show();
	$('.no-print').show();
	$('.micustomPrem').removeClass("samClass");
	 return true;
	}
	// function micustomPrint()
  // {
  //     $('.aiz-main-content').hide();
  //     var mywindow = window.open();
  //     var content = document.getElementById('orderRetModal').innerHTML;
  //     var realContent = document.body.innerHTML;
  //     mywindow.document.write(content);
  //     mywindow.document.close(); // necessary for IE >= 10
  //     mywindow.focus(); // necessary for IE >= 10*/
  //     mywindow.print();
  //     document.body.innerHTML = realContent;
  //     mywindow.close();
  //         $('.aiz-main-content').show();
  //     return true;
  // }
	jQuery(document).on('click','.micustomclose',function() {
	    // jQuery('#orderRetModal').hide();
			jQuery('#orderRetModal').css({
        'z-index': '1040',
        'display': 'none'
    });
			jQuery('.modal-stack').css({
        'display': 'none'
    });
	});
$(document).ready(function() {
	$(document).on('click','.pro_checkbox',function(){
		productCheckbox();
		productCheckboxExport();
	});
});
function productCheckbox(){
	var proCheckID = [];
	$.each($("input[name='all_pro[]']:checked"), function()
	{
		proCheckID.push($(this).val());
	});
	console.log(proCheckID);
	var proexpData =	JSON.stringify(proCheckID);
	$('#checkox_pro').val(proexpData);
	if(proCheckID.length > 0){
		$('#product_export').removeAttr('disabled');
	}else{
		$('#product_export').attr('disabled',true);
	}
	if(proCheckID.length > 0)
	{
		$('#product_delete').removeAttr('disabled');
		$('#product_delete').addClass('hoverProBtn');
	}
	else
	{
		$('#product_delete').attr('disabled',true);
		$('#product_delete').removeClass('hoverProBtn');
	}
}
function productCheckboxExport()
{
	var proCheckID = [];
	$.each($("input[name='all_pro[]']:checked"), function()
	{
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
	if(proCheckID.length > 0)
	{
		$('#product_delete').removeAttr('disabled');
	}
	else
	{
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
	if ($(this).prop('checked')==true)
	{
		var FilterDefaultVal = $('.default-filter-check-value').val();
	if(FilterDefaultVal != '')
	{
		var FilterDefaultValData =  JSON.parse(FilterDefaultVal);
		$('.filtered_field').prop('checked',false);
		console.log(FilterDefaultValData);
		$.each( FilterDefaultValData, function( keyFilter, valFilter )
		{
			$('#filteredColOpt .'+keyFilter).prop('checked',true);
			console.log(valFilter);
		});
	}
	}
	else
	{
		$('.filtered_field').prop('checked',false);
	}
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
</script>
@endsection
