<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">

            <a href="{{ route('admin.dashboard') }}" class="d-block text-center">

                @if(get_setting('system_logo_white') != null)

                    <img class="mw-100" src="{{ uploaded_asset(get_setting('system_logo_white')) }}" class="brand-icon" alt="{{ get_setting('site_name') }}">

                @else

                    <img class="mw-100" src="{{ static_asset('uploads/all/r8kUFE9ZoEBx7xejIl9b1RyadmBEcI2Xn0tYdq9I.png') }}" class="brand-icon" alt="{{ get_setting('site_name') }}">

                @endif

            </a>

        </div>
         <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name="" placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                  @if(Auth::user()->user_type == 'admin' || in_array('310', json_decode(Auth::user()->staff->role->permissions)))
                <li class="aiz-side-nav-item">
                    <a href="{{route('admin.dashboard')}}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate('Dashboard')}}</span>
                   </a>
                </li>
                @endif
                <!-- POS Addon-->
                @if (addon_is_activated('pos_system'))

                    @if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-tasks aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('POS System')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('poin-of-sales.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['poin-of-sales.index', 'poin-of-sales.create'])}}">

                                        <span class="aiz-side-nav-text">{{translate('POS Manager')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('poin-of-sales.activation')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('POS Configuration')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif
            <!-- Product -->

                @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Products')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <!--Submenu -->

                        <ul class="aiz-side-nav-list level-2">
                        @if(Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a class="aiz-side-nav-link" href="{{route('products.create')}}">

                                    <span class="aiz-side-nav-text">{{translate('Add New product')}}</span>

                                </a>

                            </li>
                            @endif

                            <li class="aiz-side-nav-item">

                                <a href="{{route('products.all')}}" class="aiz-side-nav-link">

                                 <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>

                                </a>

                            </li>
                            <li class="aiz-side-nav-item">

                                <a href="{{route('products.available.products')}}" class="aiz-side-nav-link">

                                 <span class="aiz-side-nav-text">{{ translate('Available Products') }}</span>

                                </a>

                            </li>

                           
                          

                            <!--Blog System-->

                                <!-- <li class="aiz-side-nav-item">

                                    <a href="#" class="aiz-side-nav-link">

                                        <i class="las la-bullhorn aiz-side-nav-icon"></i>

                                        <span class="aiz-side-nav-text">{{ translate('Appraisal') }}</span>

                                        <span class="aiz-side-nav-arrow"></span>

                                    </a> -->

                                    <!-- <ul class="aiz-side-nav-list level-2"> -->

                                        <li class="aiz-side-nav-item">

                                            <a href="{{route('Appraisal.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['Appraisal.create', 'Appraisal.edit'])}}">

                                                <span class="aiz-side-nav-text">{{ translate('Appraisal') }}</span>

                                            </a>

                                        </li>
                                        <!--
                                        <li class="aiz-side-nav-item">

                                            <a href="{{ route('Appraisal.create') }}" class="aiz-side-nav-link {{ areActiveRoutes(['Appraisal.create', 'Appraisal.edit'])}}">

                                                <span class="aiz-side-nav-text">{{ translate('Create Appraisal') }}</span>

                                            </a>

                                        </li>

                                    </ul> -->

                                </li>

                        


                              <li class="aiz-side-nav-item">

                        <a href="#"  class="aiz-side-nav-link">

                            <!--<i class="las la-bullhorn aiz-side-nav-icon"></i>-->

                            <span class="aiz-side-nav-text">{{ translate('Fields') }}</span>

                            <!-- <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span> -->

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">
                        @if(Auth::user()->user_type == 'admin' ||  in_array('107', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{route('brands.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}" >
                                    <span class="aiz-side-nav-text">{{translate('Brand')}}</span>
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->user_type == 'admin' ||  in_array('108', json_decode(Auth::user()->staff->role->inner_permissions)))
                              <li class="aiz-side-nav-item">

                                <a href="{{route('categories.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Category')}}</span>

                                </a>

                            </li>
                            @endif
                            @if(Auth::user()->user_type == 'admin' || in_array('109', json_decode(Auth::user()->staff->role->inner_permissions)))
                               <li class="aiz-side-nav-item">

                            <a href="{{route('productcondition.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['productcondition.index', 'productcondition.create', 'productcondition.edit'])}}">

                                <span class="aiz-side-nav-text">{{translate('Condition')}}</span>

                            </a>

                            </li>
                            @endif

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('attributes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>

                                </a>

                            </li> -->
                              @if(Auth::user()->user_type == 'admin' || in_array('110', json_decode(Auth::user()->staff->role->inner_permissions)))
                             <li class="aiz-side-nav-item">

                               <a href="{{route('metal.index')}}" class="aiz-side-nav-link">

                                   <span class="aiz-side-nav-text">{{translate('Metal')}}</span>

                               </a>

                           </li>
                            @endif
                             @if(Auth::user()->user_type == 'admin' || in_array('111', json_decode(Auth::user()->staff->role->inner_permissions)))
                           <li class="aiz-side-nav-item">

                              <a href="{{route('model.index')}}" class="aiz-side-nav-link">

                                  <span class="aiz-side-nav-text">{{translate('Model Number')}}</span>

                              </a>

                          </li>
                          @endif
                          @if(Auth::user()->user_type == 'admin' ||  in_array('112', json_decode(Auth::user()->staff->role->inner_permissions)))
                             <li class="aiz-side-nav-item">

                                <a href="{{route('partners.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Partners')}}</span>

                                </a>

                            </li>
                            @endif

                            @if(Auth::user()->user_type == 'admin' || in_array('113', json_decode(Auth::user()->staff->role->inner_permissions)))
                          <li class="aiz-side-nav-item">

                             <a href="{{route('size.index')}}" class="aiz-side-nav-link">

                                 <span class="aiz-side-nav-text">{{translate('Size')}}</span>

                             </a>

                         </li>
                        @endif

                       @if(Auth::user()->user_type == 'admin' || in_array('114', json_decode(Auth::user()->staff->role->inner_permissions)))
                         <li class="aiz-side-nav-item">

                            <a href="{{route('unit.index')}}" class="aiz-side-nav-link">

                                <span class="aiz-side-nav-text">{{translate('Unit')}}</span>

                            </a>

                        </li>
                        @endif
                         @if(Auth::user()->user_type == 'admin' || in_array('115', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">

                           <a href="{{route('warehouse.index')}}" class="aiz-side-nav-link">

                               <span class="aiz-side-nav-text">{{translate('Warehouse')}}</span>

                           </a>

                       </li>
                        @endif
                          @if(Auth::user()->user_type == 'admin' || in_array('116', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">

                           <a href="{{route('products.barcode')}}" class="aiz-side-nav-link">

                               <span class="aiz-side-nav-text">{{translate('Print Barcode/Label')}}</span>

                           </a>

                       </li>
                       @endif

                        </ul>

                    </li>



                  
                            <li class="aiz-side-nav-item">

                                <a href="{{route('return.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Return')}}</span>

                                </a>

                            </li>

                        

                    <li class="aiz-side-nav-item">

                        <a href="{{route('transfer.index')}}" class="aiz-side-nav-link">

                            <span class="aiz-side-nav-text">{{translate('All Transfers')}}</span>

                        </a>

                    </li>

                    <li class="aiz-side-nav-item">

                        <a href="{{route('inventory_run.index')}}" class="aiz-side-nav-link">

                            <span class="aiz-side-nav-text">{{translate('Inventory Run')}}</span>

                        </a>

                    </li>
                    <!-- <li class="aiz-side-nav-item">
                        <a href="{{ route('purchases.index') }}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('List Purchases')}}</span>
                        </a>
                    </li> -->

                    <li class="aiz-side-nav-item">
                        <a href="{{route('Producttype.index')}}" class="aiz-side-nav-link">
                            <span class="aiz-side-nav-text">{{translate('List Product Type')}}</span>
                        </a>
                    </li>

                    <li class="aiz-side-nav-item">

                        <a href="{{route('sequence.index')}}" class="aiz-side-nav-link">

                            <span class="aiz-side-nav-text">{{translate('List Sequence')}}</span>

                        </a>

                    </li>



                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('products.admin')}}" class="aiz-side-nav-link {{ areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit']) }}" >

                                    <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>

                                </a>

                            </li> -->

                            <!-- @if(get_setting('vendor_system_activation') == 1) -->

                                <!-- <li class="aiz-side-nav-item">

                                    <a href="{{route('products.seller')}}" class="aiz-side-nav-link {{ areActiveRoutes(['products.seller', 'products.seller.edit']) }}">

                                        <span class="aiz-side-nav-text">{{ translate('Seller Products') }}</span>

                                    </a>

                                </li> -->

                            <!-- @endif -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('digitalproducts.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['digitalproducts.index', 'digitalproducts.create', 'digitalproducts.edit']) }}">

                                    <span class="aiz-side-nav-text">{{ translate('Digital Products') }}</span>

                                </a>

                            </li> -->

                             <li class="aiz-side-nav-item">

                                <a href="{{route('Listingtype.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['Listingtype.index', 'Listingtype.create', 'Listingtype.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Listing Type')}}</span>

                                </a>

                            </li>
                            @if(Auth::user()->user_type == 'admin' || in_array('26', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{ route('product_bulk_upload.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Bulk Import')}}</span>

                                </a>

                            </li>
                            @endif
                            <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('22', json_decode(Auth::user()->staff->role->permissions))) -->


                            <li class="aiz-side-nav-item">

                                <a href="{{ route('uploaded-files.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">

                                <i class="las la-folder-open aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{ translate('All Uploads') }}</span>

                                </a>

                                </li>
                                <!-- @endif -->

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('products-files.info') }}" class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create'])}}">

                                        <i class="las la-folder-open aiz-side-nav-icon"></i>

                                         <span class="aiz-side-nav-text">{{ translate('Product Uploads') }}</span>

                                          </a>
                                            </li>

                                

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('colors')}}" class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Colors')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('reviews.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Product Reviews')}}</span>

                                </a>

                            </li> -->



                        </ul>



                    </li>
                    <!-- <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                        <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{translate(' Purchases ')}}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('purchases.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate(' List Purchases')}}</span>
                                </a>
                            </li>
                        </ul>
                    </li> -->

                @endif

                @if(Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))

             <li class="aiz-side-nav-item">

           <a href="#" class="aiz-side-nav-link">

               <i class="las la-user-tie aiz-side-nav-icon"></i>

               <span class="aiz-side-nav-text">{{translate('Memo')}}</span>

               <span class="aiz-side-nav-arrow"></span>

           </a>
           @if(Auth::user()->user_type == 'admin' ||  in_array('29', json_decode(Auth::user()->staff->role->inner_permissions)))

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memo.create')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Add Memo')}}</span>

                   </a>

               </li>

           </ul>
        @endif
           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memo.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Open Memo List')}}</span>

                   </a>

               </li>

           </ul>

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memo.close')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Close Memo List')}}</span>

                   </a>

               </li>

           </ul>
           @if(Auth::user()->user_type == 'admin' || in_array('81', json_decode(Auth::user()->staff->role->inner_permissions)))

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memostatus.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Invoices')}}</span>

                   </a>

               </li>

           </ul>
         @endif
         @if(Auth::user()->user_type == 'admin' || in_array('82', json_decode(Auth::user()->staff->role->inner_permissions)))

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memotrade.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Trade')}}</span>

                   </a>

               </li>

           </ul>
          @endif
          @if(Auth::user()->user_type == 'admin' || in_array('83', json_decode(Auth::user()->staff->role->inner_permissions)))

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memotrade_ngd.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Trade-ngd')}}</span>

                   </a>

               </li>

           </ul>
         @endif

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memoreturns.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('Return')}}</span>

                   </a>

               </li>

           </ul>

           <ul class="aiz-side-nav-list level-2" style="padding-left:15px;">

               <li class="aiz-side-nav-item">

                   <a href="{{route('memopayment.index')}}" class="aiz-side-nav-link">

                       <span class="aiz-side-nav-text">{{translate('List Payment Terms')}}</span>

                   </a>

               </li>

           </ul>

       </li>

   @endif



                <!-- Auction Product -->

                @if(addon_is_activated('auction'))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-gavel aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Auction Products')}}</span>

                            @if (env("DEMO_MODE") == "On")

                                <span class="badge badge-inline badge-danger">Addon</span>

                            @endif

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <!--Submenu-->

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a class="aiz-side-nav-link" href="{{route('auction_products.create')}}">

                                    <span class="aiz-side-nav-text">{{translate('Add New auction product')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('auction.all_products')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_products.edit','product_bids.show']) }}">

                                    <span class="aiz-side-nav-text">{{ translate('All Auction Products') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('auction.inhouse_products')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Inhouse Auction Products') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('auction.seller_products')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Seller Auction Products') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('auction_products_orders')}}" class="aiz-side-nav-link {{ areActiveRoutes(['auction_products_orders.index']) }}">

                                    <span class="aiz-side-nav-text">{{ translate('Auction Products Orders') }}</span>

                                </a>

                            </li>

                        </ul>

                    </li>

                @endif



            <!-- Sale -->

                <!-- <li class="aiz-side-nav-item">

                    <a href="#" class="aiz-side-nav-link">

                        <i class="las la-money-bill aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">{{translate('Sales')}}</span>

                        <span class="aiz-side-nav-arrow"></span>

                    </a> -->

                    <!--Submenu-->

                    <!-- <ul class="aiz-side-nav-list level-2">

                        @if(Auth::user()->user_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('all_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['all_orders.index', 'all_orders.show'])}}">

                                    <span class="aiz-side-nav-text">{{translate('All Orders')}}</span>

                                </a>

                            </li>

                        @endif



                         @if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('inhouse_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show'])}}" >

                                    <span class="aiz-side-nav-text">{{translate('Inhouse orders')}}</span>

                                </a>

                            </li>

                        @endif

                        @if(Auth::user()->user_type == 'admin' || in_array('6', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('seller_orders.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_orders.index', 'seller_orders.show'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Seller Orders')}}</span>

                                </a>

                            </li>

                        @endif -->

                      <!--  @if(Auth::user()->user_type == 'admin' ||  in_array('6', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('pick_up_point.order_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_point.order_index','pick_up_point.order_show'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Pick-up Point Order')}}</span>

                                </a>

                            </li>

                        @endif -->

                    <!-- </ul>

                </li> -->



            <!-- Sale -->

                <!-- <li class="aiz-side-nav-item">

                    <a href="#" class="aiz-side-nav-link">

                        <i class="las la-money-bill aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">{{translate('Return')}}</span>

                        <span class="aiz-side-nav-arrow"></span>

                    </a> -->

                    <!--Submenu-->

                    <!-- <ul class="aiz-side-nav-list level-2">

                        @if(Auth::user()->user_type == 'admin' || in_array('5', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{route('return.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Return')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('return.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Return')}}</span>

                                </a>

                            </li>

                        @endif

                    </ul> -->

                </li>

















                <!-- Job Orders -->

                <li class="aiz-side-nav-item">

                    <a href="#" class="aiz-side-nav-link">

                        <i class="las la-money-bill aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">{{translate(' Job Order ')}}</span>

                        <span class="aiz-side-nav-arrow"></span>

                    </a>

                    <!--Submenu-->

                    <ul class="aiz-side-nav-list level-2">


                            <li class="aiz-side-nav-item">

                                <a href="{{route('job_orders.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('All Job Orders')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('job_orders.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Job Order')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('job_orders.open')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Open')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('job_orders.close')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate(' Close ')}}</span>

                                </a>

                            </li>


                    </ul>

                </li>















                <!-- Transfers -->

                <!-- <li class="aiz-side-nav-item">

                    <a href="#" class="aiz-side-nav-link">

                        <i class="las la-money-bill aiz-side-nav-icon"></i>

                        <span class="aiz-side-nav-text">{{translate(' Transfers ')}}</span>

                        <span class="aiz-side-nav-arrow"></span>

                    </a>

                    <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{route('transfer.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('All Transfers')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('transfer.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Transfers')}}</span>

                                </a>

                            </li>

                    </ul>

                </li> -->











                <!-- Deliver Boy Addon-->

                @if (addon_is_activated('delivery_boy'))

                    <!-- @if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions))) -->

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-truck aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('Delivery Boy')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boys.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.index'])}}">

                                        <span class="aiz-side-nav-text">{{translate('All Delivery Boy')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boys.create')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.create'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Add Delivery Boy')}}</span>

                                    </a>

                                </li>

                                {{-- <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boys-payment-histories')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.index'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Payment Histories')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boys-collection-histories')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boys.create'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Collected Histories')}}</span>

                                    </a>

                                </li> --}}

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boy.cancel-request')}}" class="aiz-side-nav-link {{ areActiveRoutes(['delivery-boy.cancel-request'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Cancel Request')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('delivery-boy-configuration')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Configuration')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    <!-- @endif -->

                @endif



            <!-- Refund addon -->

                @if (addon_is_activated('refund_request'))

                    <!-- @if(Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions))) -->

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-backward aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{ translate('Refunds') }}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('refund_requests_all')}}" class="aiz-side-nav-link {{ areActiveRoutes(['refund_requests_all', 'reason_show'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Refund Requests')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('paid_refund')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Approved Refunds')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('rejected_refund')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('rejected Refunds')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('refund_time_config')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Refund Configuration')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    <!-- @endif -->

                @endif





            <!-- Customers -->

                @if(Auth::user()->user_type == 'admin' || in_array('8', json_decode(Auth::user()->staff->role->permissions)))

                    <!-- <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-user-friends aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>

                                </a>

                            </li>

                            @if(get_setting('classified_product') == 1)

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('classified_products')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('customer_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_packages.index', 'customer_packages.create', 'customer_packages.edit'])}}">

                                        <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>

                                    </a>

                                </li>

                            @endif

                        </ul>

                    </li> -->

                @endif



            <!-- Sellers -->

                @if((Auth::user()->user_type == 'admin' || in_array('9', json_decode(Auth::user()->staff->role->permissions))) && get_setting('vendor_system_activation') == 1)

                    <li class="aiz-side-nav-item">

                        <!-- <a href="#" class="aiz-side-nav-link">

                            <i class="las la-user aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a> -->

                        <ul class="aiz-side-nav-list level-2">

                            <!-- <li class="aiz-side-nav-item">

                                @php

                                    $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();

                                @endphp

                                <a href="{{ route('sellers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>

                                    @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('sellers.payment_histories') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Payouts') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('withdraw_requests_all') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Payout Requests') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('business_settings.vendor_commission') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Seller Commission') }}</span>

                                </a>

                            </li> -->



                            @if (addon_is_activated('seller_subscription'))

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('seller_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_packages.index', 'seller_packages.create', 'seller_packages.edit'])}}">

                                        <span class="aiz-side-nav-text">{{ translate('Seller Packages') }}</span>

                                        @if (env("DEMO_MODE") == "On")

                                            <span class="badge badge-inline badge-danger">Addon</span>

                                        @endif

                                    </a>

                                </li>

                            @endif

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('seller_verification_form.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Seller Verification Form') }}</span>

                                </a>

                            </li> -->

                        </ul>

                    </li>

                @endif

               

            <!-- Reports -->

                @if(Auth::user()->user_type == 'admin' || in_array('10', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-file-alt aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>
                        @if(Auth::user()->user_type == 'admin' || in_array('71', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <ul class="aiz-side-nav-list level-2">
                        <li class="aiz-side-nav-item">

                                <a href="{{ route('stock_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['stock_report.index'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('Warehouse Stock Chart') }}</span>

                                </a>

                            </li>
                                </ul>
                                @endif
                   
                        <ul class="aiz-side-nav-list level-2">
                            @if(Auth::user()->user_type == 'admin' || in_array('70', json_decode(Auth::user()->staff->role->inner_permissions)))
                         <!--       <li class="aiz-side-nav-item">
    
                                    <a href="{{ route('in_house_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['in_house_sale_report.index'])}}">
    
                                       <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>   
    
                                    </a>
    
                                </li>    -->
                            @endif
                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('seller_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_sale_report.index'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>

                                </a>

                            </li> -->
                            
                            @if(Auth::user()->user_type == 'admin' ||  in_array('72', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('best_sellers_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['best_sellers_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Best Sellers Report') }}</span>
                                </a>

                                </li>
                                @endif
                                 <li class="aiz-side-nav-item">
                                <a href="{{ route('average_cost_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['average_cost_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Average Cost Report') }}</span>
                                </a>

                                </li>
                            @if(Auth::user()->user_type == 'admin' || in_array('204', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('seller_sale_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['seller_sale_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Sales Report') }}</span>
                                </a>

                                </li>
                                @endif
                                @if(Auth::user()->user_type == 'admin' ||  in_array('73', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('product_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['product_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Products Report') }}</span>
                                </a>

                                </li>
                                @endif
                                @if(Auth::user()->user_type == 'admin' ||  in_array('77', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('suppliers_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['suppliers_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Suppliers Report') }}</span>
                                </a>

                                </li>
                                @endif

                                @if(Auth::user()->user_type == 'admin' ||   in_array('74', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('profit_loss.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['profit_loss.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Profit And/Or Loss') }}</span>
                                </a>

                                </li>
                                @endif
                             @if(Auth::user()->user_type == 'admin' ||  in_array('76', json_decode(Auth::user()->staff->role->inner_permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('Ccustomer_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['Ccustomer_report.index'])}}">
                                        <span class="aiz-side-nav-text">{{ translate('Customers Report') }}</span>
                                    </a>
    
                                </li>
                            @endif
                             @if(Auth::user()->user_type == 'admin' || in_array('200', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('short_stock.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['short_stock.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('Short Stock Report') }}</span>
                                </a>

                            </li>
                            @endif

                            <li class="aiz-side-nav-item">

                               

                            </li>

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('wish_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['wish_report.index'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>

                                </a>

                            </li> -->
                        @if(Auth::user()->user_type == 'admin' || in_array('78', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('user_search_report.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['user_search_report.index'])}}">
                                    <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->user_type == 'admin' || in_array('75', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('purchases.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{translate(' Purchases Report')}}</span>
                                </a>
                            </li>
                            @endif

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('wallet-history.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>

                                </a>

                            </li> -->

                        </ul>

                    </li>

                @endif




                  <!-- Job Orders Report -->

                  <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{translate(' Job Order Report')}}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                    @if(Auth::user()->user_type == 'admin' || in_array('91', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('agent_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' Job Order by Agent')}}</span>
                            </a>
                        </li>
                        @endif

                        @if(Auth::user()->user_type == 'admin' ||  in_array('92', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('client_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' Job Order by Client')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('93', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('complete_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' Complete Job Report')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('94', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('pending_job_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate('  Pending Job Report ')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('95', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('OnHoldJob_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' On Hold Job Report')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('96', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('OpenJob_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' Open Job Report')}}</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type == 'admin' || in_array('97', json_decode(Auth::user()->staff->role->inner_permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="{{route('PastDueJob_report.index')}}" class="aiz-side-nav-link">
                                <span class="aiz-side-nav-text">{{translate(' Past Due Job Report')}}</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>



                @if(Auth::user()->user_type == 'admin' || in_array('23', json_decode(Auth::user()->staff->role->inner_permissions)))

                <!--Blog System-->

                    <li class="aiz-side-nav-item">

                        <!-- <a href="#" class="aiz-side-nav-link">

                            <i class="las la-bullhorn aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{ translate('Blog System') }}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a> -->

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('blog.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['blog.create', 'blog.edit'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('All Posts') }}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('blog-category.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['blog-category.create', 'blog-category.edit'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('Categories') }}</span>

                                </a>

                            </li>

                        </ul>

                    </li>



                @endif





            <!-- marketing -->

                @if(Auth::user()->user_type == 'admin' || in_array('11', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-bullhorn aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{ translate('Newsletter') }}</span>

                            <!-- <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span> -->

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            @if(Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))

                                <!-- <li class="aiz-side-nav-item">

                                    <a href="{{ route('flash_deals.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">

                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>

                                    </a>

                                </li> -->

                            @endif

                            @if(Auth::user()->user_type == 'admin' || in_array('128', json_decode(Auth::user()->staff->role->inner_permissions)))

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('newsletters.index')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>

                                    </a>

                                </li>
                            @endif
                                @if (addon_is_activated('otp_system'))

                                    <!-- <li class="aiz-side-nav-item">

                                        <a href="{{route('sms.index')}}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{ translate('Bulk SMS') }}</span>

                                            @if (env("DEMO_MODE") == "On")

                                                <span class="badge badge-inline badge-danger">Addon</span>

                                            @endif

                                        </a>

                                    </li> -->

                                @endif

                             @if(Auth::user()->user_type == 'admin' || in_array('129', json_decode(Auth::user()->staff->role->inner_permissions)))
                             <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                            @endif

                          <!--  <li class="aiz-side-nav-item">

                                <a href="{{route('coupon.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['coupon.index','coupon.create','coupon.edit'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>

                                </a>

                            </li> -->

                        </ul>

                    </li>

                @endif



            <!-- Support -->

                @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <!-- <a href="#" class="aiz-side-nav-link">

                            <i class="las la-link aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Support')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a> -->

                        <ul class="aiz-side-nav-list level-2">

                            @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))

                                @php

                                    $support_ticket = DB::table('tickets')

                                                ->where('viewed', 0)

                                                ->select('id')

                                                ->count();

                                @endphp

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('support_ticket.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Ticket')}}</span>

                                        @if($support_ticket > 0)<span class="badge badge-info">{{ $support_ticket }}</span>@endif

                                    </a>

                                </li>

                            @endif



                            @php

                                $conversation = \App\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();

                            @endphp

                            @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('conversations.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Product Queries')}}</span>

                                        @if (count($conversation) > 0)

                                            <span class="badge badge-info">{{ count($conversation) }}</span>

                                        @endif

                                    </a>

                                </li>

                            @endif

                        </ul>

                    </li>

                @endif



            <!-- Affiliate Addon -->

                @if (addon_is_activated('affiliate_system'))

                    @if(Auth::user()->user_type == 'admin' || in_array('15', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-link aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('Affiliate System')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('affiliate.configs')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Affiliate Registration Form')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('affiliate.index')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Affiliate Configurations')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('affiliate.users')}}" class="aiz-side-nav-link {{ areActiveRoutes(['affiliate.users', 'affiliate_users.show_verification_request', 'affiliate_user.payment_history'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Affiliate Users')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('refferals.users')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Referral Users')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('affiliate.withdraw_requests')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Affiliate Withdraw Requests')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('affiliate.logs.admin')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Affiliate Logs')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif



            <!-- Offline Payment Addon-->

                @if (addon_is_activated('offline_payment'))

                    @if(Auth::user()->user_type == 'admin' || in_array('16', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('Offline Payment System')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('manual_payment_methods.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index', 'manual_payment_methods.create', 'manual_payment_methods.edit'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Manual Payment Methods')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('offline_wallet_recharge_request.index') }}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Offline Wallet Recharge')}}</span>

                                    </a>

                                </li>

                                @if(get_setting('classified_product') == 1)

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('offline_customer_package_payment_request.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Offline Customer Package Payments')}}</span>

                                        </a>

                                    </li>

                                @endif

                                @if (addon_is_activated('seller_subscription'))

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('offline_seller_package_payment_request.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Offline Seller Package Payments')}}</span>

                                            @if (env("DEMO_MODE") == "On")

                                                <span class="badge badge-inline badge-danger">Addon</span>

                                            @endif

                                        </a>

                                    </li>

                                @endif

                            </ul>

                        </li>

                    @endif

                @endif



            <!-- Paytm Addon -->

                @if (addon_is_activated('paytm'))

                    @if(Auth::user()->user_type == 'admin' || in_array('17', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-mobile-alt aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('Paytm Payment Gateway')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('paytm.index') }}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Set Paytm Credentials')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif



            <!-- Club Point Addon-->

                @if (addon_is_activated('club_point'))

                    @if(Auth::user()->user_type == 'admin' || in_array('18', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="lab la-btc aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('Club Point System')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('club_points.configs') }}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Club Point Configurations')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('set_product_points')}}" class="aiz-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit'])}}">

                                        <span class="aiz-side-nav-text">{{translate('Set Product Point')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('club_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details'])}}">

                                        <span class="aiz-side-nav-text">{{translate('User Points')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif



            <!--OTP addon -->

                @if (addon_is_activated('otp_system'))

                    @if(Auth::user()->user_type == 'admin' || in_array('19', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-phone aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('OTP System')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('otp.configconfiguration') }}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('OTP Configurations')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('sms-templates.index')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('SMS Templates')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('otp_credentials.index')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Set OTP Credentials')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif



                @if(addon_is_activated('african_pg'))

                    @if(Auth::user()->user_type == 'admin' || in_array('19', json_decode(Auth::user()->staff->role->permissions)))

                        <li class="aiz-side-nav-item">

                            <a href="#" class="aiz-side-nav-link">

                                <i class="las la-phone aiz-side-nav-icon"></i>

                                <span class="aiz-side-nav-text">{{translate('African Payment Gateway Addon')}}</span>

                                @if (env("DEMO_MODE") == "On")

                                    <span class="badge badge-inline badge-danger">Addon</span>

                                @endif

                                <span class="aiz-side-nav-arrow"></span>

                            </a>

                            <ul class="aiz-side-nav-list level-2">

                                <li class="aiz-side-nav-item">

                                    <a href="{{ route('african.configuration') }}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('African PG Configurations')}}</span>

                                    </a>

                                </li>

                                <li class="aiz-side-nav-item">

                                    <a href="{{route('african_credentials.index')}}" class="aiz-side-nav-link">

                                        <span class="aiz-side-nav-text">{{translate('Set African PG Credentials')}}</span>

                                    </a>

                                </li>

                            </ul>

                        </li>

                    @endif

                @endif



            <!-- Website Setup -->

                @if(Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer', 'website.header'])}}" >

                            <i class="las la-desktop aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Website Setup')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">
                          @if(Auth::user()->user_type == 'admin' || in_array('130', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{ route('website.header') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Header')}}</span>

                                </a>

                            </li>
                            @endif
                          @if(Auth::user()->user_type == 'admin' || in_array('131', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('website.footer', ['lang'=>  App::getLocale()] ) }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.footer'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Footer')}}</span>

                                </a>

                            </li>
                            @endif
                          @if(Auth::user()->user_type == 'admin' || in_array('132', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('website.pages') }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create' ,'custom-pages.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Pages')}}</span>

                                </a>

                            </li>
                            @endif
                          @if(Auth::user()->user_type == 'admin' || in_array('133', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Appearance')}}</span>

                                </a>

                            </li>
                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('website.product_section') }}" class="aiz-side-nav-link {{ areActiveRoutes(['website.product_section', 'custom-pages.create' ,'custom-pages.edit'])}}">
                                    <span class="aiz-side-nav-text">{{translate('Product Section')}}</span>
                                </a>

                            </li>

                        </ul>

                    </li>

                @endif



            <!-- Setup & Configurations -->

                @if(Auth::user()->user_type == 'admin' || in_array('14', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Setup & Configurations')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">
                        @if(Auth::user()->user_type == 'admin' ||  in_array('134', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{route('general_setting.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('General Settings')}}</span>

                                </a>

                            </li>
                        @endif



                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('activation.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Features activation')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('languages.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['languages.index', 'languages.create', 'languages.store', 'languages.show', 'languages.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Languages')}}</span>

                                </a>

                            </li> -->


                        @if(Auth::user()->user_type == 'admin' || in_array('135', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{route('currency.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Currency')}}</span>

                                </a>

                            </li>
                        @endif

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('tax.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Vat & TAX')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('pick_up_points.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_points.index','pick_up_points.create','pick_up_points.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Pickup point')}}</span>

                                </a>

                            </li> -->
                          @if(Auth::user()->user_type == 'admin' || in_array('136', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('SMTP Settings')}}</span>

                                </a>

                            </li>
                        @endif

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('payment_method.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Payment Methods')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('File System & Cache Configuration')}}</span>

                                </a>

                            </li> -->
                          @if(Auth::user()->user_type == 'admin' || in_array('137', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Social media Logins')}}</span>

                                </a>

                            </li>
                        @endif
                      @if(Auth::user()->user_type == 'admin' || in_array('138', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="javascript:void(0);" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Facebook')}}</span>

                                    <span class="aiz-side-nav-arrow"></span>

                                </a>

                                <ul class="aiz-side-nav-list level-3">

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Facebook Chat')}}</span>

                                        </a>

                                    </li>

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('facebook-comment') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Facebook Comment')}}</span>

                                        </a>

                                    </li>

                                </ul>

                            </li>
                            @endif
                          @if(Auth::user()->user_type == 'admin' || in_array('139', json_decode(Auth::user()->staff->role->inner_permissions)))



                            <li class="aiz-side-nav-item">

                                <a href="javascript:void(0);" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Google')}}</span>

                                    <span class="aiz-side-nav-arrow"></span>

                                </a>

                                <ul class="aiz-side-nav-list level-3">

                                    <!-- <li class="aiz-side-nav-item">

                                        <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Analytics Tools')}}</span>

                                        </a>

                                    </li> -->

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Google reCAPTCHA')}}</span>

                                        </a>

                                    </li>

                                    <li class="aiz-side-nav-item">

                                        <a href="{{ route('google-map.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Google Map')}}</span>

                                        </a>

                                    </li>

                                    <!-- <li class="aiz-side-nav-item">

                                        <a href="{{ route('google-firebase.index') }}" class="aiz-side-nav-link">

                                            <span class="aiz-side-nav-text">{{translate('Google Firebase')}}</span>

                                        </a>

                                    </li> -->

                                </ul>

                            </li>
                            @endif








<!-- 
                            <li class="aiz-side-nav-item">

                                <a href="javascript:void(0);" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Shipping')}}</span>

                                    <span class="aiz-side-nav-arrow"></span>

                                </a>

                                <ul class="aiz-side-nav-list level-3">

                                    <li class="aiz-side-nav-item">

                                        <a href="{{route('shipping_configuration.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update'])}}">

                                            <span class="aiz-side-nav-text">{{translate('Shipping Configuration')}}</span>

                                        </a>

                                    </li>

                                    <li class="aiz-side-nav-item">

                                        <a href="{{route('countries.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['countries.index','countries.edit','countries.update'])}}">

                                            <span class="aiz-side-nav-text">{{translate('Shipping Countries')}}</span>

                                        </a>

                                    </li>

                                    <li class="aiz-side-nav-item">

                                        <a href="{{route('cities.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['cities.index','cities.edit','cities.update'])}}">

                                            <span class="aiz-side-nav-text">{{translate('Shipping Cities')}}</span>

                                        </a>

                                    </li>

                                </ul>

                            </li> -->



                        </ul>

                    </li>

                @endif





            <!-- Staffs -->

                <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('20', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-user-tie aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('All staffs')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('roles.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">

                                    <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>

                                </a>

                            </li>

                        </ul>

                    </li>

                @endif -->

                <!-- @if(Auth::user()->user_type == 'admin' ||  in_array('20', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-list aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Sequence')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{route('sequence.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Sequence')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('sequence.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Sequence')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>

                                </a>

                            </li> -->

                        <!-- </ul>

                    </li>

                @endif -->

                @if(Auth::user()->user_type == 'admin' ||  in_array('25', json_decode(Auth::user()->staff->role->permissions)))


                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-list aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('People')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                          <!-- <li class="aiz-side-nav-item">

                              <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">

                                  <span class="aiz-side-nav-text">{{ translate('Users List') }}</span>

                              </a>

                          </li> -->
                          <!--@if(Auth::user()->user_type == 'admin' || in_array('20', json_decode(Auth::user()->staff->role->permissions)))-->
                                <!-- <li class="aiz-side-nav-item">
                                    <a href="#" class="aiz-side-nav-link">
                                        <i class="las la-user-tie aiz-side-nav-icon"></i>
                                        <span class="aiz-side-nav-text">{{translate('Staffs')}}</span>
                                        <span class="aiz-side-nav-arrow"></span>
                                    </a> -->
                                    <!-- <ul class="aiz-side-nav-list level-2"> -->
                                      @if(Auth::user()->user_type == 'admin' ||  in_array('98', json_decode(Auth::user()->staff->role->inner_permissions)))
                                        <li class="aiz-side-nav-item">
                                            <a href="{{ route('staffs.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                                <span class="aiz-side-nav-text">{{translate('Users List')}}</span>
                                            </a>
                                        </li>
                                        @endif
                                          @if(Auth::user()->user_type == 'admin' || in_array('201', json_decode(Auth::user()->staff->role->inner_permissions)))
                                        <li class="aiz-side-nav-item">
                                            <a href="{{route('roles.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                                <span class="aiz-side-nav-text">{{translate('Staff permissions')}}</span>
                                            </a>
                                        </li>
                                        @endif
                                    <!-- </ul>
                                </li> -->
                            <!--@endif-->

                          @if(get_setting('classified_product') == 1)

                              <li class="aiz-side-nav-item">

                                  <a href="{{route('classified_products')}}" class="aiz-side-nav-link">

                                      <span class="aiz-side-nav-text">{{translate('Classified Products')}}</span>

                                  </a>

                              </li>

                              <li class="aiz-side-nav-item">

                                  <a href="{{ route('customer_packages.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['customer_packages.index', 'customer_packages.create', 'customer_packages.edit'])}}">

                                      <span class="aiz-side-nav-text">{{ translate('Classified Packages') }}</span>

                                  </a>

                              </li>

                          @endif
                            @if(Auth::user()->user_type == 'admin' || in_array('99', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('agent.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Agent')}}</span>

                                </a>

                            </li>
                            @endif
                            
                            @if(Auth::user()->user_type == 'admin' || in_array('49', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{ route('agent.create') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Agent')}}</span>

                                </a>

                            </li>
                            @endif
                            @if(Auth::user()->user_type == 'admin' || in_array('100', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{route('retailreseller.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('All Customer')}}</span>

                                </a>

                            </li>
                            @endif
                            

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('retailreseller.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Customer')}}</span>

                                </a>

                            </li> -->
                              @if(Auth::user()->user_type == 'admin' || in_array('101', json_decode(Auth::user()->staff->role->inner_permissions)))

                            <li class="aiz-side-nav-item">

                                @php

                                    $sellers = \App\Seller::where('verification_status', 0)->where('verification_info', '!=', null)->count();

                                @endphp

                                <a href="{{ route('sellers.index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history','sellers.approved','sellers.profile_modal','sellers.show_verification_request'])}}">

                                    <span class="aiz-side-nav-text">{{ translate('All Seller') }}</span>

                                    @if($sellers > 0)<span class="badge badge-info">{{ $sellers }}</span> @endif

                                </a>

                            </li>
                            @endif
                            

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('expertise.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Expertise')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>

                                </a>

                            </li> -->
                            @if(Auth::user()->user_type == 'admin' || in_array('102', json_decode(Auth::user()->staff->role->inner_permissions)))
                            <li class="aiz-side-nav-item">

                                <a href="{{route('expertise.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Expertise')}}</span>

                                </a>

                            </li>
                            @endif
                            

                        </ul>

                    </li>

                @endif

                <!-- @if(Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-list aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Product Type')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{route('Producttype.index')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Product Type')}}</span>

                                </a>

                            </li>

                            <li class="aiz-side-nav-item">

                                <a href="{{route('Producttype.create')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Add Product Type')}}</span>

                                </a>

                            </li> -->

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>

                                </a>

                            </li> -->

                        <!-- </ul>

                    </li>

                @endif -->

                @if(Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))

                    <!-- <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-list aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Purchases')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <li class="aiz-side-nav-item">

                                <a href="{{ route('purchases.index') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('List Purchases')}}</span>

                                </a>

                            </li>

                        </ul>

                    </li> -->

                @endif

                @if(Auth::user()->user_type == 'admin' || in_array('24', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <a href="#" class="aiz-side-nav-link">

                            <i class="las la-user-tie aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('System')}}</span>

                            <span class="aiz-side-nav-arrow"></span>

                        </a>

                        <ul class="aiz-side-nav-list level-2">

                            <!-- <li class="aiz-side-nav-item">

                                <a href="{{ route('system_setting') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('System setting')}}</span>

                                </a>

                            </li> -->

                            <li class="aiz-side-nav-item">
                            @if(Auth::user()->user_type == 'admin' || in_array('103', json_decode(Auth::user()->staff->role->permissions)))
                                <a href="#" class="aiz-side-nav-link">

                                    <!-- <i class="las la-money-bill aiz-side-nav-icon"></i> -->

                                    <span class="aiz-side-nav-text">{{translate(' System setting ')}}</span>

                                    <span class="aiz-side-nav-arrow"></span>

                                </a>
                                @endif

                                <!--Submenu-->
                              @if(Auth::user()->user_type == 'admin' || in_array('104', json_decode(Auth::user()->staff->role->permissions)))

                                <ul class="aiz-side-nav-list level-2">

                                        <li class="aiz-side-nav-item">

                                            <a href="{{ route('system_setting') }}" class="aiz-side-nav-link">

                                                <span class="aiz-side-nav-text">{{translate(' Tax Rates')}}</span>

                                            </a>

                                        </li>

                                </ul>
                                @endif

                            </li>
                        @if(Auth::user()->user_type == 'admin' ||  in_array('105', json_decode(Auth::user()->staff->role->permissions)))



                            <li class="aiz-side-nav-item">

                                <a href="{{ route('system_update') }}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Update')}}</span>

                                </a>

                            </li>
                            @endif
                                   @if(Auth::user()->user_type == 'admin' || in_array('106', json_decode(Auth::user()->staff->role->permissions)))

                            <li class="aiz-side-nav-item">

                                <a href="{{route('system_server')}}" class="aiz-side-nav-link">

                                    <span class="aiz-side-nav-text">{{translate('Server status')}}</span>

                                </a>

                            </li>
                            @endif

                        </ul>

                    </li>

                @endif



            <!-- Addon Manager -->

                @if(Auth::user()->user_type == 'admin' || in_array('21', json_decode(Auth::user()->staff->role->permissions)))

                    <li class="aiz-side-nav-item">

                        <!-- <a href="{{route('addons.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['addons.index', 'addons.create'])}}">

                            <i class="las la-wrench aiz-side-nav-icon"></i>

                            <span class="aiz-side-nav-text">{{translate('Addon Manager')}}</span>

                        </a> -->

                    </li>

                @endif

            </ul><!-- .aiz-side-nav -->

        </div><!-- .aiz-side-nav-wrap -->

    </div><!-- .aiz-sidebar -->

    <div class="aiz-sidebar-overlay"></div>

</div><!-- .aiz-sidebar -->
