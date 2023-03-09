@extends('backend.layouts.app')

<style>
    .catgers_table td {
    width: 33.33%;
    text-align: center;
    padding: 70px !important;
    color:#fff;
    font-size:30px !important;
    }
    .cat_name{
        background-color:#5bc0de;
    }
    .cat_velu{
        background-color:#428bca;
    }
    .cat_pric{
        background-color:#78cd51;
    }
    .chartWrapper {
        position: relative;
    }
    .chartWrapper > canvas {
        position: absolute;
        left: 0;
        top: 0;
        pointer-events:none;
    }
    .chartAreaWrapper {
      overflow-x: scroll;
        position: relative;
        width: 100%;
    }
    .chartAreaWrapper2 {
        position: relative;
        height: 600px;
    }
    .chartWrapperScnd {
    position: relative;
    }
    .chartWrapperScnd > canvas {
        position: absolute;
        left: 0;
        top: 0;
        pointer-events:none;
    }
    .chartAreaWrapperScnd {
      overflow-x: scroll;
        position: relative;
        width: 100%;
    }
    .chartAreaWrapper2Scnd {
        position: relative;
        height: 600px;
    }
</style>
@section('content')
  @if(Auth::user()->user_type == 'admin' || in_array('310', json_decode(Auth::user()->staff->role->permissions)))
    @if(env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
        <div class="">
            <div class="alert alert-danger d-flex align-items-center">
                {{translate('Please Configure SMTP Setting to work all email sending functionality')}},
                <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
            </div>
        </div>
    @endif
        <div class="row gutters-10">
            <div class="col-lg-12">
                <div class="row gutters-10">
                    @if(Auth::user()->user_type == 'admin' || in_array('501', json_decode(Auth::user()->staff->role->inner_permissions)))
                    <div class="col-6">
                        <a href="{{route('job_orders.index')}}"   class="aiz-side-nav-link">
                            <div class="bg-grad-2 text-white rounded-lg mb-4 overflow-hidden">
                                <div class="px-3 pt-3">
                                    <div class="opacity-50">
                                        <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                        {{ translate('Job Orders') }}
                                    </div>
                                    <div class="h3 fw-700 mb-3">{{ $joCountQry }}</div>
                                    @php echo $joCountQry; @endphp
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if(Auth::user()->user_type == 'admin' || in_array('502', json_decode(Auth::user()->staff->role->inner_permissions)))
                    <div class="col-6">
                        <a href="{{route('products.available.products')}}"   class="aiz-side-nav-link">
                            <div class="bg-grad-3 text-white rounded-lg mb-4 overflow-hidden">
                                <div class="px-3 pt-3">
                                    <div class="opacity-50">
                                        <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                        {{ translate('Available Inventory') }}
                                    </div>
                                    <div class="h3 fw-700 mb-3">{{$productQry}}</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                    </a>
                    </div>
                    @endif

                    @if(Auth::user()->user_type == 'admin' || in_array('503', json_decode(Auth::user()->staff->role->inner_permissions)))
                    <div class="col-6">
                        <a href="{{route('memo.index')}}"   class="aiz-side-nav-link">
                            <div class="bg-grad-1 text-white rounded-lg mb-4 overflow-hidden">
                                <div class="px-3 pt-3">
                                    <div class="opacity-50">
                                        <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                        {{ translate('Memos') }}
                                    </div>
                                    <div class="h3 fw-700 mb-3">
                                    {{ $memoQuery }}
                                </div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                    @endif
                    @if(Auth::user()->user_type == 'admin' || in_array('504', json_decode(Auth::user()->staff->role->inner_permissions)))
                    <div class="col-6">
                        <a href="{{route('average_cost_report.index')}}"   class="aiz-side-nav-link">
                            <div class="bg-grad-4 text-white rounded-lg mb-4 overflow-hidden">
                                <div class="px-3 pt-3">
                                    <div class="opacity-50">
                                        <span class="fs-12 d-block">{{ translate('Total') }}</span>
                                        {{ translate('Average Cost Report') }}
                                    </div>
                                    <div class="h3 fw-700 mb-3">{{ $average_cost }}</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.3)" fill-opacity="1" d="M0,128L34.3,112C68.6,96,137,64,206,96C274.3,128,343,224,411,250.7C480,277,549,235,617,213.3C685.7,192,754,192,823,181.3C891.4,171,960,149,1029,117.3C1097.1,85,1166,43,1234,58.7C1302.9,75,1371,149,1406,186.7L1440,224L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    @php
        setlocale(LC_MONETARY,"en_US");
    @endphp
    <div class="card">
        <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist" style="display:-webkit-inline-box;">
            @if(Auth::user()->user_type == 'admin' ||in_array('86', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;" >
                    <a class="nav-link active" style="width:auto;" id="ex2-tab-1" data-toggle="tab" href="#summarypane" role="tab" aria-controls="ex2-tabs-1" aria-selected="true"> Summary </a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' ||in_array('87', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;">
                    <a class="nav-link" style="width:auto;"  id="ex2-tab-2" data-toggle="tab" href="#memo" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Memo</a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' ||in_array('88', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;">
                    <a class="nav-link" style="width:auto;" id="ex2-tab-3" data-toggle="tab" href="#quotations" role="tab" aria-controls="ex2-tabs-3" aria-selected="false">Quotations</a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' ||in_array('89', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;">
                    <a class="nav-link" style="width:auto;" id="ex2-tab-4" data-toggle="tab" href="#job_orders" role="tab" aria-controls="ex2-tabs-4" aria-selected="false">Job Orders</a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('84', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;">
                  <a class="nav-link Customers" style="width:auto;" id="ex2-tab-5"  data-toggle="tab" href="#Customers" role="tab" aria-controls="ex2-tabs-5" aria-selected="false">Customers</a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('85', json_decode(Auth::user()->staff->role->inner_permissions)))
                <li class="nav-item" role="presentation" style="width:auto !important;">
                  <a class="nav-link"  style="width:auto;" id="ex2-tab-6" data-toggle="tab" href="#suppliers" role="tab" aria-controls="ex2-tabs-6" aria-selected="false">Suppliers</a>
                </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('144', json_decode(Auth::user()->staff->role->inner_permissions)))
            <li class="nav-item" role="presentation" style="width:auto !important;">
              <a class="nav-link" style="width:auto;" id="ex2-tab-7" data-toggle="tab" href="#wearhouse" role="tab" aria-controls="ex2-tabs-7" aria-selected="false" >Warehouse Stock Chart</a>
            </li>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('145', json_decode(Auth::user()->staff->role->inner_permissions)))
            <li class="nav-item" role="presentation" style="width:auto !important;">
                <a class="nav-link low_stock_data" style="width:auto;" id="ex2-tab-8" data-toggle="tab" href="#low_stock_data" role="tab" aria-controls="ex2-tabs-8" aria-selected="false">Low Stock</a>
            </li>
            @endif
        </ul>
        <!-- Tabs navs -->
        <!-- Tabs content -->
        <div class="tab-content" id="ex2-content">
                    @if(Auth::user()->user_type == 'admin' || in_array('86', json_decode(Auth::user()->staff->role->inner_permissions)))
            <div class="tab-pane fade show active" id="summarypane" role="tabpanel" aria-labelledby="ex2-tab-1">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form class="" action="" method="GET">
                                <div class="card-header row gutters-5">
                                    <div class="col text-center text-md-left d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <h5 class="mb-md-0 h6">{{ translate('All Summary') }}</h5>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-center justify-content-between">
                                            <span><b>Search</b></span>
                                            <input type="text" name="summarypane_s" class="form-control form-control-sm sort_search_val">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table aiz-table mb-0  mytable" id="memoAjaxDA">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{translate('Company Name')}}</th>
                                                <th>{{translate('Open Balance')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($all_summary as $key => $optData)
                                                <tr data-id="{{ $optData->company_id}}" data-company="{{ $optData->company}}">
                                                    <td data-toggle="modal" data-id="{{ $optData->company}}" data-target="#memoModal">{{ ($all_summary->currentpage()-1) * $all_summary->perpage() + $key + 1 }}</td>
                                                    <td data-toggle="modal" data-id="{{ $optData->company}}" data-target="#memoModal">{{ $optData->company}}</td>
                                                    <td data-toggle="modal" data-id="{{ $optData->company}}" data-target="#memoModal">{{ money_format("%(#1n", $optData->memoSubTotal)."\n"}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{$all_summary->appends(request()->input('summarypane'))->links()}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('87', json_decode(Auth::user()->staff->role->inner_permissions)))
            <div class="tab-pane fade" id="memo" role="tabpanel" aria-labelledby="ex2-tab-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form class=""  action="" method="GET">
                                <div class="card-header row gutters-5">
                                    <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <h5 class="mb-md-0 h6">{{ translate('All Memo') }}</h5>
                                        </div>
                                        <div class="col-md-4  d-flex align-items-center justify-content-between">
                                            <span><b>Search</b></span>
                                            <input type="text" name="memo_s" class="form-control form-control-sm sort_search_val">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table aiz-table mb-0" id="memo_data_datatbl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{translate('Memo Number')}}</th>
                                                <th>{{translate('Company Name')}}</th>
                                                <th>{{translate('Open Balance')}}</th>
                                                <th>{{translate('Date')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($memo_details as $key => $optData)
                                                <tr>
                                                    <td> <a  href="{{route('memo.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" style="cursor:pointer;tex-decoration:none;color:#000;">{{ ($memo_details->currentpage()-1) * $memo_details->perpage() + $key + 1 }}</a></td>

                                                    <td><a  href="{{route('memo.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" style="cursor:pointer;tex-decoration:none;color:#000;">{{ $optData->memo_number}}</a></td>

                                                    <td><a  href="{{route('memo.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" style="cursor:pointer;tex-decoration:none;color:#000;"> {{$optData->company}}</a></td>

                                                    <td><a  href="{{route('memo.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" style="cursor:pointer;tex-decoration:none;color:#000;"> {{ money_format("%(#1n", $optData->sub_total)."\n"}}</a> </td>

                                                    <td><a  href="{{route('memo.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" style="cursor:pointer;tex-decoration:none;color:#000;">{{ date("m/d/Y", strtotime($optData->date))}} </a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{$memo_details->appends(request()->input('memo'))->links()}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('88', json_decode(Auth::user()->staff->role->inner_permissions)))
            <div class="tab-pane fade" id="quotations" role="tabpanel" aria-labelledby="ex2-tab-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header row gutters-5">
                                <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                    <div class="col-md-6">
                                        <h5 class="mb-md-0 h6">{{ translate('All Quotations') }}</h5>
                                    </div>
                                    <div class="col-md-4  d-flex align-items-center justify-content-between">
                                        <span><b>Search</b></span>
                                        <input type="text" name="Quotations" class="form-control form-control-sm sort_search_val">
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                <table class="table aiz-table mb-0">

                                    <thead>

                                        <tr>

                                            <!-- <th>#</th> -->

                                            <th>{{translate('Date')}}</th>

                                            <th>{{translate('Reference No.')}}</th>

                                            <th>{{translate('Customer')}}</th>

                                            <th>{{translate('Status')}}</th>

                                            <th>{{translate('Amount')}}</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                                <div class="aiz-pagination">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('89', json_decode(Auth::user()->staff->role->inner_permissions)))
            <div class="tab-pane fade" id="job_orders" role="tabpanel" aria-labelledby="ex2-tab-4">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card">
                            <form class=""  action="" method="GET">
                                <div class="card-header row gutters-5">
                                    <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <h5 class="mb-md-0 h6">{{ translate('All Job Orders') }}</h5>
                                        </div>
                                        <div class="col-md-4  d-flex align-items-center justify-content-between">
                                          <span><b>Search</b></span>
                                          <input type="text" name="job_orders_s" class="form-control form-control-sm sort_search_val">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table aiz-table mb-0" id="job_orders_filter">
                                        <thead>
                                            <tr>
                                                <th>#</th>

                                                <th>{{translate('Job Order')}}</th>

                                                <th>{{translate('Name')}}</th>

                                                <th>{{translate('Model Number')}}</th>

                                                <th> {{translate('Job Status')}}</th>

                                                <th>{{translate('Date Entered')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $count=0; @endphp
                                            @foreach($jobOrderData as $key =>  $optData)
                                                @php $count++; @endphp
                                                <tr>

                                                    <td>{{ ($jobOrderData->currentpage()-1) * $jobOrderData->perpage() + $key + 1 }}</td>

                                                    <td>   <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">{{$optData->job_order_number}} </a></td>
                                                    @if($optData->customer_group=="retail")
                                                    <td>  <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">{{$optData->cu_name}}</a></td>
                                                    @else
                                                    <td>  <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">{{$optData->company}}</a></td>
                                                    @endif
                                                    <td>  <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">{{$optData->model_number}} </a></td>
                                                    @php
                                                       $current_date= date('Y-m-d', strtotime("-4 days"));
                                                       $past_date=date('Y-m-d', strtotime($optData->estimated_date_return));
                                                    @endphp
                                                    <td>  <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">
                                                            @if($current_date > $past_date )
                                                               <p style="color:red;">Post Due </p>
                                                            @else
                                                                {{translate('Open')}}
                                                            @endif

                                                   </a></td>

                                                    <td>  <a  href="{{ route('job_orders.edit',['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" target="_blank" style='text-decoration:none;color:#000;' title="{{ translate('edit') }}">{{date('m/d/20y',strtotime($optData->estimated_date_return))}} </a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="aiz-pagination">
                                        {{ $jobOrderData->appends(request()->input('job_orders'))->links() }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('84', json_decode(Auth::user()->staff->role->inner_permissions)))
        <div class="tab-pane fade" id="Customers" role="tabpanel" aria-labelledby="ex2-tab-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form class="" action="" method="GET">
                            <div class="card-header row gutters-5">
                                <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                    <div class="col-md-6">
                                        <h5 class="mb-md-0 h6">{{ translate('All Customer') }}</h5>
                                    </div>
                                    <div class="col-md-4  d-flex align-items-center justify-content-between">
                                        <span><b>Search</b></span>
                                        <input type="text" name="Customers_s" class="form-control form-control-sm sort_search_val">
                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <table class="table aiz-table mb-0" id="customerdataTbl">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{translate('Company')}}</th>
                                            <th>{{translate('open balance')}}</th>
                                            <th>{{translate('Name')}}</th>
                                            <th>{{translate('Phone no.')}}</th>
                                            <th>{{translate('Email address')}}</th>
                                            <th>{{translate('value')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($summery_details as $key => $optData)
                                            <tr>

                                                <td>{{ ($summery_details->currentpage()-1) * $summery_details->perpage() + $key + 1 }}</td>

                                                <td>{{ $optData->company}}</td>

                                                <td>{{money_format("%(#1n",$optData->memoSubTotal)."\n" }}</td>

                                                <td>{{ $optData->c_name}}</td>

                                                <td>{{ $optData->phone}}</td>

                                                <td>{{ $optData->email}}</td>

                                                <td> @if($optData->memoSubTotal >= $optData->totalProCost){{money_format("%(#1n",$optData->memoSubTotal-$optData->totalProCost)."\n" }} @else {{money_format("%(#1n",$optData->totalProCost)."\n" }} @endif</td>

                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="aiz-pagination">
                                    {{   $summery_details->appends(['Customers' => ''])}}
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(Auth::user()->user_type == 'admin' || in_array('85', json_decode(Auth::user()->staff->role->inner_permissions)))
        <div class="tab-pane fade" id="suppliers" role="tabpanel"   aria-labelledby="ex2-tab-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <form class="" action="" method="GET">
                            <div class="card-header row gutters-5">
                                <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                    <div class="col-md-6">
                                        <h5 class="mb-md-0 h6">{{ translate('All Suppliers') }}</h5>
                                    </div>
                                    <div class="col-md-4  d-flex align-items-center justify-content-between">
                                        <span><b>Search</b></span>
                                        <input type="text" name="suppliers_s" class="form-control form-control-sm sort_search_val">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table aiz-table mb-0" id="supplierTbl">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{translate('Company')}}</th>

                                            <th>{{translate('Name')}}</th>

                                            <th>{{translate('Phone no.')}}</th>

                                            <th>{{translate('Email address')}}</th>

                                            <th>{{translate('value')}}</th>

                                            <!-- <th>{{translate('Total Amount')}}</th> -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Customer_details as $key => $optData)
                                            <tr>
                                                <td>{{ ($Customer_details->currentpage()-1) * $Customer_details->perpage() + $key + 1 }}</td>

                                                <td>@if($optData->customer_group=="reseller"){{ $optData->company}} @else {{$optData->customer_name}} @endif</td>

                                                <td>{{ $optData->customer_name}}</td>

                                                <td>{{ $optData->phone}}</td>

                                                <td>{{ $optData->email}}</td>

                                                <td>{{money_format("%(#1n",$optData->totalProCost)."\n" }}</td>

                                                <!-- <td>{{ $optData->company}}</td> -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="aiz-pagination">
                                    {{ $Customer_details->appends(['suppliers' => ''])->links()}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(Auth::user()->user_type == 'admin' || in_array('144', json_decode(Auth::user()->staff->role->inner_permissions)))
        <div  class="tab-pane fade" id="wearhouse" role="tabpanel" aria-labelledby="ex2-tab-7">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">

                        <div class="card-header row gutters-5">

                            <div class="col text-center text-md-left">

                                <h5 class="mb-md-0 h6">{{ translate('All Warehouse') }}</h5>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="card">
                                        <!--card body-->
                                        <form class="warehouse_table" id="sort_products" action="" method="GET">
                                            <div class="row page_qty_sec product_search_header">
                                                <div class="col-md-4 warehouse_tab">
                                                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="warehouse_id" id="warehouse_id" data-live-search="true">
                                                        <option value="">All Warehouse</option>
                                                        @foreach ($warehouseDataFltr as $whouse_filter)
                                                            <option value="{{$whouse_filter->id}}" @if($whouse_filter->id == Request::get('warehouse_id')) selected @endif>{{ $whouse_filter->name }}</option>
                                                        @endforeach;
                                                    </select>
                                                    <button type="submit" id="warehouse_type" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                                                </div>
                                                <div class="col-md-4 warehouse_tab">
                                                    <!-- <label class="fillter_sel_show m-auto"><b>Stock</b></label> -->
                                                    <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="stock" id="stock_filter_type" data-live-search="true">
                                                        <!-- <option value="">Select Stock</option> -->
                                                        <option value="">All</option>
                                                        <option value="2" @if(Request::get('stock')==2) selected @endif>Available</option>
                                                        <option value="3"  @if(Request::get('stock')==3) selected @endif>On Memo</option>
                                                    </select>
                                                    <button type="submit" id="stock_filter_btn" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                                                </div>
                                                <div class="col-md-4 warehouse_tab">
                                                    <!-- <label class="fillter_sel_show m-auto"><b>Value</b></label> -->
                                                         @php $value= Request::get('value'); @endphp
                                                        <input type="hidden" value="{{$value}}" id="value_w">
                                                        <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="value" id="warehouse_values" data-live-search="true">
                                                            <option value="">Select Values</option>
                                                            <option value="1" @if(Request::get('value')==1) selected @endif>Gross </option>
                                                            <option value="2" @if(Request::get('value')==2) selected @endif>Net</option>
                                                        </select>
                                                        <button type="submit" id="values_filterbtn" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                                        </div>
                                        <div class="card-body" style="width: 100%;">

                                           <table class="table aiz-table mb-0">
                                            <tbody>
                                                @php
                                                 $totalcount=0;
                                                 $totalamount=0;
                                                 $totalamountnet=0;
                                                 $totalcountnet=0;
                                                @endphp
                                                @if($value == 2)
                                                @foreach($mergedNetAmount as $mrkey => $mrwarehouse)
                                                @php
                                                    $lskeynet = $mrkey;
                                                    $totalcountnet = $totalcountnet += $mrwarehouse[1];
                                                    $totalamountnet = $totalamountnet += $mrwarehouse[0];
                                                @endphp
                                                <tr class="catgers_table">
                                                    <td class="cat_name">{{$mrkey}} </td>
                                                    <td class="cat_velu">{{$mrwarehouse[1]}}  </td>
                                                    <td class="cat_pric">{{ money_format("%(#1n", $mrwarehouse[0])."\n"}} <br>
                                                    <span style='text-align:center ;cursor:pointer;'data-toggle="modal" data-id="" onclick="warehousedataAjax('{{$mrkey}}')" > <i class="las la-eye"></i></span></td>
                                                </tr>
                                                @endforeach
                                                @php  $lskeynet=""; @endphp
                                                <tr class="catgers_table">
                                                     <td class="cat_name"> Total</td>
                                                     <td class="cat_velu"> {{$totalcountnet}}</td>
                                                    <td class="cat_pric">
                                                    {{ money_format("%(#1n", $totalamountnet)."\n"}}
                                                    <br><span style='text-align:center ;cursor:pointer;'data-toggle="modal" onclick="warehousedataAjax('{{$lskeynet}}')" data-id=""> <i class="las la-eye"></i></span></td>
                                                </tr>
                                                @else
                                               @foreach($all_warehouse as $key=>$warehouse)
                                                    @php
                                                    //dd($warehouse->listing_type);
                                                        $listingtype=$warehouse->listing_type;
                                                        $totalcount= $totalcount+=$warehouse->total_count;
                                                        $totalamount=$totalamount+=$warehouse->totalPrice;
                                                    @endphp
                                                      <tr class="catgers_table">
                                                          <td class="cat_name">{{$listingtype}} </td>
                                                          <td class="cat_velu">{{$warehouse->total_count}}  </td>
                                                          <td class="cat_pric">{{ money_format("%(#1n", $warehouse->totalPrice)."\n"}} <br>
                                                          <span style='text-align:center ;cursor:pointer;'data-toggle="modal" data-id="" onclick="warehousedataAjax('{{$listingtype}}')" > <i class="las la-eye"></i></span></td>
                                                      </tr>
                                                @endforeach

                                                @php  $listingtype="" ; @endphp
                                                <tr class="catgers_table">
                                                     <td class="cat_name"> Total</td>
                                                     <td class="cat_velu"> {{$totalcount}}</td>
                                                    <td class="cat_pric">
                                                    {{ money_format("%(#1n", $totalamount)."\n"}}
                                                    <br><span style='text-align:center ;cursor:pointer;'data-toggle="modal" onclick="warehousedataAjax('{{$listingtype}}')" data-id=""> <i class="las la-eye"></i></span></td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(Auth::user()->user_type == 'admin' || in_array('145', json_decode(Auth::user()->staff->role->inner_permissions)))

            <!-- low stock  -->
            <div class="tab-pane fade" id="low_stock_data" role="tabpanel"  aria-labelledby="ex2-tab-8">

                <div class="row">

                    <div class="col-md-12">

                        <div class="card">
                            <form class="" action="" method="GET">
                                <div class="card-header row gutters-5">
                                    <div class="col text-center text-md-left  d-flex align-items-center justify-content-between">
                                        <div class="col-md-6">
                                            <h5 class="mb-md-0 h6">{{ translate('All Low Stock') }}</h5>
                                        </div>
                                        <div class="col-md-4  d-flex align-items-center justify-content-between">
                                          <span><b>Search</b></span>
                                          <input type="text" name="low_stock_data_s" class="form-control form-control-sm sort_search_val">
                                        </div>
                                    </div>

                                </div>

                                <div class="card-header">
                                        <select id="listing_type_graph_low_data" class="form-control aiz-selectpicker w-25" data-live-search="true">

                                            <option value=""> All </option>

                                            @foreach ($lowStockOpt as $listType)

                                                <option value="{{$listType->option_value}}"> {{$listType->option_value}} </option>

                                            @endforeach

                                        </select>
                                </div>
                                <div class="card-body" id="filtered_data_listing_type">
                                    <table class="table aiz-table mb-0" id="low_stock_filter">
                                        <thead>
                                            <tr>
                                                <th>#</th>

                                                <th>{{translate('Listing Type')}}</th>

                                                <th>{{translate('Brand')}}</th>

                                                <th>{{translate('Model')}}</th>

                                                <th>{{translate('Low Stock')}}</th>

                                                <th>{{translate('Product Stock')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php

                                            $number = 1;

                                            @endphp

                                            @foreach($detailedProduct as $key => $optData)

                                                <tr>

                                                    <td>{{ ($detailedProduct->currentpage()-1) * $detailedProduct->perpage() + $key + 1 }}</td>

                                                    <td>{{ $optData->listing_type}}</td>

                                                    <td>{{ $optData->bname}}</td>

                                                    <td>{{ $optData->model}}</td>

                                                    <td>

                                                        @if($optData->low_stock > 0 && $optData->low_stock >= $optData->prostock)

                                                            <span class="badge badge-inline badge-danger">Low</span>({{$optData->low_stock}})

                                                        @else

                                                                {{$optData->low_stock}}

                                                        @endif

                                                     </td>

                                                    <td>{{ $optData->prostock}}</td>

                                                </tr>

                                                    @php

                                                    $number++;

                                                    @endphp

                                                @endforeach

                                            </tbody>

                                        </table>

                                        <div class="aiz-pagination">
                                            {{$detailedProduct->appends(request()->input('low_stock_data'))->links()}}
                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif
          </div>

         <!-- Tabs content -->
        <!-- </div> -->
        <!-- summery_model -->

        <div class="modal fade" id="summery_model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header justify-content-start">

                        <h5 class="modal-title">WINSTONS</h5>

                    </div>

                    <div class="modal-body">

                        <table class="table aiz-table mb-0">

                            <thead>

                                <tr>

                                <th>{{translate('Memo Number')}}</th>

                                <th>{{translate('Open Balance')}}</th>

                                <th>{{translate('Status')}}</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($memo_details as $key => $optData)

                                    <tr>

                                    <td>{{ $optData->memo_number}}</td>

                                    <td>{{ money_format("%(#1n", $optData->sub_total)."\n"}}</td>

                                    <td>Open Memo</td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                      </div>

                    </div>
                </div>
            </div>


                <div class="row gutters-10">
                  @if(Auth::user()->user_type == 'admin' || in_array('146', json_decode(Auth::user()->staff->role->inner_permissions)))

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <h6 class="mb-0 fs-14">{{ translate('Category wise product') }}</h6>

                                    <select id="listing_type_graph_1"  class="form-control aiz-selectpicker w-25" data-live-search="true">

                                        <option value="">Select listing</option>

                                        @foreach ($lowStockOpt as $listType)

                                            <option value="{{$listType->option_value}}"> {{$listType->option_value}} </option>

                                        @endforeach

                                    </select>
                            </div>
                            <!-- <div class="card-body" style="pointer-events: none;"> -->
                            <div class="card-body" >
                                <!-- <canvas id="graph-1" class="w-100" height="500"></canvas> -->
                                <div class="chartWrapper">
                                	<div class="chartAreaWrapper">
                                		<div class="chartAreaWrapper2">
                                		    <canvas id="myChart"></canvas>
                                		</div>
                                	</div>
                                	<canvas id="myChartAxis" height="600" width="0"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                      @if(Auth::user()->user_type == 'admin' || in_array('147', json_decode(Auth::user()->staff->role->inner_permissions)))

                    <div class="col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <h6 class="mb-0 fs-14">{{ translate('Model wise product stock') }}</h6>

                                    <select id="listing_type_graph"  class="form-control aiz-selectpicker w-25" data-live-search="true">

                                        <option value="">Select listing</option>

                                        @foreach ($lowStockOpt as $listType)

                                            <option value="{{$listType->option_value}}"> {{$listType->option_value}} </option>

                                        @endforeach

                                    </select>

                            </div>
                            <div class="card-body">
                                <!-- <canvas id="graph-2" class="w-100" height="500"></canvas> -->
                                <div class="chartWrapperScnd">
                                	<div class="chartAreaWrapperScnd">
                                		<div class="chartAreaWrapper2Scnd">
                                		    <canvas id="myChart-2"></canvas>
                                		</div>
                                	</div>
                                	<canvas id="myChartAxis-2" height="600" width="0"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            <!-- model  -->

            <div class="modal fade" id="memoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                <div class="modal-dialog" style="max-width:700px;">

                    <div class="modal-content" id="micustomMemoDa">

			            <div class="modal-header">

                            <h5 class="companyHeading text-capitalize"></h5>

                            <!-- <h5 class="modal-title">Return Items</h5> -->

                    			<div class="close-btn">

                    				<!-- <button class="btn btn-xs btn-default no-print pull-right" onclick="micustomPrint()" style="border:1px solid gainsboro !important;"> <i class="las la-print"></i> Print</button> -->

                    				<button type="button" class="close micustomclose" data-dismiss="modal" aria-label="Close">

                    					<span aria-hidden="true">&times;</span>

                    				</button>

                    			</div>

                            </div>

    	                    <div class="modal-body" >

    		                    <div id="meDaModelData">

                        		</div>

                        	</div>

                          </div>

                        </div>

                     </div>



                <!-- warehouse model  -->

                 <!-- warehouse model  -->
    <div class="modal fade" id="warehousemodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width:700px;">
            <div class="modal-content">
                <div class="card">
                    <div class="card-header row gutters-5">
                        <div class="col text-center text-md-left">
                            <h5 class="mb-md-0 h6 products_type_name"></h5>
                        </div>
                    </div>
                    <div class="card-body warehouseResponse">
                        <table class='table table-bordered table-hover table-striped print-table order-table table'>
                            <thead>
                                <tr class='bg-primary text-white'>
                                    <th class='text-center'>Partners</th>
                                    <th class='text-center'>Items</th>
                                    <th class='text-center'>Cost</th>
                                </tr>
                            </thead>
                            <tbody id="gci_warehouse_prtnr">

                            </tbody>
                            <tfoot id="gci_warehouse_footer">
                            </tfoot>
                        </table>
                        <div class="aiz-pagination"> </div>
                    </div>
                </div>
                <div class="close-btn"> </div>
            </div>
        </div>
    </div>
@endif
@endsection

@section('script')

<script type="text/javascript">

$('#listing_type_graph_1').on('change', function(e) {
      var getLsId = $(this).val();
      e.preventDefault();
      $.ajax({
          url: "{{route('dashboard.stockChart_1')}}",
          type: "POST",
          data: {"_token": "{{ csrf_token() }}","id" : getLsId},
              success: function( response ) {
                //   alert(response); return false;
                var graphHtml = response.stockChart;
                // alert(graphHtml);
                // console.log(graphHtml);
                var lbl = [];
                var dt = [];
                for (var i in graphHtml) {
                  if(graphHtml[i].category_name){
                    lbl.push(graphHtml[i].category_name);
                    dt.push(graphHtml[i].allqty);
                  }
                }
                // dt = dt.sort((a, b) => b-a);
                // console.log(category_name);
                var ctx = document.getElementById("myChart").getContext("2d");
                var chart = {
                      options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                               xAxes:[{
                             ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                              },
                           barThickness : 30
                          }]
                        },
                      animation: {
                                onComplete: function(animation) {
                                    var sourceCanvas = myLiveChart.chart.canvas;
                                    var copyWidth = myLiveChart.scales['y-axis-0'].width - 10;
                                    var copyHeight = myLiveChart.scales['y-axis-0'].height + myLiveChart.scales['y-axis-0'].top + 10;
                                    var targetCtx = document.getElementById("myChartAxis").getContext("2d");
                                    targetCtx.canvas.width = copyWidth;
                            targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight);
                                }
                            }
                          },
                      type: 'bar',
                      data: {
                               labels: lbl,
                      datasets: [{
                          label: 'Total Qty',
                          backgroundColor: '#49e2ff',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: dt}]
                      }
                    };
                    var newwidth = (lbl.length * 30) + 100//50 padding
                    $('.chartAreaWrapper2').width(newwidth);
                    var myLiveChart = new Chart(ctx, chart);
              }
         });
       });



    $('#listing_type_graph').on('change', function(e) {
      var getLsId = $(this).val();
      e.preventDefault();
      $.ajax({
          url: "{{route('dashboard.stockChart')}}",
          type: "POST",
          data: {"_token": "{{ csrf_token() }}","id" : getLsId},
              success: function( response ) {
                var graphHtml = response.stockChart;
                // alert(graphHtml);
                // console.log(response);
                var lblScnd = [];
                var dtScnd = [];
                for (var i in graphHtml) {
                  if(graphHtml[i].model_number){
                    lblScnd.push(graphHtml[i].model_number);
                    dtScnd.push(graphHtml[i].allqty);
                  }
                }
            //   dtScnd=dtScnd.sort(function(a, b){return b - a});
                // dtScnd = dtScnd.sort((a, b) => b-a);
                // console.log(model_number);
                var ctx = document.getElementById("myChart-2").getContext("2d");
                var chart = {
                      options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                               xAxes:[{
                             ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 90
                              },
                           barThickness : 30
                          }]
                        },
                      animation: {
                                onComplete: function(animation) {
                                    var sourceCanvas = myLiveChart.chart.canvas;
                                    var copyWidth = myLiveChart.scales['y-axis-0'].width - 10;
                                    var copyHeight = myLiveChart.scales['y-axis-0'].height + myLiveChart.scales['y-axis-0'].top + 10;
                                    var targetCtx = document.getElementById("myChartAxis-2").getContext("2d");
                                    targetCtx.canvas.width = copyWidth;
                                    targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight);
                                }
                            }
                          },
                      type: 'bar',
                      data: {
                               labels: lblScnd,
                      datasets: [{
                          label: 'Total Qty',
                          backgroundColor: '#49e2ff',
                          borderColor: '#46d5f1',
                          hoverBackgroundColor: '#CCCCCC',
                          hoverBorderColor: '#666666',
                          data: dtScnd}]
                      }
                    };
                    var newwidth = (lblScnd.length * 30) + 100//50 padding
                    $('.chartAreaWrapper2Scnd').width(newwidth);
                    var myLiveChart = new Chart(ctx, chart);
              }
         });
       });

    // $(document).ready(function()
    // {
    //     if($('#low_stock_filter').length > 0)
    //     {
    //         $('#low_stock_filter').DataTable({
    //             "bPaginate": false
    //         });
    //     }
    //         $('#memo_data_datatbl').DataTable({
    //             "bPaginate": false
    //         });
    //
    //
    // });

    // $(document).ready(function() {

    //     if($('#memo_data_datatbl').length > 0){

    //         $('#memo_data_datatbl').DataTable({

    //             "bPaginate": true

    //         });

    //     }

    // });

    // $(document).ready(function() {
    //
    //     if($('#customerdataTbl').length > 0){
    //         $('#customerdataTbl').DataTable({
    //             "bPaginate": false
    //         });
    //     }
    // });



    // $(document).ready(function() {

    //     if($('#open_balance_filter').length > 0){

    //         $('#open_balance_filter').DataTable({

    //             "bPaginate": false

    //         });

    //     }

    // });

    // $(document).ready(function() {
    //
    //     if($('#job_orders_filter').length > 0){
    //
    //         $('#job_orders_filter').DataTable({
    //
    //             "bPaginate": false
    //
    //         });
    //
    //     }
    //
    // });

    // $(document).ready(function() {
    //
    //     if($('#memoAjaxDA').length > 0){
    //
    //         $('#memoAjaxDA').DataTable({
    //
    //             "bPaginate": false
    //
    //         });
    //
    //     }
    //
    // });

    // $(document).ready(function() {
    //
    //     if($('#supplierTbl').length > 0){
    //
    //         $('#supplierTbl').DataTable({
    //
    //             "bPaginate": false
    //
    //         });
    //
    //     }
    //
    // });



    function getstock_id(id)

    {

        alert(id);

        $.ajax({

            url:"{{route('dashboard.memoDetails',['id' =>"+id+"])}}" ,

            type:'get',

            success:function(response){

                // alert(response);

            }



        })

    }

</script>

<script>

$('#memoAjaxDA').on('click', function(e) {

  e.preventDefault();

	var getIdFromRow = $(event.target).closest('tr').data('id');
// 	alert(getIdFromRow);

	var company = $(event.target).closest('tr').data('company');

  $.ajax({

      url: "{{route('dashboard.memoDA')}}",

      type: "POST",

      data: {"_token": "{{ csrf_token() }}","id" : getIdFromRow},

      success: function( response ) {

        var ReturnHtml = response.memoDaHtmlData;
        // alert(ReturnHtml);

        $('#meDaModelData').html(ReturnHtml);

        $('.companyHeading').text(company);

      }

     });

   });





   $("#listing_type_graph_low_data").change(function(e){

        e.preventDefault();

       var id=$(this).val();

       $.ajax({

           type:'post',

           url:"{{route('dashboard.tistingType')}}",

           data:{"_token": "{{ csrf_token() }}","id" : id},

           success:function(data){

            var ReturnHtml = data.listingTypeData;

            $('#filtered_data_listing_type').html(ReturnHtml);

            $('#low_stock_filter > table:last').append(ReturnHtml);

                $('#low_stock_filter').dataTable({

                    "autoWidth":false

                    , "destroy":true

                    , "info":false

                    , "JQueryUI":true

                    , "ordering":true

                    , "paging":false

                    , "scrollY":"500px"

                    , "scrollCollapse":true

                });

           }
       });
   });

 function warehousedataAjax(listing_type)
        {
            // alert(listing_type);
            var warehouse_values=$('#value_w').val();
            var warehouse_id=$('#warehouse_id').val();
            var stock=$('#stock_filter_type').val();
            // alert(stock);
            $.ajax({
                type:'post',
                url:'{{route("dashboard.warehouseData")}}',
                // dataType:'json',
                data:{"_token": "{{ csrf_token() }}","listing_type":listing_type,"warehouse_values":warehouse_values,'warehouse_id':warehouse_id,'stock':stock},
                success:function(response)
                {
                    // alert("fghgjhkhjhgdfhj");
                    var ReturnHtml = response.listingTypeData;
                    var listingFtr = response.listingFooter;
                    // alert(ReturnHtml);
                    $("#warehousemodel").modal('toggle');
                    $('#gci_warehouse_prtnr').html(ReturnHtml);
                    $('#gci_warehouse_footer').html(listingFtr);
                    // $('.products_type_name').text(response.product_type);
                }
            });
        }
// function micustomPrint()
// {
//     $('.no-print').hide();

// 	// $('.hideonprint').hide();

// 	$('.micustomclose').hide();

// 	$('.micustomPrem').addClass("samClass");

// 	var printContents = document.getElementById("memoModal").innerHTML;

// 	var originalContents = document.body.innerHTML;

// 	document.body.innerHTML = originalContents;

// 	window.print();

// 	// $('.hideonprint').show();

// 	$('.micustomclose').show();

// 	$('.micustomPrem').show();

// 	$('.no-print').show();

// 	$('.micustomPrem').removeClass("samClass");

// 	 return true;

// }

  $(document).ready(function(){
      var pageLoc = window.location.search.substring(1);
      pageLoc = pageLoc.split('=');
      function paginationSort(){
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active show');
        $('.'+pageLoc[0]).addClass('active');
        $('#'+pageLoc[0]).addClass('fade active show');
      }
      $('.tab-pane').each(function(tab,index){
        if(pageLoc[0] == 'Customers'){
          paginationSort();
        } else if( pageLoc[0] == 'low_stock_data'){
          paginationSort();
        } else if( pageLoc[0] == 'memo'){
          paginationSort();
        } else if( pageLoc[0] == 'job_orders'){
          paginationSort();
        } else if( pageLoc[0] == 'suppliers'){
          paginationSort();
        } else if( pageLoc[0] == 'summarypane'){
          paginationSort();
        }else if( pageLoc[0] == 'suppliers_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.suppliers').addClass('active');
          $('#suppliers').addClass('fade active show');
          return false;
        }else if( pageLoc[0] == 'summarypane_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.summarypane').addClass('active');
          $('#summarypane').addClass('fade active show');
          return false;
        }else if( pageLoc[0] == 'memo_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.memo').addClass('active');
          $('#memo').addClass('fade active show');
          return false;
        }else if( pageLoc[0] == 'job_orders_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.job_orders').addClass('active');
          $('#job_orders').addClass('fade active show');
          return false;
        }else if( pageLoc[0] == 'Customers_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.Customers').addClass('active');
          $('#Customers').addClass('fade active show');
          return false;
      }else if( pageLoc[0] == 'low_stock_data_s'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.low_stock_data').addClass('active');
          $('#low_stock_data').addClass('fade active show');
          return false;
      }else if( pageLoc[0] == 'warehouse_id'){
          $('.nav-link').removeClass('active');
          $('.tab-pane').removeClass('active show');
          $('.wearhouse').addClass('active');
          $('#wearhouse').addClass('fade active show');
          return false;
        }
      });
   });

</script>
<script>
//   $(document).ready( function () {
//     $('.myTable').DataTable({
//         "searching":true,
//         "paging":true,
//         "pageLength":25,
      
        
//         });
// } );
</script>

@endsection
