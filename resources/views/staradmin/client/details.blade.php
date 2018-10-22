@extends('layouts.default')

@section('title', '商品详情')

@section('left-menu')
	<a href="/" class="back">
		<div class="glyphicon glyphicon-menu-left" aria-hidden="true"></div>
	</a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/details.css') }}" />
@endsection

@section('content')	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@if(!empty($record)) 

    <div class="wrapper img-product">
		<img src="{{$record->product_picurl}}" alt="product details" class="product_details" />
    </div>
	<div class="wrapper full-height">
		<div class="card">
			<div class="description">
				<div class="icon-wrapper">
					<div class="icon-taobao"></div>
				</div>
				{{$record->product_name}}
			</div>
			<div class="clear"></div>
		</div>

		<div class="card">
			<div class="promo-price">
				<div class="icon-voucher-wrapper">
					<div class="icon-voucher"></div>
				</div>
				<div class="number"><span class="yuan-sign">¥</span> {{$record->product_price}}</div>
				<div class="strikethrough-text">淘宝正常售价:¥ {{$record->product_price}}
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="card">
			<!-- We can get rid of the strikethrough look by adding a span tag and applying a background color to the span. Applying a background to the h2:after won't work because it won't adjust and hug the text. -->
			<div class="voucher-header">
				<span>复制优惠卷代码 打开手机淘宝即可优惠</span>
				<div class="voucher">
					<div class="code"> {{$record->voucher_id}}
					</div>
				</div>
			</div>
		</div>
		
		<div class="button-wrapper">
			<button class="btn openeditmodel btn_submit" type="submit">免费挖宝本商品</button>
		</div>
	</div>

@else
	<div class="wrapper full-height">
		<div class="card"> 
			@lang('dingsu.no_record_found')
		</div>
	</div>
@endif




<!-- Modal starts -->
<form class="form-sample" name="formvoucher" id="formvoucher" action="" method="post" autocomplete="on" >
<div class="modal fade col-md-12" id="viewvouchermode" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">				
				<div class="row">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="wrapper modal-img-product">
						<img src="{{$record->product_picurl}}" alt="product details" class="product_details" />
			        </div>

					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="description center-text">
								{{$record->product_name}}
							</div>
							<div class="clear"></div>
						</div>

						<div class="modal-card">
							<div class="modal-center">
								<div class="modal-promo-price">优惠价:{{$record->product_price}}元</div>
								<div class="modal-strikethrough-text">淘宝正常售价: {{$record->product_price}}元</div>
							</div>
							<div class="clear"></div>
						</div>

						<div class="modal-card">
							<div class="wabao-price center-text">
								390挖宝币 免费兑换
							</div>
							<div class="clear"></div>
						</div>

						<div class="modal-card">
							<div class="icon-wabao-wrapper">
								<div class="icon-wabao"></div>
							</div>
						</div>

						<div>
							<a href="/arcade" class="btn btn_submit">进入挖宝 开始赚钱</a>
						</div>
					</div>
				</div>							
			</div>
		</div>
	</div>
</div>
</form> 
<!-- Modal Ends -->


<script type="text/javascript">
	$(document).ready(function () {
		
				
		});
	
	$('.openeditmodel').click(function() {
		$('#viewvouchermode').modal('show');		
	});
	
</script>



@endsection






