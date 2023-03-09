@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Product Section') }}</h1>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<h6 class="mb-0 fw-600">{{ translate('Product Section') }}</h6>
	</div>
	<div class="card-body">
		<table class="table aiz-table mb-0">
        <thead>
            <tr>
                <th >#</th>
                <th>{{translate('Name')}}</th>
                <th >{{translate('Image')}}</th>
                <th >{{translate('Actions')}}</th>
            </tr>
        </thead>
        <tbody>
        	@foreach (\App\ProductSection::all() as $key => $page)
        	<tr>
        		<td>{{ $key+2 }}</td>
        		<td>{{$page->name}}</td>
        		<td>   <img loading="lazy"  src="{{ uploaded_asset($page->img) }}" alt="" class="img-responsive" style="width:80px; height:80px;"></td>
        		<td><a href="{{Route('website.product_section_edit',$page->id)}}" class="btn btn-icon btn-circle btn-sm btn-soft-primary" title="Edit">
							<i class="las la-pen"></i>
					</a>
				</td>
        	</tr>
        	@endforeach
        </tbody>
    </table>
	</div>
</div>
@endsection


