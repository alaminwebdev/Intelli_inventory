@extends('backend.layouts.app')
@section('content')
<script src="{{asset('public/backend/js/amcharts4/core.js')}}"></script>
<script src="{{asset('public/backend/js/amcharts4/charts.js')}}"></script>
<script src="{{asset('public/backend/js/amcharts4/themes/kelly.js')}}"></script>
<script src="{{asset('public/backend/js/amcharts4/themes/animated.js')}}"></script>

<style type="text/css">
  h4{
    padding-top:10px;
  }
  .card-body{
    border-radius: 10px;
    text-align: center;
    padding: 0px !important;
    min-height: 350px;
  }



  .card-body img{
    width:100%;
    vertical-align: 0%;
    margin:-6px;
  }

  .card-body > ul{
    list-style: none;
    margin: 0px;
  }
  .card-body > ul > li{
    text-align:center;
  }
  .card-body > h5{
    font-size:15px;
    text-align: center;
    padding: 0px;
    padding:7px 0px;
    margin: 0px;
    color:white;
    
    /* color:white */
  }
  .card-clock{
    background: transparent;
    border:none;
  }
</style>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('Dashboard')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('Home')</a></li>
              <li class="breadcrumb-item active">@lang('Dashboard')</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  {{-- @php
    $categories = \App\Model\Category::all();
  @endphp --}}
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        {{-- <div class="col-md-4">
          <div class="card">
            <div class="card-body">
           
              <img src="{{asset('public/images/dashboard_img/1_ptw.png')}}" alt="">
              <h5 style="background:#538135">Production Tubewell</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">2 PTW recently Installed <a href="#" style="text-decoration: underline;">click here</a></span></br>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">5 PTW data has been updated <a href="#" style="text-decoration: underline;">click here</a></span></br>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">3 PTW’s maintenance are upcoming <a href="#" style="text-decoration: underline;">click here</a></span>
               
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <img src="{{asset('public/images/dashboard_img/2_wtp.png')}}" alt="">
              <h5 style="background:#2F5496">Water Treatment Plant</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">2 Water Treatment Plant recently Installed <a href="" style="text-decoration: underline;">click here</a></span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <img src="{{asset('public/images/dashboard_img/3_owt.png')}}" alt="">
              <h5 style="background:#BF8F01">Over Head Reserviors</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">3 OHR’s maintenance are upcoming <a href="" style="text-decoration: underline;">click here</a></span>
            </div>
          </div>
        </div>

        

        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <img src="{{asset('public/images/dashboard_img/5_dpl.jpg')}}" alt="">
              <h5 style="background:#7B7B7B">Water Distribution Pipeline</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">Total 3km Distribution Line established <a href="" style="text-decoration: underline;">click here</a></span> 
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <img src="{{asset('public/images/dashboard_img/4_tpl.jpg')}}" alt="">
              <h5 style="background:#C45911">Water Transmission Pipeline</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">Total 2km Transmission Line established <a href="" style="text-decoration: underline;">click here</a></span>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <img src="{{asset('public/images/dashboard_img/6_wr.jpg')}}" alt="">
              <h5 style="background:#17a2b8">Water Reserver</h5>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">1 water reserver recently installed<a href="" style="text-decoration: underline;"> click here</a></span>
            </div>
          </div>
        </div> --}}
        {{-- @php
            $value = array();
            $max = 0;
        @endphp
        @foreach($categories as $key => $category)
            @php
              $subCategories = \App\Model\SubCategory::where('category_id',$category->id)->get();
  
              if($subCategories->count() > $max)
              {
                $max = $subCategories->count();
                $maxpx = 37 * $max;
              }
              
            @endphp
          @endforeach
        @foreach($categories as $key => $category) --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box" style="padding: 0;">
            <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px">
              <span class="info-box-text" style="text-align: center;background: #2E74B5;padding: 5px;font-size: 16px;">User Account</span> --}}
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">2 User registration are pending for approval <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div> --}}
        {{-- <div class="col-12 col-sm-6 col-md-4"> --}}
          {{-- <img src="{{asset('public/images/dashboard_img/1_ptw.png')}}" alt=""> --}}
          {{-- <div class="info-box" style="padding: 0;"> --}}
            {{-- <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span> --}}
            
            {{-- @php
              $subCategories = \App\Model\SubCategory::where('category_id',$category->id)->get();
  
              if($subCategories->count() > $max)
              {
                $max = $subCategories->count();
                $maxpx = 37 * $max;
              }
              
            @endphp --}}
            {{-- <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px"> --}}
              {{-- <img src="{{asset('public/images/dashboard_img/1_ptw.png')}}" alt=""> --}}
              {{-- <span class="info-box-text" style="text-align: center;background: #538135;padding: 5px;font-size: 16px;">Production Tubewell</span> --}}
              
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">2 PTW recently Installed <a href="" style="text-decoration: underline;">click here</a></span>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">5 PTW data has been updated <a href="" style="text-decoration: underline;">click here</a></span>
              <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">3 PTW’s maintenance are upcoming <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div>  --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box" style="padding: 0;">
            <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px">
              <span class="info-box-text" style="text-align: center;background: #2F5496;padding: 5px;font-size: 16px;">Water Treatment Plants</span> --}}
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">2 Water Treatment Plant recently Installed <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div>  --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box" style="padding: 0;">
            <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px">
              <span class="info-box-text" style="text-align: center;background: #BF8F01;padding: 5px;font-size: 16px;">Over Head Reservoirs</span> --}}
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">3 OHR’s maintenance are upcoming <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div>  --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box" style="padding: 0;">
            <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px">
              <span class="info-box-text" style="text-align: center;background: #7B7B7B;padding: 5px;font-size: 16px;">Distribution Line</span> --}}
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">Total 3km Distribution Line established <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div>  --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box" style="padding: 0;">
            <div id="info-box-content" class="info-box-content" style="padding: 0;height: 150px">
              <span class="info-box-text" style="text-align: center;background: #C45911;padding: 5px;font-size: 16px;">Transmission Line</span> --}}
              {{-- @foreach($subCategories as $subCategory) --}}
              {{-- <span class="info-box-text" style="text-align: center;padding-top: 5px;padding-bottom: 5px;font-size: 14px;">Total 2km Transmission Line established <a href="" style="text-decoration: underline;">click here</a></span> --}}
              {{-- @endforeach --}}
            {{-- </div>
          </div>
        </div>  --}}
        {{-- @endforeach
        @php
        unset($maxpx);
        unset($max);
        @endphp --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Likes</span>
              <span class="info-box-number">41,410</span>
            </div>              
          </div>
        </div> --}}
        {{-- <div class="clearfix hidden-md-up"></div> --}}
        {{-- <div class="col-12 col-sm-6 col-md-4">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number">760</span>
            </div>              
          </div>
        </div> --}}
        {{-- <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">New Members</span>
              <span class="info-box-number">2,000</span>
            </div>              
          </div>
        </div> --}}
      </div>
    </div>
  </section>
    <script type="text/javascript">
      $(function(){
        function showTime(){
          var date = new Date();
          var h = date.getHours();
          var m = date.getMinutes();
          var s = date.getSeconds();
          var session = "AM";
          if(h == 0){
            h = 12;
          }
          if(h > 12){
            h = h - 12;
            session = "PM";
          }
          h = (h < 10) ? "0" + h : h;
          m = (m < 10) ? "0" + m : m;
          s = (s < 10) ? "0" + s : s;

          var time = h + ":" + m + ":" + s + " " + session;
          document.getElementById("clock").innerText = time;
          setTimeout(showTime, 1000);
        }

        showTime();
      })
    </script>
  @endsection

