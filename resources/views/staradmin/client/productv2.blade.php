<style type="text/css">
	.header .top li a, .header .top li a:hover, .header .top li a:focus {
			text-decoration: none;
		}

	.line {
		padding: 8px;
	}

	.voucher-price {
		text-align: center;
        border: 1px solid #8c36d9;
        border-radius: 5px;
        font-size: 10px;
        color: #8c36d9;
        padding: 3px;
    }

	.draw-price {
		text-align: center;
	    border: 1px solid red;
	    border-radius: 5px;
	    font-size: 10px;
	    color: red;
	    padding: 3px;
	}
	
	.columnval {
	  float: left;
	  width: 48%;
	  position:relative; /* and this has to be relative */
	  margin:0.05rem;
	  margin-left:0.08rem;

	}

    .rowval {
        padding-bottom: 2px;
        padding-left: 1px;
        padding-right: 1px;
    }
	 
	.rowval::after {
	  clear: both;
	  display: table;
	  align-content: center;
	  text-align: center;
	}

	.marginleft {	
	  /*margin-left: 0.3rem;*/
	}

	.marginright {	
	  /*margin-right: 0.3rem;*/
	}

	.marginbottom {
		margin-bottom: 0.2rem;
	}

	.featuredbg {

		position:relative;	
	    background: white;
	    border-top-left-radius: 6px;
	    border-top-right-radius: 6px;
	    border-bottom-left-radius: 6px;
	    border-bottom-right-radius: 6px;
	    /*padding: 0.2rem;*/
	    /*height: 4.4rem;*/
	}

	.featuredbg img {
		border-top-left-radius: 6px;
	    border-top-right-radius: 6px;
	    /*border-bottom-left-radius: 6px;*/
	    /*border-bottom-right-radius: 6px;*/
	}

	.featureddetail h2 {
		color: black;
	    padding: 0.08rem;
	    white-space: nowrap; 
	  	overflow: hidden;
	  	text-overflow: ellipsis;
	}

.featureddetail h3 .new-lbl-cur{
  text-align: center;
  font-size: 12px;
  color: red;
  font-weight: 0 !important;
}

.featureddetail h3 .new-price{
  text-align: center;
  font-size: 18px;
  color: red;
  font-weight: 0 !important;
  line-height: 0.6rem;
}

.featureddetail h3 .new-txt{
	color: #c6c6c6;
	font-size: 12px;
}

.featureddetail h3 .btn-go{
	text-align: center;
    border: 1px solid red;
    border-radius: 5px;
    font-size: 13px;
    color: white;
    padding-left: 5px;
    background-color: red;
    float: right;
    padding-right: 7px;
    padding-top: 2px;
    margin-top: 5px;
    font-weight: bold;
}

.featureddetail h3 .imgThunder{
	height: 19px;
    padding-bottom: 3px;
}

.featureddetail h3 .normal-txt{
	color: #c6c6c6;
	font-size: 12px;
}

.featureddetail h3 .normal-price{
	color: #c6c6c6;
	font-size: 12px;
	text-decoration: line-through;
}

.featureddetail h3 .normal-sell{
	color: #c6c6c6;
	font-size: 12px;
	float: right;
}

.product_section {
	/*margin-top: 1.6rem;*/
	margin-bottom: 0.2rem;
}
</style>        
@if (!empty($vouchers))

 <section class="card-flex product_section">
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
                                    	<span class="new-lbl-cur">￥</span>
                                    	<span class="new-price">{{$v->discount_price}}</span>
                                    	<span class="new-txt">到手价</span>
                                    	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
                                    </h3>
                                </div>
                            </span>                         
                        </div>
                    </a>
                </div>
        @else
                <div class="columnval featuredbg marginright">
                    <a href="/product/detail">
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
    	                            	<span class="new-lbl-cur">￥</span>
                                    	<span class="new-price">{{$v->discount_price}}</span>
                                    	<span class="new-txt">到手价</span>
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
</section>
@endif