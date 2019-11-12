@extends('layouts.default_app')

@section('top-css')
    @parent  
    
    <link rel="stylesheet" type="text/css" href="{{ asset('/clientapp/css/swiper.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/css/blog.css?version=1.0.0') }}" />
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
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

      .isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }

    </style>
@endsection

@section('top-javascript')
    @parent
    <!-- <script type="text/javascript" src="{{ asset('/test/blog_html/js/swiper.min.js') }}"></script> -->
    
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:historyBackWFallback('/profile');"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '晒单详情')

@section('right-menu')
@endsection

@section('content')
@php($_phone = substr($blog->phone, 0, 3) . '****' . substr($blog->phone, 7, strlen($blog->phone)))
@php($_date = date('Y.m.d H:i:s', strtotime($blog->updated_at)))

<Div class="shareDetail fix">
  <div class="inTitleBox">
    <div class="name"><span>{{$_phone}}</span><em>{{$_date}}</em></div>
    <div class="address">{{$blog->address}}</div>
  </div>
  <div class="imgBanner">
    <div class="swiper-container imgSwiper">
      <div class="swiper-wrapper">
        @if (!empty($blog->uploads) && (!empty(json_decode($blog->uploads))))
          @foreach(json_decode($blog->uploads) as $photo)
            <div class="swiper-slide">
              <img src="{{$photo}}">
            </div>
          @endforeach
        @endif
      </div>
      <div class="swiper-hd"></div>
    </div>

  </div>
  <div class="inBanner">
    <div class="imgBox">
      <img src="{{$blog->picture_url}}">
    </div>
    <div class="txtBox">
      <h2>{{$blog->name}}</h2>
      <p><em>{{$blog->point_to_redeem}}</em>挖宝币</p>
    </div>
    <div class="btnBox">
      <a href="/vip">我也要抽奖</a>
    </div>
  </div>
  <div class="inDetail">
    <p>{{$blog->content}}</p>
  </div>
  @php ($_memberid = empty(Auth::Guard('member')->user()->id) ? 0 : Auth::Guard('member')->user()->id)
  @if ($_memberid == $blog->member_id)
  <div class="inSet">
    <a class="delBtn">
      <img src="{{ asset('/clientapp/images/delIcon.png') }}"><span>删除晒单</span>
    </a>
  </div>
  @endif
</Div>

<div class="slideImg dn">
    <div class="swiper-container swiper-Show">
      <div class="swiper-wrapper ">
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
    <!-- <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('/clientapp/js/swiper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/clientapp/js/being.js') }}" ></script>
    <script>
      $(function () {

        var banner = new Swiper(".imgSwiper", {
          autoHeight: window.innerHeight,
          autoplay: false, //可选选项，自动滑动
          pagination: {
            el: '.swiper-hd',
            type: 'custom',
            renderCustom: function (swiper, current, total) {
              return current + ' / ' + total;
            },
            preventClicksPropagation: false,
          },
        });

        var swiper = new Swiper(".swiper-Show", {
          autoHeight: window.innerHeight,
          autoplay: false, //可选选项，自动滑动
        });

        $('.shareDetail .imgBanner').on('click', 'img', function () {
          $('.slideImg').removeClass('dn');
          let html = "";
          let that = $(this);
          $.each(that.parents('.swiper-wrapper').find('.swiper-slide'), function (index, res) {
            img = $(res).find('img').attr('src');
            console.log(img);
            html += ' <div class="swiper-slide">';
            html += '<div class="inBox"><img src="' + img + '"></div>';
            html += ' </div>';
          });
          console.log(html);
          swiper.appendSlide(html);
        });

        $('.slideImg').click(function (e) {
          if ($(e.target).find('.swiper-container').length > 0) {
            $('.slideImg').find('.swiper-slide').remove();
            $('.slideImg').addClass('dn');
          };
        });


        $('.delBtn').click(function() {
          var _id = '{{$blog->id}}';

          $.ajax({
            type: 'GET',
            url: "/blog/del?id=" + _id, 
            dataType: "json",
            error: function (error) { console.log(error) },
            success: function(data) {
              console.log(data);
              window.top.location.href = "/blog";  
            }
          }); // end $.ajax

        });


      })
    </script>

@endsection