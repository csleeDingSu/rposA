@extends('layouts.default')

{{-- @section('title', '玩法介绍') --}}

{{--
    @section('left-menu')
    <a href="javascript:history.back()" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection
--}}

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/redeem.css') }}" />
	<link rel="stylesheet" href="{{ asset('/client/css/how_to_play.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

<div class="full-height no-header">
    <div class="container">
        <div class="card">
            <img src="{{ asset('/client/images/redeem-background.jpg') }}" alt="redeem background">
            <div class="summary-table">
                <div class="nav-top">
                    <div class="col-xs-2 nav-left">
                        <a href="/profile">返回</a>
                    </div>
                    <div class="col-xs-8">
                        @if(env('THISVIPAPP','false'))
                            兑换奖品
                        @else
                            兑换红包
                        @endif
                        
                    </div>
                    <div class="col-xs-2 nav-right">
                        <a href="/summary">明细</a>
                    </div>
                </div>
                <div class="label-coin"><span class="wabao-coin"></span>元</div> 
                @if(!env('THISVIPAPP','false'))         
                    <div class="label-desc">
                        <a href="/share">邀请好友送场次，抽红包，去邀请 ></a>
                    </div>
                @endif
            </div>
        </div>
        <!-- end wabao coin info -->
    </div>


	<div class="tips_container">
	
		<div class="panel-step1">
		</div>
		<a href="/share"><div class="panel-step1-btn"></div></a>
        <div class="panel-step2"></div>
        <a href="/arcade"><div class="panel-step2-btn"></div></a>
   
    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection
