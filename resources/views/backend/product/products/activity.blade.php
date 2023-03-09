@extends('backend.layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="aiz-titlebar text-left mt-2 mb-3">
</div>
<br>
<div class="card">
  <!-- Tabs navs -->
  <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist" style="display:-webkit-inline-box;">
    <li class="nav-item" role="presentation" style="width:100px !important;" >
      <a class="nav-link active" style="width:100px;" id="ex2-tab-1" data-toggle="tab" href="#a" role="tab" aria-controls="ex2-tabs-1" aria-selected="true">All</a>
    </li>
    <li class="nav-item" role="presentation" style="width:100px !important;">
      <a class="nav-link" style="width:100px;" id="ex2-tab-2" data-toggle="tab" href="#b" role="tab" aria-controls="ex2-tabs-2" aria-selected="false">Activities</a>
    </li>
    <li class="nav-item" role="presentation" style="width:100px !important;">
      <a class="nav-link" style="width:100px;" id="ex2-tab-3" data-toggle="tab" href="#c" role="tab" aria-controls="ex2-tabs-3" aria-selected="false">Notes</a>
    </li>
  </ul>
  <!-- Tabs navs -->

  <!-- Tabs content -->
  <div class="tab-content" id="ex2-content">
    <div
      class="tab-pane fade show active"
      id="a"
      role="tabpanel"
      aria-labelledby="ex2-tab-1">
         <table id="CusData" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-condensed table-hover table-striped">
              <tbody>
                  <tr>
                      <td class="">
                          <div class="cls_img_main_block">
                              <div class="text-center">
                                  <a href="javascript:void()">
                                  <img src="https://gciwatch.com/assets/uploads/c95266e25563355dd23bce72d04a0fe5.jpeg" alt="" style="width:30px; height:30px;">
                                  </a>
                              </div>
                          </div>
                      </td>

                      <td>
                        <div class="cls_store_number">Added to the Inventory as Stock Id <b><a href="#"> {{$product->stock_id}} </a></b> Purchased  on  <b>{{date('m/d/20y',strtotime($product->dop))}}</b></div>
                      </td>
                  </tr>


                   @if(isset($transfer->product_id))
                   @if($transfer->product_id == $product->id)
                  <tr>
                      <td class="">
                          <div class="cls_img_main_block">
                              <div class="text-center">
                                  <a href="javascript:void()">
                                  <img src="https://gciwatch.com/assets/uploads/c95266e25563355dd23bce72d04a0fe5.jpeg" alt="" style="width:30px; height:30px;">
                                  </a>
                              </div>
                          </div>
                      </td>

                      <td>
                        <div class="cls_store_number">StockId <a href =""><b>{{$product->stock_id}}</b></a> was transfered From  Warehouse <b> {{$transfer->from_warehouse_name}} to {{$transfer->to_warehouse_name}} </b>  on {{date('m/d/20y' ,strtotime($product->created_at))}}</div>
                      </td>
                  </tr>
                  @endif
                 @endif



                 @if(isset($inventoryRun->user))
                                                    @if($inventoryRun->user == $product->user_id)
                                                    <tr>
                                                        <td class="">
                                                            <div class="cls_img_main_block">
                                                                <div class="text-center">
                                                                    <a href="javascript:void()">
                                                                    <img src="https://gciwatch.com/assets/uploads/c95266e25563355dd23bce72d04a0fe5.jpeg" alt="" style="width:30px; height:30px;">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="cls_store_number">Added to the Inventory as Stock Id <a href =""><b>{{$product->stock_id}}</b></a>Purchased From <b> {{$inventoryRun->username}} </b> on {{date('m/d/20y' ,strtotime($product->dop))}}</div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    @endif


                 
                 @if(isset($memo->product_id))
                   @if($memo->product_id == $product->id)
                  <tr>
                      <td class="">
                          <div class="cls_img_main_block">
                              <div class="text-center">
                                  <a href="javascript:void()">
                                  <img src="https://gciwatch.com/assets/uploads/c95266e25563355dd23bce72d04a0fe5.jpeg" alt="" style="width:30px; height:30px;">
                                  </a>
                              </div>
                          </div>
                      </td>

                      <td>
                        <div class="cls_store_number">StockId <a href =""><b>{{$product->stock_id}}</b></a> was Memo To Memo <b> {{$memo->memo_number}} </b>By Customer <a href=""><b>{{$memo->customer_name}}</b></a> on {{date('m/d/20y' ,strtotime($product->created_at))}}</div>
                      </td>
                  </tr>
                  @endif
                 @endif



              </tbody>
            </table>
    </div>
    <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="ex2-tab-2">
      <table id="CusData" cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-condensed table-hover table-striped">
        <tbody>
          <tr>
              <td class="">
                  <div class="cls_img_main_block">
                      <div class="text-center">
                          <a href="javascript:void()">
                          <img src="https://gciwatch.com/assets/uploads/c95266e25563355dd23bce72d04a0fe5.jpeg" alt="" style="width:30px; height:30px;">
                          </a>
                      </div>
                  </div>
              </td>

              <td>
                <div class="cls_store_number">Added to the Inventory as Stock Id <b><a href="#"> {{$product->stock_id}} </a></b> Purchased  on  <b>{{$product->created_at}}</b></div>
              </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="ex2-tab-3">
      <p>No Notes Found.</p>
    </div>
  </div>
  <!-- Tabs content -->
</div>
@endsection
@section('modal')
    @include('modals.delete_modal')
@endsection
