@extends('layouts.layout')

@section('title', '阿福街')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/details.css') }}" />
@endsection

@section('content')	
        <div class="wrapper img-product">
			<img src="/client/images/product_details.jpg" alt="product details" class="product_details" />
        </div>
		
		<div class="wrapper full-height">
			<div class="card">
				<div class="col-xs-6 promo-price">
					<span class="number">19.9</span> 试用价
				</div>
				<div class="col-xs-6 price">
					<div class="normal-title">淘宝正常售价：</div>
					<div class="normal-number">49.9元</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 description">
					ins超火的网红女士手表星空防水时尚款女2018新款时尚潮流chic风
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="card">
				<!-- We can get rid of the strikethrough look by adding a span tag and applying a background color to the span. Applying a background to the h2:after won't work because it won't adjust and hug the text. -->
				<div class="voucher-header">
					<span>独家优惠卷</span>
					<div class="voucher">
						<div class="code">¥ v2Dqb1HL5DF ¥</div>
						<div>请复制后，打开淘宝APP就能看到商品。</div>
					</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 instruction">
					使用方法：<br />
					第一步： 复制上方橙色文字的淘口令。<br />
					第二步： 打开淘宝APP。<br />
					第三步： 领取优惠卷，下单购买。<br />					
				</div>
				<div class="clear"></div>
			</div>
		</div>
@endsection
