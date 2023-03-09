@extends('backend.layouts.app')
@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<!-- <h1 class="h3">{{translate('All Sequence')}}</h1> -->
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('All Sequence') }}</h5>
				</div>
				@if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->inner_permissions)))
				<div class="btn-group mr-2" role="group" aria-label="Third group">
					<a class="btn btn-soft-primary" href="{{route('sequence.create')}}" title="{{ translate('add') }}">
						Add Sequence	<i class="lar la-plus-square"></i>
					</a>
				</div>
				@endif
		    </div>
			<form class="" id="sort_products" action="" method="GET">
				<div class="card-header row gutters-5 purchases_form_sec">
					<div class="col-md-3 d-flex page_form_secs">
						<label class="fillter_sel_show m-auto"><b>Show</b></label>
						<input type="hidden" name="search" id="searchinputfield">
					        <select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example" name="pagination_qty">

                                <!-- <option value="10" @if($pagination_qty == 10) selected @endif>10</option> -->

                                <option value="25" @if($pagination_qty == 25) selected @endif>25</option>

                                <option value="50" @if($pagination_qty == 50) selected @endif>50</option>

                                <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                                <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>

                                <option value="all" @if($pagination_qty == 'all') selected @endif>All</option>

                                </select>
						<!--<button type="submit" id="purchases_pagi_sub" name="purchases_pagi_sub" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>-->
					</div>
					<div class="col-6 d-flex search_form_sec">
						<label class="fillter_sel_show m-auto"><b>Search</b></label>
						<input type="text" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}"  @endisset>
						<button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
					</div>
				</div>
		    	<div class="card-body">
			        <table class="table aiz-table mb-0">
			            <thead>
			                <tr>
			                    <th>#</th>
		                        <th>{{translate('Sequence Name')}}</th>
		                        <th>{{translate('Sequence Prefix')}}</th>
		                        <th>{{translate('Sequence Start')}}</th>
								@if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->inner_permissions)))<th>{{translate('Cost Code Multiplier')}}</th>
								@endif
			                    <th class="text-right">{{translate('Options')}}</th>
			                </tr>
			            </thead>
			            <tbody>
							@php
								$count = 1;
							@endphp
			                @foreach($partnersData as $key => $optData)
		                    <tr>
	                            <td>{{ $count}}</td>
	                            <td>{{ $optData->sequence_name}}</td>
	                            <td>{{ $optData->sequence_prefix}}</td>
	                            <td>{{ $optData->sequence_start}}</td>
								@if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->inner_permissions)))<td>{{ $optData->cost_code_multiplier}}</td>@endif
		                        <td class="text-right">
															@if(Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->inner_permissions)))
		                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('sequence.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
		                                <i class="las la-edit"></i>
		                            </a>
																@endif
																@if(Auth::user()->user_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->inner_permissions)))
		                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('seqoption.destroy', $optData->id)}}" title="{{ translate('Delete') }}">
		                                <i class="las la-trash"></i>
		                            </a>
																@endif
		                        </td>
		                    </tr>
							@php
								$count++
							@endphp
		                @endforeach
		            </tbody>
		        </table>
			
            <div class="aiz-pagination">
              @if($pagination_qty != "all")
                    <p>
                        Showing {{ $partnersData->firstItem() }} to {{ $partnersData->lastItem() }} of  {{$partnersData->total()}} entries
                      </p>
                    {{ $partnersData->appends(request()->input())->links() }}
                     @else
                        <p>
                          Showing {{$partnersData->count()}} of  {{$partnersData->count()}} entries
                        </p>
                    @endif
            </div>
		        
			</form>
		</div>
	</div>
</div>
</div>
@endsection
@section('modal')
    @include('modals.delete_modal')
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

            prosearchform();

        });
</script>
@endsection
