 @extends('backend.layouts.app')

@section('content')

<style>

.permistion {
padding-left: 10px;
border: 1px solid #ccc;
}
.fa-solid.fa-folder-open {
border-right: 1px solid #ccc;
padding: 10px;
color:#428bca
}
.g-per{
display: inline-block;
font-size: 16px;
margin: 0px;
color:#428bca
}
.group p{
margin: 0px;
padding: 10px;
border: 1px solid #ccc;

}
.table{
  padding:10px;
  border:1px solid #ccc
}
table {
width: 100%;
border: 1px solid black;
font-family: arial, sans-serif;
border-collapse: collapse;
}
td.staff {
background-color: #428bca;
color: white;
}
.module{
border: 1px solid #ccc;
width: 11%;
}
th.permission {
border: 1px solid #ccc;
text-align:center;
}
.view{

    border: 1px solid #ccc;
}
th {
    border: 1px solid #ccc;
    font-weight: 400;
}
th.miscell{
    width: 70%;
    text-align:center;
}
tr {
    height: 25px;
}
tr:nth-child(even) {
    background-color: #f9f9f9;
  }
  td{
      text-align: center;
      border: 1px solid #ccc;
      font-size: 13px;
  }
  td.check {
    text-align: left;
}
td.memo {
    text-align: left;
    height: 40px;
}
.dash {
    text-align: left;
  }
  .deposit{
      text-align: left;
  }
  .btn-1{
    margin: 9px 5px;
    display: inline-block;
    padding: 7px 19px;
    color: white;
    background-color: #428bca;
  }
  .mi_table_permissions {
text-transform: capitalize;
}
  .mi_table_permissions tr td input{
      margin:0px 8px;
  }
</style>

<div class="col-lg-12 mx-auto">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Role Information')}}</h5>
        </div>
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-3 col-from-label" for="name">{{translate('Name')}}</label>
                    <div class="col-md-9">
                        <input type="text" placeholder="{{translate('Name')}}" id="name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="card-header">
                    <h5 class="mb-0 h6">{{ translate('Permissions') }}</h5>
                </div>
                <br>
                <div class="form-group row">
                    <label class="col-md-2 col-from-label"></label>
                    <div class="col-md-8">
                        @if (addon_is_activated('pos_system'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('POS System') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="1">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Dashboard') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="310">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Products') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="2">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Memo') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="3">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('All Orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="3">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Inhouse orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="4">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Seller Orders') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="5">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Pick-up Point Order') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="6">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        @if (addon_is_activated('refund_request'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('Refunds') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="7">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif -->
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Customers') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="8">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Sellers') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="9">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Reports') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="10">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Marketing') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="11">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Support') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="12">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Website Setup') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="13">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Setup & Configurations') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="14">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- @if (addon_is_activated('affiliate_system'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('Affiliate System') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="15">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif
                        @if (addon_is_activated('offline_payment'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('Offline Payment System') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="16">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif
                        @if (addon_is_activated('paytm'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('Paytm Payment Gateway') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="17">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif
                        @if (addon_is_activated('club_point'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('Club Point System') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="18">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif
                        @if (addon_is_activated('otp_system'))
                          <div class="row">
                              <div class="col-md-10">
                                  <label class="col-from-label">{{ translate('OTP System') }}</label>
                              </div>
                              <div class="col-md-2">
                                  <label class="aiz-switch aiz-switch-success mb-0">
                                      <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="19">
                                      <span class="slider round"></span>
                                  </label>
                              </div>
                          </div>
                        @endif -->
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Staffs') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="20">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Addon Manager') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="21">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Uploaded Files') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="22">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('Blog System') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="23">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div> -->
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('System') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="24">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <label class="col-from-label">{{ translate('People') }}</label>
                            </div>
                            <div class="col-md-2">
                                <label class="aiz-switch aiz-switch-success mb-0">
                                    <input type="checkbox" name="permissions[]" class="form-control demo-sw" value="25">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group">
                    <div class="permistion">
                    <i class="fa-solid fa-folder-open"></i>
                    <h1 class="g-per">Group Permission</h1>
                </div>
                    <p>please set group permission bellow</p>
                </div>
                <div class="table">
                <table class="mi_table_permissions">
                    <tr class="staff">
                        <td class="staff" colspan="6">staff (staff) group permitions</td>
                    </tr>
                    <tr class="rowspan">
                        <th class="module" rowspan="2">module name</th>

                        <th class="permission" colspan="5">permission</th>
                    </tr>
                    <tr class="view">

                        <th>view</th>
                        <th>add</th>
                        <th>edit</th>
                        <th>delete</th>
                        <th class="miscell">miscellaneous</th>


                    </tr>
                    <tr>
                        <th>sequence</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="1"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="2"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="3"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="4"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="5"> cost code multiplier <input type="checkbox" name="inner_permissions[]" value="6"> export </td>
                    </tr>
                    <tr>
                        <th>product type</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="7"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="8"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="9"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="10"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="11"> export</td>
                    </tr>
                    
                    <tr>
                        <th>Listing type</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="118"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="119"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="120"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="121"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="122"> export</td>
                    </tr>
                    <tr>
                        <th>Inventory Run</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="123"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="124"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="125"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="126"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="127"> export</td>
                    </tr>
                    <tr>
                        <th>product</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="12"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="13"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="14"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="15"></td>
                        <td class="check"> <input type="checkbox" name="inner_permissions[]" value="16">product cost <input type="checkbox" name="inner_permissions[]" value="17">units <input
                                type="checkbox" name="inner_permissions[]" value="18">partners <input type="checkbox" name="inner_permissions[]" value="19">brands <input type="checkbox" name="inner_permissions[]" value="20">conditions <input
                                type="checkbox" name="inner_permissions[]" value="21">model <input type="checkbox" name="inner_permissions[]" value="22">metel <input type="checkbox" name="inner_permissions[]" value="23">sizes <input
                                type="checkbox" name="inner_permissions[]" value="24">warehouses <input type="checkbox" name="inner_permissions[]" value="25">supplier <input type="checkbox" name="inner_permissions[]" value="26">import <input
                                type="checkbox" name="inner_permissions[]" value="27">export   <input type="checkbox" name="inner_permissions[]" value="202">All Uploads <input type="checkbox" name="inner_permissions[]" value="203
                                ">Product Uploads</td>
                    </tr>
                    <tr>
                        <th>memo</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="28"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="29"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="30"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="31"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="32">export</td>
                    </tr>
                    <tr>
                        <th>job order</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="33"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="34"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="35"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="36"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="37">export</td>
                    </tr>
                    <tr>
                        <th>customers</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="38"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="39"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="40"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="41"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="42">export</td>
                    </tr>
                    <tr>
                        <th>suppliers</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="43"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="44"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="45"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="46"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="47">export</td>
                    </tr>
                    <tr>
                        <th>agent</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="48"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="49"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="50"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="51"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="52">export</td>
                    </tr>
                    <tr>
                        <th>transfers</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="53"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="54"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="55"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="56"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value=""> export</td>

                    </tr>
                    <tr>
                        <th>return</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="57"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="58"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="59"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="60"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value=""> export</td>

                    </tr>
                    <tr>
                        <th>appraisal</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="61"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="62"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="63"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="64"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value=""> export</td>

                    </tr>
                    <tr>
                        <th>price group</th>
                        <td> <input type="checkbox" name="inner_permissions[]" value="65"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="66"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="67"></td>
                        <td><input type="checkbox" name="inner_permissions[]" value="68"></td>
                        <td class="check"><input type="checkbox" name="inner_permissions[]" value="69">export</td>
                    </tr>
                    <tr class="rowspan">
                        <th class="report" rowspan="2">reports</th>

                        <td class="memo" colspan="5"><input type="checkbox" name="inner_permissions[]" value="70"> In House Product Sale  <input type="checkbox" name="inner_permissions[]" value="204"> Sales Report<input type="checkbox" name="inner_permissions[]" value="71"> warehouses stock <input
                                type="checkbox" name="inner_permissions[]" value="72"> best sellers <input type="checkbox" name="inner_permissions[]" value="73"> product Report <input type="checkbox" name="inner_permissions[]" value="74"> profit and/or
                            loss <input type="checkbox" name="inner_permissions[]" value="75"> purchases Report<input type="checkbox" name="inner_permissions[]" value="76"> customers Report <input type="checkbox" name="inner_permissions[]" value="77">
                            suppliers Report <input type="checkbox" name="inner_permissions[]" value="78"> User Searches <input type="checkbox" name="inner_permissions[]" value="200"> Short Stock Report <input type="checkbox" name="inner_permissions[]" value=""> export</td>


                    </tr>
                    <tr class="sales">

                        <td class="memo" colspan="5"><input type="checkbox" name="inner_permissions[]" value="79">sales <input type="checkbox" name="inner_permissions[]" value="80">memo <input
                                type="checkbox" name="inner_permissions[]" value="81">invoice <input type="checkbox" name="inner_permissions[]" value="82">trade <input type="checkbox" name="inner_permissions[]" value="83">trade ngd</td>


                    </tr>
                    <tr class="dashbord">
                        <th class="dashbord">dashbord</th>
                        <td class="dash" colspan="5"> <input type="checkbox" name="inner_permissions[]" value="84"> customers <input type="checkbox" name="inner_permissions[]" value="85"> suppliers <input
                                type="checkbox" name="inner_permissions[]" value="86"> summary <input type="checkbox" name="inner_permissions[]" value="87"> memo <input type="checkbox" name="inner_permissions[]" value="88"> quotations <br> <input
                                type="checkbox" name="inner_permissions[]" value="89"> job orders <input type="checkbox" name="inner_permissions[]" value="144"> Warehouse stock chart <input type="checkbox" name="inner_permissions[]" value="145"> Low stock <input type="checkbox" name="inner_permissions[]" value="146"> Category wise product sale <input type="checkbox" name="inner_permissions[]" value="147"> Model wise product sale <input type="checkbox" name="inner_permissions[]" value="501">Total Job orders <input type="checkbox" name="inner_permissions[]" value="502"> Total Available Inventory  <input type="checkbox" name="inner_permissions[]" value="503">total memos <input type="checkbox" name="inner_permissions[]" value="504"> Total product Brand </td>

                    </tr>
                    <tr>
                        <th>deposits</th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="90">add deposits</td>
                    </tr>
                    <tr>
                        <th>job order report</th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="91"> job order by agent <input type="checkbox" name="inner_permissions[]" value="92"> job order
                            by client <input type="checkbox" name="inner_permissions[]" value="93"> complete job report <input type="checkbox" name="inner_permissions[]" value="94"> pending job report <input
                                type="checkbox" name="inner_permissions[]" value="95"> on hold job report <input type="checkbox" name="inner_permissions[]" value="96"> open job report <input type="checkbox" name="inner_permissions[]" value="97">
                            pastdue job report <input type="checkbox" name="inner_permissions[]" value=""> export</td>

                    </tr>
                    <tr>
                        <th>People</th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="98"> user list <input type="checkbox" name="inner_permissions[]" value="99"> list agent
                          <input type="checkbox" name="inner_permissions[]" value="100"> all customer<input type="checkbox" name="inner_permissions[]" value="101"> all seller <input
                                type="checkbox" name="inner_permissions[]" value="102">List Expertise <input type="checkbox" name="inner_permissions[]" value="201"> Permission</td>
                    </tr>
                    <tr>
                        <th>System</th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="103"> system setting <input type="checkbox" name="inner_permissions[]" value="104"> tax rates <input
                                type="checkbox" name="inner_permissions[]" value="105">update <input type="checkbox" name="inner_permissions[]" value="106"> server status </td>
                    </tr>
                    
                    <tr>
                        <th>Fields </th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="107"> Brand<input type="checkbox" name="inner_permissions[]" value="108"> Category <input
                                type="checkbox" name="inner_permissions[]" value="109">Condition <input type="checkbox" name="inner_permissions[]" value="110"> Metal<input type="checkbox" name="inner_permissions[]" value="111"> Model Number<input type="checkbox" name="inner_permissions[]" value="112"> Partners<input type="checkbox" name="inner_permissions[]" value="113"> Size <input type="checkbox" name="inner_permissions[]" value="114"> Unit<input type="checkbox" name="inner_permissions[]" value="115"> Warehouse <input type="checkbox" name="inner_permissions[]" value="116"> Print Barcode /Label</td>
                    </tr>
                    <tr>
                        <th>Newsletter </th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="128"> Newsletters<input type="checkbox" name="inner_permissions[]" value="129"> Subcribers 
                        </td>
                    </tr> 
                    <tr>
                        <th>Website Setup </th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="130"> Header<input type="checkbox" name="inner_permissions[]" value="131"> Footer <input type="checkbox" name="inner_permissions[]" value="132"> Pages <input type="checkbox" name="inner_permissions[]" value="133"> Appearance 
                        </td>
                    </tr>
                    <tr>
                        <th>Setup & Configurations </th>
                        <td class="deposit" colspan="5"><input type="checkbox" name="inner_permissions[]" value="134"> General Settings <input type="checkbox" name="inner_permissions[]" value="135"> Currency <input type="checkbox" name="inner_permissions[]" value="136"> STMP Settings <input type="checkbox" name="inner_permissions[]" value="137"> Social media Logins  <input type="checkbox" name="inner_permissions[]" value="138"> Facebook <input type="checkbox" name="inner_permissions[]" value="139"> Google 
                        </td>
                    </tr>
                    

                </table>
            </div>
                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                </div>
            </div>
        </from>
    </div>
</div>

@endsection
