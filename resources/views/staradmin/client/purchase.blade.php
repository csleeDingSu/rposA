@extends('layouts.default')

@section('title', '付款页面')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/purchase.css') }}" />
@endsection

@section('content')

<div class="full-height">
	<div class="container">
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<div class="member-box">
			<img class="img_flow" src="{{ asset('/client/images/membership/flow-purchase.png') }}"  />
			<!-- end member id -->

			<!-- member details -->
			<div class="information-table">
				<div class="row">
					<div class="col-xs-12">
					  	<div class="label-title">选择场次</div>
					  	<input type="hidden" id="cut" value="i8I2yX408f" />
					</div>

					<form method="post" action="">
						<input type="hidden" id="radio-value" name="radio-value" />
					  	<div class="radio-group"></div>
					  
					</form>

					<div class="col-xs-6">
						<div class="label-title">支付金额</div>
					</div>
					<div class="col-xs-6 text-right">
						<div class="point"></div>
					</div>

					<div class="col-xs-12">
					  	<div class="button-copy cutBtn">复制支付口令</div>
					</div>
				</div>
			</div>
			<!-- end member details -->


		  	<div class="listing-table">
				<div class="col-xs-4">
					重要提示：
				</div>
				<div class="col-xs-8">
					付款成功后，请提交付款信息，填写姓名，否则后台无法确认。
				</div>
				<div style="clear: both;"></div>
				<div class="input-wrapper">
					<input type="text" value="" id="txt_name" name="txt_name" placeholder="输入姓名" />
				</div>
				<div class="button-submit">确认提交</div>
				<div class="error">未输入姓名无法提交，请填写真实姓名</div>

			</div>
		</div>
		
		<div class="top-background">
			<img src="{{ asset('/client/images/membership/bg-purchase.png') }}" />
		</div>
		<div class="bottom-background"></div>

		<!-- member listing -->
		
		<!-- end member listing -->
	</div>
</div>

@endsection



@section('footer-javascript')
<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="modal-successful" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="instructions">
									提交成功
								</div>								
							</div>
							
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	<script src="{{ asset('/client/js/purchase.js') }}"></script>
@endsection
