@extends('layouts.layout')

@section('title', '阿福街')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/details.css') }}" />
@endsection

@section('content')	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@if(!empty($record)) 

		<div class="card" style="background-color: #f5f3f3;">
			<a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default" >@lang('dingsu.back')</a>
        </div>

        <div class="wrapper img-product">
			<img src="{{$record->product_picurl}}" alt="product details" class="product_details" />
        </div>
		<div class="wrapper full-height">
			<div class="card">
				<div class="col-xs-6 promo-price">
					<span class="number">{{$record->product_price}}</span> 试用价
				</div>
				<div class="col-xs-6 price">
					<div class="normal-title">淘宝正常售价：</div>
					<div class="normal-number">{{$record->product_price}} 元</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 description">
					{{$record->product_name}}
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="card">
				<!-- We can get rid of the strikethrough look by adding a span tag and applying a background color to the span. Applying a background to the h2:after won't work because it won't adjust and hug the text. -->
				<div class="voucher-header">
					<span>独家优惠卷</span>
					<div class="voucher">
						<div class="code">¥ {{$record->voucher_id}} ¥</div>
						<div>请复制后，打开淘宝APP就能看到商品。</div>
					</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 instruction">
					使用方法：<br />
					第一步： 复制上方橙色文字的淘口令。<br />
					第二步： 打开淘宝APP。<br />
					第三步： 领取优惠卷，下单购买。<br />					
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="row">
				<div class="col-md-2 col-md-offset-5"><button class="btn btn-danger openeditmodel" type="submit">View</button></div>
				
			</div>
		</div>

		


<br><br><br><br>

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

				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
				</div>
				<div class="modal-body">
				
					<div class="row">
						<div class="wrapper img-product">
							<img src="{{$record->product_picurl}}" alt="product details" class="product_details" />
						</div>
		<div class="wrapper full-height">
			<div class="card">
				<div class="col-xs-6 promo-price">
					<span class="number">{{$record->product_price}}</span> 试用价
				</div>
				<div class="col-xs-6 price">
					<div class="normal-title">淘宝正常售价：</div>
					<div class="normal-number">{{$record->product_price}} 元</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 description">
					{{$record->product_name}}
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="card">
				<!-- We can get rid of the strikethrough look by adding a span tag and applying a background color to the span. Applying a background to the h2:after won't work because it won't adjust and hug the text. -->
				<div class="voucher-header">
					<span>独家优惠卷</span>
					<div class="voucher">
						<div class="code">¥ {{$record->voucher_id}} ¥</div>
						<div>请复制后，打开淘宝APP就能看到商品。</div>
					</div>
				</div>
			</div>
			
			<div class="card">
				<div class="col-xs-12 instruction">
					使用方法：<br />
					第一步： 复制上方橙色文字的淘口令。<br />
					第二步： 打开淘宝APP。<br />
					第三步： 领取优惠卷，下单购买。<br />					
				</div>
				<div class="clear"></div>
				
				<div class="col-md-2 col-md-offset-5"><a href="/arcade" class="btn btn-danger openeditmodel" >Play Game</a></div>
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






