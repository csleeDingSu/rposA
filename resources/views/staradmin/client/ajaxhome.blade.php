@if(count($vouchers))
								
								@foreach($vouchers as $item)
									<li class="dbox">
										<a class="dbox0 imgBox" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}" data-voucher="{{$item->voucher_pass}}" data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}" >
											<img src="{{$item->product_picurl . $setting->mobile_default_image_url}}" alt="{{$item->product_name}}">
										</a>
										<div class="dbox1">
											<h2>
												<div class="freefornewbie">
													<img src="{{ asset('/client/images/lblbg.png') }}">
													<h1>
														@if ($item->product_price >= 30)
															新人減30
														@else
															新人免單
														@endif
													</h1>
												</div>
												<span class="spacepadding"></span>
												<span>{{$item->product_name}}</span>
											</h2>
											<div class="price">
													<div class="divPrice">	淘宝原价￥{{$item->product_price}}
													
													<span class="vPricebg">
														<span class="vPrice">
															{{number_format($item->voucher_price, 0)}}元券
														</span>														
														@if (!empty($item->expiry_datetime))

														@php @$date = \Carbon\Carbon::parse($item->expiry_datetime) @endphp
														@php @$now = \Carbon\Carbon::now() @endphp
														@php @$diff = $date->diffInDays($now) @endphp

														@if (@$diff > 0)
														<span class="vExpiry">
															剩
															{{ @$diff }}天
														</span>
														@endif
														@endif
													</span>
												</div>
												<div class="showDiscountPrice">
													￥
													<span class="discount_price">
														{{$item->discount_price}}
													</span>
													<span class="month_sales">
														已售
														@if (empty($item->sales_show))
															{{$item->month_sales}}
														@else
															{{$item->sales_show}}
														@endif
														件+
													</span>
												</div>
											</div>

											<!--
											<div class="mset">
												<a data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}" class="showvoucher" href="javascript:void(0)" data-voucher="{{$item->voucher_pass}}" data-tt_product_discount_price="{{$item->discount_price}}">领{{number_format($item->voucher_price, 0)}}元券</a>
												<a class="type" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}">我要免单</a>
											</div>
											-->
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