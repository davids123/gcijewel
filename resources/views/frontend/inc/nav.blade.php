@if(get_setting('topbar_banner') != null)
<div class="position-relative top-banner removable-session z-1035 d-none" data-key="top-banner" data-value="removed">
    <a href="{{ get_setting('topbar_banner_link') }}" class="d-block text-reset">
        <img src="{{ uploaded_asset(get_setting('topbar_banner')) }}" class="w-100 mw-100 h-50px h-lg-auto img-fit">
    </a>
    <button class="btn text-white absolute-top-right set-session" data-key="top-banner" data-value="removed" data-toggle="remove-parent" data-parent=".top-banner">
        <i class="la la-close la-2x"></i>
    </button>
</div>
@endif
<!-- Top Bar -->
<div class="top-navbar bg-white border-bottom border-soft-secondary z-1035">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col">
                <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                    @if(get_setting('show_language_switcher') == 'on')
                    <li class="list-inline-item dropdown mr-3" id="lang-change">
                        @php
                            if(Session::has('locale')){
                                $locale = Session::get('locale', Config::get('app.locale'));
                            }
                            else{
                                $locale = 'en';
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2" data-toggle="dropdown" data-display="static">
                            <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$locale.'.png') }}" class="mr-2 lazyload" alt="{{ \App\Language::where('code', $locale)->first()->name }}" height="11">
                            <span class="opacity-60">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-left">
                            @foreach (\App\Language::select('languages.*')->where('status',"1")->get() as $key => $language)
                                <li>
                                    <a href="javascript:void(0)" data-flag="{{ $language->code }}" class="dropdown-item @if($locale == $language) active @endif">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ static_asset('assets/img/flags/'.$language->code.'.png') }}" class="mr-1 lazyload" alt="{{ $language->name }}" height="11">
                                        <span class="language">{{ $language->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    @if(get_setting('show_currency_switcher') == 'on')
                    <li class="list-inline-item dropdown ml-auto ml-lg-0 mr-0" id="currency-change">
                        @php
                            if(Session::has('currency_code')){
                                $currency_code = Session::get('currency_code');
                            }
                            else{
                                $currency_code = \App\Currency::findOrFail(get_setting('system_default_currency'))->code;
                            }
                        @endphp
                        <a href="javascript:void(0)" class="dropdown-toggle text-reset py-2 opacity-60" data-toggle="dropdown" data-display="static">
                            {{ \App\Currency::where('code', $currency_code)->first()->name }} {{ (\App\Currency::where('code', $currency_code)->first()->symbol) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">
                            @foreach (\App\Currency::where('status', 1)->get() as $key => $currency)
                                <li>
                                    <a class="dropdown-item @if($currency_code == $currency->code) active @endif" href="javascript:void(0)" data-currency="{{ $currency->code }}">{{ $currency->name }} ({{ $currency->symbol }})</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>

            <div class="col-5 text-right d-none d-lg-block">
                <ul class="list-inline mb-0 h-100 d-flex justify-content-end align-items-center">
                    @auth
                        @if(isAdmin())
                            <!-- <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="{{ route('admin.dashboard') }}" class="text-reset d-inline-block opacity-60 py-2">{{ translate('My Panel')}}</a>
                            </li> -->
                        @else

                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0 dropdown">
                                <a class="dropdown-toggle no-arrow text-reset" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="">
                                        <span class="position-relative d-inline-block">
                                            <i class="las la-bell fs-18"></i>
                                            @if(count(Auth::user()->unreadNotifications) > 0)
                                                <span class="badge badge-sm badge-dot badge-circle badge-primary position-absolute absolute-top-right"></span>
                                            @endif
                                        </span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                    <div class="p-3 bg-light border-bottom">
                                        <h6 class="mb-0">{{ translate('Notifications') }}</h6>
                                    </div>
                                    <div class="px-3 c-scrollbar-light overflow-auto " style="max-height:300px;">
                                        <ul class="list-group list-group-flush" >
                                            @forelse(Auth::user()->unreadNotifications as $notification)
                                                <li class="list-group-item">
                                                    @if($notification->type == 'App\Notifications\OrderNotification')
                                                        @if(Auth::user()->user_type == 'customer')
                                                        <a href="javascript:void(0)" onclick="show_purchase_history_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                            <span class="ml-2">
                                                                {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                            </span>
                                                        </a>
                                                        @elseif (Auth::user()->user_type == 'seller')
                                                            @if(Auth::user()->id == $notification->data['user_id'])
                                                                <a href="javascript:void(0)" onclick="show_purchase_history_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                                    <span class="ml-2">
                                                                        {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0)" onclick="show_order_details({{ $notification->data['order_id'] }})" class="text-reset">
                                                                    <span class="ml-2">
                                                                        {{translate('Order code: ')}} {{$notification->data['order_code']}} {{ translate('has been '. ucfirst(str_replace('_', ' ', $notification->data['status'])))}}
                                                                    </span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </li>
                                            @empty
                                                <li class="list-group-item">
                                                    <div class="py-4 text-center fs-16">
                                                        {{ translate('No notification found') }}
                                                    </div>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="text-center border-top">
                                        <a href="{{ route('all-notifications') }}" class="text-reset d-block py-2">
                                            {{translate('View All Notifications')}}
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                                <a href="{{ route('dashboard') }}" class="text-reset d-inline-block opacity-60 py-2">My Panel</a>
                            </li>
                        @endif
                        <li class="list-inline-item">
                            <a href="{{ route('logout') }}" class="text-reset d-inline-block opacity-60 py-2">Logout</a>
                        </li>
                    @else
                        <li class="list-inline-item mr-3 border-right border-left-0 pr-3 pl-0">
                            <a href="{{ route('user.login') }}" class="text-reset d-inline-block opacity-60 py-2">{{ translate('Login')}}</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('user.registration') }}" class="text-reset d-inline-block opacity-60 py-2">{{ translate('Registration')}}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END Top Bar -->
<header class="@if(get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
    <div class="position-relative logo-bar-area z-1">
        <div class="container">
            <div class="d-flex align-items-center">

                <div class="col-auto col-xl-3 pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-20px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-70px h-md-70px" height="40">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-30px h-md-40px" height="40">
                        @endif
                    </a>

                </div>
                <div class="d-lg-none ml-auto mr-0">
                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle" data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>

                <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">
                    <div class="position-relative flex-grow-1">
                        <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                            <div class="d-flex position-relative align-items-center mi_cus_header">
                                <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                    <button class="btn px-2" type="button"><i class="la la-2x la-long-arrow-left"></i></button>
                                </div>
                                <div class="input-group mi_cus_header_input">
                                    <input type="text" class="border-0 border-lg form-control" id="search" name="keyword" @isset($query)
                                        value="{{ $query }}"
                                    @endisset placeholder="I am shopping for..." autocomplete="off">
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="la la-search la-flip-horizontal fs-18"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--<div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100" style="min-height: 200px">-->
                        <!--    <div class="search-preloader absolute-top-center">-->
                        <!--        <div class="dot-loader"><div></div><div></div><div></div></div>-->
                        <!--    </div>-->
                            <!--<div class="search-nothing d-none p-3 text-center fs-16">-->

                            <!--</div>-->
                            <!--<div id="search-content" class="text-left">-->

                            <!--</div>-->
                        <!--</div>-->
                    </div>
                </div>

                <div class="d-none d-lg-none ml-3 mr-0">
                    <div class="nav-search-box">
                        <a href="#" class="nav-box-link">
                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                        </a>
                    </div>
                </div>

                <!--<div class="d-none d-lg-block ml-3 mr-0">-->
                <!--    <div class="" id="compare">-->
                <!--        @include('frontend.partials.compare')-->
                <!--    </div>-->
                <!--</div>-->

                <!-- <div class="d-none d-lg-block ml-3 mr-0">
                    <div class="" id="wishlist">
                        @include('frontend.partials.wishlist')
                    </div>
                </div>

                <div class="d-none d-lg-block  align-self-stretch ml-3 mr-0" data-hover="dropdown">
                    <div class="nav-cart-box dropdown h-100" id="cart_items">
                        @include('frontend.partials.cart')
                    </div>
                </div> -->

            </div>
        </div>
        @if(Route::currentRouteName() != 'home')
        <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3" id="hover-category-menu">
            <div class="container">
                <div class="row gutters-10 position-relative">
                    <div class="col-lg-3 position-static">
                        @include('frontend.partials.category_menu')
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!--mitash-->
    <div class="header_menu">
        <div class="container">
            <div class="nev_menu">
                <nav>
                  <div class="aiz-category-menu rounded @if(Route::currentRouteName() == 'home') shadow-sm" @else "shadow-lg" id="category-sidebar" @endif>
                    @php
                    $brandDet = navBrands();
                    $conditionpro=App\Productcondition::select('productconditions.*')->get();
                    $newBrands = App\Product::select('brands.slug','brands.name','products.productcondition_id')
                                      ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                                      ->join('brands', 'brands.id', '=', 'products.brand_id')
                                      ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                      ->where('product_types.listing_type','Watch')
                                      ->where('products.productcondition_id',14)
                                      ->where('products.published',1)
                                      ->orderBy('name', 'ASC')
                                      ->groupBy('products.brand_id')
                                      ->get();
                    $usedBrands = App\Product::select('brands.slug','brands.name','products.productcondition_id')
                                      ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
                                      ->join('brands', 'brands.id', '=', 'products.brand_id')
                                      ->join('productconditions','productconditions.id','=','products.productcondition_id')
                                      ->where('product_types.listing_type','Watch')
                                      ->where('products.productcondition_id',15)
                                      ->where('products.published',1)
                                      ->orderBy('name', 'ASC')
                                      ->groupBy('products.brand_id')
                                      ->get();
                    @endphp
                      <ul class="list-unstyled categories no-scrollbar mb-0 text-left">
                        <li class="category-nav-element " > <a href="https://gcijewel.com/" class="text-truncate text-reset "><span class="cat-name">Home</span></a> </li>
                        @foreach (\App\Models\Producttype::select('product_types.*')->groupBy('listing_type')->where('product_types.status',"1")->get() as $key => $navMenu)
                            @if($navMenu->listing_type == "Watch")
                              <li>
                                  <a href="{{ route('products.listing_type', $navMenu->listing_type) }}" class="text-truncate text-reset ">
                                    {{$navMenu->listing_type}}
                                  </a>
                                  <div class="droupdwon-menu">
                                      <ul>
                                        @foreach($conditionpro as $proCondition => $cond_name)
                                            @if($cond_name->name == "New")
                                                <li data-id="{{ $cond_name->id }}"  class="miCustomLiMini">
                                                    <a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}" class="text-truncate text-reset ">
                                                        {{$cond_name->name}}
                                                    </a>
                                                    <div class="droupdwon-menu miCustomMiniDropDown miCustomMiniProp">
                                                        <ul>
                                                            @foreach ($newBrands as $bSlug => $brandName)
                                                              @if($brandName->productcondition_id == 14)
                                                                <li><a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}&brand={{$brandName->slug}}">{{$brandName->name}}</a></li>
                                                              @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @elseif($cond_name->name == "Used")
                                            <li data-id="{{ $cond_name->id }}"  class="miCustomLiMini">
                                                <a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}" class="text-truncate text-reset ">
                                                    {{$cond_name->name}}
                                                </a>
                                                <div class="droupdwon-menu miCustomMiniDropDown miCustomMiniProp">
                                                    <ul>
                                                        @foreach ($usedBrands as  $usedbrandName)
                                                          @if($usedbrandName->productcondition_id == 15)
                                                            <li><a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}&brand={{$usedbrandName->slug}}">{{$usedbrandName->name}}</a></li>
                                                          @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                            @endif
                                        @endforeach
                                        
                                      </ul>
                                  </div>
                              </li>
                                  <!--<div class="droupdwon-menu">-->
                                  <!--  <ul>-->
                                        <!-- @foreach($conditionpro as $proCondition => $cond_name)
                                            @if($cond_name->name == "New" || $cond_name->name == "Used")
                                                <li data-id="{{ $cond_name->id }}">
                                                    <a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}" class="text-truncate text-reset ">
                                                        {{$cond_name->name}}
                                                    </a>
                                                    <div class="droupdwon-menu">
                                                        <ul>
                                                            @foreach ($brandDet as $bSlug => $brandName)
                                                              <li><a href="{{ route('products.listing_type', $navMenu->listing_type) }}?condition={{$cond_name->name}}&brand={{$bSlug}}">{{$brandName}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach -->
                                <!--    </ul>-->
                                <!--</div>-->
                              <!--</li>-->
                            @endif
                        @endforeach
                        <!-- <li>
                         <a href="{{ route('products.listing_type', "Watch Parts") }}">Watch Parts</a>
                         <div class="droupdwon-menu">
                           <ul>
                                @foreach (\App\Models\Producttype::select('product_types.*')->groupBy('listing_type')->get() as $key => $category)
                                    @if( $category->listing_type == "Bezel" || $category->listing_type == "Dial" || $category->listing_type == "Band" )
                                            <li><a href="{{ route('products.listing_type', $category->listing_type) }}">{{$category->listing_type}}</a></li>
                                    @endif

                                @endforeach
                                <li><a href="{{ route('products.listing_type', "Other Watch Parts") }}">Other Watch Parts</a></li>
                              </ul>
                         </div>
                        </li> -->
                                 <li>
                                 <a href="{{ route('products.listing_type', "Watch Parts") }}">Watch Parts</a>
                                 <div class="droupdwon-menu">
                                   <ul>
                                        @foreach (DB::table('product_types')->select('product_types.*')->orderBy('product_types.product_type_name')->where('product_types.status',"1")->get() as $key => $category)
                                            @if( $category->product_type_name == "Bezel" || $category->product_type_name == "Dial" || $category->product_type_name == "Bands" || $category->product_type_name == "Crystal" || $category->product_type_name == "Insert" || $category->product_type_name == "Links" )
                                                    <li><a href="{{ route('products.listing_type', $category->product_type_name) }}">{{$category->product_type_name}}</a></li>
                                            @endif

                                        @endforeach
                                        <!--<li><a href="{{ route('products.listing_type', "Other Watch Parts") }}">Other Watch Parts</a></li>-->
                                      </ul>
                                 </div>
                                </li>
                            <li>
                          <a href="{{ route('products.listing_type', "Jewelry") }}">Jewelry</a>
                          <div class="droupdwon-menu ">
                              <ul>
                                    @foreach (DB::table('product_types')->select('product_types.*')->orderBy('product_types.product_type_name')->where('product_types.status',"1")->get() as $key => $category)
                                        @if($category->product_type_name == "Bracelet" || $category->product_type_name == "Earring" || $category->product_type_name == "Ring" || $category->product_type_name == "Necklace")
                                                <li><a href="{{ route('products.listing_type', $category->product_type_name) }}">{{$category->product_type_name}}</a></li>
                                        @endif
                                    @endforeach

                              </ul>
                          </div>
                       </li>
                       <li>
                         <a href="#">Others</a>
                         <div class="droupdwon-menu">
                           <ul>
                                @foreach (\App\Models\Producttype::select('product_types.*')->groupBy('listing_type')->where('product_types.status',"1")->get() as $key => $category)
                                    @if($category->listing_type == "Diamonds" || $category->listing_type == "Memorabilia" || $category->listing_type == "Gold Collectibles" || $category->listing_type == "Accessories" )
                                            <li><a href="{{ route('products.listing_type', $category->listing_type) }}">{{$category->listing_type}}</a></li>
                                    @endif

                                @endforeach
                               
                                 <!--<li><a href="{{ route('products.listing_type', 'Dial') }}">Watch Parts</a></li>-->
                                 <!--<li><a href="{{ route('products.listing_type','Accessories') }}">Accessories</a></li>-->
                              </ul>
                         </div>
                       </li>
                        <li><a href="#">Services</a>
                        <div class="droupdwon-menu">
                            <ul>
                                <li><a href="{{Route('watch_and_jewelry_service.create') }}" >Watch & Jewelry Service</a></li>
                                <!--<li><a href="#" onclick="show_jewelry_re_modal()">Jewelry Repair</a></li>-->
                                <!--<li><a href="#" onclick="show_custom_pi_modal()">Custom Pieces</a></li>-->
                                <li><a href="{{Route('sell_my_watch.create')}}" >Sell Your Watch</a></li>
                            </ul>
                        </div>
                        </li>

                      </ul>

                  </div>


                    <!-- <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Timepieces</a>
                        <div class="droupdwon-menu">
                            <ul>
                                <li><a href="#">Watches</a></li>
                            </ul>
                        </div>
                        </li>
                        <li><a href="#">Jewelry</a>
                        <div class="droupdwon-menu">
                            <ul>
                                <li><a href="#">Bracelets</a></li>
                                <li><a href="#">Earrings</a></li>
                                <li><a href="#">Rings</a></li>
                                <li><a href="#">Cuffinks</a></li>
                                <li><a href="#">Neclaces</a></li>
                            </ul>
                        </div>
                        </li>
                        <li><a href="#">Services</a>
                        <div class="droupdwon-menu">
                            <ul>
                                <li><a href="#">Watch Repair</a></li>
                                <li><a href="#">Jewelry Repair</a></li>
                                <li><a href="#">Custom Pieces</a></li>
                            </ul>
                        </div>
                        </li>
                        <li><a href="#">Others</a>
                        <div class="droupdwon-menu">
                            <ul>
                                <li><a href="#">Diamounds</a></li>
                                <li><a href="#">Gold Collectibles</a></li>
                                <li><a href="#">Memorabilia</a></li>
                            </ul>
                        </div>
                        </li>
                    </ul> -->
                </nav>

            </div>
        </div>
    </div>

</header>
<script>
    function show_custom_pi_modal(){
        @if (Auth::check())
            $('#custome_pi_model').modal('show');
        @else
            $('#login_modal').modal('show');
        @endif
    }
</script>
