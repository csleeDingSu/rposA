
@foreach($result as $item)
	<li class="dbox">
		<a href="#" class="imgBox dbox0">
			@if($item->product_image)
			<img src="{{ Config::get('app.ads_product_image_url') . $item->product_image }}">
			@elseif ($item->product_picurl)
			<img src="{{ $item->product_picurl }}">
			@else
			@endif
		</a>
		<div class="dbox1">
			<h2>{{$item->product_description}}</h2>
			<h3>
				<font>券后价¥{{$item->discount_price}}</font>
				淘宝原价{{$item->product_price}}元
			</h3>
			<div class="quan">

				<span>¥{{$item->required_point}}元券
				@if ($item->product_quantity > 0)
					<font>剩 {{$item->product_quantity}} 张</font>
				@endif
				</span>
				<a data-id="{{$item->redeem_code}}" id="{{$item->redeem_code}}">微信领取</a>
			</div>
		</div>
	</li>
@endforeach