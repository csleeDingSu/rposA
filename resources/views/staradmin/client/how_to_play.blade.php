@extends('layouts.default')

@section('title', '玩法介绍')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/how_to_play.css') }}" />
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
    <div class="container banner">
        <div class="nav-top">
            <span class="left">
                <a href="/vip">返回</a>
            </span>
            <span class="center">
                玩法介绍
            </span>
            <span class="right">
            </span>
        </div>
        <div class="note note-top">
            <div class="title">无抽奖上限，无限让你抽</div>
            <div class="introduction">
                告别15元封顶，中奖金币不封顶<br>
                抽奖金币无限制，抽多少都可以
            </div>
            <img class="img-money" src="{{ asset('/client/images/how-to-play/mon.png') }}">
        </div>
        <div class="note">
            <div class="title">如何抽奖更容易中</div>
            <div class="introduction">
                如何提升中奖概率？ 平台提供多种抽奖方案：<br>
                6期加倍，首选方案，中奖率超高<br>
                5期加倍，中奖率高，中奖率高<br>
                4期加倍，适用新手。
            </div>
            <a href="/tips-new">
                <div class="btn-tips">了解如何中奖</div>
            </a>
        </div>
        <div class="note">
            <div class="title">公平抽奖机制，绝无作弊</div>
            <div class="introduction">            
                平台的抽奖是系统自动抽奖机制，随机产生开奖结果，再次承诺绝无作弊。
            </div>
        </div>
        <div class="note">
            <div class="title">大量超值奖品，闪电换购</div>
            <div class="product"></div>
        </div>
    </div>

</div>

@endsection

@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/js/how-to-play.js') }}"></script>

@endsection