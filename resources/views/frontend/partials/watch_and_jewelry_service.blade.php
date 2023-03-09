@extends('frontend.layouts.app')
<!-- <style media="screen">
.ReloadBtn {

background-size : 100%;
width: 32px;
height: 32px;
border: 0px; outline none;
position: absolute;
bottom: 30px;
left : 310px;
outline: none;
cursor: pointer; /**/
}
</style> -->
<style>
h3.tm{
    font-weight: bold;
    font-family: MV Boli;
    font-size: 40px;
    text-align: center;
    word-spacing: 8px;
}

.jewelry_service_left .card-body {
	text-align: center;
}
.watch_mi {
	width: 350px;
	margin: 0 auto;
	text-align: left;
}
/*.modal-content .modal-body{*/
/*    overflow:hidden !important;*/
/*}*/
.modal-content .mi_watch_service .modal-body{
    overflow-y: scroll !important;
    padding-bottom: 50px !important;
}
.mi_watch_service .capt.myform {
    background-color: #fff;
}
@media screen and (max-width: 991px) {
.jewelry_service_left .card-body {
	padding: 5px !important;
}
.jewelry_service_left .card-body h3 {
	font-size: 28px !important;
}
.watch_mi {
	width: 100%;
	padding-left: 10px;
}

}
</style>
@section('content')
        <div class="watch_servies_page">
        <div style="height:420px;" class="wt watch_Jewelry_servies_section">
            <!--<div class="row" >-->
            <!--    <div class="col-md-12" style="padding:0px;">-->
            <!--    <img src="https://gcijewel.com/public/uploads/all/Watch-and-17.09.2022.jpg" style="width:100%;">-->
            <!--    </div>-->
            <!--</div>-->
            <div class="row cr" style="display:block;">
                <div class="col-md-6" style="max-width: 100%;">
                    <div class="jewelry_service_left">
               <div class="card-body" style="padding-left:40px; padding-top:30px;">
             <h3 class="mb-0 h6 font-bold tm " style="font-size:40px;">{{translate('Watch  and Jewelry Services')}}</h3> 
         <div class="watch_mi">
             <p class="text_sec_point ">- Service/Overhauls</p>
            <p class="text_sec_point ">- Polish </p>
            <p class="text_sec_point ">- Jewelry Care and Maintenance </p>
            <p class="text_sec_point ">- Jewelry Repair </p>
            <p class="text_sec_point ">- Custom Piece </p>
            </div>
            <p class="disclaimer_text"><b>*Disclaimer Note:</b> Services are not limited to the list above. For other services and concerns feel free to contact us.</p>
        <button class="btn btn-sm btn-soft-primary mr-2 add-to-cart fw-600 mi_btn_watch_Jewelry_servies" onclick="show_watch_re_modal()" style="font-size:15px;">{{ translate('Service Request Form')}}</button>
        </div>
        </div>

                </div>
                <div class="col-md-6">
                    <div class="jewelry_service_right">
                        <!--<img src="https://gcijewel.com/public/uploads/all/watch-text1.jpg">-->
                    <!--<div  class="watch_Jewelry_logo" style="margin-top:15px;">-->
                    <!--    <img src="https://gcijewel.com/public/uploads/all/logo_gci.jpg" alt="" class="" height="">-->
                    <!--</div>-->
                    <!--<div class="watch_Jewelry_servies_text">-->
                    <!--    <h2>GCI JEWELRY</h2>-->
                    <!--    <p>650 S, Hill St, Suite 318 Los Angeles CA 90014 Tel:213-373-4424</p>-->
                    <!--</div>-->
                    </div>
                    </div>
            </div>
    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <p class="cls_content_footer_static"><b>-->
    <!--            GCI Jewelry (GCI) nor any of our affiliates are authorized dealers for Rolex and/or any brand that is directly sold by them. GCI and/or affiliates are not responsible for any typos, mistakes, and/or errors found in this site. Accordingly, we assume no liability with respect to any legal action that may be taken, as a result of, the information contained in this site. GCI and/or affiliates are not responsible for any typos, mistakes, and/or errors found in this document. Price and availability are subject to change without prior notice. All intellectual property rights such as trademarks, trade names, designs and copyrights are reserved and are exclusively owned by Rolex and/or their respective owners. GCI Jewelry is a DBA of Shak Corp. Shak Corp nor any of its affiliates are affiliated with Rolex, Audemars Piguet, Cartier, Panerai and/or any other brand of watch referenced on this site. GCI Jewelry is a 3rd party independent seller of used and unworn watches and jewelry.-->
    <!--        </b></p>-->
    <!--    </div>-->

    <!--</div>-->
    </div>
    </div>

<!--service form model -->

 <!--dimond model-->
 <div class="modal fade" id="watch_re_model" >

        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal ser" id="modal-size" role="document">
            <div class="modal-content position-relative" style="top:40px;">
                <div class="mi_watch_service">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5 ">{{ translate('Service Request Form')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="capt myform" action="{{ route('conversations.diamond.store') }}" method="POST" id="serviceReq">
                    @csrf
                    
                    
                <!--    @if($errors->any())-->
                <!--   <ul class="alert alert-danger">-->
                <!--      @foreach($errors as $error)-->
                <!--         <li> {{$error}} </li>-->
                <!--      @endforeach-->
                <!--   </ul>-->
                <!--@endif-->
                    <div class="modal-body gry-bg  pt-3">
                        <div class="form-group">
                            <label>Company Name *</label>
                              <input type="hidden" name="request_type" value="Watch Repair">
                            <input type="text" class="form-control mb-3" name="company" id="company_name" value="" placeholder="{{ translate('Company Name') }}" required="" >
                            <span class="text-danger" >  @error('company'){{$message}} @enderror </span>
            
                        </div>
                        <div class="form-group">
                            <label >Contact Name *</label>
                           
                           <input type="text" class="form-control mb-3" name="name" id="Contact_Name" value="" placeholder="{{ translate('Contact Name') }}" required="">
                           <span class="text-danger" >  @error('name'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Contact Number *</label>
                            <input type="number" class="form-control mb-3" name="phone" id="Contact_Number" value="" placeholder="{{ translate('Contact Number') }}" required="">
                            <span class="text-danger" >  @error('phone'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Email *</label>
                            <input type="email" class="form-control mb-3" name="email" id="email" value="" placeholder="{{ translate('Email') }}" required="">
                            <span class="text-danger" >  @error('email'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Address *</label>
                            <input type="text" class="form-control mb-3" name="address"  id="address" value="" placeholder="{{ translate('Address') }}" required="">
                            <span class="text-danger" >  @error('address'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>City *</label>
                            <input type="text" class="form-control mb-3" name="city" id="city" value="" placeholder="{{ translate('City') }}" required="">
                                                        <span class="text-danger" >  @error('city'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>State *</label>
                            <input type="text" class="form-control mb-3" name="state" id="state" value="" placeholder="{{ translate('State') }}" required="">
                             <span class="text-danger" >  @error('state'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Zip *</label>
                            <input type="hidden" name="getmail" value="@if(Cookie::get('cookiemail') !== false){{ Cookie::get('cookiemail') }}@endif">
                            <input type="text" class="form-control mb-3" name="zip" id="zip" value="" placeholder="{{ translate('Zip') }}" required="">
                             <span class="text-danger" >  @error('zip'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Brand *</label>
                            <input type="text" class="form-control mb-3" name="brand" id="brand" value="" placeholder="{{ translate('Brand') }}" required="">
                         <span class="text-danger" >  @error('brand'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Model *</label>
                            <input type="text" class="form-control mb-3" name="model" id="model" value="" placeholder="{{ translate('Model') }}" required="">
                        <span class="text-danger" >  @error('model'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Serial *</label>
                            <input type="text" class="form-control mb-3" name="serial" id="serial" value="" placeholder="{{ translate('Serial') }}" required="">
                         <span class="text-danger" >  @error('serial'){{$message}} @enderror </span>
                        </div>
                        <div class="form-group">
                            <label>Description of the problem *</label>
                            <textarea class="form-control" rows="8" name="description" id="Description" required placeholder="{{ translate('Description of the problem') }}"></textarea>
                         <span class="text-danger" >  @error('description'){{$message}} @enderror </span>
                        </div>
                        
                        
                        @php $error_message="" ; @endphp
                        <!-- <div class="form-group">
                          <fieldset>
                            <input type="text" id="UserCaptchaCode" class="form-control mb-3 CaptchaTxtField" placeholder='Enter Captcha - Case Sensitive'>
                            <span id="WrongCaptchaError" class="error"></span>
                            <div class='CaptchaWrap'>
                              <div id="CaptchaImageCode" class="CaptchaTxtField">
                                <canvas id="CapCode" class="capcode" width="300" height="80"></canvas>
                              </div>
                            </div>
                          </fieldset>
                        </div> -->

                        <div class="form-group">
                              <div class="form-group">
                                  <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                              </div>
                        </div>
                          <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>
                        <button type="button" class="btn btn-primary fw-600 addDisable">{{ translate('Send')}}</button>
                    </div>
                    </div>

                  
                    @if(isset($success_message))
                        <div class="demo-success"> {{$success_message}}</div>
                    @endif
                </form>
            </div>
        </div>
         </div>
    </div>

@endsection

@section('script')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
       function show_watch_re_modal(){
            $('#watch_re_model').modal('show');
        }
    </script>

    <script type="text/javascript">

        // making the CAPTCHA  a required field for form submission
        $(document).ready(function(){
            // alert('helloman');
            $(".addDisable").on("click", function(evt)
            {
                var response = grecaptcha.getResponse();
                // console.log(response.length);
                if(response.length == 0)
                {
                //reCaptcha not verified
                    alert("please verify you are human!");
                    evt.preventDefault();
                    return false;
                }
                //captcha verified
                //do the rest of your validations here
                $("#serviceReq").submit();
            });
        });
        
        
        // $(document).ready(function(){
        //     $('.myform').submit(function(e){
        //       e.preventDefault();
        //       var myfrm = $(this).serialize();
              
        //       $.ajax({
        //           url:"{{route('conversations.diamond.store')}}",
        //           type:"post",
        //           data: {
        //                 "_token": "{{ csrf_token() }}",
        //                 "formData": myfrm
        //                 },
        //           success:function(response){
                      
        //             console.log(response);  
                      
        //           }
                   
        //       });
                
        //     });
        // });
        
        
        
        
        
        
    </script>
@endsection
