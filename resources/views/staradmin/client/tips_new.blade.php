@extends('layouts.default')

@section('title', '抽奖攻略')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/tips_new.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('top-javascript')
    @parent
    <script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
@endsection

@section('content') 
<div class="full-height no-header">
    <div class="container">
        <div class="nav-top">
            <span class="left">
                <a href="javascript:history.back()"><img class="nav-top-back" src="{{ asset('/client/images/back.png') }}" width="11" height="20" style="padding-bottom: 3px;" />&nbsp;返回</a>
            </span>
            <span class="center">
                抽奖攻略
            </span>
            <span class="right">
            </span>
        </div>
        <div class="topic">加倍抽奖 中奖更容易</div>
        <div class="note">
            <div class="title">6期加倍 首选方案</div>
            <div class="introduction">
                充值120金币，分6次抽奖，中奖率高达99％
            </div>
            <div class="introduction-bet">
                <div class="circle first-padding">1<br><span class="txt">起步</span></div>
                <div class="line-connect"></div>
                <div class="circle">3<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">7<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">15<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">31<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">63<br><span class="txt">加倍</span></div>
            </div>
            <div class="introduction-detail">
                120金币分6次抽奖，从1金币起步，不中下局加倍3金币，不中下局加倍7金币，不中下局加倍15金币。<br>以此加倍原理，6次机会，只要抽中1次就有奖励。
            </div>
            <div class="button-line">
                <a href="/purchasepoint">
                    <span class="btn-topup">充值120金币</span>
                </a>
                <a href="/vip">
                    <span class="btn-play">马上去抽奖</span>
                </a>
            </div>
        </div>
        <div class="note">
            <div class="title">5期加倍 中奖率高</div>
            <div class="introduction">
                充值57金币，分5次抽奖，中奖率高
            </div>
            <div class="introduction-bet">
                <div class="circle second-padding">1<br><span class="txt">起步</span></div>
                <div class="line-connect"></div>
                <div class="circle">3<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">7<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">15<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">31<br><span class="txt">加倍</span></div>
                
            </div>
            <div class="introduction-detail">
                57金币分5次抽奖，从1金币起步，不中下局加倍3金币，不中下局加倍7金币，不中下局加倍15金币。<br>以此加倍原理，5次机会，只要抽中1次就有奖励。
            </div>
            <div class="button-line">
                <a href="/purchasepoint">
                    <span class="btn-topup">充值57金币</span>
                </a>
                <a href="/vip">
                    <span class="btn-play">马上去抽奖</span>
                </a>
            </div>
        </div>
        <div class="note">
            <div class="title">4期加倍 中奖率高</div>
            <div class="introduction">
                充值26金币，分4次抽奖，中奖率高
            </div>
            <div class="introduction-bet">
                <div class="circle third-padding">1<br><span class="txt">起步</span></div>
                <div class="line-connect"></div>
                <div class="circle">3<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">7<br><span class="txt">加倍</span></div>
                <div class="line-connect"></div>
                <div class="circle">15<br><span class="txt">加倍</span></div>
                
            </div>
            <div class="introduction-detail">
                26金币分4次抽奖，从1金币起步，不中下局加倍3金币，不中下局加倍7金币，不中下局加倍15金币。<br>以此加倍原理，4次机会，只要抽中1次就有奖励。
            </div>
            <div class="button-line">
                <a href="/purchasepoint">
                    <span class="btn-topup">充值26金币</span>
                </a>
                <a href="/vip">
                    <span class="btn-play">马上去抽奖</span>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

@section('footer-javascript')
    @parent

@endsection