@extends('frontend.layouts.app')

@section('content')


    <!--<div class="home-banner-area mb-4">-->
    <!--    <div class="container-fluid" style="padding:0px;">-->
    <!--        <div class="row gutters-10 position-relative">-->
               
               <div class="watch_servies_page">
                   <div class="watch_servies_section">
                    <div class="card-header">
                        <h5 class="mb-0 h6">{{translate('Watch services')}}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table aiz-table mb-0">
                            <thead>
                                <tr>
                                    <th>{{translate('Name')}}</th>
                                    <th>{{translate('Cost')}}</th>
                                 </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Assemble/Disassmble</td>
                                    <td>100-200</td>
                                </tr>
                                <tr>
                                    <td>Change Dial</td>
                                    <td>80-150</td>
                                </tr>
                                <tr>
                                    <td>Change Bezel</td>
                                    <td>50-150</td>
                                </tr>
                                <tr>
                                    <td>Change Bands</td>
                                    <td>50-150</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                     <p><b>*Disclaimer Note:</b> Watch Service are not limited to the list above. For other services and concerns feel free to contact us. Price are subject to change."</p>
                  <button class="btn btn-sm btn-soft-primary mr-2 add-to-cart fw-600" onclick="service_form()" style="font-size:15px;">{{ translate('Service Request Formquire')}}</button>
              </div>
               </div>
<!--service form model -->

  <div class="modal fade mi_watch_form" id="service_form_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">

            <div class="modal-content position-relative">

                <div class="modal-header">

                    <h5 class="modal-title fw-600 h5">{{ translate('Service Request Form')}}</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <form class="" action="{{ route('products.watch_service_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body gry-bg px-3 pt-3">

                        <div class="form-group">

                            <label>Type *</label>

                            <select name="type" required>
                                <option value="Watch">Watch</option>
                                <option value="Jewelry">Jewelry</option>
                                <option value="Others">Others</option>
                            </select>

                        </div>

                        <div class="form-group">

                            <label>Model *</label>

                            <input type="text" class="form-control mb-3" name="model" value="" required>

                        </div>

                        <div class="form-group">

                            <label>Brand *</label>

                            <input type="text" class="form-control mb-3" name="brand" value=""  required>

                        </div>

                        <div class="form-group">

                            <label>Serial  *</label>

                            <input type="text" class="form-control mb-3" name="serial " value=""  required>

                        </div>

                        <div class="form-group">

                            <label>Job Details *</label>

                          <select name="job_details" required>
                              <option value="Polish">Polish</option>
                              <option value="Overhual">Overhual</option>
                              <option value="Change/Put Dial">Change/Put Dial</option>
                              <option value="Swap Dial">Swap Dial</option>
                              <option value="Swap Bezel">Swap Bezel</option>
                          </select>
                        </div>
                        <div class="form-group">

                            <label>Images  *</label>

                            <input type="file" class="form-control mb-3" name="image " value=""  required>

                        </div>
                        
                        <div class="form-group">

                            <label>Description of Problem *</label>
                            <textarea class="form-control" rows="8" name="description" required ></textarea>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-outline-primary fw-600" data-dismiss="modal">{{ translate('Cancel')}}</button>

                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send')}}</button>

                    </div>

                </form>

            </div>

        </div>

    </div>


@endsection

@section('script')
    <script>
       function service_form(){

            @if (Auth::check())

                $('#service_form_model').modal('show');

            @else

                $('#service_form_model').modal('show');

            @endif

        }

    </script>
@endsection
