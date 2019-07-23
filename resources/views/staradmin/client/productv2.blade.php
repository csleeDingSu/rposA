@section('top-css')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ asset('/client/css/productv2.css') }}" />
@endsection
    
    <div class="rowval">
    	<div class="columnval featuredbg marginleft">
			<div class="free"></div>
			<img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[0]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[0]->product_picurl)?>" style="width:100%">
			<div class="dbox1">
				<span class="featureddetail">
					<h2>{{empty($item_featured[0]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[0]->product_name}}</h2>
					<div class="price1">
						<h3>
							<span class="lbl">券后</span>
							<span class="lbl_cur">￥</span>
							<span class="price2">
								{{number_format(empty($item_featured[0]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[0]->discount_price,2)}} </span>
							<span class="price3">
								￥{{number_format( empty($item_featured[0]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[0]->product_price,2)}}
							</span>
						</h3>
					</div>
				</span>							
			</div>
		</div>
		<div class="columnval featuredbg marginright">
			<div class="free"></div>
			<img src="<?=str_replace('_160x160.jpg', '', empty($item_featured[1]->product_picurl) ? env('shareproduct_img', 'https://img.alicdn.com/bao/uploaded/i2/4204664043/O1CN01TCTohy1fjjnPv9Pte_!!0-item_pic.jpg') : $item_featured[1]->product_picurl)?>" style="width:100%">
			<div class="dbox1">
				<span class="featureddetail">
					<h2>{{empty($item_featured[1]->product_name) ? env('shareproduct_content', '宝宝鞋儿童小熊鞋老爹鞋子2019新款春秋男童运动鞋潮网红鞋女童鞋') : $item_featured[1]->product_name}}</h2>
					<div class="price1">
						<h3>
						<span class="lbl">券后</span>
						<span class="lbl_cur">￥</span>
						<span class="price2">{{number_format(empty($item_featured[1]->discount_price) ? env('shareproduct_pricebefore',20) : $item_featured[1]->discount_price,2)}} </span>
						<span class="price3">
						￥{{number_format( empty($item_featured[1]->product_price) ? env('shareproduct_priceafter', 55) : $item_featured[1]->product_price,2)}}
						</span>
						</h3>
						
					</div>
				</span>							
			</div>
		</div>
	</div>
