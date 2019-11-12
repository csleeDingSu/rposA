@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" type="text/css" href="{{ asset('/clientapp/css/blog.css?version=1.0') }}" />
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          position: fixed;
          left: 0px;
          top: 1.8rem;
          width: 100%;
          height: 85%;
          z-index: 9999;
          background: url(/client/images/preloader.gif) center no-repeat;
          background-color: rgba(255, 255, 255, 1);
          background-size: 32px 32px;
        }
         
       .reveal-modal {
          /*position: relative;*/
          margin: 0 auto;
          top: 25%;
      }

      .isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }

    </style>
@endsection

@section('top-javascript')
    @parent   
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:historyBackWFallback('/profile');"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '晒单评论')

@section('right-menu')
@endsection

@section('blog-tab')
  <div class="card-body flex0">
    <div class="sdMain">
      <a class="btn-all on">全部晒单</a>
      <a class="btn-my">我的晒单</a>
    </div>
  </div>
@endsection


@section('content')
<div class="loading2" id="loading2"></div>

<input id="hidPg" type="hidden" value="">
<input id="hidPgMy" type="hidden" value="">
<input id="hidNextPg" type="hidden" value="">
<input id="hidNextPgMy" type="hidden" value="">
<input id="hidMemberId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">

<div id="all">
  <div class="wfBox">  
    <div class="inList" id="inList-all">              
      <div class="item">
        <div class="item-line-1"></div>
      </div>
      <div class="item">
        <div class="item-line-2"></div>
      </div>
    </div>
  </div>
</div>

<div id="my">
  <div class="wfBox">  
    <div class="inList" id="inList-my">              
      <div class="item">
        <div class="item-line-1-my"></div>
      </div>
      <div class="item">
        <div class="item-line-2-my"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer-javascript')
  @parent  
  <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
  <script type="text/javascript" src="{{ asset('/clientapp/js/blog.js?version=1.0') }}"></script>
  <script type="text/javascript">

    $(document).ready(function () {
      $('.scrolly').addClass('bgf3');
    });

    document.onreadystatechange = function () {
      var state = document.readyState
      if (state == 'interactive') {
      } else if (state == 'complete') {
        setTimeout(function(){
            document.getElementById('interactive');
            document.getElementById('loading').style.visibility="hidden";
            $('.loading').css('display', 'initial');
            // document.getElementById('loading2').style.visibility="hidden";
        },100);
      }
    }

  </script>

@endsection