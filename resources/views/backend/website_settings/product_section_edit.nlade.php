@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Edit Product Section') }}</h1>
		</div>
	</div>
</div>
<div class="card">

	<form class="p-4" action="{{ route('website.product_section_update', $pro->id) }}" method="POST" enctype="multipart/form-data">
		@csrf
		<div class="card-header px-0">
			<h6 class="fw-600 mb-0">{{ translate('Product Section') }}</h6>
		</div>
		<div class="card-body px-0">
			<div class="form-group row">
				<label class="col-sm-2 col-from-label" for="name">{{translate(' Image')}}</label>
				<div class="col-sm-10">
					<div class="input-group " data-toggle="aizuploader" data-type="image">
							<div class="input-group-prepend">
									<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse') }}</div>
							</div>
							<div class="form-control file-amount">{{ translate('Choose File') }}</div>
							<input type="hidden" name="img" class="selected-files" value="{{ $pro->img }}">
					</div>
					<div class="file-preview">
					</div>
				</div>
			</div>

			<div class="text-right">
				<button type="submit" class="btn btn-primary">{{ translate('Update Page') }}</button>
			</div>
		</div>
	</form>
</div>
@endsection
