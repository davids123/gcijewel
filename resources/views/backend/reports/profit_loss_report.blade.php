@extends('backend.layouts.app')
<style>
	.align_text
	{
     text-align:center;
	}
	.mi_listing_type .col-md-3 {
	max-width: 70%;
}
.mi_listing_type {
position: absolute;
right: 210px;
top: 0px;
width: 100%;
}
.mi_listing_type .dropdown-toggle .filter-option-inner-inner{
    color:#000;
}
	</style>
@php  setlocale(LC_MONETARY,"en_US");  @endphp
@section('content')
	<div class="aiz-titlebar text-left mt-2 mb-3">
		<div class=" align-items-center">
	       <h1 class="h3">{{translate('Profit and Loss')}}</h1>
		</div>
	</div>
	<form class="" id="sort_products" action="" method="GET">
		<div class="col-md-3 ml-auto d-flex style="margin-left: 0 !important; max-width:28% !important;">
		    <div class="date_year_box row" style="right:31px;">
		        <i class="las la-calendar"></i>
                <i class="fa fa-calendar"></i>&nbsp;
                <input type="hidden" name="startrangedate" class="startrangedate" value="">
                <input type="hidden" name="endrangedate" class="endrangedate" value="">
                <input type="text" name="reportrange" id="reportrange" value="01/01/2018 - 01/15/2018" />
                <span></span> <i class="fa fa-caret-down"></i>
                <i class="las la-angle-down"></i>
			</div>
			<button type="submit" id="warehouse_type" name="warehouse_type" class="d-none calendar_submit"><i class="las la-search aiz-side-nav-icon" ></i></button>

		<div class="mi_listing_type">
            <div class="col-md-3 ml-auto d-flex">
                <select class="form-control form-control-sm aiz-selectpicker mb-2 mb-md-0" name="listing_type" id="product_type" data-live-search="true">
                    <option value="">All Listing Type</option>
                    @foreach (App\SiteOptions::where('option_name', '=', 'listingtype')->get() as $p_type_filter)
                        <option value="{{$p_type_filter->option_value}}" @if($p_type_filter->option_value == Request::get('listing_type')) selected @endif>{{ $p_type_filter->option_value }}</option>
                    @endforeach;
                </select>
                <button type="submit" id="pro_type"  class="d-none"><i class="las la-search aiz-side-nav-icon" ></i></button>
            </div>
        </div>
        </div>
		@php
    		$total_sale=0;
    		$profitsale=0;
    		foreach($sales as $row)
    		{
    		    $total_sale+=$row->sub_total;
    		    $profitsale+=$row->product_cost;
    		}
    		$avarge_sale_price=$total_sale-$profitsale
		@endphp
		<div class="row profit_boxs">
			<div class="col-md-4">
				<div class="sales sales_orang">
					<p>Sales ({{$sales->count()}})</p>
					<i class="las la-star"></i>
					<div class="row price">
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%(#1n",$total_sl)."\n"}}</h2>
								<p>Total Sales</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%+n",$avrg_sale_cost)."\n"}}</h2>
								<p>Total Profit</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="sales invoice_green">
					<p>Invoice ({{$invoice->count()}})</p>
					<i class="las la-heart"></i>
					<div class="row price">
						<div class="col-md-6">
							<div class="prise-box">
									<h2 class="align_text">{{money_format("%(#1n",$total_in)."\n"}}</h2>
								<p>Total Sales</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="prise-box">
									<!-- <h2 class="align_text">{{ $avrg_invoice_cost }}</h2> -->
									<h2 class="align_text">{{money_format("%+n",$avrg_invoice_cost)."\n"}}</h2>
								<p>Total Profit</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			@php $tradecount=0;  @endphp
			<div class="col-md-4">
				<div class="sales trade_red">
					<p>Trade ({{$trade->count()}})</p>
					<i class="las la-random"></i>
					<div class="row price">
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%(#1n",$total_trd)."\n"}}</h2>
								<p>Total Sales</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%+n",$avrg_trd_cost)."\n"}}</h2>
								<p>Total Profit</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			@php $tradengdcount=0;  @endphp
			<div class="col-md-4">
				<div class="sales trade_green">
					<p>TradeNGD ({{$tradeNGD->count()}})</p>
					<i class="las la-dollar-sign"></i>
					<div class="row price">
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%(#1n",$total_trdNGD)."\n"}}</h2>
								<p>Total Sales</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="prise-box">
								<h2 class="align_text">{{money_format("%+n",$avrg_trdNGD_cost)."\n"}}</h2>
								<p>Total Profit</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection
@section('script')

<script type="text/javascript">
$(function() {
  <?php if($startrangedate != ""){ ?>
    var start = "<?php echo $startrangedate; ?>";
    start = moment(start);
  <?php  }else{ ?>
    var start = '';
  <?php  }   ?>

  <?php if($endrangedate != ""){ ?>
    var end = "<?php echo $endrangedate; ?>";
    end = moment(end);
  <?php  }else{ ?>
    var end = '';
  <?php }   ?>

    function cb(start, end) {
        $('#reportrange span').html(start.format('MM/DD/YYYY') + ' - ' + end.format('MM / DD / YYYY'));
        $('.startrangedate').val(start.format('MM/DD/YYYY'));
        $('.endrangedate').val(end.format('MM/DD/YYYY'));

    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This fiscal year': [moment().startOf('year'), moment().endOf('year')],
           'Last fiscal year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    }, cb);
console.log(start);
console.log(end);
    cb(start, end);
    // $('#date_reng').trigger('click');

});
$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
		$('.calendar_submit').trigger('click');
});

</script>
@endsection
