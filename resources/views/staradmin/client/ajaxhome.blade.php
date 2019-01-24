@if(count($vouchers))
								
								@foreach($vouchers as $item)
									<li class="dbox">
										<a class="dbox0 imgBox" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}">
											<img src="{{$item->product_picurl . $setting->mobile_default_image_url}}" alt="{{$item->product_name}}">
										</a>
										<div class="dbox1">
											<h2>{{$item->product_name}}</h2>
											<div class="price">
												<span>￥{{$item->product_price}} </span>
												<div class="quan">
													<p>
														<font>￥</font>{{number_format($item->voucher_price, 2)}}
													</p>
													<h3>优惠券</h3>
												</div>
											</div>
											<div class="mset">
												<a class="showvoucher" href="javascript:void(0)" data-voucher="{{$item->voucher_pass}}">领取优惠券</a>
												<a class="type" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}">挖宝赚钱</a>
											</div>
										</div>
									</li>
								@endforeach
								
							@else
								<!--<li class="dbox">
									<a href="#" class="dbox0 imgBox">
										<img src="{{ asset('/test/main/images/demo/d-img2.png') }}">
									</a>
									<div class="dbox1">
										<h2>双人被夏凉被空调被双人被夏凉被空调被调被调被调被</h2>
										<div class="price">
											<span>￥338.00 </span>
											<div class="quan">
												<p>
													<font>￥</font>100.00
												</p>
												<h3>优惠券</h3>
											</div>
										</div>
										<div class="mset">
											<a>领取优惠券</a>
											<a class="type">免费挖宝</a>
										</div>
									</div>
								</li> -->
							@endif