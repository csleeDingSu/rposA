@extends('layouts.default')

@section('title', '挖宝记录')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/allhistory.css') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('top-javascript')
	@parent
	<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />

		<div class="full-width-tabs">
			<!-- betting history tabs -->
			<ul class="nav nav-pills">
			  <li class="{{ empty($slug) ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#normal-tab">普通专场</a></li>
			  <li class="{{ (!empty($slug) and $slug == 'vip') ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#vip-tab">VIP专场</a></li>
			</ul>
			<!-- end betting history tabs -->

			<!-- tab content -->
			<div class="tab-content">
				<!-- normal list content -->
				<div id="normal-tab" class="tab-pane fade {{ empty($slug) ? 'in active' : '' }}">
					<div id="normal-history"></div>
					<div id="normal-pagination"></div>
				</div>
				<!-- end normal list content -->

				<!-- vip history content -->
				<div id="vip-tab" class="tab-pane fade {{ (!empty($slug) and $slug == 'vip') ? 'in active' : '' }}">
					<div id="vip-history"></div>
					<div id="vip-pagination"></div>
				</div>
				<!-- end vip list content -->
			</div>
		</div>
	</div>
</div>
@endsection

@section('footer-javascript')
	@parent
	<script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
	<script src="{{ asset('/client/js/allhistory.js') }}"></script>

@endsection