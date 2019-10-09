@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/summary.css') }}" />
    <link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('top-javascript')
	@parent
	<!-- <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script> -->
@endsection

@if(env('THISVIPAPP','false'))
    <!-- top nav -->
    @section('left-menu')
      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
    @endsection

    @section('title', '明细')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '明细')
    @section('top-navbar')
    @endsection
@endif

@section('content')

@if(!env('THISVIPAPP','false'))
<div class="full-height">
	<div class="container">
@endif

		<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<input type="hidden" id="this_vip_app" value="{{ env('THISVIPAPP','false') }}" />
		<div id="summary">
			<div class="no-record">
                <img src="{{ asset('/clientapp/images/no-record/summary.png') }}">
                <div>暂无明细</div>
              </div>
		</div>
        <div id="pagination"></div>

@if(!env('THISVIPAPP','false'))
	</div>
</div>
@endif

@endsection

@section('footer-javascript')
	@parent
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
	<script src="{{ asset('/client/js/summary.js') }}"></script>

@endsection