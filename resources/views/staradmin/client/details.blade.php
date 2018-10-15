@extends('layouts.layout')

@section('title', '阿福街')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/details.css') }}" />
@endsection

@section('content')	


@if(!empty($record)) 


        <div class="wrapper img-product">
			<img src="{{$record->product_picurl}}" alt="product details" class="product_details" />
        </div>
		<div class="wrapper full-height">
			<div class="card">
				<div class="col-xs-6 promo-price">
					<span class="number">{{$record->product_price}}</span> 试用价
				</div>
				<div class="col-xs-6 price">
					<div class="normal-title">淘宝正常售价：</div>
					<div class="normal-number">{{$record->product_price}} 元</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 description">
					{{$record->product_name}}
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="card">
				<!-- We can get rid of the strikethrough look by adding a span tag and applying a background color to the span. Applying a background to the h2:after won't work because it won't adjust and hug the text. -->
				<div class="voucher-header">
					<span>独家优惠卷</span>
					<div class="voucher">
						<div class="code">¥ {{$record->voucher_id}} ¥</div>
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
@else
<div class="wrapper full-height">
			<div class="card"> 
				@lang('dingsu.no_record_found')
				</div>
	</div>
 @endif
@endsection
