@extends('layouts.default')

@section('title', '抽奖攻略')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/download_app.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('top-javascript')
    @parent
@endsection

@section('content')
<div class="full-height no-header">
    <div class="container bg-img">
        <div class="logo"></div>
        <div class="topic">挖宝网</div>
        <div class="topic-description">玩无限抽奖，换超值奖品</div>
        <div class="note">
            <img class="img-wheel" src="{{ asset('/client/images/download-app/wheel.png') }}">
            <div class="title">欢乐无限抽</div>
            <div class="introduction">
                <span class="glyphicon glyphicon-star cust-star"></span>&nbsp;  无抽奖上限，无限让你抽<br>
                <span class="glyphicon glyphicon-star cust-star"></span>&nbsp;  100%公平抽奖机制，绝无作弊<br>
                <span class="glyphicon glyphicon-star cust-star"></span>&nbsp;  大量超值奖品，闪电换购<br>
            </div>
        </div>
        @if ($isMacDevices)
            <a href="{{env('DOWNLOAD_APP_IOS', '#')}}">
                <div class="btn-download">iPhone 版下载</div>
            </a>
        @else
            <a href="{{env('DOWNLOAD_APP_ANDROID', '#')}}" class="bottom">
                <div class="btn-download">android 版下载</div>
            </a>
        @endif

        @if ($isMacDevices)
            <div class="guide-title"><span class="highlight">[必看]</span>苹果用户设置信任教程</div>
            <div class="img-guide1"></div>
            <div class="guide-txt">1. 打开手机，在界画找到 【设置】 - 【通用】</div>
            <div class="img-guide2"></div>
            <div class="guide-txt">2. 【通用】 界画上滑找到 【设备管理】，然后点开aimeilife Technology Co,.Ltd 企业证书</div>
            <div class="img-guide3"></div>
            <div class="guide-txt bottom">3. 点开信任 "aimeilife Technology Co,.Ltd" 证书并点击 【信任】 ，然后返回界面点击挖宝网app</div>
        @endif
    </div>

</div>

@endsection

@section('footer-javascript')
    @parent

@endsection