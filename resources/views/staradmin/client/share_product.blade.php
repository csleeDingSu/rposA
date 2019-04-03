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
		border: 0.03rem solid #ff5949;

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

	.showTips .inBox {
	  /*background: #fff;*/
	  /*width: 5.9rem;
	  border-radius: 0.1rem;
	  -webkit-border-radius: 0.1rem;
	  -moz-border-radius: 0.1rem;
	  -ms-border-radius: 0.1rem;
	  -o-border-radius: 0.1rem;
	  text-align: center;
	  box-sizing: border-box;
	  position: relative;
	  padding-bottom: 0.85rem;*/
	}

	/* Red Packet Modal */
#red-packet-modal .packet-title {
	padding-top: 20px;
	color: #ffffff;
	font-size: 16px;
	font-weight: 500;
}

#red-packet-modal .modal-card {
    width: 260px;
    margin: 0 auto;
    font-size: 16px;
}

#red-packet-modal .packet-value {
	font-size: 90px;
	color: #ff3e3e;
	font-weight: 500;
	margin-left: -20px;
	height: 100px;
}

#red-packet-modal .packet-info {
	font-size: 14px;
	font-weight: 500;
	color: #ff3e3e;
}

#red-packet-modal .packet-sign {
	font-size: 33px;
}

#red-packet-modal .modal-content {
  background: url('/client/images/packet-background.png') no-repeat;
  background-size: contain;
  color: white;
  text-align: center;
  border-top-left-radius: 6px;
  border-top-right-radius: 6px;
  padding: 10px;
  font-weight: 700;
  width: 301px !important;
  height: 382px;
  padding: 0;
  position:relative;
  -webkit-box-shadow: none;
  -moz-box-shadow: none;
  box-shadow: none;
  border: none;
}

#red-packet-modal .modal-content {
  margin-top: -12px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  width: 296px;
  z-index: 9999;
  position:relative;
}

#red-packet-modal .instructions {
  font-size: 12px;
  font-weight: 500;
  color: #ffffff;
  text-align: center;
  line-height: 28px;
  padding: 25px 0px 5px 0px;
}

#red-packet-modal .instructions img{
  margin-top: -2px;
}

#red-packet-modal .highlight {
  color: #ffe613;
  font-weight: 700;
}

#red-packet-modal .instructions h2{
  color: #ffffff;
  font-size: 16px;
  text-align: center;
  padding-bottom: 10px;
  font-weight: 700;
}

#red-packet-modal .btn-red-packet {
  background: url('/client/images/btn-red-packet.png') no-repeat top center;
  font-size: 18px;
  color: #ff3e3e;
  background-size: contain;
  width: 250px;
  height: 40px;
  padding-top: 6px;
  margin-top: 10px;
  cursor: pointer;
  text-align: center;
  font-weight: 500;
}

#red-packet-modal .divider{
    color:#ffffff;
    width:90%;
    margin:10px auto;
    overflow:hidden;
    text-align:center;   
    line-height:1.2em;
    font-size: 16px;
}

#red-packet-modal .divider:before, #red-packet-modal .divider:after{
    content:"";
    vertical-align:middle;
    display:inline-block;
    width:50%;
    border-bottom:1px dashed #ffffff;
    margin:0 2% 0 -55%;
}

#red-packet-modal .divider:after{
    margin:0 -55% 0 2%;
}

#red-packet-modal h1:nth-child(2){
    font-size:3em;
}
/* Red Packet Modal */

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
							<img src="{{empty($item->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item->product_picurl }}">
						</a>
						<div class="dbox1">
							<span>
								<h2>{{empty($item->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item->product_name}}</h2>
								<div class="price1">
									<h3>券后
									<span class="price2">￥{{number_format(empty($item->discount_price) ? env('shareproduct_pricebefore',20) : $item->discount_price,2)}} </span>
									<span class="price3">
									淘宝价￥{{number_format( empty($item->product_price) ? env('shareproduct_priceafter', 55) : $item->product_price,2)}}
									</span>
									</h3>
									
								</div>
							</span>							
						</div>
					</li>
				</ul>

				<div class="button">
					<a class="getvoucher" href="#">{{ env('shareproduct_captionbtnforgetvoucher', '领60元优惠券购买') }}</a>
					<a class="playgame" href="#">{{ env('shareproduct_captionbtnforplaygame', '玩赚免单') }}</a>
				</div>
			</div>
		</div>

		<!-- 领取优惠券  -->
		<div class="showQuan dflex scaleHide">
			<div class="inBox">
				<img src="{{ asset('/test/main/images/showIcon.png') }}" class="icon">
				<h2>复制成功后, 打开淘宝APP即可领优惠卷</h2>

				
					<h3 id="cut" class="copyvoucher"> {{empty($item->voucher_pass) ? "￥K8454DFGH45H" : $item->voucher_pass}}</h3>
					<a class="cutBtn"><img src="{{ asset('/test/main/images/btn-1.png') }}"></a>
					<h4>如复制不成功，请手指按住优惠卷代码复制。</h4>
				
				
			</div>
		</div>

		<!-- 玩赚免单 -->
		<div class="showTips dflex scaleHide">
			<div class="inBox">
				<div id="red-packet-modal">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="packet-title">恭喜你获得免单红包</div>
							<div class="modal-body" style="padding:10px !important;">
								<div class="modal-row">
									<div class="wrapper modal-full-height">							
										<div class="modal-card">
											<div class="packet-value"><span class="packet-sign">￥</span>45</div>
											<div class="packet-info">可提现支付宝</div>
											<div class="instructions">
												<h1 class="divider">领取方式</h1>
												注册后，进入 <img src="{{ asset('/client/images/small-life.png') }}" width="20" height="20" /> <span class="highlight">玩赚免单</span> 赚金币换领取<br />
												新人免费玩3次 可赚45元
											</div>
											<a href="/login">
												<div class="btn-red-packet">注册</div>
											</a>
										</div>
									</div>
								</div>							
							</div>
						</div>
					</div>
				</div>
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

		})
		
	</script>
	
</body>

</html>