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
						 $item['goodsid']        = $item['id'] ;

$item = (object )$item;
@endphp

									<li class="dbox">
										<a class="dbox0 imgBox" href="javascript:void(0)" data-goodsid="{{$item->goodsid}}" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}" data-voucher="{{$item->voucher_pass}}" data-imgurl="{{$item->product_picurl}}" >
											<img src="{{$item->product_picurl}}" alt="{{$item->product_name}}">
										</a>
										<div class="dbox1">
											<h2>
												<!--div class="freefornewbie">
													<img src="{{ asset('/client/images/lblbg.png') }} data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}">
													<h1>
														@if ($item->product_price >= 30)
															新人減30
														@else
															新人免單
														@endif
													</h1>
												</div>
												<span class="spacepadding"></span-->
												<span>{{$item->product_name}}</span>
											</h2>
											<div class="price">
												<div class="col-xs-6">
													<div class="divPrice">													
														<span class="vPricebg">
															<span class="vPrice" style="font-size: 0.30rem !important">
																{{number_format($item->voucher_price, 0)}}元券
															</span>							
														</span>
													</div>
													<div class="showDiscountPrice">
														￥
														<span class="discount_price">
															{{$item->discount_price}}
														</span>
														
													</div>
												</div>
												<div class="col-xs-6">
													<div class="month_sales">
														@php @$sales = 0 @endphp
														@if (empty($item->sales_show))
															@if ($item->month_sales > 10000)
																@php @$sales = round($item->month_sales/10000, 1) @endphp
																@php @$sales = @$sales.'万' @endphp
															@else
																@php @$sales = $item->month_sales  @endphp
															@endif
														@else
															@php @$sales = $item->sales_show  @endphp
														@endif
															已售{{$sales}}件
														</div>
														<div class="mset">
															<a  data-goodsid="{{$item->goodsid}}" data-imgurl="{{$item->product_picurl}}" class="showvoucher" href="javascript:void(0)" data-voucher="{{$item->voucher_pass}}" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_voucher_price="{{$item->voucher_price}}">
																<img class="btn-product" src="{{ asset('/client/images/btn-product.png') }}"  />
																<div class="caption_redeem_voucher">领券</div>
																<div class="caption_redeem_angpao2">拿红包</div>
																
															</a>
														</div>
												</div>
											</div>
											<div style="clear: both;"></div>
											<div class="divider">&nbsp;</div>

											<!--
											<div class="mset">
												<a data-imgurl="{{$item->product_picurl . $setting->product_home_popup_size}}" class="showvoucher" href="javascript:void(0)" data-voucher="{{$item->voucher_pass}}" data-tt_product_discount_price="{{$item->discount_price}}">领{{number_format($item->voucher_price, 0)}}元券</a>
												<a class="type" href="javascript:void(0)" data-tt_id="{{$item->id}}" data-tt_product_name="{{$item->product_name}}" data-tt_product_price="{{$item->product_price}}" data-tt_product_img="{{$item->product_picurl}}_460x460Q90.jpg" data-tt_product_discount_price="{{$item->discount_price}}" data-tt_voucher_price="{{$item->voucher_price}}">我要免单</a>
											</div>
											<-->
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