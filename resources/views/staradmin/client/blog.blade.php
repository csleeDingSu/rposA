@extends('layouts.default_app')

@section('top-css')
    @parent  
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
<input id="hidNextPg" type="hidden" value="">

    <div id="all">
      <div class="wfBox">  
        <div class="inList">              
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
        <div class="inList">              
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
<!-- view photo Modal starts -->
  <div class="modal fade col-md-12" id="view-photo" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <img src="" class="view-pic">
    </div>
  </div>
<!-- view photo Modal Ends -->

    @parent  
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('/client/blog/js/swiper.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
    <script type="text/javascript">

      document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
        } else if (state == 'complete') {
          setTimeout(function(){
              document.getElementById('interactive');
              document.getElementById('loading').style.visibility="hidden";
              $('.loading').css('display', 'initial');
              document.getElementById('loading2').style.visibility="hidden";
          },100);
        }
      }

      var page=1;
      $('#hidPg').val(page);
      $('#hidNextPg').val(page + 1);

      $(document).ready(function () {  

        $('#my').css('display','none');  

        $('.btn-all').click(function() {
          $('.btn-all').addClass('on');  
          $('#all').css('display','block');
          $('.btn-my').removeClass('on');
          $('#my').css('display','none');  
        });

        $('.btn-my').click(function() {
          $('.btn-all').removeClass('on');
          $('#all').css('display','none');  
          $('.btn-my').addClass('on');
          $('#my').css('display','block');
        });       
        
        getBlogList(page);
        getBlogMyList(page);

        //execute scroll pagination
        being.scrollBottom('.scrolly', '.wfBox', () => {
          page++;
          console.log('new page ' + page);
          var current_page = parseInt($('#hidPg').val());
          console.log('current page ' + current_page);
          var next_page = parseInt($('#hidNextPg').val());
          console.log('next page ' + next_page);
            
          if(page == next_page) {
            getBlogList(page);
            getBlogMyList(page);
          } else {
            console.log('no page ' + page);
          } 

        });
      });



  function getBlogList(page) {

    page = (page > 0 ? page : 1);

    $.ajax({
        type: 'GET',
        url: "/blog/list-all?page=" + page, 
        dataType: "json",
        error: function (error) { console.log(error) },
        success: function(data) {
            // console.log(data);
            var records = data.records.data;
            var html = '';
            var html1 = '';
            var html2 = '';
            var isLine1 = true;
            var _photo = null;
            var _phone = null;
            var _uploads = null;
            var _address = null;

            $.each(records, function(i, item) {
              // console.log(JSON.parse(item.uploads));
              isLine1 = ((i + 1) % 2) > 0 ? true : false;
              _uploads = JSON.parse(item.uploads);
              console.log(_uploads);
              _photo = (_uploads == null) ? '' : (((_uploads != null && _uploads.length > 0) && (_uploads[0] != 'undefined')) ? _uploads[0] : _uploads);    
              _photo = (_photo == '') ? '' : '<div class="imgBox"><img src="' + _photo + '"></div>';
              _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
              // _phone = item.phone;
              _address = item.address;
              _address = (_address == null) ? _address : ((_address.length > 5) ? _address.substring(0,5) + '...' : _address);
              
              html = '<a href="/blog/detail?id=' + item.id + '">' +
                      '<div class="inBox">' +
                        _photo +
                        '<h2>' + item.content + '</h2>' +
                        '<div class="inDetail">' +
                          '<p>' + _phone + '</p>' +
                          '<span>' + _address + '</span>' +
                        '</div>' +
                      '</div>' +
                      '</a>';

                if (isLine1) {
                  html1 += html;
                } else {
                  html2 += html;
                }

              });

              if (html1 == '' && html2 == '' && $('.item-line-1').html() == '')
              {
                _html = '<div class="no-record">' +
                          '<img src="/clientapp/images/no-record/blog.png">' +
                          '<div>暂无晒单记录</div>' +
                        '</div>';
                $('.item-line-1').html(_html);

              } else {
                  $('.item-line-1').append(html1);
                $('.item-line-2').append(html2);
              } 

                $('#hidPg').val(page);
                $('#hidNextPg').val(page + 1);

            }
    }); // end $.ajax
    
  } // end function

  function getBlogMyList(page) {

    page = (page > 0 ? page : 1);

    $.ajax({
        type: 'GET',
        url: "/blog/list-my?page=" + page, 
        dataType: "json",
        error: function (error) { console.log(error) },
        success: function(data) {
            // console.log(data);
            var records = data.records.data;
            var html = '';
            var html1 = '';
            var html2 = '';
            var isLine1 = true;
            var _photo = null;
            var _phone = null;
            var _uploads = null;
            var _address = null;

            $.each(records, function(i, item) {
              // console.log(JSON.parse(item.uploads));
              isLine1 = (i % 2) > 0 ? true : false;
              _uploads = JSON.parse(item.uploads);
              console.log(_uploads);
              _photo = (_uploads == null) ? '' : (((_uploads != null && _uploads.length > 0) && (_uploads[0] != 'undefined')) ? _uploads[0] : _uploads);    
              _photo = (_photo == '') ? '' : '<div class="imgBox"><img src="' + _photo + '"></div>';
              _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
              // _phone = item.phone;
              _address = item.address;
              _address = (_address == null) ? _address : ((_address.length > 5) ? _address.substring(0,5) + '...' : _address);
              
              html = '<a href="/blog/detail?id=' + item.id + '">' +
                      '<div class="inBox">' +
                        _photo +
                        '<h2>' + item.content + '</h2>' +
                        '<div class="inDetail">' +
                          '<p>' + _phone + '</p>' +
                          '<span>' + _address + '</span>' +
                        '</div>' +
                      '</div>' +
                      '</a>';

                if (isLine1) {
                  html1 += html;
                } else {
                  html2 += html;
                }

              });

            if (html1 == '' && html2 == '' && $('.item-line-1-my').html() == '')
            {
              _html = '<div class="no-record">' +
                        '<img src="/clientapp/images/no-record/blog.png">' +
                        '<div>暂无晒单记录</div>' +
                      '</div>';
              $('.item-line-1-my').html(_html);

            } else {
                $('.item-line-1-my').append(html1);
                $('.item-line-2-my').append(html2);
            }
          
            $('#hidPg').val(page);
            $('#hidNextPg').val(page + 1);

            }
    }); // end $.ajax
    
  } // end function


    </script>

@endsection