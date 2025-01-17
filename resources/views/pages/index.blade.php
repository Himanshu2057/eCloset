@extends('layouts.app')

@section('content')

@include('layouts.menubar')
@include('layouts.slider')

@php
 $featured = DB::table('products')->where('status',1)->orderBy('id','desc')->limit(12)->get();

 $trend = DB::table('products')->where('status',1)->where('trend',1)->orderBy('id','desc')->limit(8)->get();

  $best = DB::table('products')->where('status',1)->where('best_rated',1)->orderBy('id','desc')->limit(8)->get();

 $hot = DB::table('products')
            ->join('brands','products.brand_id','brands.id')
            ->select('products.*','brands.brand_name')
            ->where('products.status',1)->where('hot_deal',1)->orderBy('id','desc')->limit(3)
            ->get();

@endphp

    <!-- Deals of the week -->

    <div class="deals_featured">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">
                    
                    <!-- Deals -->

                    <div class="deals">
                        <div class="deals_title">Deals of the Week</div>
                        <div class="deals_slider_container">
                            
                            <!-- Deals Slider -->
                            <div class="owl-carousel owl-theme deals_slider">
    
                        @foreach($hot as $ht)                            
                    <!-- Deals Item -->
                    <div class="owl-item deals_item">
                        <div class="deals_image"><img src="{{ asset( $ht->image_one )}}" alt=""></div>
                            <div class="deals_content">
                                 <div class="deals_info_line d-flex flex-row justify-content-start">
                                    <div class="deals_item_category"><a href="#">{{ $ht->brand_name }}</a></div>
               
                                    @if($ht->discount_price == NULL)
                                    @else
                                    <div class="deals_item_price_a ml-auto">Rs.{{ $ht->selling_price }}</div>
                                    @endif
                

                                </div>
                                <div class="deals_info_line d-flex flex-row justify-content-start">
                                    <div class="deals_item_name">{{ $ht->product_name }}</div>

                                    @if($ht->discount_price == NULL)
                                    <div class="deals_item_price ml-auto">Rs.{{ $ht->selling_price }}</div>
                                     @else

                                    @endif

                                    @if($ht->discount_price != NULL)
                                    <div class="deals_item_price ml-auto">Rs.{{ $ht->discount_price }}</div>
                                    @else

                                    @endif
                 


                                </div>
                            <div class="available">
                                <div class="available_line d-flex flex-row justify-content-start">
                                    <div class="available_title">Available: <span>{{ $ht->product_quantity  }}</span></div>
                                    <div class="sold_title ml-auto">Already sold: <span>28</span></div>
                                </div>
                                <div class="available_bar"><span style="width:17%"></span></div>
                            </div>
                            
                            <div class="deals_timer d-flex flex-row align-items-center justify-content-start">
                                <div class="deals_timer_title_container">
                                    <div class="deals_timer_title">Hurry Up</div>
                                    <div class="deals_timer_subtitle">Offer ends in:</div>
                                </div>
                            <div class="deals_timer_content ml-auto">
                                <div class="deals_timer_box clearfix" data-target-time="">
                                    <div class="deals_timer_unit">
                                        <div id="deals_timer1_hr" class="deals_timer_hr"></div>
                                        <span>hours</span>
                                    </div>
                                    <div class="deals_timer_unit">
                                        <div id="deals_timer1_min" class="deals_timer_min"></div>
                                        <span>mins</span>
                                    </div>
                                    <div class="deals_timer_unit">
                                        <div id="deals_timer1_sec" class="deals_timer_sec"></div>
                                        <span>secs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                @endforeach
                               

                            </div>

                        </div>

                        <div class="deals_slider_nav_container">
                            <div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i></div>
                            <div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i></div>
                        </div>
                    </div>
                    
                    <!-- Featured -->
                    <div class="featured">
                        <div class="tabbed_container">
                            <div class="tabs">
                                <ul class="clearfix">
                                    <li class="active">Featured</li>
                                    
                                </ul>
                                <div class="tabs_line"><span></span></div>
                            </div>

                            <!-- Product Panel -->
                            <div class="product_panel panel active">
                                <div class="featured_slider slider">


                @foreach($featured as $row)
        <!-- Slider Item -->
            <div class="featured_slider_item">
                <div class="border_active"></div>
                    <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center" style="padding:5%">
                        <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
                        <div class="product_content">

                        @if($row->discount_price == NULL)
                        <div class="product_price discount">Rs.{{ $row->selling_price }}<span> </div>
                        @else
                        <div class="product_price discount">Rs.{{ $row->discount_price }}<span>Rs.{{ $row->selling_price }}</span></div>
                        @endif


                
                        <div class="product_name"><div><a href="{{ url('product/details/'.$row->id.'/'.$row->product_name) }}">{{ $row->product_name }}</a></div></div>
                

                        <!--   <div class="product_extras">
                      
                            <button class="product_cart_button addcart" data-id="{{ $row->id }}">Add to Cart</button>
                            </div> -->

                        <div class="product_extras">                          
                            <button id="{{ $row->id }}" class="product_cart_button addcart" data-toggle="modal" data-target="#cartmodal" onclick="productview(this.id)">Add to Cart</button>
                        </div>
                    </div>


                <button class="addwishlist" data-id="{{ $row->id }}" >
                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                </button>
            

                    <ul class="product_marks">
                        @if($row->discount_price == NULL)
                        <li class="product_mark product_discount" style="background: blue;">New</li>
                        @else
                       <li class="product_mark product_discount">
                       @php
                         $amount = $row->selling_price - $row->discount_price;
                         $discount = $amount/$row->selling_price*100;

                       @endphp
                       
                       {{ intval($discount) }}%

                      </li> 
                        @endif
                    </ul>
                </div>
            </div>
                @endforeach   

        </div>
            
            <div class="featured_slider_dots_cover"></div>
        </div>

                             

        </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Popular Categories -->

    <div class="popular_categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="popular_categories_content">
                        <div class="popular_categories_title">Popular Categories</div>
                        <div class="popular_categories_slider_nav">
                            <div class="popular_categories_prev popular_categories_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="popular_categories_next popular_categories_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                        <div class="popular_categories_link"><a href="#">full catalog</a></div>
                    </div>
                </div>
                


            @php
            $category = DB::table('categories')->get();
            @endphp        
                <!-- Popular Categories Slider -->

                <div class="col-lg-9">
                    <div class="popular_categories_slider_container">
                        <div class="owl-carousel owl-theme popular_categories_slider">

                        @foreach($category as $cat)
                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset('public/frontend/images/man-icon.png')}}" alt=""></div>
                                    <div class="popular_category_text">Men</div>
                                </div>
                            </div>

                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset('public/frontend/images/woman-icon.png')}}" alt=""></div>
                                    <div class="popular_category_text">Women</div>
                                </div>
                            </div>

                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset('public/frontend/images/kid-icon.png')}}" alt=""></div>
                                    <div class="popular_category_text">Kids</div>
                                </div>
                            </div>

                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset('public/frontend/images/watch-icon.png')}}" alt=""></div>
                                    <div class="popular_category_text">Watches & Accessories</div>
                                </div>
                            </div>

                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="{{ asset('public/frontend/images/beauty-icon.png')}}" alt=""></div>
                                    <div class="popular_category_text">Bags & Purse</div>
                                </div>
                            </div>

                          @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner -->
  @php
     $mid = DB::table('products')
            ->join('categories','products.category_id','categories.id')
            ->join('brands','products.brand_id','brands.id')
            ->select('products.*','brands.brand_name','categories.category_name')
            ->where('products.mid_slider',1)->orderBy('id','DESC')->limit(3)
            ->get();

  @endphp


    <div class="banner_2">
        <div class="banner_2_container" style="background-color:#E5F3FB;">
            <div class="banner_2_dots"></div>
            <!-- Banner 2 Slider -->

            <div class="owl-carousel owl-theme banner_2_slider">
            @foreach($mid as $row)
                <!-- Banner 2 Slider Item -->
    <div class="owl-item">
    <div class="banner_2_item">
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="col-lg-4 col-md-6 fill_height">
                    <div class="banner_2_content">
                        <div class="banner_2_category"><h4>{{ $row->category_name }}</h4></div>
                        <div class="banner_2_title">{{ $row->product_name }}</div>
                        <div class="banner_2_text"><h4> {{ $row->brand_name }}</h4> <br>
                            <h2>Rs.{{ $row->selling_price }} </h2>

                        </div>
                        <div class="rating_r rating_r_4 banner_2_rating"><i></i><i></i><i></i><i></i><i></i></div>
                        <div class="button banner_2_button"><a href="#">Explore</a></div>
                    </div>
                    
                </div>
                <div class="col-lg-8 col-md-6 fill_height">
                    <div class="banner_2_image_container">
                        <div class="banner_2_image"><img src="{{ asset( $row->image_one )}} " alt="" style="height: 300px; width: 250px;"></div>
                    </div>
                </div>
            </div>
        </div>          
    </div>
    </div>
             @endforeach
               
            </div>
        </div>
    </div>


    <!-- Hot New Category One -->

@php
$cats = DB::table('categories')->skip(1)->first();
$catid = $cats->id;

$product = DB::table('products')->where('category_id',$catid)->where('status',1)->limit(10)->orderBy('id','DESC')->get();

@endphp

    <div class="new_arrivals">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">{{ $cats->category_name }}</div>
                            <ul class="clearfix">
                                <li class="active"> </li>
                                 
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="z-index:1;">

                                <!-- Product Panel -->
                                <div class="product_panel panel active">
                                    <div class="arrivals_slider slider">

           @foreach($product as $row)
    <!-- Slider Item -->
    <div class="featured_slider_item">
        <div class="border_active"></div>
        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
            <div class="product_content">

      @if($row->discount_price == NULL)
<div class="product_price discount">Rs.{{ $row->selling_price }}<span> </div>
      @else
<div class="product_price discount">Rs.{{ $row->discount_price }}<span>Rs.{{ $row->selling_price }}</span></div>
      @endif


                
                <div class="product_name"><div><a href="{{url('product/details/'.$row->id.'/'.$row->product_name)}}">{{ $row->product_name }}</a></div></div>
                <div class="product_extras">
                    
                    <button class="product_cart_button">Add to Cart</button>
                </div>
            </div>


             <a href="{{ URL::to('add/wishlist/'.$row->id)}}">
            <div class="product_fav"><i class="fas fa-heart"></i></div>
             </a>
            

            <ul class="product_marks">
       @if($row->discount_price == NULL)
       <li class="product_mark product_discount" style="background: blue;">New</li>
       @else
                       <li class="product_mark product_discount">
                       @php
                         $amount = $row->selling_price - $row->discount_price;
                         $discount = $amount/$row->selling_price*100;

                       @endphp
                       
                       {{ intval($discount) }}%

                      </li> 
       @endif

               
                 
            </ul>
        </div>
    </div>
    @endforeach   

                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                            </div>
 

                        </div>
                                
                    </div>
                </div>
            </div>
        </div>      
    </div>


    <!-- Hot New Category Two -->
 
    @php
$cats = DB::table('categories')->skip(0)->first();
$catid = $cats->id;

$product = DB::table('products')->where('category_id',$catid)->where('status',1)->limit(10)->orderBy('id','DESC')->get();

@endphp

    <div class="new_arrivals">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">{{ $cats->category_name }}</div>
                            <ul class="clearfix">
                                <li class="active"> </li>
                                 
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="z-index:1;">

                                <!-- Product Panel -->
                                <div class="product_panel panel active">
                                    <div class="arrivals_slider slider">

           @foreach($product as $row)
    <!-- Slider Item -->
    <div class="featured_slider_item">
        <div class="border_active"></div>
        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
            <div class="product_content">

      @if($row->discount_price == NULL)
<div class="product_price discount">Rs.{{ $row->selling_price }}<span> </div>
      @else
<div class="product_price discount">Rs.{{ $row->discount_price }}<span>Rs.{{ $row->selling_price }}</span></div>
      @endif


                
                <div class="product_name"><div><a href="product.html">{{ $row->product_name }}</a></div></div>
                <div class="product_extras">
                    
                    <button class="product_cart_button">Add to Cart</button>
                </div>
            </div>


             <button class="addwishlist" data-id="{{ $row->id }}" >
            <div class="product_fav"><i class="fas fa-heart"></i></div>
            </button>
            

            <ul class="product_marks">
       @if($row->discount_price == NULL)
       <li class="product_mark product_discount" style="background: blue;">New</li>
       @else
                       <li class="product_mark product_discount">
                       @php
                         $amount = $row->selling_price - $row->discount_price;
                         $discount = $amount/$row->selling_price*100;

                       @endphp
                       
                       {{ intval($discount) }}%

                      </li> 
       @endif

               
                 
            </ul>
        </div>
    </div>
    @endforeach   

                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                            </div>
 

                        </div>
                                
                    </div>
                </div>
            </div>
        </div>      
    </div>

    <!-- Hot New Category Three -->
 
@php
$cats = DB::table('categories')->skip(3)->first();
$catid = $cats->id;

$product = DB::table('products')->where('category_id',$catid)->where('status',1)->limit(10)->orderBy('id','DESC')->get();

@endphp

    <div class="new_arrivals">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">{{ $cats->category_name }}</div>
                            <ul class="clearfix">
                                <li class="active"> </li>
                                 
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="z-index:1;">

                                <!-- Product Panel -->
                                <div class="product_panel panel active">
                                    <div class="arrivals_slider slider">

           @foreach($product as $row)
    <!-- Slider Item -->
    <div class="featured_slider_item">
        <div class="border_active"></div>
        <div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
            <div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt="" style="height: 120px; width: 100px;"></div>
            <div class="product_content">

      @if($row->discount_price == NULL)
<div class="product_price discount">Rs.{{ $row->selling_price }}<span> </div>
      @else
<div class="product_price discount">Rs.{{ $row->discount_price }}<span>Rs.{{ $row->selling_price }}</span></div>
      @endif


                
                <div class="product_name"><div><a href="product.html">{{ $row->product_name }}</a></div></div>
                <div class="product_extras">
                    <button class="product_cart_button">Add to Cart</button>
                </div>
            </div>


             <button class="addwishlist" data-id="{{ $row->id }}" >
            <div class="product_fav"><i class="fas fa-heart"></i></div>
            </button>
            

            <ul class="product_marks">
       @if($row->discount_price == NULL)
       <li class="product_mark product_discount" style="background: blue;">New</li>
       @else
                       <li class="product_mark product_discount">
                       @php
                         $amount = $row->selling_price - $row->discount_price;
                         $discount = $amount/$row->selling_price*100;

                       @endphp
                       
                       {{ intval($discount) }}%

                      </li> 
       @endif

               
                 
            </ul>
        </div>
    </div>
    @endforeach   

                                </div>
                                <div class="featured_slider_dots_cover"></div>
                            </div>

                            </div>
 

                        </div>
                                
                    </div>
                </div>
            </div>
        </div>      
    </div>



    <!-- Trends -->

    <div class="trends">
        <div class="trends_background"></div>
        <div class="trends_overlay"></div>
        <div class="container">
            <div class="row">

                <!-- Trends Content -->
                <div class="col-lg-3">
                    <div class="trends_container">
                        <h2 class="trends_title">Buy One Get One</h2>
                        <div class="trends_text"><p>Buy One Get OneBuy One Get OneBuy One Get OneBuy One Get One</p></div>
                        <div class="trends_slider_nav">
                            <div class="trends_prev trends_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="trends_next trends_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                    </div>
                </div>


@php
 $buyget = DB::table('products')
            ->join('brands','products.brand_id','brands.id')
            ->select('products.*','brands.brand_name') 
            ->where('status',1)->where('buyone_getone',1)->orderBy('id','DESC')->limit(6)->get();

@endphp

                <!-- Trends Slider -->
                <div class="col-lg-9">
                    <div class="trends_slider_container">

                        <!-- Trends Slider -->

                        <div class="owl-carousel owl-theme trends_slider">
       @foreach($buyget as $row)
                            <!-- Trends Slider Item -->
            <div class="owl-item">
                <div class="trends_item is_new">
                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="{{ asset( $row->image_one )}}" alt=""></div>
                    <div class="trends_content">
        <div class="trends_category"><a href="#">{{ $row->brand_name }}</a></div>
                        <div class="trends_info clearfix">
          <div class="trends_name"><a href="product.html">{{ $row->product_name }}</a></div>
                             

 @if($row->discount_price == NULL)
<div class="product_price discount">Rs.{{ $row->selling_price }}<span> </div>
      @else
<div class="product_price discount">Rs.{{ $row->discount_price }}<span>Rs.{{ $row->selling_price }}</span></div>
      @endif 

      <a href="" class="btn btn-danger btn-sm">Add to Cart</a>
                        </div>
                    </div>
                    <ul class="trends_marks">
                       
                        <li class="trends_mark trends_new">BuyGet</li>
                    </ul>
                     <button class="addwishlist" data-id="{{ $row->id }}" >
                    <div class="trends_fav"><i class="fas fa-heart"></i></div>
                </button>

                </div>
            </div>

        @endforeach
                           

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Recently Viewed -->

    <div class="viewed">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="viewed_title_container">
                        <h3 class="viewed_title">Recently Viewed</h3>
                        <div class="viewed_nav_container">
                            <div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
                            <div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
                        </div>
                    </div>

                    <div class="viewed_slider_container">
                        
                        <!-- Recently Viewed Slider -->

                        <div class="owl-carousel owl-theme viewed_slider">
                            
                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/1.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.525<span>Rs.700</span></div>
                                        <div class="viewed_name"><a href="#">Wallet for Men</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/2.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.2625<span>Rs.3500</span></div>
                                        <div class="viewed_name"><a href="#">Anti-theft Bag with usb port</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/3.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.500</div>
                                        <div class="viewed_name"><a href="#">Printed T-shirt for men</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/4.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.2500</div>
                                        <div class="viewed_name"><a href="#">Converse Shoe</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/5.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.1125<span>Rs.1500</span></div>
                                        <div class="viewed_name"><a href="#">Collection of 5 printed T-shirts</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recently Viewed Item -->
                            <div class="owl-item">
                                <div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
                                    <div class="viewed_image"><img src="{{ asset('public/frontend/images/6.jpg')}}" alt=""></div>
                                    <div class="viewed_content text-center">
                                        <div class="viewed_price">Rs.800</div>
                                        <div class="viewed_name"><a href="#">Mini purse for Ladies</a></div>
                                    </div>
                                    <ul class="item_marks">
                                        <li class="item_mark item_discount">-25%</li>
                                        <li class="item_mark item_new">new</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="cartmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLavel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLavel">Product Quick View</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body">
       <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="" id="pimage" style="height: 220px; width: 200px;">
                <div class="card-body">
                    <h5 class="card-title text-center" id="pname">  </h5>
                    
                </div>
                
            </div>
            
        </div>


<div class="col-md-4">
            <ul class="list-group">
  <li class="list-group-item">Product Code:<span id="pcode"></span> </li>
  <li class="list-group-item">Category: <span id="pcat"></span></li>
  <li class="list-group-item">Subcategory: <span id="psub"></span></li>
  <li class="list-group-item">Brand:<span id="pbrand"></span> </li>
  <li class="list-group-item">Stock: <span class="badge" style="background: green;color: white;" > Available</span> </li>
</ul>
            
        </div>

        <div class="col-md-4">

        <form method="post" action="{{ route('insert.into.cart') }}">
        @csrf 
 
    <input type="hidden" name="product_id" id="product_id">

         <div class="form-group">
            <label for="exampleInputcolor">Color</label>
            <select name="color" class="form-control" id="color">
  
             </select>
             
         </div>   

 <div class="form-group">
            <label for="exampleInputcolor">Size</label>
            <select name="size" class="form-control" id="size">
   
             </select>
             
         </div>   


         <div class="form-group">
     <label for="exampleInputcolor">Quantity</label>
     <input type="number" class="form-control" name="qty" value="1"> 
         </div>   


<button type="submit" class="btn btn-primary">Add to Cart </button>

</form>  
            
        </div>
 

           
       </div>
      </div>




      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>


    <!-- CHAT BAR BLOCK -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/frontend/styles/chatbot.css') }}">
  

    <div class="chat-bar-collapsible">
        
       
            <i id="chat-icon" type="button" style="color: white" class="fa fa-fw fa-comments-o collapsible"></i>
       



        <div class="content">
            
            <div class="full-chat-block">
                <!-- MESSAGE CONTAINER -->
                
                <div class="outer-container">
                    
                    <div class="chat-container">
                        <!-- MESSAGES -->
                        
                        <div id="chat-box">
                            
                            <h5 id="chat-timestamp"></h5>
                            <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                        
                        </div>
                        <!-- User input box -->
                        
                        <div class="chat-bar-input-block">
                            
                            <div id="userInput">
                                <input type="text" id="textInput" class="input-box" name="msg" placeholder="Tap 'Enter' to send a message">
                                <p></p>
                            </div>

                            <div class="chat-bar-icons">
                                <i id="chat-icon" style="color: crimson" class="fa fa-fw fa-heart" onclick="heartButton()"></i>
                                <i id="chat-icon" style="color: #333" class="fa fa-fw fa-send" onclick="sendButton()"></i>

                            </div>
                        
                        </div>
                        
                        <div id="chat-bar-bottom">
                            
                            <p></p>
                        
                        </div>
                    
                    </div>
                
                </div>
            
            </div>
        
        </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    
    <script src="{{ asset('public/frontend/js/responses.js')}}"></script>
    <script src="{{ asset('public/frontend/js/chat.js')}}"></script>
    



    <!---------------------->



<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script type="text/javascript">
    function productview(id){
        $.ajax({
         url: "{{ url('/cart/product/view/') }}/"+id, 
         type: "GET",
         dataType:"json",
         success:function(data){
       $('#pcode').text(data.product.product_code);
       $('#pcat').text(data.product.category_name);
       $('#psub').text(data.product.subcategory_name);
       $('#pbrand').text(data.product.brand_name);
       $('#pname').text(data.product.product_name);
       $('#pimage').attr('src',data.product.image_one);
       $('#product_id').val(data.product.id);

       var d = $('select[name="color"]').empty();
       $.each(data.color,function(key,value){
       $('select[name="color"]').append('<option value="'+value+'">'+value+'</option>'); 
        });

          var d = $('select[name="size"]').empty();
       $.each(data.size,function(key,value){
       $('select[name="size"]').append('<option value="'+value+'">'+value+'</option>'); 
        });


         }  
        })
    }


</script>



<!-- <script type="text/javascript">
    
   $(document).ready(function(){
     $('.addcart').on('click', function(){
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                url: " {{ url('add/to/cart/') }}/"+id,
                type:"GET",
                datType:"json",
                success:function(data){
             const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

             if ($.isEmptyObject(data.error)) {

                Toast.fire({
                  icon: 'success',
                  title: data.success
                })
             }else{
                 Toast.fire({
                  icon: 'error',
                  title: data.error
                })
             }
 

                },
            });

        }else{
            alert('danger');
        }
     });

   }); -->


</script>



<script type="text/javascript">
    
   $(document).ready(function(){
     $('.addwishlist').on('click', function(){
        var id = $(this).data('id');
        if (id) {
            $.ajax({
                url: " {{ url('add/wishlist/') }}/"+id,
                type:"GET",
                datType:"json",
                success:function(data){
             const Toast = Swal.mixin({
                  toast: true,
                  position: 'top-end',
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                  onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                  }
                })

             if ($.isEmptyObject(data.error)) {

                Toast.fire({
                  icon: 'success',
                  title: data.success
                })
             }else{
                 Toast.fire({
                  icon: 'error',
                  title: data.error
                })
             }
 

                },
            });

        }else{
            alert('danger');
        }
     });

   });


</script>





@endsection 