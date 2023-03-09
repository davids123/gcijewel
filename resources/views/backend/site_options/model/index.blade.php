@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="align-items-center">
			<h1 class="h3">{{translate('All Model Number')}}</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
		<div class="card">
		    <div class="card-header row gutters-2">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('All Model Number') }}</h5>
				</div>
				<!-- <div class="col-md-4">
					<form class="" id="sort_brands" action="" method="GET">
						<div class="input-group input-group-sm">
					  		<input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type name & Enter') }}">
						</div>
					</form>
				</div> -->
				<div class="btn-group mr-2" role="group" aria-label="Third group">
					<!-- <a class="btn btn-soft-primary" href="{{route('model.create')}}" title="{{ translate('add') }}">
						Add Model Number	<i class="lar la-plus-square"></i>
					</a> -->
				</div>
		    </div>
		    <div class="card-body">
		        <table class="table mb-0" id="site_model">
		            <thead>
		                <tr>
		                    <th>#</th>
		                    <th class="text-center-">{{translate('Model Number')}}</th>
							<th class="text-center-">{{translate('Desc')}}</th>
							<th class="text-center-">{{translate('Low Stock')}}</th>
		                    <th class="text-center-">{{translate('Options')}}</th>
		                </tr>
		            </thead>
		            <tbody class="text-center-">

		            </tbody>
		        </table>
		    </div>
		</div>
	</div>
	<div class="col-md-5">
	 <div class="card">
		 <div class="card-header row gutters-5">
			 <div class="col text-center text-md-left">
					 <h5 class="mb-0 h6">{{translate('Add New Model Number')}}</h5>
			 </div>
		 </div>
		 <div class="">
			 <form class="p-4" action="{{ route('model.save') }}" method="POST">
					 <input type="hidden" name="option_name" value="model">
					 @csrf
					 <div class="form-group row">
							 <label class="col-sm-3 col-from-label" for="name">
									 {{ translate('Model Number')}}
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
					 <div class="form-group row">
          <label class="col-sm-3 col-from-label" for="name">
              {{ translate('Low Stock')}}
          </label>
          <div class="col-sm-9">
              <input type="number" placeholder="{{ translate('Low Stock')}}" id="low_stock" name="low_stock" class="form-control">
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
	 if($('#site_model').length > 0){
			$('#site_model').DataTable({
             processing: true,
             serverSide: true,
             ajax: "{{route('partners.getAllmodel')}}",
             columns: [
                 { data: 'id' },
                 { data: 'option_value' },
                 { data: 'description' },
                 { data: 'low_stock' },
                 { data: 'link' },
             ]
         });
		}
	});

	function myFunction() {
      if(!confirm("Are You Sure You Want to Delete this Model ?"))
      event.preventDefault();
  }
</script>
@endsection
