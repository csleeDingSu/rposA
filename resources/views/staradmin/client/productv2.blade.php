@if (!empty($vouchers))
    @php ($t = 0)
    @foreach($vouchers as $v)
        @php ($_id = !empty($v->id) ? $v->id : 0)
        @php ($product_picurl = !empty($v->product_picurl) ? $v->product_picurl : (empty($v->mainPic) ? '' : $v->mainPic))
        @php ($product_name = !empty($v->product_name) ? $v->product_name : (empty($v->title) ? '' : $v->title))

        @php ($oldPrice = empty($v->originalPrice) ? 0 : $v->originalPrice)
        @php ($product_price = !empty($v->product_price) ? $v->product_price : $oldPrice)        

        @php ($couponPrice = empty($v->couponPrice) ? 0 : $v->couponPrice)
        @php ($promoPrice = $oldPrice - $couponPrice)
        @php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)
        @php ($voucher_price = !empty($v->voucher_price) ? $v->voucher_price : $promoPrice)

        @php ($newPrice = $oldPrice - $couponPrice - 12)
        @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
        @php ($discount_price = !empty($v->discount_price) ? $v->discount_price : $newPrice)
        
        @php ($sales_show = !empty($v->sales_show) ? $v->sales_show : 0)
        @php ($sales = ($v->monthSales >= 1000) ? number_format(((float)$v->monthSales / 10000), 2, '.', '') . '万' : $v->monthSales . '件')
        @php ($sales_show = ($sales_show > 0) ? $sales_show : (($v->monthSales >= 1000) ? number_format(((float)$v->monthSales / 10000), 2, '.', '') . '万' : $v->monthSales))

        @php ($commissionRate = empty($v->commissionRate) ? 0 : $v->commissionRate)
        @php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
        @php ($reward = (int)($promoPrice * $commissionRate))
        @php ($reward = ($reward <= 0) ? '0' : $reward)

        @php ($goodsId = empty($v->goodsId) ? 0 : $v->goodsId)
        @php ($couponLink = empty($v->couponLink) ? '#' : $v->couponLink)
        
        @php ($_param = "?id=" . $_id . "&goodsId=" . $goodsId . "&mainPic=" . $product_picurl . "&title=" . $product_name . "&monthSales=" . $sales_show . "&originalPrice=" . $product_price . "&couponPrice=" . $couponPrice . "&couponLink=" . urlencode($couponLink) . "&commissionRate=" . $commissionRate . "&voucher_pass=&life=")

        @php ($t += 1)
        @if ($t % 2 != 0)
            <div class="rowval">
                <div class="columnval featuredbg marginleft">
                  	<a href="/product/detail/{{$_id}}">
                        <img src="{{$product_picurl}}" style="width:100%">
                        <div class="dbox1">
                            <span class="featureddetail">
                                <h2>{{$product_name}}</h2>
                                <div class="line">
                                    <h3>
                                    	<span class="voucher-price">领券减{{number_format($voucher_price, 2) + 0}}元</span>
                                    	<span class="draw-price">抽奖补贴12元</span>
                                    </h3>
                                </div>
                                <div class="line">
                                    <h3>
                                    	<span class="normal-txt">原价</span>
                                    	<span class="normal-price">￥{{number_format($product_price,2) + 0}}</span>
                                    	<span class="normal-sell">热销{{$sales_show}}件</span>
                                    </h3>
                                </div>
                                <div class="line-end">
                                	<h3>
                                    	<span class="new-price">
                                            <span class="new-txt">到手价</span>
                                            <span class="new-lbl-cur">￥</span>{{number_format($discount_price,2) + 0}}</span>
                                    	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
                                    </h3>
                                </div>
                            </span>                         
                        </div>
                    </a>
                </div>
        @else
                <div class="columnval featuredbg marginright">
                    <a href="/product/detail/{{$_id}}">
                        <img src="{{$product_picurl}}" style="width:100%">
                        <div class="dbox1">
                            <span class="featureddetail">
                                <h2>{{$product_name}}</h2>
                                <div class="line">
                                    <h3>
                                    	<span class="voucher-price">领券减{{number_format($voucher_price,2) + 0}}元</span>
                                    	<span class="draw-price">抽奖补贴12元</span>
                                    </h3>
                                </div>
                                <div class="line">
                                    <h3>
                                    	<span class="normal-txt">原价</span>
                                    	<span class="normal-price">￥{{number_format($product_price,2) + 0}}</span>
                                    	<span class="normal-sell">热销{{$sales_show}}件</span>
                                    </h3>
                                </div>
                                <div class="line-end">
                                	<h3>
                                    	<span class="new-price">
                                            <span class="new-txt">到手价</span>
                                            <span class="new-lbl-cur">￥</span>{{number_format($discount_price,2) + 0}}</span>
                                    	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
    	                            </h3>
                                </div>
                            </span>                         
                        </div>
                    </a>
                </div>
            </div>
        @endif
    @endforeach 
@endif