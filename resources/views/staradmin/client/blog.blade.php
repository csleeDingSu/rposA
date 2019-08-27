@extends('layouts.default')

@section('title', '晒单评论')

@section('top-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/public.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/swiper.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/style.css') }}" />  
    <link rel="stylesheet" href="{{ asset('/client/css/blog.css') }}" />
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
    
@endsection

@section('content')
<div class="loading" id="loading"></div>
<section class="card">
    <section class="card-header">
      <a class="returnIcon" href="/profile"><img src="{{ asset('/client/blog/images/retrunIcon.png') }}"><span>返回</span></a>
      <h2>用户晒单</h2>
    </section>
    <div class="card-body over">        
        <div class="scrollBox ">
            @if (!empty($blog))
                @foreach($blog as $b)
                    <div class="listBox">
                      <div class="userBox">
                        <div class="username">
                          <h2>{{substr($b->phone, 0, 3)}}****{{substr($b->phone, 7, strlen($b->phone))}}</h2><span>{{date('Y.m.d h:i:s A', strtotime($b->updated_at))}}</span>
                        </div>
                        <div class="address">{{$b->address}}</div>
                      </div>
                      <div class="txtBox">{{$b->content}}</div>
                      <ul class="imgBox">
                        @if (!empty($b->uploads) && (!empty(json_decode($b->uploads))))
                            @foreach(json_decode($b->uploads) as $photo)
                                <li><img src="{{ $photo }}"></li>
                            @endforeach  
                        @endif
                      </ul>
                    </div>
                @endforeach 
            @endif
                <div class="lastPage">暂无更多...</div>    
        </div>
        
    </div>
  </section>


  <div class="slideImg dn">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <!-- <div class="swiper-slide">
          <div class="inBox"><img src="images/demo1.png"></div>
        </div>
        <div class="swiper-slide">
          <div class="inBox"><img src="images/demo2.png"></div>
        </div>
        <div class="swiper-slide">
          <div class="inBox"><img src="images/1231.jpg"></div>
        </div> -->

      </div>
    </div>
  </div>

@endsection

@section('footer-javascript')
    @parent
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
        
        var swiper = new Swiper(".swiper-container", {
          autoHeight: window.innerHeight,
          autoplay: false, //可选选项，自动滑动
        });

        $('.listBox .imgBox li').click(function () {
          $('.slideImg').removeClass('dn');
          let html = "";
          let that = $(this);
          $.each(that.parent().find('li'), function (index, res) {
            img = $(res).find('img').attr('src');
            html += ' <div class="swiper-slide">';
            html += '<div class="inBox"><img src="' + img + '"></div>';
            html += ' </div>';
          });

          swiper.appendSlide(html);

        });

        $('.slideImg').click(function (e) {
          if($(e.target).find('.swiper-container').length>0){
            $('.slideImg').addClass('dn');
          };
        });
    </script>

@endsection