@extends('layouts.default_without_footer')

@section('title', '个人中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/share_product_bk.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

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
				<!-- temporary hide
					<a class="playgame" href="#">{{ env('shareproduct_captionbtnforplaygame', '玩赚免单') }}</a> -->

				<a class="playgame" href="/">{{ env('shareproduct_captionbtnforplaygame', '玩赚免单') }}</a>
			</div>

			
		</div>
	</section>
@endsection



@section('footer-javascript')
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
	</div>
	
	@parent
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

			//temporary hide
			// $("body").on("click",".button a.playgame",function(e) {
			// 	being.wrapShow();
			// 	being.scaleShow('.showTips');
			// });

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
@endsection
