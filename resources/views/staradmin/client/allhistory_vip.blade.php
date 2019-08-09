@extends('layouts.default')

@section('title', '转盘记录')

@section('left-menu')
    <a href="/profile" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/allhistory_vip.css') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('top-javascript')
	@parent
	<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<input type="hidden" id="page" value="1" />
		<input type="hidden" id="max_page" value="1" />

		<div class="full-width-tabs">
			
				<!-- vip history content -->
				<div id="vip-tab" class="tab-pane fade in active">
					<div id="vip-history"></div>
					<p class="isnext">下拉显示更多...</p>
				</div>
				<!-- end vip list content -->
			
		</div>
	</div>
</div>
@endsection

@section('footer-javascript')
	@parent
	<script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
	<script src="{{ asset('/client/js/allhistory_vip.js') }}"></script>
	<script type="text/javascript">
        var end_of_result = "@lang('dingsu.end_of_result')";
    </script>

@endsection