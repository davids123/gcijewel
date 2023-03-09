@extends('backend.layouts.app')



@section('content')



<div class="aiz-titlebar text-left mt-2 mb-3">

	<div class="align-items-center">

			<h1 class="h3">{{translate('All Appraisal')}}</h1>

	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
		    <div class="card-header row gutters-5">
				<div class="col text-center text-md-left">
					<h5 class="mb-md-0 h6">{{ translate('All Appraisal') }}</h5>
				</div>
                @if(Auth::user()->user_type == 'admin' ||  in_array('62', json_decode(Auth::user()->staff->role->inner_permissions)))
				<div class="btn-group mr-2" role="group" aria-label="Third group">
					<a class="btn btn-soft-primary" href="{{route('Appraisal.create')}}" title="{{ translate('add') }}">
						Add Appraisal	<i class="lar la-plus-square"></i>
					</a>
				</div>
                @endif
                <!--
                 @if(Auth::user()->user_type == 'admin' ||  in_array('142', json_decode(Auth::user()->staff->role->inner_permissions)))
                <div class="d-flex my-2">

                    <a href="#"  class="btn btn-primary mr-2">Export Data</a>

                </div>
                @endif
                -->

				<!-- <div class="col-md-2"> -->



                <!-- <div class="form-group mb-0">

                    <input type="text" class="form-control form-control-sm" id="search" name="search" @isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="{{ translate('Type & Enter') }}">

                </div> -->

            </div>

		    </div>
            <form class="" id="sort_products" action="" method="GET">
                <div class="card-header row gutters-5 appraisal_form_sec purchases_form_sec">
                <div class="col-md-3 d-flex page_form_secs">
                <input type="hidden" name="search" id="searchinputfield">
                    <label class="fillter_sel_show m-auto"><b>Show</b></label>
                    <select class="form-control form-select" id="pagination_use_qty"  aria-label="Default select example">
                        <!-- <option value="10" @if($pagination_qty == 10) selected @endif>10</option> -->
                        <option value="25" @if($pagination_qty == 25) selected @endif>25</option>
                        <option value="50" @if($pagination_qty == 50) selected @endif>50</option>
                        <option value="100" @if($pagination_qty == 100) selected @endif>100</option>
                        <option  value="500" @if($pagination_qty == 500) selected @endif>500</option>
                        <option value="all" @if($pagination_qty == "all") selected @endif>All</option>
                    </select>

                    <button type="submit" id="purchases_pagi_sub"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>

                </div>
                <div class="col-md-6 d-flex"></div>
                <div class="col-md-3 d-flex search_form_sec">
                    <label class="fillter_sel_show m-auto"><b>Search</b></label>
                    <input type="text" class="form-control form-control-sm sort_search_val"  @isset($sort_search) value="{{ $sort_search }}" @endisset>
                    <button type="button" class="search_btn_field"><i class="las la-search aiz-side-nav-icon" ></i></button>
			    </div>
                </div>

                <div class="mi_custome_table">

                <div class="card-body">

                    <table class="table aiz-table mb-0" >

                        <thead>

                            <tr>

                                <th>#</th>

                            <!-- <th><input type="checkbox" onclick="toggle(this);" id="select_count"  name="all[]"></th> -->

                            <th>{{translate('Template Name')}}</th>

                            <th>{{translate('Listing Type')}}</th>

                            <th>{{translate('Stock id')}}</th>

                            <th>{{translate('Manufacturer')}}</th>

                            <th>{{translate('Model Name')}}</th>

                            <th>{{translate('Factory Model')}}</th>

                            <th>{{translate('Serial No')}}</th>

                            <th>{{translate('Sp Value')}}</th>

                            <th>{{translate('Appraisal Date')}}</th>

                            <th class="text-right">{{translate('Options')}}</th>

                            </tr>

                        </thead>

                        <tbody>
                            @php $count=0; @endphp

                            @foreach($appraisal as $key => $optData)
                            @php $count++; @endphp

                                <tr>

                                    <!-- <td><input type="checkbox" class="memo_checkbox" value="{{ $optData->id}}" name="all_memo[]" id="memo_data"></td> -->

                                    <td onclick="modelAp({{$optData->id}})">{{ $count}}</td>

                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->template_name}}</td>

                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->listing_type}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->stock_id}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->manufacturer}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->model_name}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->factory_model}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->serial_no}}</td>
                                    <td onclick="modelAp({{$optData->id}})">{{ $optData->sp_value}}</td>
                                    <td onclick="modelAp({{$optData->id}})"> {{$optData->appraisal_date}} </td>
                                    <td class="text-right">
                                    @if(Auth::user()->user_type == 'admin' ||  in_array('63', json_decode(Auth::user()->staff->role->inner_permissions)))
                                        <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('Appraisal.edit', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" title="{{ translate('Edit') }}">
                                            <i class="las la-edit"></i>
                                        </a>
                                        @endif
                                        @if(Auth::user()->user_type == 'admin' ||  in_array('61', json_decode(Auth::user()->staff->role->inner_permissions)))
                                        <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  href="#"  title="{{ translate('View') }}" data-toggle="modal" onclick="modelAp({{$optData->id}})" >
                                            <i class="las la-eye"></i>
                                       </a>
                                       @endif
                                        <a class="btn btn-soft-success btn-icon btn-circle btn-sm"  type="button"  onclick="micustomPrint({{$optData->id}})"  target="_blank"><i class="las la-print"></i></a>
                                        @if(Auth::user()->user_type == 'admin' ||   in_array('64', json_decode(Auth::user()->staff->role->inner_permissions)))
                                        <a href="{{route('appraisal.destroy', ['id'=>$optData->id, 'lang'=>env('DEFAULT_LANGUAGE')] )}}" class="btn btn-soft-success btn-icon btn-circle btn-sm" onclick="return confirm('Are you sure?');">

                                                <i class="las la-trash"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                        <div class="aiz-pagination">
                            @if($pagination_qty !== "All")
                                <p>
                                    Showing {{ $appraisal->firstItem() }} to {{ $appraisal->lastItem() }} of  {{$appraisal->total()}} entries
                                </p>
                                {{ $appraisal->appends(request()->input())->links() }}
                            @else
                                <p>
                                    Showing <?php echo $appraisal->count(); ?> of  <?php echo $appraisal->count(); ?> entries
                                </p>
                            @endif
                        </div>
                </div>
                </div>
            </form>
		</div>
	</div>
</div>
<!-- Modal -->

<div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title template_name" id="exampleModalLabel"></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body p-0">

        <div class="aiz-titlebar text-left mt-2- mb-3-">

        <!-- <h5 class="mb-0 h6">{{translate('My Watch')}}</h5> -->

        <table class="table aiz-table mb-0">

		            <tbody>

		                <tr>

                            <td>{{translate('Listing Type')}}</td>

                            <td class="listing_type"></td>

		                </tr>

                        <tr>

                            <td>{{translate('Stock Id')}}</td>

                            <td class="stock_id"></td>

		                </tr>

                        <tr>

                            <td>{{translate('Manufacturer')}}</td>

                            <td class="manufacturer"></td>

		                </tr>

                        <tr>

                            <td>{{translate('Model Name')}}</td>

                            <td class="model_name"></td>

		                </tr>

                        <tr>

                            <td>{{translate('Factory Model')}}</td>

                            <td class='factory_model'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Serial No')}}</td>

                            <td class='serial_no'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Size')}}</td>

                            <td class='size'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Dial')}}</td>

                            <td class='dial'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Bazel')}}</td>

                            <td class='bazel'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Metal')}}</td>

                            <td class='metal'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Bracelet Meterial')}}</td>

                            <td class='bracelet_meterial'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Crystal')}}</td>

                            <td class='crystal'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Suggested Apparaisad Value')}}</td>

                            <td class='suggested_apparaised_value'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Image')}}</td>

                            <td class='image'> </td>

		                </tr>

                        <tr>

                            <td>{{translate('Appraised For:Name ,Address ,City, State, zipcode')}}</td>

                            <td class='appraised_address'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Appraisal Number')}}</td>

                            <td class='appraisal_number'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Appraisal Location')}}</td>

                            <td class='appraisal_location'></td>

		                </tr>

                        <tr>

                            <td>{{translate('Appraisal Date')}}</td>

                            <td class='appraisal_date'></td>

		                </tr>

		            </tbody>

		        </table>

            </div>


         </div>

     </div>

  </div>

</div>


<!-- print function  -->

<div id="print_doc">
    <style>
        @media print {
            @page {
                margin: 0mm 0mm 0mm 0mm !important;
                width:100% !important;
                size: landscape !important;

                }

            body{
            padding:0px !important;
            border:none !important;
              }

            .mi_print{
                width:100% !important;
                padding:0px 0px 0px 0px !important;
                margin-left:0px !important;

            }
            /*.micustomborder{*/
            /*    border: 1px solid black !important;*/
            /*}*/
            /*.print_sec.left{*/
            /*    border:1px solid #000 !important;*/
            /*}*/
            /*.print_sec.right{*/
            /*    border:1px solid #000 !important;*/
            /*}*/
            .print_sec{
                width:50% !important;
            }
            .print_sec.left .print_innner_sec{
                margin-right:2px;
                padding:5px 10px;

            }
            .print_sec.right .print_innner_sec{
               margin-left:2px;
               padding:5px 10px;
            }
            /*.print_innner_sec{*/
            /*    border:1px solid #000 !important;*/
            /*}*/
            .imgLogo{
                width:170px;
                margin-top:5px !important;
                margin:0 auto !important;
            }
            .imgLogo.mi_costme_logo.my_watch{
                width:100% !important;
                margin-left:0px !important;
                 margin-top:0px !important;
            }
            .imgLogo.my_watch{
                width:100% !important;
                height:60px !important;
            }
            .mi_costme_logo{
               margin-left:55px !important;
           }
            .report_text h3{
                margin-bottom:30px;
                margin-top:10px;
                font-weight: 600;
                font-size:20px;
            }
            .report_text p{
                font-size:12px;
                margin:0px;
                padding-left:0px;
                line-height:16px !important;
            }
            p.retort_velu{
                font-size:12px;
                height:16px !important;
            }
            .appraised_value{
                margin-top:5px;
                margin-bottom:2px;
            }
            .appraised_value p{
                border:2px solid #f3cb84;
                padding:5px 5px;
                font-size:20px;
                font-weight: 600;
            }
            .product_img p{
                text-align:left;
                font-size:16px;
            }
            .product_img{
                width:100%;
                text-align:center;
                height:395px !important;
                max-height:395px !important;
                margin:0 auto !important;
                max-width:100% !important;

            }
                .product_img img{
                width: 250px !important;
                height: 300px !important;
                object-fit: cover;
                margin:5px auto;
                }
            .appraised_ditel{
                width:100%;
                text-align:center;
                color:#000 !important;
            }
            .signature_div{
                text-align:center;
            }
            .appraised_ditel h3{
                 font-weight: 600;
                 font-size:20px !important;
            }
            .appraised_ditel p{
                font-size:14px;
            }
            .appraisal_nu-loc-dat h3{
                font-weight: 600;
                font-size:20px !important;
            }
            .appraisal_nu-loc-dat p{
                font-size:22px;
                margin:0px;
                padding-left:15px;
            }
            .signature_div p{
                font-size:20px;
            }
            .appraisal_dec p{
                font-size:16px;
                text-align: justify;
                margin-bottom:5px;

            }
            .print_sec.right{
                margin-top:0% !important;
            }
            p.retort_apr{
                font-weight: 600;
                font-size:12px;

            }
            .my_watch_dealer_head{
                padding:6px 0px;
                font-size:14px !important;
            }
          .luxheade_bg{
              width:100%;
              height:750px;
          }
          .luxheade_bg img{
              width:100%;
              height:750px;
          }
         .mi_luxhead{
             width:100%;
             position: absolute;
             left:0;
             top:0;
             height:100%;
             z-index:9999;
         }
         .mi_watchhead{
            width:100%;
            position: absolute;
            left:0;
            top:0;
            height:100%;
            z-index:9999;
         }
         .watchhead_bg{
              width:100%;
              height:750px;
         }
         .watchhead_bg img{
              width:100%;
              height:750px;
         }
         h3.retort_apr.appraisal_name_print{
             font-size:14px !important;
             margin-bottom:5px !important;
         }
        p.retort_apr.appraisal_add_location_print{
        margin-bottom:0px !important;
        }

        }
    </style>
    <div class="mi_print">
        <div class="watchhead_bg mywatchhead"><img src="https://gcijewel.com/public/uploads/all/gci-pdf-bg.png"></div>
        <div class="row mi_watchhead">
            <!--my watch-->
            <div class="print_sec left col-6 mywatchhead" style="padding-left:15px !important;">
                 <div class="print_innner_sec mywatchhead" style="border:1px solid #000; margin-left:15px !important;padding:0 !important; margin-top:20px;">
                    <center>
                        <div style='backgroud:#000;' class="mywatch retort_apr">
                            <img src='https://gcijewel.com/public/uploads/all/my-watch-dealer.jpg' class='imgLogo retort_apr mi_costme_logo my_watch'>
                        </div>
                        <!--Header-->
                    </center>
                    <div class="report_text mywatchhead" style="padding-left:10px!important;">
                        <h3 class='retort_apr mywatchhead' style="text-align: center;">Appraisal Report</h3>
                        <p style="text-align:center; font-size:12px;" class='retort_apr mywatchhead'>The following appraisal service report identifies the characteristics of the referenced watch at the time of inspection. This appraisal report establishes the new retail replacement value in the most common and appropriate jewelry markets, to provide a basis for obtaining insurance.</p>
                        <p class='retort_apr retort_velu'><b>Manufacturer</b> : <span class="Manufacturer_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Model Name</b> : <span class="model_number_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Factory Model</b> : <span class="factory_model_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Serial No.</b> : <span class="serial_no_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Size</b> : <span class="size_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Dial</b> : <span class="dial_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Bezel</b> : <span id="bezalPrint"> </span></p>
                        <p class='retort_apr retort_velu'><b>Metal</b> : <span class="metal_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Bracelet Material</b> : <span class="bracelet_meterial_print"> </span></p>
                        <p><b>Crystal</b> : <span class="Crystal_print"></span></p>
                    </div>
                    <div class="appraised_value retort_apr mywatchhead">
                        <p style="text-align:center; font-size:14px; width:100%; border-color:#000; border-left:none; border-right:none; background-color:#d9d9d9;margin-bottom:0px;" class='retort_apr'>Suggested Appraised Value*: <span  class="sp_value_print"> </span></p>
                    </div>
                    <div class='image_print product_img retort_apr mywatchhead' style="padding-left:10px !important;">
                    </div>
                </div>
            </div>
            <div class="print_sec right col-6 mywatchhead" style="padding-left:15px !important;">
                <div class="print_innner_sec retort_apr mywatchhead" style="border:1px solid #000;padding:0 !important; width:100%; margin-left:15px; margin-top:20px; margin-right:15px !important;">
                     <h3 class='retort_apr mywatchhead' style="text-align: center; color:#fff; margin-top:0px; margin-bottom:0px; border:1px solid #000; font-size:14px; padding:5px 0px; background-color:#000;">Appraisal Report</h3>
                     <div class="my_watch_dealer_head mywatchhead">
                        <div class="appraised_ditel" style="background-color:#d9d9d9;border-top:1px solid #000;border-bottom:1px solid #000; width:100%;">
                             <h3 style=" margin-bottom:5px; margin-top:5px;font-weight: 600; font-size:14px !important;text-align:center;" class='retort_apr '>Appraised For</h3>
                            <h3 class='retort_apr appraisal_name_print' ></h3>
                            <p class='retort_apr appraisal_add_location_print'></p>
                            <p class='retort_apr appraisal_location_print' style="margin-bottom:5px !important;"></p>
                        </div>
                    </div>
                    <div class="signature_div mywatchhead">
                        <p class='retort_apr' style="text-align: center;margin-bottom:0px !important; "><img src="https://gcijewel.com/public/uploads/all/ging.png"  style=" border-bottom:solid black 2px; width:150px;"></p>
                        <p class='retort_apr' style="margin:5px 0px !important">Inspected/Appraised by myWatchDealer.com</p>
                    </div>

                    <div class="appraisal_nu-loc-dat retort_apr mywatchhead" style="margin-bottom:2px;">
                        <h3 class='retort_apr mywatchhead my_watch_dealer_head' style=" margin-bottom:2px;background-color:#d9d9d9;font-size:14px !important; text-align:center !important;border-top:1px solid #000;border-bottom:1px solid #000;">Details of Appraisal</h3>
                        <p class='retort_apr' style="margin-top:0px;">Appraisal Number: <b><span class='appraisal_number_print'></span></b></p>
                        <p class='retort_apr'>Appraisal Location: <b><span> Los Angeles, CA 900014</span></b></p>
                        <p class='retort_apr'style="margin-bottom:0px;">Date: <b><span class='appraisal_date_print'></span></b></p>
                    </div>
                    <center>
                        <div style='backgroud:#000; margin-bottom:5px !important;' class="mywatch">
                            <img src='https://gcijewel.com/public/uploads/all/my-watch-dealer.jpg' class='imgLogo retort_apr mi_costme_logo my_watch'>
                        </div>
                    </center>
                    <div class="appraisal_dec retort_apr mywatchhead" style="padding:10px!important;">
                        <p class='retort_apr'>Any questions regarding this appraisal can be sent to myWatchDealer.com via email at sales@mywatchdealer.com or can be mailed to:  </p>
                            <p class='retort_apr' style="margin-bottom:0px !important;"> myWatchDealer.com</p>
                            <p class='retort_apr' style="margin:0px !important;"> 650 S. Hill St. Suite 317</p>
                            <p class='retort_apr' style="margin:0px !important;"> Los Angeles, CA 90014</p>
                            <p class='retort_apr' style="margin:0px !important;">213-985-3753</p>
                        <p class='retort_apr' style="margin-top:10px !important;">*myWatchapp.com is a registered DBA of Shak Corp Inc. This is not an invoice or receipt of sale. Suggested MSRP/Appraised Value is calculated based on estimated market prices for this item sold in other retail stores at the time of appraisal. myluxapp.com provides appraisal and other related services for Watches, Jewelry, Diamonds and Gold. myluxapp.com is a not affiliated with any of the brands of watches, jewelry, diamonds and/or gold that have been appraised in this report, unless specified otherwise. The values set forth herein are estimates of the current market price at which the appraised jewelry may be purchased in theaverage fine jewelry store at the time of appraisal. Because jewelry appraisal and evaluation is subjective, estimates of replacement value may vary from one appraiser toanother and such a variance does not necessarily constitute error on part of theappraiser. This appraisal should not be used as the basis for the purchase or sale of the items set forth herein and is provided, solely as an estimate of approximate replacement values of said items at this time and place. Accordingly, we assume no liability with respect to any legal action that may be taken, as a result of, the information contained in this appraisal.</p>
                    </div>
                </div>
            </div>
            </div>
            <!--my lux -->
            <div class="luxheade_bg myluxheade"><img src="https://gcijewel.com/public/uploads/all/gci-pdf-bg-new.jpg"></div>
            <div class="row mi_luxhead">
             <div class="print_sec left col-6 myluxheade" >
                 <div class="print_innner_sec myluxheade">
                    <div style='backgroud:#000; ' class="mylux_watch retort_apr" style="text-align: center;">
                        <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo retort_apr mi_costme_logo'>
                    </div>
                    <div class="report_text myluxheade">
                        <h3 class='retort_apr myluxheade'>Appraisal Report</h3>
                        <p style="letter-spacing: 1px !important; font-size:12px;" class='retort_apr myluxheade'>The following appraisal service report identifies the characteristics of the referenced watch at the time of inspection. This appraisal report establishes the new retail replacement value in the most common and appropriate jewelry markets, to provide a basis for obtaining insurance.</p>
                        <p class='retort_apr retort_velu'><b>Manufacturer</b> : <span class="Manufacturer_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Model Name</b> : <span class="model_number_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Factory Model</b> : <span class="factory_model_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Serial No.</b> : <span class="serial_no_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Size</b> : <span class="size_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Dial</b> : <span class="dial_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Bezel</b> : <span id="bezalPrint"> </span></p>
                        <p class='retort_apr retort_velu'><b>Metal</b> : <span class="metal_print"> </span></p>
                        <p class='retort_apr retort_velu'><b>Bracelet Material</b> : <span class="bracelet_meterial_print"> </span></p>
                        <p><b>Crystal</b> : <span class="Crystal_print"> </span></p>
                    </div>
                    <div class="appraised_value retort_apr myluxheade">
                        <p style="text-align:center; font-size:16px;" class='retort_apr'>Suggested Appraised Value*: <span  class="sp_value_print"> </span></p>
                    </div>
                    <div class='image_print product_img retort_apr myluxheade' >
                    </div>
                </div>
            </div>
            <div class="print_sec right col-6 myluxheade">
                <div class="print_innner_sec retort_apr" myluxheade>
                    <div style='backgroud:#000; ' class="mylux_watch" style="text-align: center;">
                         <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo' style="margin:0 auto !important;">
                    </div>
                    <br>
                    <div class="myluxheade">
                        <h3 style=" margin-bottom:5px; margin-top:5px;font-weight: 600; font-size:20px;text-align:center;" class='retort_apr  '>Appraised For</h3>
                        <div class="appraised_ditel" style="background-color:#f3cb84;">
                            <h3 class='retort_apr appraisal_name_print'></h3>
                            <p class='retort_apr appraisal_add_location_print'></p>
                            <p class='retort_apr appraisal_location_print'></p>
                        </div>
                    </div>
                    <div class="signature_div myluxheade">
                        <p class='retort_apr' style="text-align: center; "><img src="https://gcijewel.com/public/uploads/all/ging.png" style=" border-bottom:solid black 5px;"></p>
                        <p class='retort_apr'>Inspected/Appraised by Myluxapp.com</p>
                    </div>
                    <div class="appraisal_nu-loc-dat retort_apr myluxheade" style="margin-bottom:10px;">
                        <h3 class='retort_apr mywatchhead my_watch_dealer_head'>Details of Appraisal</h3>
                        <h3 class='retort_apr myluxheade'>Details of Appraisal</h3>
                        <p class='retort_apr'>Appraisal Number: <b><span class='appraisal_number_print'></span></b></p>
                        <p class='retort_apr'>Appraisal Location: <b><span > Los Angeles, CA 900014</span></b></p>
                        <p class='retort_apr'>Date: <b><span class='appraisal_date_print'></span></b></p>
                    </div>
                    <center>
                        <div style='backgroud:#000; ' class="mylux_watch" style="text-align: center;">
                            <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo retort_apr'>
                        </div>
                    </center>
                    <br>
                    <div class="appraisal_dec retort_apr myluxheade">
                         <p class='retort_apr'>Any questions regarding this appraisal can be sent to myLuxDealer.com via email at sales@myluxdealer.com or can be mailed to:</p>
                           <p> myluxapp.com 650 S. Hill St. Suite 317 Los Angeles, CA 9001 213-985-3753 </p>
                        <p class='retort_apr'>*myluxapp.com is a registered DBA of Shak Corp Inc. This is not an invoice or receipt of sale. Suggested MSRP/Appraised Value is calculated based on estimated market prices for this item sold in other retail stores at the time of appraisal. myluxapp.com provides appraisal and other related services for Watches, Jewelry, Diamonds and Gold. myluxapp.com is a not affiliated with any of the brands of watches, jewelry, diamonds and/or gold that have been appraised in this report, unless specified otherwise. The values set forth herein are estimates of the current market price at which the appraised jewelry may be purchased in theaverage fine jewelry store at the time of appraisal. Because jewelry appraisal and evaluation is subjective, estimates of replacement value may vary from one appraiser toanother and such a variance does not necessarily constitute error on part of theappraiser. This appraisal should not be used as the basis for the purchase or sale of the items set forth herein and is provided, solely as an estimate of approximate replacement values of said items at this time and place. Accordingly, we assume no liability with respect to any legal action that may be taken, as a result of, the information contained in this appraisal.</p>
                    </div>

                </div>
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
        $('.retort_apr').hide();

$('.imgLogo').hide();

        $(document).on("change", ".check-all", function() {

            if(this.checked) {

                // Iterate each checkbox

                $('.check-one:checkbox').each(function() {

                    this.checked = true;

                });

            } else {

                $('.check-one:checkbox').each(function() {

                    this.checked = false;

                });

            }



        });



        $(document).ready(function(){

               $(document).on("click", ".select-tr-edit", function() {

                var editHref = $(this).data('href');

               window.location.href = editHref;

        });

        });



        function update_todays_deal(el){

            if(el.checked){

                var status = 1;

            }

            else{

                var status = 0;

            }

            $.post('{{ route('products.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){

                if(data == 1){

                    AIZ.plugins.notify('success', '{{ translate('Todays Deal updated successfully') }}');

                }

                else{

                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');

                }

            });

        }



        function update_published(el){

            if(el.checked){

                var status = 1;

            }

            else{

                var status = 0;

            }

            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){

                if(data == 1){

                    AIZ.plugins.notify('success', '{{ translate('Published products updated successfully') }}');

                }

                else{

                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');

                }

            });

        }



        function update_approved(el){

            if(el.checked){

                var approved = 1;

            }

            else{

                var approved = 0;

            }

            $.post('{{ route('products.approved') }}', {

                _token      :   '{{ csrf_token() }}',

                id          :   el.value,

                approved    :   approved

            }, function(data){

                if(data == 1){

                    AIZ.plugins.notify('success', '{{ translate('Product approval update successfully') }}');

                }

                else{

                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');

                }

            });

        }



        function update_featured(el){

            if(el.checked){

                var status = 1;

            }

            else{

                var status = 0;

            }

            $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){

                if(data == 1){

                    AIZ.plugins.notify('success', '{{ translate('Featured products updated successfully') }}');

                }

                else{

                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');

                }

            });

        }



        function sort_products(el){

            $('#sort_products').submit();

        }



        function bulk_delete() {

            var data = new FormData($('#sort_products')[0]);

            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

                url: "{{route('bulk-product-delete')}}",

                type: 'POST',

                data: data,

                cache: false,

                contentType: false,

                processData: false,

                success: function (response) {

                    if(response == 1) {

                        location.reload();

                    }

                }

            });

        }

        function toggle(source) {

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            for (var i = 0; i < checkboxes.length; i++) {

                if (checkboxes[i] != source)

                    checkboxes[i].checked = source.checked;

            }

        }

       function modelAp(id)

        {

           $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

               type:'post',

               url:'{{route("Appraisal_view.ajax")}}',

               data:{id : id},

               dataType:'json',

               success:function(response)

               {
                    // alert(response.html);
                $("#view").modal("toggle");

                $('.listing_type').text(response.data['listing_type']);
                $('.stock_id').text(response.data['stock_id']);

                $('.manufacturer').text(response.data['manufacturer']);

                $('.model_name').text(response.data['model_name']);

                $('.factory_model').text(response.data['factory_model']);

                $('.serial_no').text(response.data['serial_no']);

                $('.size').text(response.data['size']);

                $('.dial').text(response.data['dial']);

                $('.bazel').text(response.data['bazel']);

                $('.metal').text(response.data['metal']);

                $('.bracelet_meterial').text(response.data['bracelet_meterial']);

                $('.crystal').text(response.data['crystal']);

                $('.suggested_apparaised_value').text(response.data['sp_value']);

                $('.image').html(response.html);

                $('.appraised_address').text(response.data['appraised_name'] +' , '+ response.data['appraised_address'] +' , '+ response.data['appraisal_city ']+' , '+ response.data['appraisal_state'] +' , '+response.data['appraisal_zipcode']);

                $('.appraisal_number').text(response.data['appraisal_number']);

                $('.appraisal_location').text(response.data['appraised_address']);

                $('.appraisal_date').text(response.data['appraisal_date']);

                $('.template_name').text(response.data['template_name']);



                //    alert(response.template_name);

               }

           });

        }

        // $("#print_doc").hide();
        // $('#print_doc_mylux').hide();

        function micustomPrint(id){

            // alert(id);

            $.ajax({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },

               type:'post',

							 cache: false,

               url:'{{route("Appraisal_view.ajax")}}',


               data:{id : id},

               dataType:'json',

               success:function(response)

               {
                        $('.imgLogo').show();
                        $('.retort_apr').show();
                        $('.mylux_watch').addClass('myLuxWatch');
                        $('.mywatch').addClass('my_watch');
                //    alert(response.data['template_name']);
                    var printContents = document.getElementById("print_doc").innerHTML;

                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;

                if(response.data['template_name']=='mywatch')
                 {
                     $('.my_watch').show();
                     $('.mywatchhead').show();
                     $('.myluxheade').hide();
                     $('.myLuxWatch').hide();
                     $('.print_sec').addClass("micustomborder");
                 }
                 else
                 {
                     $('.myLuxWatch').show();
                     $('.my_watch').hide();
                     $('.mywatchhead').hide();
                     $('.myluxheade').show();
                 }
                 var formatter = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                });
                    $("#print_doc").show();

                    $('.my_lux_watch').hide();

                    $('.Manufacturer_print').text(response.data['manufacturer']);

                    $('.model_number_print').text(response.data['model_name']);

                    $('.factory_model_print').text(response.data['factory_model']);

                    $('.serial_no_print').text(response.data['serial_no']);

                    $('.size_print').text(response.data['size']);
                    // var imghtml='<p><b>image</b></p>'+ response.html;
                    $('.image_print').html(response.html);

                    $('.dial_print').text(response.data['dial']);

                    $('#bezalPrint').text(response.data['bazel']);

                    $('.metal_print').text(response.data['metal']);

                    $('.bracelet_meterial_print').text(response.data['bracelet_meterial']);

                    $('.Crystal_print').text(response.data['crystal']);

                    $('.sp_value_print').text(formatter.format(response.data['sp_value']));

                    $('.appraisal_number_print').text(response.data['appraisal_number']);

                    // $('.appraisal_location_print').text(response.data['appraisal_location']);
                    $('.appraisal_add_location_print').text(response.data['appraised_address']);
                      $('.appraisal_location_print').text(response.data['appraisal_city']+ "," + response.data['appraisal_state']+ ","  +response.data['appraisal_zipcode'] );
                    $('.appraisal_name_print').text(response.data['appraised_name']);

                    $('.appraisal_date_print').text(response.data['appraisal_date']);

                    // var css = '@page { size: landscape; }',
                    // head = document.head || document.getElementsByTagName('head')[0],
                    // style = document.createElement('style');
										//
                    // style.type = 'text/css';
                    // style.media = 'print';
										//
                    // if (style.styleSheet){
                    // style.styleSheet.cssText = css;
                    // } else {
                    // style.appendChild(document.createTextNode(css));
                    // }
										//
                    // head.appendChild(style);
										setTimeout(() => {
											window.print();
											document.body.innerHTML = originalContents;
                                            AIZ.plugins.metismenu();
										}, "1000");

                    return true;


               }

            });

        }

        // $(document).ready(function() {

        //     if($('#appraisal_data').length > 0)

        //     {

        //         $('#appraisal_data').DataTable({

        //             "bPaginate": false,
        //             "searching": false

        //          });

        //         }

        //  });


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
