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

section {
	background-color: #f6f6f6;
	padding: 20px;
}	
	
.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
	
	.header .top li a, .header .top li a:hover, .header .top li a:focus {
			text-decoration: none;
		}
		
	.infinite-scroll {

		position:relative !important;	
	    background: white;
	    color: black;
	    /*text-align: center;*/
	    /*margin: 20px;*/
	    border-top-left-radius: 6px;
	    border-top-right-radius: 6px;
	    border-bottom-left-radius: 6px;
	    border-bottom-right-radius: 6px;
	    padding: 15px;
	    padding-bottom: 30px;
	    font-weight: 700;
	    /*height: 7rem !important;*/
      /*box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.1), 0 6px 20px 0 rgba(0, 0, 0, 0.1);*/
      /*line-height: 2px !important;*/

	}

	.infinite-scroll .imgBox {
	  margin: 0 auto;
	  /*border: 0.01rem solid #efefef;*/
	  /*padding: 0.15rem;*/
	  /*padding-right: 0.3rem;*/
	  font-size: 0;
	  display: inline-block;
	  margin-bottom: 0.2rem;
	}

	.infinite-scroll .imgBox img {
		width: 100%; 
	    height: 100%; 
	    object-fit: contain;
	    /*max-width: 6rem;*/
	}

	.infinite-scroll h2 {
		font-size: 26px;
		font-size: 4vw;

	  font-weight: 510;
	  color: #666666;
	  margin-bottom: 0.4rem;
	}

	.lbl{
		width: 20%;
	  text-align: center;
	  border-radius: 0.1rem;
	  display: inline-block;
	  line-height: 0.48rem;	  
	  -webkit-border-radius: 0.1rem;
	  -moz-border-radius: 0.1rem;
	  -ms-border-radius: 0.1rem;
	  -o-border-radius: 0.1rem;
	  background-color: #f75656;
	  font-size: 100%;
	  font-size: 0.3rem;
	  color: #fff;
	  font-weight: 0 !important;
	}

	.infinite-scroll .price1 .price2{
		width: 50%;
	  
		/*font-size: 0.4rem;*/
		/*font-size: 100%;*/
		font-size: 0.6rem;
	  	font-weight: 700;
	  	color: #f75656;
	  	padding-left: 0.2rem;
	  	padding-right: 0.2rem;

	}

	.infinite-scroll .price1 .price3{

		width: 30%;
	  
		font-size: 24px;
		font-size: 0.3rem;
		color: #bbbbbb;
		text-decoration: line-through;

	}

	.infinite-scroll .button {
		padding: 0.3rem;
		padding-top: 0.5rem;
	}

	.infinite-scroll .button a {
	  width: 5.5rem;
	  padding: 0.25rem;
	  /*margin-left: 0.18rem;*/
	  /*margin-right: 0.18rem;*/
	  text-align: center;
	  border-radius: 0.1rem;
	  display: inline-block;
	  /*font-size: 0.4rem;	  */
	  line-height: 0.48rem;	  
	  -webkit-border-radius: 0.1rem;
	  -moz-border-radius: 0.1rem;
	  -ms-border-radius: 0.1rem;
	  -o-border-radius: 0.1rem;
	}

	.getvoucher {
		/*margin-top: 0.3rem;*/
		font-weight: 500;
		color: #f75656;
		border: 0.02rem solid #ff5949;
		font-size: 100%;
		/*font-size: 5.8vw;*/
		font-size: 0.4rem;

	}

	.playgame {

		margin-top: 0.3rem;
		font-weight: 600;
		color: #fff;
		background-color: #f75656;
		font-size: 100%;
		/*font-size: 6.2vw;*/
		font-size: 0.45rem;
	  	
	}

	.getvoucher:hover { color:#f75656 ; text-decoration: none; }
	.playgame:hover { color:#fff ; text-decoration: none; }

.showTips .inBox {
	position: relative; 
	z-index: 1; 
	text-align: center; 
	margin-top:10.9rem;
}

.showTips img {
	margin: 0 auto;
	  font-size: 0;
	  display: inline-block;
	  margin-bottom: 0.2rem;
	width: 6.5rem !important; 
    object-fit: contain;

}

.showTips .ply {
	padding-left:0.04rem;
}


#speech-packet-modal {
  color: white;
  text-align: center;
  /*position: relative; //changed to relative from fixed also works if position is not there*/

  position: absolute; top: 0rem; z-index: 3;

}

#speech-packet-modal h4{	
	color: white;
	font-size: 5.5vw;
	padding: 0.1rem;
	text-align: center; padding-top:0.4rem; padding-left:0.75rem;
 }

#speech-packet-modal h5{
	color: white;
	font-size: 3.5vw;
	text-align: center; padding-left:0.75rem;
}

.wrapBox {
	height: 13.9rem;

}

	</style>
<body>

	<section>
		<div class="infinite-scroll">
			<ul class="list-2">
				<li class="dbox">
					<a class="dbox0 imgBox" href="#">
						<img src="<?=str_replace('_160x160.jpg', '', empty($item->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item->product_picurl)?>">
					</a>
				</li>
				<li class="dbox">
					<div class="dbox1">
						<span>
							<h2>{{empty($item->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item->product_name}}</h2>
							<div class="price1">
								<h3>
								<span class="lbl">券后价</span>
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
				<a class="getvoucher" href="#"><?=str_replace('60', number_format(empty($item->voucher_price) ? 10 : $item->voucher_price,0), env('shareproduct_captionbtnforgetvoucher', '领60元优惠券购买'))?></a>
				<a class="playgame" href="#">{{ env('shareproduct_captionbtnforplaygame', '玩赚免单') }}</a>
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
					<img src="{{ asset('/client/images/share_product_speech.png') }}">
					<div id="speech-packet-modal">
						<a href="/member/login/register">
							<h4>点击这里，免单红包任你拿</h4>
							<h5>新人送3次机会 可赚45元 （ 可提现 ）</h5>
						</a>
					</div>
					
				</div>
				<div class="ply">
					<a href="/member/login/register">
						<div id="footer-life">
							<i class="nTxt">0</i>
							<!-- <p>玩赚免单</p> -->
						</div>
					</a>
				</div>
			</div>
		</div>


	</section>

@include('layouts/footer')

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