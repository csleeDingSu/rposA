@extends('layouts.default')

@section('title', '晒单评价')

@section('top-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/public.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/swiper.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/blog_create.css') }}" />
    
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
    </style>
@endsection

@section('top-navbar')
@endsection

@section('top-javascript')
    @parent
    <script src="{{ asset('/client/blog/js/lrz.mobile.min.js')}}"></script>
    
@endsection

@section('content')
<div class="loading" id="loading"></div>
<section class="card">
    <section class="card-header">
      <a class="returnIcon" href="javascript:history.back()"><img src="{{ asset('/client/blog/images/retrunIcon.png') }}"><span>返回</span></a>
      <h2>晒单评价</h2>
    </section>
    <div class="card-body">

      <div class="textBox">
        <label class="area">
          <textarea class="txt" rows="10" placeholder="亲！抽中奖品的心情不错吧！快点跟大家分享下你的喜悦吧！沾沾你的好运气哦！"></textarea>
        </label>
        <div class="imgBox">
          <ul class="imgList">
            <!-- <li>
              <img src="images/demo2.png">
              <a class="delBtn"><img src="images/crossIcon.png"></a>
            </li>
            <li>
              <img src="images/demo3.png">
              <a class="delBtn"><img src="images/crossIcon.png"></a>
            </li>
            <li>
              <img src="images/demo2.png">
              <a class="delBtn"><img src="images/crossIcon.png"></a>
            </li>
            <li>
              <img src="images/demo4.png">
              <a class="delBtn"><img src="images/crossIcon.png"></a>
            </li> -->
            <li class="upBox">
              <input type="file">
              <a class="upBtn">
                <img src="{{ asset('/client/blog/images/cameraIcon.png')}}"> <span>上传图片</span></a>
            </li>
          </ul>
        </div>

      </div>
      <button class="sendBtn">发布</button>


    </div>
  </section>

<div class="showBox">
    <div class="tickBox">
      <div class="inBox">
        <div class="txtBox">
          <img src="{{ asset('/client/blog/images/tickicon.png')}}">
          <p>晒单成功</p>
        </div>
        <div class="btnBox">
          <a href="/">首页抽奖</a>
          <a href="/blog">查看晒单</a>
        </div>
      </div>
    </div>
</div>

@endsection

@section('footer-javascript')
    @parent
    <script type="text/javascript">
        var gUpload = [];

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

    </script>

@endsection