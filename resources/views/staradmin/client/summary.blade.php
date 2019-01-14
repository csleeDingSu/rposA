@extends('layouts.default')

@section('title', '挖宝币明细')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/summary.css') }}" />
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
		<div id="summary">
			<div class="row">
                <div class="col-xs-8 column-1">
	                <div class="item">挖宝成功收益结算</div>
	                <div class="date">2018-12-20</div>
	            </div>
	            <div class="col-xs-4 column-2">
                    <div class="right-wrapper">
                        <div class="points">+150</div>
                        <div class="icon-coin-wrapper">
                            <div class="icon-coin"></div>
                        </div>
                        
                        <div style="clear: both"></div>
                        <div class="balance">2050</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 column-1">
	                <div class="item">兑换话费卡</div>
	                <div class="date">2018-12-20</div>
	            </div>
	            <div class="col-xs-4 column-2">
                    <div class="right-wrapper">
                        <div class="points negative">-500</div>
                        <div class="icon-coin-wrapper">
                            <div class="icon-coin"></div>
                        </div>
                        
                        <div style="clear: both"></div>
                        <div class="balance">1550</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 column-1">
	                <div class="item">兑换VIP入场卷</div>
	                <div class="date">2018-12-20</div>
	            </div>
	            <div class="col-xs-4 column-2">
                    <div class="right-wrapper">
                        <div class="points negative">-300</div>
                        <div class="icon-coin-wrapper">
                            <div class="icon-coin"></div>
                        </div>
                        
                        <div style="clear: both"></div>
                        <div class="balance">1250</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 column-1">
	                <div class="item">兑换商品</div>
	                <div class="date">2018-12-20</div>
	            </div>
	            <div class="col-xs-4 column-2">
                    <div class="right-wrapper">
                        <div class="points negative">-1250</div>
                        <div class="icon-coin-wrapper">
                            <div class="icon-coin"></div>
                        </div>
                        
                        <div style="clear: both"></div>
                        <div class="balance">0</div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection

@section('footer-javascript')
	@parent
	<script src="{{ asset('/client/js/summary.js') }}"></script>

@endsection