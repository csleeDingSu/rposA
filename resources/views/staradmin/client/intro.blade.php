@extends('layouts.default')

@section('title', '免单攻略')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/intro.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

<div class="full-height no-header">

	<div class="intro-container">
	
		<div class="intro-title">
            <img src="{{ asset('/client/images/intro/title.png') }}" />
        </div>
        <div class="playBox">
            <div class="playIn">
              <img src="{{ asset('/client/images/intro/wheel.png') }}" class="ig">
              <div class="finger ">

                <img src="{{ asset('/client/images/intro/pointer.png') }}">
                <div class="inTime">
                  <a href="/arcade"><img src="{{ asset('/client/images/intro/enter.png') }}" class="clickme"></a>
                </div>
              </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-title">转盘玩法说明</div>
            猜单数或双数，默认有1200金币，采用阶梯式玩法，6次内猜对有奖励，<span class="highlight">奖励的金币可兑换红包（可提现）</span><br />
            每次幸运转盘可赚取150金币，可兑换15元。
        </div>
        <div class="panel bottom-space">
            <div class="panel-title">超多红包拿不完</div>
            注册送2次幸运转盘，每邀请1个好友赚1次幸运转盘，好友邀请别人，你也能获得1次幸运转盘。<br />
            <span class="highlight">假如你邀请了10个好友，而每个好友也邀请10个人，你就能获得110次幸运转盘，最多赚1650元红包。</span>
        </div>
    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection