@extends('layouts.default_blog')

@section('title', '晒单评价')

@section('top-css')
    @parent
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

        $(function () {

          //发送
          $('.sendBtn').click(function () {
            if ($('.txt').val() == "") {
              alert('评论不能为空');
            } else {
                document.getElementById('loading').style.visibility="visible";

                $.ajax({
                    type: 'POST',
                    url: "/blog/create",
                    data: { 'content': $('.txt').val(), 'uploads': gUpload },
                    dataType: "json",
                    // beforeSend: function( xhr ) {
                    //     xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    // },
                    error: function (error) { 
                        document.getElementById('loading').style.visibility="hidden";
                        console.log(error.responseText) },
                    success: function(data) {
                        document.getElementById('loading').style.visibility="hidden";
                        if(data.success){
                            $('.showBox').fadeIn(150);
                        }
                    }
                });
            }
          });

          //文本
          $(".txt").bind("input propertychange", function (event) {
            let that = $(this);
            console.log(that.val());
            if (that.val() == "") {
              $('.sendBtn').removeClass('on');
            } else {
              $('.sendBtn').addClass('on');
            }
          });

          //图片上传

          $('.upBox input').change(function () {
            let that=$(this);
            let obj = this;
            lrz(obj.files[0], {
              width: 800,
              height: 600,
              before: function () {
                console.log('压缩开始');
              },
              fail: function (err) {
                console.error(err);
              },
              always: function () {
                console.log('压缩结束');
              },
              done: function (results) {
                // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
                var data = results.base64;
                gUpload.push(data);

                let imgUrl = "<li>";
                imgUrl += '<img src="'+data+'">';
                var crossIcon = "{{ asset('/client/blog/images/crossIcon.png') }}";
                imgUrl += '<a class="delBtn"><img src="'+crossIcon+'"></a>';
                imgUrl += ' </li>';

                that.parent('li').before(imgUrl);
                $('.upBtn span').html(($('.imgList li').length-1)+'/6');

              }
            });
          });
          //图片删除
          $('.imgList').on('click','.delBtn',function(){
            let that=$(this).parent('li');
            let index=that.index();
            $('.imgList li').eq(index).remove();
            let acount=$('.imgList li').length-1>0?$('.imgList li').length-1:0;
            $('.upBtn span').html(acount+'/6');
          });

        })
    </script>

@endsection