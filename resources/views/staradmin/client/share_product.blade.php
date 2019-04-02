<!DOCTYPE HTML>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<meta name="format-detection" content="telephone=no" />
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>@lang('dingsu.home')</title>
	<link rel="stylesheet" href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('/client/css/slick-theme.css') }}" />

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

</head>
<style>
	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
	
	.header .top li a, .header .top li a:hover, .header .top li a:focus {
			text-decoration: none;
		}
		
	.header {
		background-color: #ff4e4e !important;
		height: 4rem !important;
	}

	.cardBody {
		margin-top: -30px !important;
	}
	
	.infinite-scroll {

		position:relative !important;	
	    background: white;
	    color: black;
	    /*text-align: center;*/
	    margin-left: 10px;
	    margin-right: 10px;
	    border-top-left-radius: 6px;
	    border-top-right-radius: 6px;
	    border-bottom-left-radius: 6px;
	    border-bottom-right-radius: 6px;
	    padding: 10px;
	    font-weight: 700;
	    height: 7rem !important;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.1);
      /*line-height: 2px !important;*/

	}

	.infinite-scroll .imgBox {
	  margin: 0 auto;
	  /*border: 0.01rem solid #efefef;*/
	  /*padding: 0.15rem;*/
	  padding-right: 0.3rem;
	  font-size: 0;
	  display: inline-block;
	  margin-bottom: 0.2rem;
	}

	.infinite-scroll .imgBox img {
	  max-width: 2.5rem;
	}

	.infinite-scroll h2 {
	  font-size: 0.31rem;
	  font-weight: 500;
	  color: #999999;

	}

	.infinite-scroll .price1{
		margin-top: 50px;
	}

	.infinite-scroll .price1 h3{

		font-size: 0.26rem;
	  	font-weight: 0;
	  	color: #999999;
	  	  /*text-decoration: line-through;*/

	}

	.infinite-scroll .price1 .price2{

		font-size: 0.4rem;
	  	font-weight: 500;
	  	color: red;
	  	  /*text-decoration: line-through;*/

	}

	.infinite-scroll .price1 .price3{

		text-decoration: line-through;

	}

	.infinite-scroll .button a {
	  width: 100%;
	  padding: 15px;
	  /*margin-left: 0.18rem;*/
	  margin-right: 0.18rem;
	  text-align: center;
	  border-radius: 0.1rem;
	  display: inline-block;
	  font-size: 0.4rem;	  
	  line-height: 0.48rem;	  
	  -webkit-border-radius: 0.1rem;
	  -moz-border-radius: 0.1rem;
	  -ms-border-radius: 0.1rem;
	  -o-border-radius: 0.1rem;
	}

	.getvoucher {

		margin-top: 0.4rem;
		font-weight: 300;
		color: #ff5949;
		border: 0.01rem solid #ff5949;

	}

	.playgame {

		margin-top: 0.3rem;
		font-weight: bold;
		color: white;
		background-color: #ff4e4e;

	}

	.playgame a:hover {

		color: none !important;

	}

	</style>
<body>
	<section class="cardFull card-flex">
		<div class="cardHeader">
			<div class="header">
				<ul class="dbox top">
					
						<li class="dbox0">
					  		<a href="/nlogin" style="color: white; font-size: 0.3rem;">@lang('dingsu.login') / @lang('dingsu.register')</a>
					  	</li>
				  						
					<li class="dbox1 logo"><img src="{{ asset('/test/main/images/logo.png') }}"></li>				
					<li class="dbox0"><a href="/search" style="color: white; font-size: 0.3rem;"><img src="{{ asset('/client/images/search_btn.png') }}" style="height: 0.3rem;"> 搜索</a></li>					
				</ul>				
			</div>
		</div>
		<div class="cardBody">
			<div class="infinite-scroll">
				<ul class="list-2">
					<li class="dbox">
						<a class="dbox0 imgBox" href="#">
							<img src="{{$item->product_picurl}}_160x160.jpg" alt="{{$item->product_name}}">
						</a>
						<div class="dbox1">
							<span>
								<h2>{{$item->product_name}}</h2>
								<div class="price1">
									<h3>券后
									<span class="price2">￥{{number_format($item->voucher_price,2)}} </span>
									<span class="price3">
									淘宝价￥{{number_format($item->product_price, 2)}}
									</span>
									</h3>
									
								</div>
							</span>							
						</div>
					</li>
				</ul>

				<div class="button">
					<a class="getvoucher" href="#">领60元优惠券购买</a>
					<a class="playgame" href="#">玩赚免单</a>
				</div>
			</div>
		</div>

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox">
				<img src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<h2>复制成功后, 打开淘宝APP即可领优惠卷</h2>

				
					<h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3>
					<a class="cutBtn"><img src="{{ asset('/test/main/images/btn-1.png') }}"></a>
					<h4>如复制不成功，请手指按住优惠卷代码复制。</h4>
				
				
			</div>
		</div>

		<!-- 玩赚免单 -->
		<div class="showInfo dflex scaleHide">
			<div class="inBox">
				test
				
			</div>
		</div>
		@include('layouts/footer')

	</section>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).ready(function(){
			
			$('.showQuan').click((e) => {
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-1.png') }} ");
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showQuan');
					being.wrapHide();
				}
			});

			$("body").on("click",".button a.getvoucher",function(e) {
				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
			});
			
			$("body").on("click",".imgBox",function(){			
				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
			});

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});
			clipboard.on('success', function (e) {
				console.log(e);
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			$("body").on("click",".button a.playgame",function(e) {
				being.wrapShow();
				being.scaleShow('.showInfo');
			});

		})
		
	</script>
	
</body>

</html>