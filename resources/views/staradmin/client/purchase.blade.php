@extends('layouts.default')

@section('title', '开通场次')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/purchase.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')
<div class="full-height no-header">
	<div class="container">
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />

	<!-- Collect the nav links, forms, and other content for toggling -->
	

		<div class="member-box">
			<div class="card left">
				<div class="col-xs-3 left-menu">
					<a href="/profile" class="back">
				        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>返回
				    </a>
				</div>
				<div class="col-xs-6">
					<div class="navbar-title">
					  <div class="navbar-brand">开通场次</div>
					</div>
				</div>

				<div class="col-xs-3 right-menu">
				  	<div class="menu-wrapper">购买记录</div>
				</div>
			</div>

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
						<div class="how-to-pay">
							请提交30元骏网一卡通卡号和密码，可兑换2场次幸运转盘，预计2-5分钟开通完成。
						</div>
					</div>

					<div class="col-xs-12">				
						<div class="button-submit">提交购买</div>
						<div class="error"></div>
					</div>

				</div>

			</div>
			<!-- end member details -->
		</div>

		<div class="top-background">
			<img src="{{ asset('/client/images/purchase-bg.png') }}" />
		</div>
		<div class="bottom-background"></div>
		
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
