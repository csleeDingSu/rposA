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
              <div class="ring">
                <img src="{{ asset('/client/images/intro/ring.png') }}">
              </div>
              <div class="finger ">
                @if (isset(Auth::Guard('member')->user()->username))
                    <a href="/arcade">
                @else
                    <a onClick="openmodel();" href="javascript:void(0)">
                @endif
                    <img src="{{ asset('/client/images/intro/pointer.png') }}">
                    <div class="inTime">
                        
                            <img src="{{ asset('/client/images/intro/enter.png') }}" class="clickme">
                    </div>
                </a>
              </div>
            </div>

        </div>
        <div class="panel">
            <div class="panel-title">新人奖励说明</div>
            独特新颖转盘抽奖，每1场幸运转盘可抽奖15次，99%概率可抽到15元红包。<br>新人注册送2场幸运转盘，可抽30次奖，快来体验！
            <!-- 进入转盘默认有1200积分(不可提现)，使用倍增式猜单数或者双数（游戏里有介绍）。<br /><span class="highlight">在转盘里赚到的积分可兑换红包(可提现)。</span><br />每次幸运转盘最多能兑换15元红包。如果你有10次机会，就可以赚150元。 -->            
        </div>
        <div class="panel bottom-space">
            <div class="panel-title">邀请奖励说明</div>
            每邀请1个好友送1埸大幸运转盘，好友邀请别人，你也能获得1场幸运转盘（可抽奖15次）<br>
            <span class="highlight">
                假如你進请了10个好友，而每个好友也邀请10个人，你就能获得110场大幸运转盘，最多赚1650元红包。
            </span>
            <!-- 注册送2次幸运转盘，每邀请1个好友赚1次幸运转盘，好友邀请别人，你也能获得1次幸运转盘。<br />
            <span class="highlight">假如你邀请了10个好友，而每个好友也邀请10个人，你就能获得110次幸运转盘，最多赚1650元红包。</span> -->
        </div>
    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection


<link rel="stylesheet" href="{{ asset('/client/css/intro_popup.css') }}"/>

	@include('client.intromodel')
