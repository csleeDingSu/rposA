@extends('layouts.default_app')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/clientapp/css/summary_v2.css') }}" />
    <link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          position: fixed;
          left: 0px;
          top: 1rem !important;
          width: 100%;
          height: 88% !important;
          z-index: 9999;
          background: url(/client/images/preloader.gif) center no-repeat;
          background-color: rgba(255, 255, 255, 1);
          background-size: 32px 32px;
          visibility: hidden;
        }

    </style>
    
@endsection

@section('top-javascript')
	@parent
	<!-- <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script> -->
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="/profile"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '明细')

@section('right-menu')
<a class="FilterBtn"><img src="{{ asset('/clientapp/images/summary/filterbtn.png') }}">筛选</a>
@endsection
<!-- top nav end-->

@section('content')

<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
<input type="hidden" id="this_vip_app" value="{{ env('THISVIPAPP','false') }}" />
<input id="hidPg" type="hidden" value="">
<input id="hidNextPg" type="hidden" value="">

<div id='filter'>
    <span class="all">全部</span><span class="redeem">兑奖</span><span class="recharge">充值</span><span class="resell">转卖</span>
</div>
<div class="scrollpg"> 
<div class="loading2" id="loading2"></div>
<div id="summary">
</div>
</div>

@endsection

@section('footer-javascript')
	@parent
  <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
	<script src="{{ asset('/clientapp/js/summary_v2.js') }}"></script>
    <script type="text/javascript">

        document.onreadystatechange = function () {
            var state = document.readyState
            if (state == 'interactive') {
            } else if (state == 'complete') {
              setTimeout(function(){
                  document.getElementById('interactive');
                  document.getElementById('loading').style.visibility="hidden";
                  document.getElementById('loading2').style.visibility="visible";
                  $('.loading').css('display', 'initial');
                  document.getElementById('loading2').style.visibility="hidden";
              },100);
            }
          }
    </script>

@endsection