@extends('layouts.default_allowopeninwechat')

@section('title', '分享产品')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/share_product.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

	<div class="infinite-scroll" id="product">
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
							<span class="lbl_cur">￥</span>
							<span class="price2">{{number_format(empty($item->discount_price) ? env('shareproduct_pricebefore',20) : $item->discount_price,2)}} </span>
							<span class="price3">
							淘宝价￥{{number_format( empty($item->product_price) ? env('shareproduct_priceafter', 55) : $item->product_price,2)}}
							</span>
							</h3>
							
						</div>
					</span>							
				</div>
			</li>
			<li class="dbox">
				<div class="dbox2">
					<img class="imgShareBtn" src="{{ asset('/client/images/share_product_btn_bg.png') }}">
					<div class="sharebtn_text">
					<h3>	
						<span class="cur">￥</span>
						<span class="vprice"> {{
							number_format(empty($item->voucher_price) ? 10 : $item->voucher_price,2)
						}}
						</span>
						<span class="vpass">
							优惠卷代码 <br>
							<span id="cut">{{empty($item->voucher_pass) ? "￥K8454DFGH45H￥" : $item->voucher_pass}}
							</span>
						</span>
						<a class="cutBtn">
							<span class="vlink">
								立刻领卷
							</span>
						</a>
					</h3>
					</div>

				</div>
			</li>
		</ul>

		<!-- 领取优惠券  -->
		<div class="cvoucher" id="cvoucher">
			领取成功, 打开淘宝APP领优惠卷
		</div>


	</div>
	
	<img class="titleimg" src="{{ asset('/client/images/share_product_title.png') }}">

	<a href="/">

		<div class="rowval">
		  <div class="columnval featuredbg marginleft">
		  	<div class="free"></div>
		    <img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[0]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[0]->product_picurl)?>" style="width:100%">
			    <div class="dbox1">
						<span class="featureddetail">
							<h2>{{empty($item_featured[0]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[0]->product_name}}</h2>
							<div class="price1">
								<h3>
								<span class="lbl">券后</span>
								<span class="lbl_cur">￥</span>
								<span class="price2">{{number_format(empty($item_featured[0]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[0]->discount_price,2)}} </span>
								<span class="price3">
								￥{{number_format( empty($item_featured[0]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[0]->product_price,2)}}
								</span>
								</h3>
								
							</div>
						</span>							
					</div>
			</div>
		  <div class="columnval featuredbg marginright">
		  	<div class="free"></div>
		    <img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[1]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[1]->product_picurl)?>" style="width:100%">
		    <div class="dbox1">
					<span class="featureddetail">
						<h2>{{empty($item_featured[1]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[1]->product_name}}</h2>
						<div class="price1">
							<h3>
							<span class="lbl">券后</span>
							<span class="lbl_cur">￥</span>
							<span class="price2">{{number_format(empty($item_featured[1]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[1]->discount_price,2)}} </span>
							<span class="price3">
							￥{{number_format( empty($item_featured[1]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[1]->product_price,2)}}
							</span>
							</h3>
							
						</div>
					</span>							
			</div>
		  </div>
		  </div>

		  <div class="rowval">
		  <div class="columnval featuredbg marginleft marginbottom">
		  	<div class="free"></div>
		    <img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[2]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[2]->product_picurl)?>" style="width:100%">
			    <div class="dbox1">
						<span class="featureddetail">
							<h2>{{empty($item_featured[2]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[2]->product_name}}</h2>
							<div class="price1">
								<h3>
								<span class="lbl">券后</span>
								<span class="lbl_cur">￥</span>
								<span class="price2">{{number_format(empty($item_featured[2]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[2]->discount_price,2)}} </span>
								<span class="price3">
								￥{{number_format( empty($item_featured[2]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[2]->product_price,2)}}
								</span>
								</h3>
								
							</div>
						</span>							
					</div>
			</div>
		  <div class="columnval featuredbg marginright marginbottom">
		  	<div class="free"></div>
		    <img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[3]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[3]->product_picurl)?>" style="width:100%">
		    <div class="dbox1">
					<span class="featureddetail">
						<h2>{{empty($item_featured[3]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[3]->product_name}}</h2>
						<div class="price1">
							<h3>
							<span class="lbl">券后</span>
							<span class="lbl_cur">￥</span>
							<span class="price2">{{number_format(empty($item_featured[3]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[3]->discount_price,2)}} </span>
							<span class="price3">
							￥{{number_format( empty($item_featured[3]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[3]->product_price,2)}}
							</span>
							</h3>
							
						</div>
					</span>							
			</div>
		  </div>
		  </div>

		 </a>

@endsection

@section('footer-javascript')

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script>
		
		$(document).ready(function(){
			
			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					$(cvoucher).fadeIn();
					
					setTimeout(function() {
					 $(cvoucher).fadeOut('slow');
					}, 1500);

					return document.querySelector('#cut');
				}
		        
			});

			clipboard.on('success', function (e) {
				console.log(e);
				// $('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				// $('.cutBtn img').attr('src', " {{ asset('/test/main/images/btn-2.png') }} ");
			});

			
		})
		
	</script>
@endsection
