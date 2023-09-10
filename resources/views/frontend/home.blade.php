<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<noscript>
		{{-- Your browser does not support JavaScript! --}}
		<img id="noscript" src="https://cms-assets.tutsplus.com/uploads/users/30/posts/25498/preview_image/preview-tag-noscript.png" alt="Your browser does not support JavaScript!">
		<style>
			#noscript{
				width:100%;
				height:100vh;
			}
			div { display:none; }
		</style>
	</noscript>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
	<link rel="icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
	<title>{{(@$site_setting->title_suffix)?(@$site_setting->title_suffix):'Project Name'}} | {{@$title??'Dashboard'}}</title>

	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/bootstrap.min.4.0.0.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/milumax.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/fontawesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/bootstrap-select.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/magnific-popup.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/style.min.css">
	<link class="skin"  rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/skin/skin-1.css">
	<link  rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/templete.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/switcher.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/css/hover.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/revolution/revolution/css/settings.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend')}}/plugins/revolution/revolution/css/navigation.min.css">
	<link rel="stylesheet" href="{{asset('plugins')}}/select2/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="{{asset('plugins')}}/sweetalert2/sweetalert2.min.css">
	<script src="{{asset('plugins')}}/jquery/jquery.min.js"></script>
	<script src="{{asset('extra-plugins')}}/notify/notify.js"></script>
	<script type="text/javascript" src="{{asset('plugins')}}/sweetalert2/sweetalert2.min.js"></script>
	<script src="{{asset('plugins')}}/jquery-validation/jquery.validate.min.js"></script>
	<script src="{{asset('plugins')}}/jquery-validation/additional-methods.min.js"></script>
	
	<style type="text/css">
		.header-style-4 .social-line li a:hover {
			color: #1f4197;
			background: white;
			border: 1px solid #1f4197;
		}
		.header-style-4 .social-line li a {
			color: white;
			background: #1f4197;
			border: 1px solid #e3e3e3;
			border-width: 0 1px;
			height: 45px;
			line-height: 45px;
			padding: 0 15px;
			display: inline-block;
			min-width: 45px;
			cursor: pointer;
		}
		.mobile_social{
			margin-top: 30px;
		}
		@media  only screen and (min-width:320px) and (max-width:768px) {
			.mobile_social{
				margin-top: 0px;
			}
			.institute_img{
				width: 45%;
			}
			.mobile_tutorial_img{
				width: 55%;
				margin-top: 25px;
			}
			.mobile_social_div{
				margin-left: -40px;
				margin-bottom: 10px;
			}
		}
	</style>

</head>
<body id="bg" class="boxed">
	<div class="page-wraper">
		<header class="site-header header-style-4">
			<div class="bg-white" style="margin-bottom: -4px;margin-top: 1px;">
				<div class="container">
					<div class="col-md-12 col-lg-12">
						<div class="row">
							<div class="col-md-2 institute_img">
								<img src="{{fileExist(['url'=>@$site_setting->logo,'type'=>'logo'])}}" style="height: 80px;">
							</div>
							<div class="col-md-6 class mobile_tutorial_img">
								<h2 class="milumax text-uppercase">
									{{(@$site_setting->name)?(@$site_setting->name):'Project Name'}}
								</h2>		
							</div>
							<div class="col-md-4 mobile_social_div">
								<ul class="social-line text-right pull-right mobile_social">
									<li><a href="#" class="fa fa-facebook"></a></li>
									<li><a href="#" class="fa fa-twitter"></a></li>
									<li><a href="#" class="fa fa-linkedin"></a></li>
									<li><a href="#" class="fa fa-google-plus"></a></li>
								</ul>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="sticky-header main-bar-wraper">
				<div class="main-bar clearfix ">
					<div class="slide-up">					
						<nav class="navbar navbar-expand-sm   navbar-light bg-light">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="header-nav collapse navbar-collapse" id="navbarTogglerDemo03">
								<ul class="nav navbar-nav mr-auto mt-2 mt-lg-0">
									<li class="active nav-item">
										<a class=" nav-link" href="{{url('/')}}">হোম</a>
									</li>
									<li class="nav-item milu2 nav-item">
										<a class="nav-link" href="{{route('admin.login')}}">কর্তৃপক্ষ</a>
									</li>
									<li class="nav-item milu2 nav-item">
										<a class="nav-link" href="{{route('member.login')}}">সদস্য</a>
									</li>
								</ul>							 
							</div>
						</nav>					
					</div>
				</div>
			</div>			
		</header>
		<div class="page-content">
			<div class="main-slider style-two default-banner">
				<div class="tp-banner-container">
					<div class="tp-banner" >
						<div id="rev_slider_486_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="news-gallery36" data-source="gallery" style="margin:0px auto;background-color:#ffffff;padding:0px;margin-top:0px;margin-bottom:0px;">
							<div id="rev_slider_486_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.3.0.2">
								<ul>
									<li data-index="rs-100" data-transition="parallaxvertical" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="default"  data-thumb=""  data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7" data-saveperformance="off"  data-title="" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="">
										<img src="{{asset('frontend')}}/images/main-slider/image_21_10_2020.jpg"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
									</li>
								</ul>
								<div class="tp-bannertimer tp-bottom bg-primary"></div> </div>
							</div>
						</div>
					</div>
				</div>
				<div class="section-full  bg-img-fix bg-white choose-us">
					<div class="content-area">
						<div class="container">
							<div class="p-a30 bg-gray">
								<div class="blog-md clearfix date-style-2">
									<div class="dez-post-info">
										<div class="dez-post-title ">
											<h2 class="text-center text-bold">গভর্নমেন্ট আইসিটি অফিসার্স ফোরাম</h2>    
										</div>
										<div class="dez-post-text">
											<div>
												<p>গভর্নমেন্ট আইসিটি অফিসারস ফোরাম গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রাজস্ব বাজেটের অধীনে কর্মরত ক্লাস ওয়ান আইসিটি অফিসারদের একটি সংগঠন। এটি সোসাইটিস রেজিস্ট্রেশন অ্যাক্ট ১৮৬০ এর অধীনে নিবন্ধিত হয়েছে যার রেজিস্ট্রেশন নম্বর এস-১১৩০১/২০১১ রয়েছে।</p>
											</div>                                        
										</div>                              
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="site-footer" >
				<div class="footer-artwork" id="footer-artwork">&nbsp;</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-6">
							<p class="copyright text-left m-t10 m-b0"><a target="_blank" rel="nofollow" href="https://www.nanosoftbd.com/">Design &amp; Developed by Nanosoft.</a></p>
						</div>
						<div class="col-md-6">
							<p class=" text-left m-t10 m-b0 pull-right">
								কপিরাইট &copy; {{en2bn((@$site_setting->copy_right_year != date('Y'))?((@$site_setting->copy_right_year)?(@$site_setting->copy_right_year.' - '.date('Y')):''):(date('Y')))}}
								{{(@$site_setting->name)?(@$site_setting->name):'Project Name'}}
							</p>
						</div>							
					</div>
				</div>	
			</footer>
			<button class="scroltop fa fa-caret-up" ></button>
		</div>
		<div id="loading-ar ea"></div>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/jquery.themepunch.tools.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/jquery.themepunch.revolution.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.actions.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.migration.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
		<script type="text/javascript" src="{{asset('frontend')}}/plugins/revolution/revolution/js/extensions/revolution.extension.video.min.js"></script>
		<script type="text/javascript"  src="{{asset('frontend')}}/js/rev.slider.js"></script>
		<script type="text/javascript"  src="{{asset('frontend')}}/js/bootstrap.min.js"></script>
		<script src="{{asset('plugins')}}/select2/js/select2.full.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('.select2').select2();
			});
		</script>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				'use strict';
				dz_rev_slider_1();
			});
			$(document).ready(function () {
				$('.navbar-light .dmenu').hover(function () {
					$(this).find('.sm-menu').first().stop(true, true).slideDown(150);
				}, function () {
					$(this).find('.sm-menu').first().stop(true, true).slideUp(105)
				});
			});
		</script>
	</body>
	</html>