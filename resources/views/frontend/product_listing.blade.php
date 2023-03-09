@extends('frontend.layouts.app')
    @if (isset($listingtype))
        @php
            $listingtype=array($listingtype);
            $meta_title = \App\Models\Producttype::whereIn('listing_type',$listingtype)->get();
            $meta_description="";
        @endphp
    @elseif (isset($brand_id))
        @php
            $meta_title = \App\Brand::find($brand_id)->meta_title;
            $meta_description = \App\Brand::find($brand_id)->meta_description;

        @endphp
    @else
        @php
            $meta_title         = get_setting('meta_title');
            $meta_description   = get_setting('meta_description');
        @endphp
    @endif
    @section('meta_title'){{ $meta_title }}@stop
    @section('meta_description'){{ $meta_description }}@stop
    @section('meta')
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="{{ $meta_title }}">
        <meta itemprop="description" content="{{ $meta_description }}">
        <!-- Twitter Card data -->
        <meta name="twitter:title" content="{{ $meta_title }}">
        <meta name="twitter:description" content="{{ $meta_description }}">
        <!-- Open Graph data -->
        <meta property="og:title" content="{{ $meta_title }}" />
        <meta property="og:description" content="{{ $meta_description }}" />
    @endsection
    @section('content')
        <section class="mb-4 pt-3">
            <div class="container sm-px-0">
                <form class="" id="search-form" action="" method="GET">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                <div class="collapse-sidebar c-scrollbar-light text-left">
                                    <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                        <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                        <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                            <i class="las la-times la-2x"></i>
                                        </button>
                                    </div>
                                    <div class="bg-white shadow-sm rounded mb-3 d-none">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Product List')}}
                                        </div>
                                        <div class="p-3">
                                            <ul class="list-unstyled">
                                                @if (!isset($meta_title->id))
                                                    @foreach (\App\Models\Producttype::select('product_types.*')->get() as $category)
                                                        <li class="mb-2 ml-2">
                                                            <a class="text-reset fs-14" href="{{ route('products.listing_type', $category->listing_type) }}"> {{ $category->listing_type }}</a>
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <!-- <li class="mb-2">

                                                        <a class="text-reset fs-14 fw-600" href="{{ route('search') }}">

                                                            <i class="las la-angle-left"></i>

                                                            {{ translate('All Categories')}}

                                                        </a>

                                                    </li> -->
                                                    <li class="mb-2">

                                                        <a class="text-reset fs-14 fw-600" href="{{ route('products.listing_type', \App\Models\Producttype::find($meta_title->id)->listing_type) }}">

                                                            <i class="las la-angle-left"></i>

                                                            {{ \App\Models\Producttype::find($meta_title->id)  }}

                                                        </a>

                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Price range')}}
                                             <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                        </div>
                                        <div class="p-3 micutomelement">
                                            <div class="aiz-range-slider">
                                                <div

                                                id="input-slider-range"

                                                data-range-value-min="@if(\App\Product::count() < 1) 0 @else {{ \App\Product::min('unit_price') }} @endif"

                                                data-range-value-max="@if(\App\Product::count() < 1) 0 @else {{ \App\Product::max('unit_price') }} @endif"

                                                ></div>
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <span class="range-slider-value value-low fs-14 fw-600 opacity-70"

                                                            @if (isset($min_price))

                                                                data-range-value-low="{{ $min_price }}"

                                                            @elseif($products->min('unit_price') > 0)

                                                                data-range-value-low="{{ $products->min('unit_price') }}"

                                                            @else

                                                                data-range-value-low="0"

                                                            @endif

                                                            id="input-slider-range-value-low"

                                                        ></span>

                                                    </div>

                                                    <div class="col-6 text-right">

                                                        <span class="range-slider-value value-high fs-14 fw-600 opacity-70"

                                                            @if (isset($max_price))

                                                                data-range-value-high="{{ $max_price }}"

                                                            @elseif($products->max('unit_price') > 0)

                                                                data-range-value-high="{{ $products->max('unit_price') }}"

                                                            @else

                                                                data-range-value-high="0"

                                                            @endif

                                                            id="input-slider-range-value-high"

                                                        ></span>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                <!-- filter by brand start -->
                                @if(!empty($brand_data))
                                   <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Brand')}}
                                            <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                        </div>
                                        <div class="p-3 micutomelement" >
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                                @foreach ($brand_data as $brand)

                                                    <label class="aiz-checkbox">
                                                        <input  type="checkbox" name="brand_id[]"  value="{{ $brand->brand_id }}" onchange="filter()"  {{ (is_array(Request::get('brand_id')) && in_array($brand->brand_id, Request::get('brand_id'))) ? ' checked' : '' }}>
                                                        <span class="aiz-square-check"></span>
                                                        <span>   {{ translate($brand->name )}}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            
                              <!-- filer by brand end  -->
                              <!-- filter by Metal start -->
                                @if(!empty($categories_data))
                                   <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Categories')}}
                                             <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                        </div>
                                        <div class="p-3 micutomelement" >
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                                @foreach ($categories_data as $category)
                                                    <label class="aiz-checkbox">
                                                        <input  type="checkbox" name="category_id[]"  value="{{ $category->category_id }}" onchange="filter()"  {{ (is_array(Request::get('category_id')) && in_array($category->category_id, Request::get('category_id'))) ? ' checked' : '' }}>
                                                        <span class="aiz-square-check"></span>
                                                        <span>   {{ translate($category->name )}}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                              <!-- filer by category end  -->
                              <!-- filter by model start -->
                                @if(!empty($partnersData_model))
                                   <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Model')}}
                                            <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                        </div>
                                        <div class="p-3 micutomelement">
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                                 @if(Request::get('keyword') != "")
                                                    @foreach($model_key as $r)
                                                        <label class="aiz-checkbox">
                                                            <input  type="checkbox" name="model[]"  value="{{ $r}}" onchange="filter()" {{ (is_array(Request::get('metal')) && in_array($r, Request::get('metal'))) ? ' checked' : '' }} >
                                                            <span class="aiz-square-check"></span>
                                                            <span>   {{ translate($r)}}</span>
                                                        </label>
                                                    @endforeach
                                                @else
                                                    @foreach ($partnersData_model as $model)
                                                        <label class="aiz-checkbox">
                                                            <input  type="checkbox" name="model[]"  value="{{ $model->model }}" onchange="filter()" {{ (is_array(Request::get('model')) && in_array($model->model, Request::get('model'))) ? ' checked' : '' }} >
                                                            <span class="aiz-square-check"></span>
                                                            <span>   {{ translate($model->model )}}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- filer by model end  -->
                                <!-- filter by Metal start -->
                                @if(!empty($partnersData_metal))
                                   <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Metal')}}
                                            <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                        </div>
                                        <div class="p-3 micutomelement">
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                                @if(Request::get('keyword') != "")
                                                    @foreach($metal_key as $r)
                                                        <label class="aiz-checkbox">
                                                            <input  type="checkbox" name="metal[]"  value="{{ $r}}" onchange="filter()" {{ (is_array(Request::get('metal')) && in_array($r, Request::get('metal'))) ? ' checked' : '' }} >
                                                            <span class="aiz-square-check"></span>
                                                            <span>   {{ translate($r)}}</span>
                                                        </label>
                                                    @endforeach
                                                @else
                                                    @foreach ($partnersData_metal as $metal)
                                                        <label class="aiz-checkbox">
                                                            <input  type="checkbox" name="metal[]"  value="{{ $metal->metal }}" onchange="filter()"{{ (is_array(Request::get('metal')) && in_array($metal->metal, Request::get('metal'))) ? ' checked' : '' }} >
                                                            <span class="aiz-square-check"></span>
                                                            <span>   {{ translate($metal->metal )}}</span>
                                                        </label>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                              <!-- filer by Metal end  -->

                              <!-- filter by paper/car start -->

                                <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Paper/cart') }}
                                         <button type="button" style="float: right;" class="micustomtoggle">+</button>
                                    </div>
                                    <div class="p-3 micutomelement">
                                        <div class="aiz-checkbox-list" style="display:grid;height:50px; overflow: auto;">
                                             @if(Request::get('keyword') != "")
                                              @foreach($paperCart_key as $r)

                                                    <label class="aiz-checkbox">
                                                        <input  type="checkbox" name="paper_cart"  value="{{ $r}}" onchange="filter()" {{  (Request::get('paper_cart') ==  $r ? ' checked' : '') }} >
                                                        <span class="aiz-square-check"></span>
                                                        <span>   {{ translate($r)}}</span>
                                                    </label>
                                                @endforeach
                                            @else
                                                @foreach ($paperCart as $r)
                                                        <label class="aiz-checkbox">
                                                            <input  type="checkbox" name="paper_cart"  value="{{ $r->paper_cart }}" onchange="filter()" {{  (Request::get('paper_cart') ==  $r->paper_cart ? ' checked' : '') }} >
                                                            <span class="aiz-square-check"></span>
                                                           <span>   {{ translate($r->paper_cart )}}</span>  
                                                        </label>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                              <!-- filer by paper/cart end  -->

                               <!-- filter by Size start -->
                                @if(!empty($partnersData))
                                   <div class="bg-white shadow-sm rounded mb-3">

                                        <div class="fs-15 fw-600 p-3 border-bottom">

                                            {{ translate('Size')}}
                                            <button type="button" style="float: right;" class="micustomtoggle">+</button>

                                        </div>

                                        <div class="p-3 micutomelement" >
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                            @if(Request::get('keyword') != "")
                                                @foreach($size_key as $r)
                                                    <label class="aiz-checkbox">
                                                        <input  type="checkbox" name="size[]"  value="{{ $r}}" onchange="filter()" {{ (is_array(Request::get('size')) && in_array($r, Request::get('size'))) ? ' checked' : '' }} >
                                                        <span class="aiz-square-check"></span>
                                                        <span>   {{ translate($r)}}</span>
                                                    </label>
                                                @endforeach
                                            @else
                                                @foreach ($partnersData as $size)

                                                    <label class="aiz-checkbox">

                                                        <input  type="checkbox" name="size[]"  value="{{ $size->size }}" onchange="filter()"  {{ (is_array(Request::get('size')) && in_array($size->size, Request::get('size'))) ? ' checked' : '' }}>

                                                        <span class="aiz-square-check"></span>

                                                        <span>   {{ translate($size->size )}}</span>

                                                    </label>

                                                @endforeach
                                            @endif

                                            </div>

                                        </div>

                                    </div>
                                @endif

                                <!-- filer by Size end  -->
                                <!--filter by color start -->
                                @if($listing_type_uni=="Watch Parts")
                                    <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom">
                                            {{ translate('Colors')}}
                                        </div>
                                        <div class="p-3">
                                            <div class="aiz-checkbox-list" style="display:grid;height:100px; overflow: auto;">
                                                @foreach ($product_colors as $color)
                                                    <label class="aiz-checkbox">
                                                        <input  type="checkbox" name="colors[]"  value="{{ $color->colors }}" onchange="filter()"  {{ (is_array(Request::get('colors')) && in_array($color->colors, Request::get('colors'))) ? ' checked' : '' }}>
                                                        <span class="aiz-square-check"></span>
                                                        <span>   {{ translate($color->color_name )}}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif    
                                <!-- filer by color end  -->



                                <!--@foreach ($attributes as $attribute)-->

                                <!--    <div class="bg-white shadow-sm rounded mb-3">-->

                                <!--        <div class="fs-15 fw-600 p-3 border-bottom">-->

                                <!--            {{ translate('Filter by') }} {{ $attribute->getTranslation('name') }}-->

                                <!--        </div>-->

                                <!--        <div class="p-3">-->

                                <!--            <div class="aiz-checkbox-list">-->

                                <!--                @foreach ($attribute->attribute_values as $attribute_value)-->

                                <!--                    <label class="aiz-checkbox">-->

                                <!--                        <input-->

                                <!--                            type="checkbox"-->

                                <!--                            name="selected_attribute_values[]"-->

                                <!--                            value="{{ $attribute_value->value }}" @if (in_array($attribute_value->value, $selected_attribute_values)) checked @endif-->

                                <!--                            onchange="filter()"-->

                                <!--                        >-->

                                <!--                        <span class="aiz-square-check"></span>-->

                                <!--                        <span>{{ $attribute_value->value }}</span>-->

                                <!--                    </label>-->

                                <!--                @endforeach-->

                                <!--            </div>-->

                                <!--        </div>-->

                                <!--    </div>-->

                                <!--@endforeach-->



                                @if (get_setting('color_filter_activation'))

                                    <div class="bg-white shadow-sm rounded mb-3">

                                        <div class="fs-15 fw-600 p-3 border-bottom">

                                            {{ translate('Filter by color')}}

                                        </div>

                                        <div class="p-3">

                                            <div class="aiz-radio-inline">

                                                @foreach ($colors as $key => $color)

                                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ $color->name }}">

                                                    <input

                                                        type="radio"

                                                        name="color"

                                                        value="{{ $color->code }}"

                                                        onchange="filter()"

                                                        @if(isset($selected_color) && $selected_color == $color->code) checked @endif

                                                    >

                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">

                                                        <span class="size-30px d-inline-block rounded" style="background: {{ $color->code }};"></span>

                                                    </span>

                                                </label>

                                                @endforeach

                                            </div>

                                        </div>

                                    </div>

                                @endif



                                {{-- <button type="submit" class="btn btn-styled btn-block btn-base-4">Apply filter</button> --}}

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-9">



                        <ul class="breadcrumb bg-transparent p-0">

                            <li class="breadcrumb-item opacity-50">

                                <a class="text-reset" href="{{ route('home') }}">Home</a>

                            </li>

                            @if(!isset($meta_title->id))

                                <!-- <li class="breadcrumb-item fw-600  text-dark">

                                    <a class="text-reset" href="{{ route('search') }}">"{{ translate('All Categories')}}"</a>

                                </li> -->

                            @else

                                <!-- <li class="breadcrumb-item opacity-50">

                                    <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>

                                </li> -->

                            @endif

                            @if(isset($meta_title->id))

                                <li class="text-dark fw-600 breadcrumb-item">

                                    <a class="text-reset" href="{{ route('products.listing_type', \App\Models\Producttype::find($meta_title->id)->listing_type) }}">"{{ \App\Models\Producttype::find($meta_title->id)-first() }}"</a>

                                </li>

                            @endif

                        </ul>



                        <div class="text-left">

                            <div class="d-flex align-items-center">

                                <div>

                                    <h1 class="h6 fw-600 text-body">

                                        @if(isset($meta_title->id))

                                            {{ \App\Models\Producttype::find($meta_title->id) }}

                                        @elseif(isset($query))

                                            {{ translate('Search result for ') }}"{{ $query }}"

                                        @else

                                            {{ translate('All Products') }}

                                        @endif

                                    </h1>

                                    <input type="hidden" name="keyword" value="{{ $query }}">

                                </div>

                                <!--<div class="form-group ml-auto mr-0 w-200px d-none d-xl-block">-->

                                <!--    @if (Route::currentRouteName() != 'products.brand')-->

                                <!--        <label class="mb-0 opacity-50">{{ translate('Brands')}}</label>-->

                                <!--        <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="brand" onchange="filter()">-->

                                <!--            <option value="">{{ translate('All Brands')}}</option>-->

                                <!--            @foreach (\App\Brand::all() as $brand)-->

                                <!--                <option value="{{ $brand->slug }}" @isset($brand_id) @if ($brand_id == $brand->id) selected @endif @endisset>{{ $brand->getTranslation('name') }}</option>-->

                                <!--            @endforeach-->

                                <!--        </select>-->

                                <!--    @endif-->

                                <!--</div>-->

















                                            <!-- size filter  -->

                                        <!--     <div class="form-group ml-auto mr-0 w-200px d-none d-xl-block">

                                        <label class="mb-0 opacity-50">{{ translate('Size')}}</label>

                                        <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="size" onchange="filter()">

                                            <option value="">{{ translate('All Size')}}</option>

                                            @foreach($partnersData as $row)

                                            <option  value="{{ $row->option_value }}" @isset($size_id) @if ($size_id == $row->id) selected @endif @endisset> {{$row->option_value}}</option>

                                            @endforeach

                                        </select>

                                </div> -->

                                <!-- metal filter  -->

                                <!-- <div class="form-group ml-auto mr-0 w-200px d-none d-xl-block">

                                <label class="mb-0 opacity-50">{{ translate('Metal')}}</label>

                                     <select class="form-control form-control-sm aiz-selectpicker" name="metal" onchange="filter()">

                                     <option value="">{{ translate('All Metal')}}</option>

                                      @foreach($partnersData_metal as $row)

                                      <option  value="{{ $row->option_value }}" @isset($option_id) @if ($option_id == $row->id) selected @endif @endisset> {{$row->option_value}}</option>

                                      @endforeach

                                    </select>

                                </div> -->















                                <div class="form-group w-200px ml-0 ml-xl-3">

                                    <label class="mb-0 opacity-50">{{ translate('Sort by')}}</label>

                                    <select class="form-control form-control-sm aiz-selectpicker" name="sort_by" onchange="filter()">

                                        <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>

                                        <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>

                                        <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>

                                        <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>

                                    </select>

                                </div>

                                <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">

                                    <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">

                                        <i class="la la-filter la-2x"></i>

                                    </button>

                                </div>

                            </div>

                        </div>

                        <input type="hidden" name="min_price" value="">

                        <input type="hidden" name="max_price" value="">

                        <div class="row gutters-5 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2">

                            @foreach ($products as $key => $product)

                                <div class="col">

                                    @include('frontend.partials.product_box_1',['product' => $product])

                                </div>

                            @endforeach

                        </div>

                        <div class="aiz-pagination aiz-pagination-center mt-4">

                            {{ $products->appends(request()->input())->links() }}

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </section>

@endsection

@section('script')

    <script type="text/javascript">

        function filter(){
          setTimeout(function(){
            $('#search-form').submit();
          },1000)

        }

        // setTimeout(filter, 2500);

        function rangefilter(arg){

            $('input[name=min_price]').val(arg[0]);

            $('input[name=max_price]').val(arg[1]);

            filter();

        }

    </script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".micustomtoggle").click(function(){
            $(this).closest("div").siblings(".micutomelement").slideToggle();
        });
    });
</script>

@endsection
