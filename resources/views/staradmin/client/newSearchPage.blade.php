<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta name="format-detection" content="telephone=no" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <title>搜索</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('/clientapp/css/public.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/clientapp/css/swiper.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('/clientapp/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('/clientapp/css/newSearchPage.css') }}" />
  <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          height: 0.3rem;
          width: 0.3rem;
          position: relative;
          z-index: 9999;
        }

    </style>
  <script type="text/javascript" src="{{ asset('/clientapp/js/swiper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/clientapp/js/jquery-1.9.1.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/clientapp/js/being.js') }}"></script>
  <script src="{{ asset('/clientapp/js/newSearchPage.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

  <script>
      // alert('yes. i am in.');
      if(('standalone' in window.navigator)&&window.navigator.standalone){  
        var noddy,remotes=false;  
        document.addEventListener('click',function(event){  
                noddy=event.target;  
                while(noddy.nodeName!=='A'&&noddy.nodeName!=='HTML') noddy=noddy.parentNode;  
                if('href' in noddy&&noddy.href.indexOf('http')!==-1&&(noddy.href.indexOf(document.location.host)!==-1||remotes)){  
                        event.preventDefault();  
                        document.location.href=noddy.href;  
                }  
        },false);  
    }  
  </script>
</head>

<body>

<section class="card">
    <input id="hidPageId" type="hidden" value="" />
    <input id="hidgame_102_usedpoint" type="hidden" value="{{empty($game_102_usedpoint) ? 0 : $game_102_usedpoint}}" />
    <input id="hidlife" type="hidden" value="{{empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life}}" />
    
    <div class="card-header">
      <div class="topSearch">
        <a class="return" href="javascript:history.back();"><img src="{{ asset('/clientapp/images/leftIcon.png') }}"></a>
        <div class="insearch">
          <label>
            <input type="text" placeholder="复制淘宝商品标题 粘贴搜索" id="search" value="{{$search}}">
          </label>
          <a class="closeBtn dn"><img src="{{ asset('/clientapp/images/closeIcon.png') }}"></a>
          <a class="searchBtn" href="javascript:goSearch(1);">搜索</a>
        </div>
      </div>
    </div>
    <div class="card-body over ">
      <div class="scrolly">
        <div class="loading" id="loading"></div>
          <div class="listBox">
            <div class="div-instruction">
              <ul class="instruction-list">
                <li>
                  <div class="instruction-background">
                    <img src="{{ asset('/client/images/search/copy.png') }}" />
                  </div>
                </li>
                <li>打开手机淘宝/天猫，长按商品标题“拷贝”</li>
                <li>粘贴搜索框，查找优惠卷</li>
              </ul>
              
            </div>
          </div>
          <div class="lastHint">下拉显示更多产品...</div>
      </div>
    </div>

  </section>

<script>
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
      if ($(".insearch input").val() != "") {
          $('.closeBtn').show(0);
        }

      $(".insearch input").bind("input propertychange", function (event) {
        let that = $(this);
        if (that.val() == "") {
          $('.closeBtn').hide(0);
        } else if (that.val() != "") {
          $('.closeBtn').show(0);
        }
      });
      $('.closeBtn').click(function(){
        $(".insearch input").val('');
        $(this).hide(0);
      });
    });

  </script>


</body>

</html>