@extends('layouts.default')

@section('title', '挖宝优惠购')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/productv2_detail.css') }}" />
		
@endsection

@section('top-navbar')
@endsection

@section('content')
@php ($item = $voucher)
@php ($_id = !empty($item->id) ? $item->id : 0)
@php ($product_picurl = !empty($item->product_picurl) ? $item->product_picurl : (empty($item->mainPic) ? '' : $item->mainPic))
@php ($product_name = !empty($item->product_name) ? $item->product_name : (empty($item->title) ? '' : $item->title))

@php ($oldPrice = empty($item->originalPrice) ? 0 : $item->originalPrice)
@php ($product_price = !empty($item->product_price) ? $item->product_price : $oldPrice)        

@php ($couponPrice = empty($item->couponPrice) ? 0 : $item->couponPrice)
@php ($promoPrice = $oldPrice - $couponPrice)
@php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)
@php ($voucher_price = !empty($item->voucher_price) ? $item->voucher_price : $promoPrice)

@php ($newPrice = $oldPrice - $couponPrice - 12)
@php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
@php ($discount_price = !empty($item->discount_price) ? $item->discount_price : $newPrice)

@php ($sales_show = !empty($item->sales_show) ? $item->sales_show : 0)
@php ($sales = ($item->monthSales >= 1000) ? number_format(((float)$item->monthSales / 10000), 2, '.', '') . '万' : $item->monthSales . '件')
@php ($sales_show = ($sales_show > 0) ? $sales_show : (($item->monthSales >= 1000) ? number_format(((float)$item->monthSales / 10000), 2, '.', '') . '万' : $item->monthSales))

@php ($commissionRate = empty($item->commissionRate) ? 0 : $item->commissionRate)
@php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
@php ($reward = (int)($promoPrice * $commissionRate))
@php ($reward = ($reward <= 0) ? '0' : $reward)

@php ($goodsId = empty($item->goodsId) ? 0 : $item->goodsId)
@php ($couponLink = empty($item->couponLink) ? '#' : $item->couponLink)

@php ($_param = "?id=" . $_id . "&goodsId=" . $goodsId . "&mainPic=" . $product_picurl . "&title=" . $product_name . "&monthSales=" . $sales_show . "&originalPrice=" . $product_price . "&couponPrice=" . $couponPrice . "&couponLink=" . urlencode($couponLink) . "&commissionRate=" . $commissionRate . "&voucher_pass=&life=")
	
	<input id="hidgoodsId" type="hidden" value="{{empty($item->goodsId) ? 0 : $item->goodsId}}" />
<input id="hidcouponLink" type="hidden" value="{{empty($item->couponLink) ? '' : $item->couponLink}}" />


	<div class="infinite-scroll" id="product">
		<div class="header_pr header_goods ">
    		<header class="icon_header">
    			<a href="javascript:history.back()" class="iconfont fa fa-angle-left fa-2x" aria-hidden="true"></a>
        	</header>	
        </div>

		<ul class="list-2">
			<li class="dbox">
				<a class="dbox0 imgBox" href="#">
					@php ($photourl = empty($product_picurl) ? null : $product_picurl)

					@php ($photourl = str_replace('_310x310.jpg', '', $photourl))

					@php ($photourl = str_replace('_160x160.jpg', '', $photourl))

					<img src="{{$photourl}}">
				</a>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<span>
						<h2>{{$product_name}}</h2>
						<h3>热销{{$sales_show}}件</h3>
					</span>							
				</div>
			</li>
			<li class="dbox">
				<div class="dbox1 line-price">
					<div class="caption_redeem_angpao">
						<span>如何补贴</span>
						<img src="{{ asset('/client/images/productv2_detail_caption.png') }}" />
					</div>
					<div class="normal-price">
						<span class="cur">￥<span class="price">{{number_format($product_price, 2) + 0}}</span></span>
						<div class="txt">原价</div>
					</div>
					<img class="normal-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="voucher-price">
                		<span class="cur">￥<span class="price">{{number_format($voucher_price,2) + 0}}</span></span>
                		<div class="txt">优惠券</div>
                	</div>
                	<img class="voucher-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="draw-price">
                		<span class="cur">￥<span class="price">12</span>
                		<div class="txt">抽奖补贴</div>
                	</div>					
                	<img class="new-price-icon-equal" src="{{ asset('/client/images/icon-equal.png') }}" />
                	<div class="new-price">
                		<span class="new-cur">￥<span class="price">{{number_format($discount_price,2) + 0}}</span></span>
                		<div class="txt">到手价</div>
                	</div>	
				</div>
			</li>
			<li class="dbox footer">
					<div id="button-wrapper">
						<a class="copyBtn"> 
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						<a href="/arcade">
							<div id="btn-voucher" class="btn-voucher">马上抽奖</div>
						</a>
					</div>
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">{{empty($item->voucher_pass) ? "" : $item->voucher_pass}}</span></h4>

				<img class="product-detail-btn-bg" src="{{ asset('/client/images/product-detail-btn-bg.jpg') }}" />
			</li>
			
		</ul>
	</div>

@endsection

@section('footer-javascript')

	<!-- draw rules starts -->
	<div class="modal fade col-md-12" id="draw-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  抽奖补贴说明
								</div>
								<div class="instructions">
									<p>抽奖补贴由挖宝官方提供，新用户能免费获得2场次免费抽奖，通过抽奖可获得12元红包。</p>
									<p>&nbsp;</p>
									<p>用户可通过邀请好友，获得更多抽奖场次，从而获得更多购物红包。
									</p>
								</div>
								<div class="modal-go-button">
									马上抽奖
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).ready(function(){

			gettpwd();
			
			var clipboard = new ClipboardJS('.copyBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
		        
			});

			clipboard.on('success', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('margin-top', '0.95rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('margin-top', '0.95rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			$('.draw-price').click( function() {
	        	$('#draw-rules').modal();
	    	});

	    	$('.caption_redeem_angpao').click( function() {
	        	$('#draw-rules').modal();
	    	});

	    	$('.modal-go-button').click( function() {
	        	window.location.href = '/arcade';
	    	});
	    	
		})
		
		function gettpwd() {
			var _goodsId = $('#hidgoodsId').val();
			var _hidcouponLink = $('#hidcouponLink').val();

			$.ajax({
		      type: 'GET',
		      url: "/tabao/get-privilege-link?goodsId=" + _goodsId, 
		      contentType: "application/json; charset=utf-8",
		      dataType: "text",
		      error: function (error) {
		          console.log(error);
		          alert(error.responseText);
		      },
		      success: function(data) {
		          console.log(data);
		          if (data.length > 0 && JSON.parse(data).code == 0) {
		          	$('.copyvoucher').html(JSON.parse(data).data.tpwd);
		          }       
		      }
		  });

		}
	</script>
@endsection
