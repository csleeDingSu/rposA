<style>

	@media only screen and (max-width: 320px) {

	   body { 
	      font-size: 2em; 
	   }

	}
	
	</style>
@foreach($result as $item)
	<li class="dbox">
		<a href="#" class="imgBox dbox0">
			<img src="{{ env('ads_product_image_url') . $item->product_picurl }}">
		</a>
		<div class="dbox1">
			<h2>{{$item->product_description}}</h2>
			<h3>
				<font style="color: #fa8100; font-size:4vw;">券后价¥{{$item->discount_price}}</font>
				淘宝原价{{$item->product_price}}元
			</h3>
			<div class="quan">

				<span style="font-size:4vw;">¥{{$item->required_point}}元券
				@if ($item->product_quantity > 0)
					<font style="color:#81be07;">剩 {{$item->product_quantity}} 张</font>
				@endif
				</span>
				<a data-id="{{$item->redeem_code}}" id="{{$item->redeem_code}}">微信领取</a>
			</div>
		</div>
	</li>
@endforeach