@extends('layouts.default_app')

@section('top-css')
    @parent
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/style.css') }}" /> -->
	<link rel="stylesheet" href="{{ asset('/client/css/my_redeem.css') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '晒单评价')

@section('right-menu')
@endsection
    
@section('top-javascript')
	@parent
	<!-- <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script> -->
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
	<script src="{{ asset('/client/blog/js/lrz.mobile.min.js')}}"></script>
@endsection

@section('content') 
    
    <div class="card-body">
			<!-- wabao coin info -->
			<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
			<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
			<input type="hidden" id="page" value="1" />
			<input type="hidden" id="max_page" value="1" />
			<input type="hidden" id="reload_pass" value="{{ env('reload_pass','￥EXpZYiJPcpg￥') }}" />
			<input type="hidden" id="this_vip_app" value="{{ env('THISVIPAPP','false') }}" />
	
			<div id="redeem-history"></div>
			<p class="isnext">下拉显示更多...</p>
    </div>

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/my_redeem.js') }}"></script>
    <script type="text/javascript">
    	var end_of_result = "@lang('dingsu.end_of_result')";
    </script>
@endsection