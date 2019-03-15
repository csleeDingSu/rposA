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
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/module.css') }}"/>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha256-UK1EiopXIL+KVhfbFa8xrmAWPeBjMVdvYMYkTAEv/HI=" crossorigin="anonymous" />
	<link rel="stylesheet" href="{{ asset('/client/css/slick-theme.css') }}" />

	<script type="text/javascript" src="{{ asset('/test/main/js/jquery-1.9.1.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
</head>
<style>
	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }

		.header {
		    height: 1.2rem;
		}

		.header .top li {
			line-height: 0.7rem;
		}

		.header .top li a, .header .top li a:hover {
			margin-left: 0;
			text-decoration: none;
		}

        .inBox {
		  padding-top: 0.2rem;
		  padding-left: 0.2rem;
		  float: left;
		}

		.flexSp {
		  background: #ffffff;
		  border-radius: 0.42rem;
		  -webkit-border-radius: 0.42rem;
		  -moz-border-radius: 0.42rem;
		  -ms-border-radius: 0.42rem;
		  -o-border-radius: 0.42rem;
		  height: 0.74rem;
		  width: 6.2rem;
		  align-items: center;
		  padding: 0 0.2rem;
		}

        .flexSp input {
		  display: flex;
		  width: 100%;
		  box-sizing: border-box;
		  padding-left: 0.25rem;
		  font-size: 0.32rem;
		  line-height: 2em;
		  background: none;
		  border: none;
		}

		.flexSp input::placeholder {
		  color: #bdbdbd;
		}
		.flexSp input::-webkit-placeholder {
		  color: #bdbdbd;
		}

	</style>
<body style="background:#ffffff">
<input type="hidden" id="page" value="1" />
@if(count($vouchers))
<input type="hidden" id="max_page" value="{{ $vouchers->lastPage() }}" />
@else
<input type="hidden" id="max_page" value="0" />
@endif

	<section class="cardFull card-flex">
		<div class="cardHeader">
			<div class="header">
				<ul class="dbox top">			
					<li class="dbox0">
		                <div class="inBox">
                            <div class="flexSp">
                                <input type="text" id="strSearch" name="strSearch" placeholder="搜索商品名称：如剃须刀、T恤" required maxlength="30" value="{{ $strSearch }}">
                            </div>
		                </div>
						<div class="inBox"><a id="btn_search" href="#" style="color: white; font-size: 0.3rem;">搜索</a></div>
					</li>					
				</ul>
			</div>
		</div>
		

		<div class="cardBody">
			<div class="box">
				<div class="product">					
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
				<a class="btn" href="/redeem"><div class="btn-redeem">兑换商品</div></a>

			</div>
		</div>

		<div class="showTips dflex scaleHide" id="game-rules">
			<div class="inBox">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-title">
					<h1>挖宝赚钱攻略</h1>
				</div>
				<div class="modal-content">
					<div class="modal-body">				
						<div class="modal-row">
							<div class="wrapper modal-full-height">
								<div class="modal-card">
									<div class="instructions">
										挖宝是为了鼓励用户分享，而设立的免费竞猜游戏 「猜单双，6次内猜中就有奖」<br />
										<ul class="tips-list">
											<li class="tips-title">如何赚钱？</li>
											每次机会有99%概率获得15元，新注册用户有1次机会，能获得15元。<br />
											<div class="div-tips">小编偷偷讲：以后会调低奖励，现在已经注册的，赶紧抓住机会赚一波。</div>
											<li class="tips-title">如何赚更多钱？</li>
											每邀请1个新用户能获得3次机会，邀请10个赚450元「被邀请的能获得1次机会」 <br />
											非常容易邀请到很多人注册，大力分享！
										</ul>
									</div>
									<a href="/arcade">
										<div class="btn-game-rules">进入赚钱</div>
									</a>
								</div>
							</div>
						</div>							
					</div>
				</div>
			</div>
			</div>
		</div>
	</section>
	
	

	<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" integrity="sha256-NXRS8qVcmZ3dOv3LziwznUHPegFhPZ1F/4inU7uC8h0=" crossorigin="anonymous"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>

		$(document).ready(function(){
		//$(function () {
			$("#btn_search").on("click", function() {
				var strSearch = $('#strSearch').val();
				window.location.href = "/search/" + strSearch;
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

			$("body").on("click",".mset a.showvoucher",function(e) {
			//$("body").on("click",".showvoucher",function(){
				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
			});
			
			$("body").on("click",".mset a.type",function(e) {
				being.wrapShow();
				being.scaleShow('.showTips');
			});
			
			$('.showTips').click((e) => {
				var target = $(e.target).closest('.inBox').length;
				console.log(target);
				if (target > 0) {
					return;
				} else {
					being.scaleHide('.showTips');
					being.wrapHide();
				}
			});

			$("body").on("click",".imgBox",function(){
				// item_id       = $(this).data('tt_id');
				// product_name  = $(this).data('tt_product_name');
				// product_price = $(this).data('tt_product_price');
				// product_img   = $(this).data('tt_product_img');
				// product_discount_price   = $(this).data('tt_product_discount_price');
				// voucher_price = $(this).data('tt_voucher_price');
				// showBao(item_id,product_name,product_price,product_img,product_discount_price,voucher_price);

				// being.wrapShow();
				// being.scaleShow('.showTips');

				$( ".copyvoucher" ).html($(this).data('voucher'));
				being.wrapShow();
				being.scaleShow('.showQuan');
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
					being.scaleHide('.showBao');
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
				console.log(page);
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
		var max_page = parseInt($('#max_page').val());

		if(max_page == 0){
			$(".isnext").html("@lang('dingsu.end_of_result')");
		}
				
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