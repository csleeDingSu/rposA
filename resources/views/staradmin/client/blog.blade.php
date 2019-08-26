@extends('layouts.default_blog')

@section('title', '晒单评论')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/blog.css') }}" />
      
@endsection

@section('top-navbar')
@endsection

@section('top-javascript')
    @parent
    
@endsection

@section('content')
<section class="card">
    <section class="card-header">
      <a class="returnIcon" href="javascript:history.back()"><img src="{{ asset('/client/blog/images/retrunIcon.png') }}"><span>返回</span></a>
      <h2>用户晒单</h2>
    </section>
    <div class="card-body over">
        @if (!empty($data))
      <div class="scrollBox ">
        <div class="listBox">
          <div class="userBox">
            <div class="username">
              <h2>{{$data->phone}}</h2><span>{{$data->updated_at}}</span>
            </div>
            <div class="address">{{$data->address}}</div>
          </div>
          <div class="txtBox">{{$data->content}}</div>
          <ul class="imgBox">
            @if (!empty($data->uploads))
                @foreach($data->uploads as $u)
                <li><img src="{{ $u }}"></li>
                @endforeach 
            @endif
          </ul>
        </div>
        <div class="listBox">
          <div class="userBox">
            <div class="username">
              <h2>132*******324234</h2><span>2018.08.20</span>
            </div>
            <div class="address">浙江省杭州市上城区88号</div>
          </div>
          <div class="txtBox">100金币抽中苹果X，真的是太新云了啊！今天刚收到这个产，好像的按时大大说哈康师傅</div>
          <ul class="imgBox">
            <li><img src="images/1231.jpg"></li>
            <li><img src="images/demo1.png"></li>
            <li><img src="images/111.png"></li>
            <li><img src="images/demo1.png"></li>

          </ul>
        </div>
        <div class="listBox">
          <div class="userBox">
            <div class="username">
              <h2>132*******324234</h2><span>2018.08.20</span>
            </div>
            <div class="address">浙江省杭州市上城区88号</div>
          </div>
          <div class="txtBox">100金币抽中苹果X，真的是太新云了啊！今天刚收到这个产，好像的按时大大说哈康师傅</div>
          <ul class="imgBox">
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            <li><img src="{{ asset('/client/blog/images/demo1.png') }}"></li>
            
          </ul>
        </div>
        <div class="lastPage">暂无更多...</div>
      </div>
      @endif
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
    <script type="text/javascript">
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