@if(is_array($vouchers) and count($vouchers))
								
								@foreach($vouchers as $item)

@php
						 $item['product_price']  = $item['jiage'] ;
						 $item['discount_price'] = $item['jiage'] ;
						 $item['product_picurl'] = $item['pic'] ;
						 $item['voucher_price']  = $item['quan_jine'] ;
						 $item['voucher_pass']   = $item['quan_jine'] ;
						 $item['product_name']   = $item['d_title'] ;
						 $item['month_sales']    = $item['xiaoliang'] ;
						 $item['goodsid']        = $item['goodsid'] ;

$item = (object )$item;
@endphp

									<li class="dbox">
										<a class="dbox0 imgBox" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}" data-voucher="{{$item->voucher_pass}}" data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}" data-goodsid="{{$item->goodsid}}">
											<img src="{{$item->product_picurl . $setting->mobile_default_image_url}}" alt="{{$item->product_name}}">
										</a>
										<div class="dbox1">
											<h2>{{$item->product_name}}</h2>
											<div class="price">
												<div class="divPrice">淘宝价<span>￥{{$item->product_price}} </span></div>
												<div class="quan">
													<p>
														已售{{$item->month_sales}}件+
													</p>
												</div>
											</div>
											<div class="mset">
												<a data-goodsid="{{$item->goodsid}}" data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}" class="showvoucher" href="javascript:void(0)" data-voucher="{{$item->voucher_pass}}">领{{number_format($item->voucher_price, 0)}}元券</a>
												<a class="type" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}">我要免单</a>
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