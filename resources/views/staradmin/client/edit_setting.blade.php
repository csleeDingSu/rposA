@extends('layouts.default')

@section('title', '修改手机号码')

@section('left-menu')
    <a href="javascript:history.back()" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/edit-setting.css') }}" />
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
					<img class="img-phone" src="{{ asset('/client/images/setting-vip/edit-phone.png') }}" alt=""> 
					</div>	
					<div class="col-xs-12">
						<div class="notification">
							请务必提交正确的手机号码<br>
							否则会无法兑奖
						</div>
					</div>

					<div class="col-xs-12">
						<input id="phone" placeholder="{{isset(Auth::Guard('member')->user()->phone) ? Auth::Guard('member')->user()->phone : '123456789012345'}}" type="number" maxlength="15" />
					</div>

					<div class="col-xs-12">				
						<div class="button-submit">保存</div>
						<div class="error"></div>
						@if (Session::has('msg'))
							<div class="alert alert-warning" role="alert">	
								{{Session::get('msg')}}
							</div>
						@endif
					</div>

				</div>

			</div>
			<!-- end details -->
		  	
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
	<script src="{{ asset('/client/js/edit-setting.js') }}"></script>
@endsection
