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
       
       .reveal-modal {
          /*position: relative;*/
          margin: 0 auto;
          top: 25%;
      }

      .isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }
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
           //execute scroll pagination
            being.scrollBottom('.cardBody', '.box', () => {   

            page++;
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
              console.log(responce);
              // if (responce.html == null || responce.html = '') {
              //  $(".isnext").html('');  
              // }
            }
           });
        }
      //scroll pagination - end

      
        
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