@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Metals')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('All Metals') }}</h5>
				</div>
				<!-- <div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div> -->
				<div class="btn-group mr-2" role="group" aria-label="Third group">
					<!-- <a class="btn btn-soft-primary" href="{{route('metal.create')}}" title="{{ translate('add') }}">
						Add Metals	<i class="lar la-plus-square"></i>
					</a> -->
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table mb-0" id="site_metal">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th>{{translate('Metal Name')}}</th>
							<th>{{translate('Desc')}}</th>
		                    <th>{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody>

		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
	<div class="col-md-5">
 <div class="card">
	 <div class="card-header row gutters-5">
	 <div class="col text-center text-md-left">
			 <h5 class="mb-0 h6">{{translate('Add New Metal')}}</h5>
	 </div>
	 </div>
	 <div class="">
		 <form class="p-4" action="{{ route('metal.save') }}" method="POST">
				 <input type="hidden" name="option_name" value="metal">
				 @csrf
				 <div class="form-group row">
						 <label class="col-sm-3 col-from-label" for="name">
								 {{ translate('Metal')}}
						 </label>
						 <div class="col-sm-9">
								 <input type="text" placeholder="{{ translate('Name')}}" id="option_value" name="option_value" class="form-control" required>
								 @error('option_value')
								 <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
								 @enderror
						 </div>
				 </div>
				 <div class="form-group row">
						 <label class="col-sm-3 col-from-label" for="name">
								 {{ translate('Description')}}
						 </label>
						 <div class="col-sm-9">
									 <textarea name="description" rows="8" cols="80" class="form-control"></textarea>
						 </div>
				 </div>
				 <div class="form-group mb-0 text-right">
						 <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
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
<script type="text/javascript">
 $(document).ready(function() {
	 if($('#site_metal').length > 0){
			$('#site_metal').DataTable({
             processing: true,
             serverSide: true,
             ajax: "{{route('partners.getAllmetal')}}",
             columns: [
                 { data: 'id' },
                 { data: 'option_value' },
                 { data: 'description' },
                 { data: 'link' },
             ]
         });
		}
	});
	

  function myFunction() {
      if(!confirm("Are You Sure You Want to Delete this Metal ?"))
      event.preventDefault();
  }

</script>
@endsection
