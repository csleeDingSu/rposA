@extends('layouts.default')

@section('title', '挖宝优惠购')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/productv2_detail.css') }}" />
	<style type="text/css">
			
		.footer {
		    position: fixed;
		    bottom: 0;
		    width: 100%;

		    display: flex;
		    justify-content: space-between;
		    text-align: justify;
		}

		.infinite-scroll {
			background: white;
		}

		.infinite-scroll .imgBox {
		  margin: 0 auto;
		  font-size: 0;
		  display: inline-block;
		  margin-bottom: 0.1rem;
		}

		.infinite-scroll .imgBox img {
			width: 100%; 
		    height: 100%; 
		    object-fit: contain;
		}

		.infinite-scroll h2 {
		    margin: 0 0.2rem 0 0.2rem;
			font-size: 4vw;
			font-weight: 500;
			color: #666666;
			line-height: 0.6rem;
		}

		.infinite-scroll h3 {		
		    margin: 0 0.2rem 0 0.2rem;
    		font-size: 3.5vw;
    		color: #bebebe;
    		line-height: 0.6rem;
		}

		.infinite-scroll .normal-price {
			margin: 0 0.2rem 0 0.2rem;
		    color: grey;
		    font-size: 6vw;
		    width: 1.3rem;
		    position: absolute;
		}

		.infinite-scroll .normal-price .cur{
			font-size: 3vw;
		}

		.infinite-scroll .normal-price .txt{
			font-size: 3vw;
		    text-align: right;
		    margin-top: -0.15rem;
		}

		.infinite-scroll .tag1 {
			margin: 0 0.2rem 0 0.2rem;
		    color: grey;
		    font-size: 5vw;
		    width: 0.5rem;
		    position: absolute;
		    margin-right: 1.7rem;
		}

		.infinite-scroll .tag2 {
			margin: 0 0.2rem 0 0.2rem;
		    color: grey;
		    font-size: 5vw;
		    width: 0.5rem;
		    position: absolute;
		    margin-right: 3.5rem;
		}

		.infinite-scroll .tag3 {
			margin: 0 0.2rem 0 0.2rem;
		    color: grey;
		    font-size: 5vw;
		    width: 0.5rem;
		    position: absolute;
		    margin-left: 5.5rem;
		}

		.infinite-scroll .voucher-price {
			margin: 0 0.2rem 0 0.2rem;
		    color: #8c36d9;
		    font-size: 4vw;
		    width: 1.2rem;
		    position: absolute;
		    border: 1px dashed #8c36d9;
		    border-radius: 5px;
		    margin-left: 2rem;
		    text-align: center;
		    padding: 0.05rem;
		}

		.infinite-scroll .voucher-price .cur{
			font-size: 3vw;
		}

		.infinite-scroll .voucher-price .txt{
			font-size: 3vw;
		    text-align: center;
		    margin-top: 0rem;
		}

		.infinite-scroll .draw-price {
			margin: 0 0.2rem 0 0.2rem;
		    color: red;
		    font-size: 4vw;
		    width: 1.2rem;
		    position: absolute;
		    border: 1px dashed red;
		    border-radius: 5px;
		    margin-left: 4rem;
		    text-align: center;
		    padding: 0.05rem;
		}

		.infinite-scroll .draw-price .cur{
			font-size: 3vw;
		}

		.infinite-scroll .draw-price .txt{
			font-size: 3vw;
    		/*padding-left: 8vw;*/
		}

		.infinite-scroll .new-price {
			margin: 0 0.2rem 0 0.2rem;
		    color: red;
		    font-size: 7vw;
		    width: 1.2rem;
		    position: absolute;
		    margin-left: 6rem;
		    text-align: center;
		    /* padding: 0.05rem; */
		}

		.infinite-scroll .new-price .new-cur{
			font-size: 3.5vw;
		}

		.infinite-scroll .new-price .txt{
			font-size: 3vw;
		    /* padding-left: 8vw; */
		    margin-top: -0.1rem;
		    text-align: right;
		}

	.caption_redeem_angpao {
	 /*position: relative !important;*/
	 /*animation: MoveUpDown_angpao_p 1s linear infinite 0s !important;*/
	 /*-webkit-animation: MoveUpDown_angpao_p 1s linear infinite 0s !important;*/
	 padding-left: 3.6rem !important;
	}

	.caption_redeem_angpao img {
		width: 2rem !important;
    	height: 0.55rem !important;
	}

	.caption_redeem_angpao span {
	 padding-top: 0.06rem !important;
	 width: 2rem !important;
	}

	.btn-product-details {
	  width: 100%;  
	}

	#button-wrapper {
		margin-top:-1rem !important;
		width: 100% !important;
	}

	#btn-copy {
	padding-top:0.25rem !important;
	padding-left:0 !important;
	background-color: #c156ff;
	text-align:center;
	}
	#btn-voucher {
		padding-top:0.25rem !important;
	padding-left:0 !important;
	text-align: center;
		background-color: #fc892c;
	}
	.icon-wheel {
		/*display: flex;*/
	}

	</style>
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
						<h3>热销2562件</h3>
					</span>							
				</div>
			</li>
			<li class="dbox">
				<div class="dbox1">
					<div class="caption_redeem_angpao">
						<span>如何补贴</span>
						<img src="{{ asset('/client/images/share_product_caption_redeem_angpao.png') }}" />
					</div>
					<div class="normal-price">
						<span class="cur">￥</span>
						49.9
						<div class="txt">原价</div>
					</div>
					<div class="tag1">></div>
                	<div class="voucher-price">
                		<span class="cur">￥</span>
                		20
                		<div class="txt">优惠券</div>
                	</div>
                	<div class="tag2">></div>
                	<div class="draw-price">
                		<span class="cur">￥</span>
                		15
                		<div class="txt">抽奖补贴</div>
                	</div>					
                	<div class="tag3">=</div>
                	<div class="new-price">
                		<span class="new-cur">￥</span>
                		4.9
                		<div class="txt">到手价</div>
                	</div>	
				</div>
			</li>
			<li class="dbox footer">
					<!-- <img class="icon-wheel" src="{{ asset('/client/images/icon-wheel.png') }}" /> -->
					<div id="button-wrapper">
						<a class="copyBtn"> 
							<div id="btn-copy" class="btn-copy">领取优惠券</div>
						</a>
						<a href="/arcade">
							<div id="btn-voucher" class="freeVoucherBtn"><span>马上抽奖</span></div>
						</a>
					</div>
				
				<h4 style="font-size: 0;">优惠券代码 <span id="cut" class="copyvoucher">{{empty($item->voucher_pass) ? "￥K8454DFGH45H￥" : $item->voucher_pass}}</span></h4>
			</li>
			
		</ul>
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
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			clipboard.on('error', function (e) {
				console.log(e);
				$('.btn-product-details').attr('src', '/client/images/btn-copy-code.png');
				$('#btn-copy').css('padding-top', '0.1rem');
				$('.btn-copy').html("<p class='inner_span_copy1' style='margin-top: -0.1rem;'>领取成功</p><p class='inner_span_copy2'>请打开淘宝APP</p>");
			});

			
		})
		
	</script>
@endsection
