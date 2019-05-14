@extends('layouts.default')

@section('title', 'Q币购买')

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
					</div>

					<form method="post" action="">
						<input type="hidden" id="radio-value" name="radio-value" />
					  	<div class="radio-group"></div>
					  
					</form>

					<div class="col-xs-12">
						<div class="label-title">需支付<span class="point">0 Q币</span>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="how-to-pay">
							支付方式：<br>
							到淘宝搜索“1个Q币”给下方Q号充值26个Q币。<br>
							充值完成后点击“充值完成”。<br>
						</div>
					</div>

					<div class="col-xs-12 qq">
						<img class="qq-icon" src="{{ asset('/client/images/membership/qq.png') }}"  />
						<div class="qq-info">
							QQ号码: <span id="cut">{{env('qqnumber', '235883623')}}</span>
						</div>
						<div class="copy">
							<div class="button-copy cutBtn">复制号码</div>
						</div>
					</div>

					<div class="col-xs-12">				
						<div class="button-submit">充值完成</div>
						<div class="error"></div>
					</div>

				</div>

			</div>
			<!-- end member details -->


		  	
		</div>
		
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
