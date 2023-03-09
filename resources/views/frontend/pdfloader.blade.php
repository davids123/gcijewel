<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>

	</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>

<div id="print_doc">
    <style>
        @media print {
            @page {
                margin: 0mm 0mm 0mm 2mm !important;
                width:100% !important;
                size: A4 landscape;
                }
            body{
            padding:0px !important;
            border:none !important;
            }
            .mi_print{
                wodth:100% !important;
                padding:10px;
            }
            .print_sec.left .print_innner_sec{
                margin-right:2px;
                padding:5px 5px;
            }
            .print_sec.right .print_innner_sec{
               margin-left:2px;
               padding:5px 5px;
            }
            .imgLogo{
                width:350px;
                margin-top:20px !important;
                margin:0 auto;
            }
            .report_text h3{
                margin-bottom:10px;
                margin-top:20px;
                font-weight: 600;
                font-size:30px;
            }
            .report_text p{
                font-size:22px;
                margin:0px;
                padding-left:0px;
                line-height:30px !important;
            }
            p.retort_velu{
                font-size:22px;
                height:25px !important;
            }
            .appraised_value{
                margin-top:50px;
                margin-bottom:20px;
            }
            .appraised_value p{
                border:5px solid #f3cb84;
                padding:5px 5px;
                font-size:25px;
                font-weight: 600;
            }
            .product_img{
                height:650px;
                width:100%;
                text-align:center;
                /*padding-top:30px;*/
                /*padding-bottom:30px;*/
            }
            .product_img p{
                text-align:left;
                font-size:22px;
            }
            .product_img img{
                width:500px;
                margin:30px auto;
            }
            .appraised_ditel{
                width:100%;
                text-align:center;
                color:#000 !important;
                /*background-image: url('https://gcijewel.com/public/uploads/all/bg-black.jpg') !important;*/
                background-color:#f3cb84 !important;
            }
            .signature_div{
                text-align:center;
            }
            .appraised_ditel h3{
                 font-weight: 600;
            }
            .appraised_ditel p{
                font-size:20px;
            }
            .appraisal_nu-loc-dat h3{
                font-weight: 600;
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

            }
            .print_sec.right{
                margin-top:8% !important;
            }
            p.retort_apr{
                font-weight: 600;
                font-size:16px;
            }

        }
    </style>
    <div class="mi_print">
        <div class="row">
            <div class="print_sec left col-12">
                 <div class="print_innner_sec">
                    <!--  <center> <div style='backgroud:#000;' class="mywatch retort_apr"> <img src='https://gcijewel.com/public/uploads/all/watch123456.png' class='imgLogo retort_apr'> </div>-->
                    <!--<div style='backgroud:#000; ' class="mylux_watch retort_apr"> <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo retort_apr'> </div></center>-->
                   <center> <div style='backgroud:#000;' class="mywatch retort_apr"> <img src='https://gcijewel.com/public/uploads/all/XntIbIwqcnhixLCgdDcJlo41Rb5UZ3hkSGj0KREf.jpg' class='imgLogo retort_apr'> </div></center>
                    <div style='backgroud:#000; ' class="mylux_watch retort_apr" style="text-align: center;"> <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo retort_apr'> </div>
                    <div class="report_text">
                    <h3 class='retort_apr mywatchhead' style="text-align: center;">Appraisal Report</h3>
                     <h3 class='retort_apr myluxheade'>Appraisal Report</h3>
                    <p style="letter-spacing: 2px !important;text-align:center; font-size:20px;" class='retort_apr mywatchhead'>The following appraisal service report identifies the characteristics of the<br> referenced watch at the time of inspection. This appraisal report establishes<br> the new retail replacement value in the most common and appropriate jewelry <br>markets, to provide a basis for obtaining insurance.</p>
                    <p style="letter-spacing: 2px !important; font-size:20px;" class='retort_apr myluxheade'>The following appraisal service report identifies the characteristics of the<br> referenced watch at the time of inspection. This appraisal report establishes<br> the new retail replacement value in the most common and appropriate jewelry <br>markets, to provide a basis for obtaining insurance.</p>
                    <h3 style="margin-top:25px !important;" class='retort_apr'>Features</h3>
                    <p class='retort_apr retort_velu'><b>Manufacturer</b> : <span class="Manufacturer_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Model Name</b> : <span class="model_number_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Factory Model</b> : <span class="factory_model_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Serial No.</b> : <span class="serial_no_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>size</b> : <span class="size_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Dial</b> : <span class="dial_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Bezal</b> : <span id="bezalPrint"> </span></p>
                    <p class='retort_apr retort_velu'><b>Metal</b> : <span class="metal_print"> </span></p>
                    <p class='retort_apr retort_velu'><b>Bracelet Meterial</b> : <span class="bracelet_meterial_print"> </span></p>
                    <!--<p><b>Crystal</b> : <span class="Crystal_print"> </span></p>-->
                    </div>
                    <div class="appraised_value retort_apr">
                        <p style="text-align:center; font-size:25px;" class='retort_apr'>Suggested Appraised Value*: <span  class="sp_value_print"> </span></p>
                    </div>
                    <div class='image_print product_img retort_apr' >
                    </div>
                </div>
            </div>

            <div class="print_sec right col-12">
                <div class="print_innner_sec retort_apr">
                    <center> <div style='backgroud:#000;' class="mywatch"> <img src='https://gcijewel.com/public/uploads/all/XntIbIwqcnhixLCgdDcJlo41Rb5UZ3hkSGj0KREf.jpg' class='imgLogo'> </div>
                    <div style='backgroud:#000; ' class="mylux_watch" style="text-align: center;"> <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo'> </div></center>
                    <br>
                    <h3 style=" margin-bottom:10px; margin-top:10px;font-weight: 600; font-size:30px;text-align:center;" class='retort_apr'>Appraised For</h3>
                    <div class="appraised_ditel">
                        <h3 class='retort_apr'>Danny yoo</h3>
                        <p class='retort_apr'>2215 cedar spring rd apt 204<br>Dallas texas</p>
                    </div>
                    <div class="signature_div">
                        <p class='retort_apr'>Inspected/Appraised by Myluxapp.com</p>
                        <br>
                        <p class='retort_apr'></p>
                        <br>
                    </div>
                    <div class="appraisal_nu-loc-dat retort_apr">
                    <h3 class='retort_apr'>Details of Appraisal</h3>
                    <p class='retort_apr'>Appraisal Number: <b><span class='appraisal_number_print'></span></b></p>
                    <p class='retort_apr'>Appraisal Location: <b><span class='appraisal_location_print'></span></b></p>
                    <p class='retort_apr'>Date: <b><span class='appraisal_date_print'></span></b></p>
                    </div>
                    <center> <div style='backgroud:#000;' class="mywatch"> <img src='https://gcijewel.com/public/uploads/all/XntIbIwqcnhixLCgdDcJlo41Rb5UZ3hkSGj0KREf.jpg' class='imgLogo retort_apr'> </div>
                    <div style='backgroud:#000; ' class="mylux_watch" style="text-align: center;"> <img src='https://gcijewel.com/public/uploads/all/logo_my.png' class='imgLogo retort_apr'> </div></center>
                    <br>
                    <div class="appraisal_dec retort_apr">
                        <p class='retort_apr'>Any questions regarding this appraisal can be sent to myWatchDealer.com via email at sales@mywatchdealer.com or can be mailed to:<br> myWatchDealer.com 650 S. Hill St. Suite 317  Los Angeles, CA 90014 213-985-3753 </p>
                        <p class='retort_apr'>*myluxapp.com is a registered DBA of Shak Corp Inc. This is not an invoice or receipt of sale. Suggested MSRP/Appraised Value is calculated based on estimated market prices for this item sold in other retail stores at the time of appraisal. myluxapp.com provides appraisal and other related services for Watches, Jewelry, Diamonds and Gold. myluxapp.com is a not affiliated with any of the brands of watches, jewelry, diamonds and/or gold that have been appraised in this report, unless specified otherwise. The values set forth herein are estimates of the current market price at which the appraised jewelry may be purchased in theaverage fine jewelry store at the time of appraisal. Because jewelry appraisal and evaluation is subjective, estimates of replacement value may vary from one appraiser toanother and such a variance does not necessarily constitute error on part of theappraiser. This appraisal should not be used as the basis for the purchase or sale of the items set forth herein and is provided, solely as an estimate of approximate replacement values of said items at this time and place. Accordingly, we assume no liability with respect to any legal action that may be taken, as a result of, the information contained in this appraisal.</p>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<button type="button" id="prntBtn">prntBtn</button>
<script>


$(document).on("click","#prntBtn",function(){
  var css = '@page { size: landscape; }',
    head = document.head || document.getElementsByTagName('head')[0],
    style = document.createElement('style');

style.type = 'text/css';
style.media = 'print';

if (style.styleSheet){
  style.styleSheet.cssText = css;
} else {
  style.appendChild(document.createTextNode(css));
}

head.appendChild(style);
  window.print();

})
</script>

</body>
</html>
