@extends('layouts.default')

@section('title', '淘宝订单号提交教程')

@section('top-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/public.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/swiper.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/style.css') }}" />  
    <link rel="stylesheet" href="{{ asset('/client/css/receipt_guide.css') }}" />
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/client/images/preloader.gif') center no-repeat;
            background-color: rgba(255, 255, 255, 1);
            background-size: 32px 32px;
        }
       
       .reveal-modal {
          /*position: relative;*/
          margin: 0 auto;
          top: 25%;
      }

    </style>
@endsection

@section('top-navbar')
@endsection

@section('top-javascript')
    @parent
    
@endsection

@section('content')
<div class="loading" id="loading"></div>

<section class="card">
    <section class="card-header">
      <a class="returnIcon" href="/profile"><img src="{{ asset('/client/blog/images/retrunIcon.png') }}"><span>返回</span></a>
      <h2>淘宝订单号提交教程</h2>
    </section>
    <div class="card-body over"> 
        <div class="cardBody">
          <div class="container">
          <div class="step1">
            <div class="step-title"><span class="step-number">01</span> 打开淘宝app，进入- “我的淘宝”</div>
            <img class="step-img" src="{{ asset('/client/images/receipt/1.png') }}">
          </div>
          <div class="step2">
            <div class="step-title"><span class="step-number">02</span> 点击 “我的订单”，找到通过平台领券下的订单</div>
            <img class="step-img" src="{{ asset('/client/images/receipt/2.png') }}">
          </div>
          <div class="step3">
            <div class="step-title"><span class="step-number">03</span> 点击订单进入 “订单详情” 找到 “订单骗号” 复制</div>
            <img class="step-img" src="{{ asset('/client/images/receipt/3.png') }}">
          </div>
          <div class="step4">
            <div class="step-title"><span class="step-number">04</span> 进入 “下单奖励” 页面 粘贴淘宝订单号提交</div>
            <img class="step-img" src="{{ asset('/client/images/receipt/4.png') }}">
          </div>
        </div>
        </div>
    </div>
  </section>

@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/client/blog/js/swiper.min.js') }}"></script>
    <script type="text/javascript">

      document.onreadystatechange = function () {
          var state = document.readyState
          if (state == 'interactive') {
          } else if (state == 'complete') {
            setTimeout(function(){
                document.getElementById('interactive');
                document.getElementById('loading').style.visibility="hidden";
            },100);
          }
        }

      $(document).ready(function () {
           
      });

    </script>

@endsection