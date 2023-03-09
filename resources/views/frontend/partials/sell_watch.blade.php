@extends('frontend.layouts.app')

@section('content')
    <div class="sell_watch_page">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="text-align:center;margin: 70px 0px 70px 0px;">     
                <h2 style="margin-top:0px;font-family: Raleway; font-weight: 600; font-style: normal; font-size: 26px;">
                    SELL YOUR WATCH
                </h2>
                <p class="cls_sellwatch" style="margin-bottom:0px;">
                    <span style="font-size: 15px;">Selling your watch to GCI Jewelry is fast, safe and easy.</span>
                </p>
            </div>
            </div>
            <div class="row">
            <div class="col-md-6 cls_selltous"> 
                <h2 style="font-family: Raleway; font-weight: 600; font-style: normal; font-size: 26px;">
                OUR PROCESS</h2>
                <div class="row">
                    <div class="col-md-2">
                        <img src="https://gciwatch.com/assets/images/01.png" id="quote_image" alt=""> 
                    </div>
                    <div class="col-md-10">
                    <p class="cls_sellwatch">
                        <strong> Complete Form</strong>
                    </p>
                    <p class="cls_sellwatch" style="line-height: 22px;">
                        <span>Fill out the form on our website to get a quote for your watch.</span>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <img src="http://www.gciwatch.com/skin/frontend/varmo/default/images/quote.png" id="quote_image" alt="">
                </div>
            <div class="col-md-10">
                <p class="cls_sellwatch">
                    <strong>Get Quote</strong>
                </p>
                <p class="cls_sellwatch">
                    <span>We will evaluate your watch and will give a quote based on the information that you have provided.</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <img src="https://gciwatch.com/assets/images/02.png" id="quote_image" alt="">
            </div>
            <div class="col-md-10">
                <p class="cls_sellwatch">
                    <strong>Send Watch</strong>
                </p>
                <p class="cls_sellwatch">
                    <span>Along side the quote, we will give you a label fully insured to send your watch to us.</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <img src="http://www.gciwatch.com/skin/frontend/varmo/default/images/0d1439ff-search.png" id="quote_image" alt="">
            </div>
            <div class="col-md-10">
                <p class="cls_sellwatch">
                    <strong>Watch Inspection</strong>
                </p>
                <p class="cls_sellwatch">
                    <span>Once we receive the watch, our watchmakers authenticate your watch and evaluate its condition. Our team will then give you a final offer of your watch.</span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <img src="https://gciwatch.com/assets/images/03.png" id="quote_image" alt="">
            </div>
            <div class="col-md-10">
                <p class="cls_sellwatch">
                    <strong>Payment</strong>
                </p>
                <p class="cls_sellwatch">
                    <span>final offer is accepted, we process payment immediately.</span>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 sellmywatch_row">
        <div class="contact_form form_list ">
            <h2 style="margin: 0px 0px 17px 13px;font-family: Raleway; font-weight: 600; font-style: normal; font-size: 26px;">
                SELL NOW!
            </h2>
            <form action="{{Route('sell_my_watch.store')}}" method="post" id="sellmywatch" enctype="multipart/form-data" novalidate="novalidate" class="bv-form"><button type="submit" class="bv-hidden-submit" style="display: none; width: 0px; height: 0px;"></button>
                @csrf
                <div class="row">
                    <div class="col-md-6 form_item">            
                        <label for="name" class="required"><em style="color: red">*</em> First name</label>
                        <div class="input-box">
                            <input name="first_name"  class="form-control" type="text" required  value="{{old('first_name')}}">
                             <span class="text-danger" >  @error('first_name'){{$message}} @enderror </span>
                        </div>
                   </div>
                    <div class="col-md-6 form_item">
                        <label for="Lname" class="required"><em style="color: red">*</em> Last name</label>
                        <div class="input-box">
                            <input name="last_name" class="form-control" type="text" required value="{{old('last_name')}}">
                            <span class="text-danger">@error('last_name'){{$message}}@enderror </span>
                        </div>
                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form_item">
                        <label for="email" class="required"><em style="color: red">*</em> Email</label>
                        <div class="input-box">
                            <input name="email"  class="form-control " type="email" required  value="{{old('email')}}">
                            <span class="text-danger">@error('email'){{$message}}  @enderror </span>
                        
                        </div>
                        </div>
                        
                        <div class="col-md-6 form_item">
                            <label for="telephone" class="required"><em style="color: red">*</em> Phone Number</label>
                            <div class="input-box">
                                <input name="text" class="form-control" type="text" required value="{{old('text')}}">
                                <span class="text-danger">@error('text'){{$message}}@enderror </span>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form_item">
                        <label for="watchbrand" class="required"><em style="color: red">*</em> Watch Brand</label>
                        <div class="input-box select">
                            <select name="watch_brand"  class="form-control" required> 
                            <span class"text-danger">@error('watch_brand'){{$message}}@enderror </span>
                                 <option value="">Select a watch brand</option>
                                 <option value="A. Lange &amp; Söhne">A. Lange &amp; Söhne</option>
                                 <option value="Audemars Piguet">Audemars Piguet</option>
                                 <option value="Baume &amp; Mercier">Baume &amp; Mercier</option>
                                 <option value="Bell &amp; Ross">Bell &amp; Ross</option>
                                 <option value="Blancpain">Blancpain</option>
                                 <option value="Breguet &amp; Fils">Breguet &amp; Fils</option>
                                 <option value="Breitling">Breitling</option>
                                 <option value="Bremont">Bremont</option>
                                 <option value="Cartier">Cartier</option>
                                 <option value="Chopard">Chopard</option>
                                 <option value="Corum">Corum</option>
                                 <option value="Girard-Perregaux">Girard-Perregaux</option>
                                 <option value="Glashütte Original">Glashütte Original</option>
                                 <option value="Hublot">Hublot</option>
                                 <option value="IWC Schaffhausen">IWC Schaffhausen</option>
                                 <option value="Jaeger-LeCoultre">Jaeger-LeCoultre</option>
                                 <option value="Maurice LaCroix">Maurice LaCroix</option>
                                 <option value="Montblanc">Montblanc</option>
                                 <option value="Omega">Omega</option>
                                 <option value="Panerai">Panerai</option>
                                 <option value="Patek Philippe">Patek Philippe</option>
                                 <option value="Piaget">Piaget</option>
                                 <option value="Richard Mille">Richard Mille</option>
                                 <option value="Roger Dubuis">Roger Dubuis</option>
                                 <option value="Rolex">Rolex</option>
                                 <option value="TAG Heuer">TAG Heuer</option>
                                 <option value="Tudor">Tudor</option>
                                 <option value="Ulysse Nardin">Ulysse Nardin</option>
                                 <option value="Vacheron Constantin">Vacheron Constantin</option>
                                 <option value="Zenith">Zenith</option>
                                 <option value="Others">Others</option>
                            </select>                          
                        </div>
                        </div>
 
                        <div class="col-md-6 form_item">
                            <label for="ModelReferenceNumber" >Model/Reference Number</label>
                            <div class="input-box">
                                <input name="model_number"   class="form-control" type="text" required value="{{old('model_number')}}">
                                <span class="text-danger">@error('model_number'){{$message}}@enderror </span>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6 form_item">
                        <label for="DesiredAmount">Desired Amount</label>
                        <div class="input-box">
                            <input name="amount"  class="form-control" type="text" required value="{{old('amount')}}">
                            <span class="text-danger">@error('amount'){{$message}}@enderror </span>
                        </div>
                    </div>
                    <div class="col-md-6 form_item">
                        <label for="BoxesPapers" class="required"><em style="color: red">*</em> Boxes/Papers </label>
                        <div class="input-box selectbox">
                            <select name="box_paper" id="boxex_papers" class="form-control" required> 
                                                        <span class="text-danger">@error('box_paper'){{$message}}@enderror </span>

                               <option value="">Select Boxes/Papers</option>
                               <option value="Box only">Box only</option>
                               <option value="Papers only">Papers only</option>
                               <option value="Box and Papers">Box and Papers</option>
                               <option value="None">None</option> 
                            </select>      
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form_item">
                          <label for="UploadImage" id="UploadImage">Upload Image</label>
                          <div class="input-box">
                              <input name="image" id="image" class="" type="file">
                    <!--<span class="text-danger">@error('image'){{$message}}@enderror </span>-->

                          </div>
                    </div>
                    <div class="form_item col-md-6">
                        <label for="comment"><em style="color: red">*</em> Comment</label>
                        <div class="input-box">
                              <textarea name="comment"  rows="5" placeholder="Comment" required></textarea>
                               <span class="text-danger">@error('comment'){{$message}}@enderror </span>

                        </div>
                    </div>
                </div>
                <div class="row">      
                    <!--<div class="col-md-6 form_item">-->
                    <!--  <div id="recaptcha" class="g-recaptcha" data-callback="verifyCaptcha" data-sitekey="6LfEs9sUAAAAADBn3oxynv00atDhn328Cvdjuure"><div style="width: 304px; height: 78px;"><div><iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LfEs9sUAAAAADBn3oxynv00atDhn328Cvdjuure&amp;co=aHR0cHM6Ly9nY2l3YXRjaC5jb206NDQz&amp;hl=en&amp;v=g8G8cw32bNQPGUVoDvt680GA&amp;size=normal&amp;cb=on4xc3ltrkwi" width="304" height="78" role="presentation" name="a-k5has3huevq4" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div></div>-->
                    <!--  <span id="sell_msg_error" style="color: red; font-size: 85%;"></span>-->
                    <!--</div>-->
                    <div class="col-md-6">                            
                        <div class="form_item form-action" id="cls_add_btn"> 
                          <button type="submit" class="btn btn-primary" id="add_sell_btns" name="add_sell">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
      
    </script>
@endsection
