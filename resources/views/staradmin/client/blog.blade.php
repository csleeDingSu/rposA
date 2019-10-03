@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/blog/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/client/css/blog.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/test/blog_html/css/swiper.min.css') }}" />    
    <style>
         
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
    <script type="text/javascript" src="{{ asset('/test/blog_html/js/swiper.min.js') }}"></script>
    
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:goBack();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '晒单评论')

@section('right-menu')
@endsection


@section('content')
<div class="cardBody">
  <div class="box">
    <div class="infinite-scroll">
      <ul class="list-2">               
          @include('client.blog_list')
      </ul>
      {{ $blog->links() }}
    </div>
  </div>
</div>
@endsection

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

@section('footer-javascript')
<!-- view photo Modal starts -->
  <div class="modal fade col-md-12" id="view-photo" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <img src="" class="view-pic">
    </div>
  </div>
<!-- view photo Modal Ends -->

    @parent  
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/client/blog/js/swiper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
    <script type="text/javascript">

      $(document).ready(function () {
           //execute scroll pagination
            being.scrollBottom('.scrolly', '.cardBody', () => {

            page++;

            console.log(page);
            var max_page = parseInt($('#max_page').val());
            if(page > max_page) {
              $('#page').val(page);
              $(".isnext").html("@lang('dingsu.end_of_result')");
              $('.isnext').css('padding-bottom', '50px');

            }else{
              getPosts(page);
            } 
          });
      });

      //scroll pagination - start
        $('ul.pagination').hide();
        
        var page=1;

        function getPosts(page){
          $.ajax({
            type: "GET",
            url: window.location+"/?page"+page, 
            data: { page: page },
            beforeSend: function(){ 
            },
            complete: function(){ 
              $('#loading').remove
            },
            success: function(responce) { 
              $('.list-2').append(responce.html);
              // console.log(responce);
              // if (responce.html == null || responce.html = '') {
              //  $(".isnext").html('');  
              // }
            }
           });
        }
      //scroll pagination - end

      function viewPhoto(photo) {
        $('.view-pic').attr('src', photo);
        $('#view-photo').modal();
      }

//swiper
       var swiper = new Swiper(".swiper-container", {
      autoHeight: window.innerHeight,
      autoplay: false, //可选选项，自动滑动
      spaceBetween: 5,
      centeredSlides: true,
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
      swiper.removeAllSlides();
      swiper.appendSlide(html);

    });

    $('.slideImg').click(function (e) {
      if($(e.target).find('.swiper-container').length>0){
        $('.slideImg').addClass('dn');
      };
    });

    </script>

@endsection