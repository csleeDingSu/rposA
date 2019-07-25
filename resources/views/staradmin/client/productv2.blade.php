@if (!empty($vouchers))

    @php ($t = 0)
    @foreach($vouchers as $v)
        @php ($t += 1)
        @if ($t % 2 != 0)
            <div class="rowval">
                <div class="columnval featuredbg marginleft">
                  	<a href="/product/detail/{{$v->id}}">
                        <img src="{{$v->product_picurl}}" style="width:100%">
                        <div class="dbox1">
                            <span class="featureddetail">
                                <h2>{{$v->product_name}}</h2>
                                <div class="line">
                                    <h3>
                                    	<span class="voucher-price">领券减{{$v->voucher_price}}元</span>
                                    	<span class="draw-price">抽奖补贴15元</span>
                                    </h3>
                                </div>
                                <div class="line">
                                    <h3>
                                    	<span class="normal-txt">原价</span>
                                    	<span class="normal-price">￥{{$v->product_price}}</span>
                                    	<span class="normal-sell">热销{{$v->sales_show}}件</span>
                                    </h3>
                                </div>
                                <div class="line">
                                	<h3>
                                    	<span class="new-price">
                                            <span class="new-lbl-cur">￥</span>{{$v->discount_price}}</span><span class="new-txt">到手价</span>
                                    	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
                                    </h3>
                                </div>
                            </span>                         
                        </div>
                    </a>
                </div>
        @else
                <div class="columnval featuredbg marginright">
                    <a href="/product/detail/{{$v->id}}">
                        <img src="{{$v->product_picurl}}" style="width:100%">
                        <div class="dbox1">
                            <span class="featureddetail">
                                <h2>{{$v->product_name}}</h2>
                                <div class="line">
                                    <h3>
                                    	<span class="voucher-price">领券减{{$v->voucher_price}}元</span>
                                    	<span class="draw-price">抽奖补贴15元</span>
                                    </h3>
                                </div>
                                <div class="line">
                                    <h3>
                                    	<span class="normal-txt">原价</span>
                                    	<span class="normal-price">￥{{$v->product_price}}</span>
                                    	<span class="normal-sell">热销{{$v->sales_show}}件</span>
                                    </h3>
                                </div>
                                <div class="line">
                                	<h3>
                                    	<span class="new-price">
                                            <span class="new-lbl-cur">￥</span>{{$v->discount_price}}</span><span class="new-txt">到手价</span>
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