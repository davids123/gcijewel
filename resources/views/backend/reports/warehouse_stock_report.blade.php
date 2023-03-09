@extends('backend.layouts.app')
<style>
    .catgers_table td
    {
        width: 33.33%;
        text-align: center;
        padding: 70px !important;
        color:#fff;
        font-size:30px !important;
    }
    .cat_name
    {
        background-color:#5bc0de;
    }
    .cat_velu{
        background-color:#428bca;
    }
    .cat_pric
    {
        background-color:#78cd51;
    }
    #gci_warehouse_prtnr tr td {
        padding: 30px 0px !important;
        font-size: 21px !important;
    }
    #gci_warehouse_footer tr td {
        padding: 30px 0px !important;
        font-size: 21px !important;
    }
</style>
@section('content')
@php  setlocale(LC_MONETARY,"en_US");  @endphp
    <div class="aiz-titlebar text-left mt-2 mb-3">
    	<div class=" align-items-center">
           <h1 class="h3">{{translate('Warehouse Stock Chart (All)')}}</h1>
    	</div>
    </div>
    <div class="row">
        <div class="col-md-12 mx-auto">
            <div class="card">
                <!--card body-->
                <form class="warehouse_table" id="sort_products" action="" method="GET">
                    <div class="row page_qty_sec product_search_header">
                        <div class="col-md-4 warehouse_tab">
                            <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="warehouse_id" id="warehouse_id" data-live-search="true">
                                <option value="">All Warehouse</option>
                                    @foreach (App\Models\Warehouse::all() as $whouse_filter)
                                        <option value="{{$whouse_filter->id}}" @if($whouse_filter->id == Request::get('warehouse_id')) selected @endif>{{ $whouse_filter->name }}</option>
                                    @endforeach;
                                </select>
                                <button type="submit" id="warehouse_type" class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
                        </div>
                        <div class="col-md-4 warehouse_tab">
                            <!-- <label class="fillter_sel_show m-auto"><b>Stock</b></label> -->
                            <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="stock" id="stock_filter_type" data-live-search="true">
                                <!-- <option value="">Select Stock</option> -->
                                <option >All</option>
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
@endsection
<script src="https://cdn.jsdelivr.net/npm/pretty-money/dist/pretty-money.umd.js"></script>
@section('script')
    <script>
        function warehousedataAjax(listing_type)
        {
            // alert(listing_type);
            var warehouse_values=$('#value_w').val();
            var warehouse_id=$('#warehouse_id').val();
            var stock=$('#stock_filter_type').val();
            // alert(stock);
            $.ajax({
                type:'post',
                url:'{{route("reportAjax.warehouseData")}}',
                // dataType:'json',
                data:{"_token": "{{ csrf_token() }}","listing_type":listing_type,"warehouse_values":warehouse_values,'warehouse_id':warehouse_id,'stock':stock},
                success:function(response)
                {
                    // alert(response);
                    // consol.log(response);
                    var ReturnHtml = response.listingTypeData;
                    var listingFtr = response.listingFooter;
                    // // alert(ReturnHtml);
                    $("#warehousemodel").modal('toggle');
                    $('#gci_warehouse_prtnr').html(ReturnHtml);
                    $('#gci_warehouse_footer').html(listingFtr);
                }
            });
        }


    </script>
@endsection
