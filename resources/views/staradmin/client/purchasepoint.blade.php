@extends('layouts.default')

@section('title', '金币充值')

@section('left-menu')
    <a href="javascript:history.back()" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/purchasepoint.css') }}" />
@endsection

@section('content')

<div class="full-height">
	<div class="container">
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<div class="member-box">

			<!-- details -->
			<div class="information-table">
				<div class="row">
					<div class="col-xs-12">
					  	<div class="label-title">选择充值金币</div>
					</div>

					<form method="post" action="">
						<input type="hidden" id="radio-value" name="radio-value" />
					  	<div class="radio-group"></div>
					  
					</form>

					<div class="col-xs-12">
						<div class="label-reload">充值金额
							<input id="point" placeholder="0.00" type="number" maxlength="8"/>
							<!-- <span class="point">0.00</span> -->
							<span class="yuan">元</span>
						</div>
					</div>

					<div class="col-xs-12">				
						<div class="button-submit">确认充值</div>
						<div class="error"></div>
						@if (Session::has('msg'))
							<div class="alert alert-warning" role="alert">	
								{{Session::get('msg')}}
							</div>
						@endif
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
	<script src="{{ asset('/client/js/purchasepoint.js') }}"></script>
@endsection
