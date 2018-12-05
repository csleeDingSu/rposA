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
	<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
	<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
</head>
<style>
	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
	
	</style>
<body style="background:#efefef">
<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="{{$vouchers->lastPage()}}" />

	<section class="cardFull card-flex">
		<div class="cardHeader">
			<div class="header">
				<ul class="dbox top">
					
						@if (isset(Auth::Guard('member')->user()->username))
							<a class="title" href="/member" style="color: white; font-size: 0.3rem;">{{ Auth::Guard('member')->user()->username }}</a>
						@else
						<li class="dbox0">
					  		<a href="/nlogin" style="color: white; font-size: 0.3rem;">@lang('dingsu.login') / @lang('dingsu.register')</a>
					  	</li>
					  	@endif
					  	<!-- <a href="/register"><img src="{{ asset('/test/main/images/register.png') }}"></a> -->
				  						
					<li class="dbox1 logo"><img src="{{ asset('/test/main/images/logo.png') }}"></li>

					@if (isset(Auth::Guard('member')->user()->wechat_verification_status) && (Auth::Guard('member')->user()->wechat_verification_status > 0)) 
							<a class="title" href="/logout" style="color: white; font-size: 0.3rem;">退出登陆</a>
				
					@else
					<li class="dbox0"><a href="/share" style="color: white; font-size: 0.3rem;"><img src="{{ asset('/client/images/share_btn.png') }}" style="height: 0.3rem;"> @lang('dingsu.share')</a></li>
				  	@endif
					
				</ul>
				<div class="main rel">
					<div class="dbox">
						<div class="dbox1 txt">
							@if(isset($category))
								@foreach($category as $cat)

									@if ($cat->id == $cid)
										{{$current_cat_name = $cat->display_name}}
										<a class="on" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
										<!-- <a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a> -->
									@else
										<a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
									@endif

								    @break($cat->number == 6)
								@endforeach
							@else
								<a class="on">精选</a>
								<a>女装</a>
								<a>男装</a>
								<a>鞋帽</a>
								<a>食饮</a>
								<a>没装</a>
							@endif							
						</div>
						<a class="downIcon dbox0"><img src="{{ asset('/test/main/images/downIcon.png') }}"></a>
					</div>
					<div class="slideMore dn">
						<h2>全部分类<a class="close"><img src="{{ asset('/test/main/images/closeIcon.png') }}"></a></h2>
						<p>
							@foreach($category as $cat)
								@if ($cat->id == $cid)
									<a class="on" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
								@else
									<a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a>
								@endif
							@endforeach							
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="cardBody">
			<div class="box">

				@if($cid == 1)
					
					<div class="banner">

						<img src="https://wabao666.com/ad/banner/1543910501.png">
						
<!--
						{{-- @if(isset($banner)) --}}					
						{{-- @foreach($banner as $bner) --}}	
							<img data-lazy="{{url('/')}}/ad/banner/{{-- $bner->banner_image --}}"  >					
						{{-- @endforeach --}}					
						{{-- @endif --}}
-->						
					</div>

				@endif

				<!--
				<div class="banners">
					<img src="{{ asset('/test/main/images/demo/banner.png') }}">
				</div>

				<div class="product">
					<div class="title">
						<span>今日用户已领走<font color="#f63556">  </font>元产品</span>
						<h2>免费挖宝 免费领取</h2>
					</div>
					<ul class="list-1 fix">
						<li>
							<a href="#">
								<span>¥178.00</span>
								<img src="{{ asset('/test/main/images/demo/d-img.png') }}">
							</a>
							<h2>
								<font>李明东</font>挖到了
							</h2>
							<h3>刚刚</h3>
						</li>
						<li>
							<a href="#">
								<span>¥178.00</span>
								<img src="{{ asset('/test/main/images/demo/d-img.png') }}">
							</a>
							<h2>
								<font>李明东</font>挖到了
							</h2>
							<h3>1分钟之前</h3>
						</li>
						<li>
							<a href="#">
								<span>¥178.00</span>
								<img src="{{ asset('/test/main/images/demo/d-img.png') }}">

							</a>
							<h2>
								<font>李明东</font>挖到了
							</h2>
							<h3>30分钟之前</h3>
						</li>
						<li>
							<a href="#">
								<span>¥178.00</span>
								<img src="{{ asset('/test/main/images/demo/d-img.png') }}">
							</a>
							<h2>
								<font>李明东</font>挖到了
							</h2>
							<h3>30分钟之前</h3>
						</li>
						<li>
							<a href="#">
								<span>¥178.00</span>
								<img src="{{ asset('/test/main/images/demo/d-img.png') }}">
							</a>
							<h2>
								<font>李明东</font>挖到了
							</h2>
							<h3>刚刚</h3>
						</li>
					</ul>
				</div>
				 -->

				<div class="product">
					<div class="title">
						<span>共有<font color="#f63556">{{ $vouchers->total() }}</font>款产品</span>
						<h2>{{ is_null($current_cat_name) ? 精选 : $current_cat_name }}大额优惠券</h2>
					</div>
					
					<div class="infinite-scroll">
						<ul class="list-2">								
								@include('client.ajaxhome')
						</ul>
						{{ $vouchers->links() }}
						
						<p class="isnext">下拉显示更多...</p>
					</div>
					
				</div>
			</div>
		</div>
		
		@include('layouts/footer')

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox">
				<img src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<h2>复制成功后, 打开淘宝APP即可领优惠卷</h2>

				@if (isset(Auth::Guard('member')->user()->username))
					<h3 id="cut" class="copyvoucher">￥K8454DFGH45H</h3>
					<a class="cutBtn"><img src="{{ asset('/test/main/images/btn-1.png') }}"></a>
					<h4>如复制不成功，请手指按住优惠卷代码复制。</h4>
				@else
					<h3 id="cut">请先注册，才能领取优惠券</h3>
				@endif
				
				
			</div>
		</div>

		<div class="showBao dflex scaleHide">
			<div class="inBox">
				<div class="imgBox">
					<img id="product_img" src="{{ asset('/test/main/images/demo/d-img3.png') }}">
				</div>
				<h2 style="white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis ;" id = 'product_name'>INS网红手表时尚潮流手表女士韩版 抖音时来运转石英表休闲</h2>
				<h3 style="display: none">
					<font id="product_discount_price">优惠价：39元</font><em id = "product_price">淘宝原价：￥360</em>
				</h3>

				<div class="group">
				 	<img src="{{ asset('/test/main/images/icon-2.png') }}" />
					<span><em id = 'voucher_price'>390挖宝币 免费兑换</em></span>
				</div>

				<div class="group" style="text-align: center;">
					<div class="balance">你当前拥有 <em id='current_point'> {{ isset($member_mainledger->current_point) ? number_format($member_mainledger->current_point, 0, ".", "") : 0 }}</em> 挖宝币</div>
				</div>

				<a class="btn" href="/arcade"><img src="{{ asset('/test/main/images/wabao.png') }}"></a>

			</div>
		</div> 
		
	</section>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).on('ready', function() {
      
		  $(".banner").slick({
			  autoplay:true,
			  autoplaySpeed:1000,
			  arrows:false,
			  lazyLoad: 'ondemand', // ondemand progressive anticipated
			  infinite: true,
			  adaptiveHeight: false
		  });
		});
		
		
		
		$(document).ready(function(){
		//$(function () {
			
			$('.downIcon').click(function () {
				$('.cardHeader').css({ 'z-index': '11' });
				being.wrapShow('.cardBody');
				$('.slideMore').fadeIn(150);
			});

			$('.slideMore .close').click(function () {
			
				$('.slideMore').fadeOut(150);
				being.wrapHide('.cardBody', () => {
					$('.cardHeader').removeAttr('style');
				});
			});
			
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


			// $('.product .list-2 .dbox a.dbox0').click((e) => {

			// 	alert($(e.target).data('t_id'));

			// 	item_id = $(e.target).data('t_id');
			// 	product_name = $(e.target).data('t_product_name');
			// 	product_price = $(e.target).data('t_product_price');
			// 	product_img = $(e.target).data('t_product_img');

			// 	 // alert(product_name);
			
			// 	being.wrapShow();

			// 	document.getElementById("product_name").textContent = product_name;
			// 	// $(this).find("#product_name").innerHTML = product_name;
			// 	document.getElementById("product_price").textContent = '淘宝原价：￥' + product_price;
			// 	document.getElementById("product_discount_price").textContent = '优惠价：' + product_price + '元';
			// 	document.getElementById("product_img").src = product_img;

			// 	being.scaleShow('.showBao');
			
		
			// });
/*
			$('.product .list-2 .mset a.type').click((e) => {

				item_id = $(e.target).data('tt_id');
				product_name = $(e.target).data('tt_product_name');
				product_price = $(e.target).data('tt_product_price');
				product_img = $(e.target).data('tt_product_img');

				// alert(product_img);
			
				being.wrapShow();

				document.getElementById("product_name").textContent = product_name;
				// $(this).find("#product_name").innerHTML = product_name;
				document.getElementById("product_price").textContent = '淘宝原价：￥' + product_price;
				document.getElementById("product_discount_price").textContent = '优惠价：' + product_price + '元';
				document.getElementById("product_img").src = product_img;


				being.scaleShow('.showBao');
				
				
		
			});
			
			*/
			$("body").on("click",".mset a.showvoucher",function(e) {
			//$("body").on("click",".showvoucher",function(){
				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
			});
			
			$("body").on("click",".imgBox",function(){
				item_id       = $(this).data('tt_id');
				product_name  = $(this).data('tt_product_name');
				product_price = $(this).data('tt_product_price');
				product_img   = $(this).data('tt_product_img');
				product_discount_price   = $(this).data('tt_product_discount_price');
				voucher_price = $(this).data('tt_voucher_price');

				showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price);
			});
			
			
			$("body").on("click",".mset a.type",function(e) {				
				item_id       = $(e.target).data('tt_id');
				product_name  = $(e.target).data('tt_product_name');
				product_price = $(e.target).data('tt_product_price');
				product_img   = $(e.target).data('tt_product_img');
				product_discount_price = $(e.target).data('tt_product_discount_price');
				voucher_price = $(e.target).data('tt_voucher_price');
				
				showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price);
			});
			
			
			function showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price)
			{
				being.wrapShow();

				document.getElementById("product_name").textContent = product_name;
				// $(this).find("#product_name").innerHTML = product_name;
				document.getElementById("product_price").textContent = '淘宝原价：￥' + product_price;
				document.getElementById("product_discount_price").textContent = '优惠价：' + product_discount_price + '元';
				document.getElementById("product_img").src = product_img;
				document.getElementById("voucher_price").textContent = Math.round((product_price - voucher_price) * 10);

				being.scaleShow('.showBao');
			}
			

			$('.showBao').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showBao ');
					being.wrapHide();
				}
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

			being.scrollBottom('.cardBody', '.box', () => {			
				page++;
				var max_page = parseInt($('#max_page').val());
				if(page > max_page) {
					$('#page').val(page);
					$(".isnext").html("@lang('dingsu.end_of_result')");
					$('.isnext').css('padding-bottom', '50px');

				}else{
					getPosts(page);
				}	
			});
		})

		$('ul.pagination').hide();
		
		var page=1;
		
		/*$('.cardBody').on('scroll', function() {
        	if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {            
				//scroll
			}
		})*/
				
		function getPosts(page){
			$.ajax({
				type: "GET",
				url: window.location+"/?page"+page, 
				data: { page: page },
				beforeSend: function(){ 
				},
				complete: function(){ 
				  $('#loading').remove
				},
				success: function(responce) { 
					$('.list-2').append(responce.html);
				}
			 });
		}
		
	</script>

</body>

</html>