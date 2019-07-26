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
	<div class="infinite-scroll" id="product">
		<div class="header_pr header_goods ">
    		<header class="icon_header">
    			<a href="javascript:history.back()" class="iconfont fa fa-angle-left fa-2x" aria-hidden="true"></a>
        	</header>	
        </div>

		<ul class="list-2">
			<li class="dbox">
				<a class="dbox0 imgBox" href="#">
					@php ($photourl = empty($item->product_picurl) ? null : $item->product_picurl)

					@php ($photourl = str_replace('_310x310.jpg', '', $photourl))

					@php ($photourl = str_replace('_160x160.jpg', '', $photourl))

					<img src="{{$photourl}}">
				</a>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<span>
						<h2>{{empty($item->product_name) ? '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋' : $item->product_name}}</h2>
						<h3>热销2562件</h3>
					</span>							
				</div>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<div class="caption_redeem_angpao">
						<span>如何补贴</span>
						<img src="{{ asset('/client/images/productv2_detail_caption.png') }}" />
					</div>
					<div class="normal-price">
						<span class="cur">￥<span class="price">{{empty($item->product_price) ? 99 : $item->product_price}}</span></span>
						<div class="txt">原价</div>
					</div>
					<img class="normal-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="voucher-price">
                		<span class="cur">￥<span class="price">{{empty($item->voucher_price) ? 99 : number_format($item->voucher_price,2)}}</span></span>
                		<div class="txt">优惠券</div>
                	</div>
                	<img class="voucher-price-icon-minus" src="{{ asset('/client/images/icon-minus.png') }}" />
                	<div class="draw-price">
                		<span class="cur">￥<span class="price">	{{trim(empty($item->voucher_price) ? 15 : 15)}}</span></span>
                		<div class="txt">抽奖补贴</div>
                	</div>					
                	<img class="new-price-icon-equal" src="{{ asset('/client/images/icon-equal.png') }}" />
                	<div class="new-price">
                		<span class="new-cur">￥<span class="price">{{empty($item->discount_price) ? 0 : number_format($item->discount_price,2)}}</span></span>
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
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">{{empty($item->voucher_pass) ? "￥K8454DFGH45H￥" : $item->voucher_pass}}</span></h4>

				<img class="product-detail-btn-bg" src="{{ asset('/client/images/product-detail-btn-bg.jpg') }}" />
			</li>
			
		</ul>
	</div>

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
									平台所有产品均可通过抽奖可获得15元的奖补贴，在领券后可再减去15元0元。
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


@endsection

@section('footer-javascript')

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).ready(function(){
			
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
		
	</script>
@endsection
