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
        padding-bottom: 1px;
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
  font-size: 24px;
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
    font-size: 14px;
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
	height: 20px;
    padding-bottom: 3px;
}

.featureddetail h3 .normal-txt{
	color: #c6c6c6;
	font-size: 14px;
}

.featureddetail h3 .normal-price{
	color: #c6c6c6;
	font-size: 14px;
	text-decoration: line-through;
}

.featureddetail h3 .normal-sell{
	color: #c6c6c6;
	font-size: 14px;
	float: right;
}

.product_section {
	/*margin-top: 1.6rem;*/
	margin-bottom: 0.2rem;
}
</style>        
 <section class="card-flex product_section">
    @php ($total_voucher = count($vouchers))

    @foreach ($vouchers as $v)
    {{ $total_voucher}} <br>
        <p>This is {{ $v->id }}</p>
    @endforeach

            <div class="rowval">
              <div class="columnval featuredbg marginleft">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                    <div class="dbox1">
                            <span class="featureddetail">
                                <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                                <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                            </span>                         
                        </div>
                    </a>
                </div>
              <div class="columnval featuredbg marginright">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                <div class="dbox1">
                        <span class="featureddetail">
                            <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                            <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                        </span>                         
                </div>
            </a>
              </div>
              </div>

              <div class="rowval">
              <div class="columnval featuredbg marginleft">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                    <div class="dbox1">
                            <span class="featureddetail">
                                <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                                <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                            </span>                         
                        </div>
                       </a>
                </div>
              <div class="columnval featuredbg marginright">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                <div class="dbox1">
                        <span class="featureddetail">
                            <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                            <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                        </span>                         
                </div>
            </a>
              </div>
              </div>

              <div class="rowval">
              <div class="columnval featuredbg marginleft marginbottom">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                    <div class="dbox1">
                            <span class="featureddetail">
                                <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                                <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                            </span>                         
                        </div>
                    </a>
                </div>
              <div class="columnval featuredbg marginright marginbottom">
              	<a href="/product/detail">
                <img src="https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg" style="width:100%">
                <div class="dbox1">
                        <span class="featureddetail">
                            <h2>宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋</h2>
                            <div class="line">
                                <h3>
                                	<span class="voucher-price">领券减10元</span>
                                	<span class="draw-price">抽奖补贴15元</span>
                                </h3>
                            </div>
                            <div class="line">
                                <h3>
                                	<span class="normal-txt">原价</span>
                                	<span class="normal-price">￥55</span>
                                	<span class="normal-sell">热销1234件</span>
                                </h3>
                            </div>
                            <div class="line">
                            	<h3>
	                            	<span class="new-lbl-cur">￥</span>
                                	<span class="new-price">20</span>
                                	<span class="new-txt">到手价</span>
                                	<span class="btn-go"><img class="imgThunder" src="/client/images/icon-thunder.png">马上抢</span>
	                            </h3>
                            </div>
                        </span>                         
                </div>
            </a>
              </div>
              </div>
</section>