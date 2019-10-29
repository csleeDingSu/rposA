<div class="card-bar">  
  <dl class="bar">
    <dd>
	@if(Request::is('main') || Request::is('main/*'))
  		<a class="on" id="f-main">
  	@else
  		<a id="f-main">
  	@endif
        <span class="icon bar-1"></span>
        <h2>首页</h2>
      </a>
    </dd>
    <dd>
	@if(Request::is('shop') || Request::is('shop/*'))
  		<a class="on" id="f-shop">
  	@else
  		<a id="f-shop">
  	@endif
        <span class="icon bar-2"></span>
        <h2>商城</h2>
      </a></dd>
    <dt>
    @if(Request::is('arcade') || Request::is('arcade/*'))
  		<a class="on" id="f-arcade">
  	@elseif(Request::is('vip') || Request::is('vip/*'))
  		<a class="on" id="f-vip">
  	@else
  		<a id="f-arcade">
  	@endif
        <span class="icon bar-center">
          <img src="{{ asset('clientapp/images/bar-m.png') }}">
        </span>
        <h2>抽奖</h2>
      </a></dt>
    <dd>
    @if((Request::is('blog') || Request::is('blog/*')) && (!Request::is('blog/my-redeem')))
  		<a class="on" id = "f-blog">
  	@else
  		<a id = "f-blog">
  	@endif
        <span class="icon bar-3"></span>
        <h2>晒单</h2>
      </a></dd>
    <dd>
      
    @if((Request::is('profile') || Request::is('profile/*')) || (Request::is('blog/my-redeem') || Request::is('pre-share')))
  		<a class="on" id = "f-profile">
  	@else
  		<a id = "f-profile">
  	@endif
        <span class="icon bar-4"></span>
        <h2>我的</h2>
      </a></dd>
  </dl>
</div>

<!-- <link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/footer.css')}}" /> -->

    @if( Agent::is('OS X') ) 
      <style>        
      .card-bar
        {
          margin-bottom: 0px !important;
          position: fixed;
          left: 0;
          bottom: 0;
          width: 100%;
          padding-bottom: env(safe-area-inset-bottom);
          position: sticky; 
          position: -webkit-sticky;
          position: -moz-sticky;
          position: -o-sticky;
        }   
        
        /*iphone X*/
        @media only screen  
          and (device-width : 375px) 
          and (device-height : 812px) 
          and (-webkit-device-pixel-ratio : 3) {
            .footer_mb
            {
              height: 1.28rem;

            }

            @keyframes newbie {
              from {
                top: 81.8%;
              }
              to {
                top: 82.8%;
              }
            }
          }

          /*iPhone 7/8*/ 
          @media only screen 
            and (device-width : 375px) 
            and (device-height : 667px) 
            and (-webkit-device-pixel-ratio : 2) {
              @keyframes newbie {
                from {
                  top: 80.5%;
                }
                to {
                  top: 81.5%;
                }
              }
            }

          /*iPhone 6+/6s+/7+/8+*/
          @media only screen 
            and (device-width : 414px) 
            and (device-height : 736px) 
            and (-webkit-device-pixel-ratio : 3) {
              @keyframes newbie {
                from {
                  top: 80.5%;
                }
                to {
                  top: 82.5%;
                }
              }
            }

      </style>
    @endif


<script type="text/javascript">
    	
(function(){

  // Really basic check for the ios platform
  // https://stackoverflow.com/questions/9038625/detect-if-device-is-ios
  var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

  // Get the device pixel ratio
  // var ratio = window.devicePixelRatio || 1;

  // Define the users device screen dimensions
  // var screen = {
  //   width : window.screen.width * ratio,
  //   height : window.screen.height * ratio
  // };

  // iPhone X Detection
	// && screen.width == 1125 && screen.height === 2436
  if (iOS) {
    $(".card-bar").addClass("footer_mb");
  }
})();

  $('#f-main').on('touchend', function(){    
    $('#f-main').addClass("on");
    $('#f-shop').removeClass("on");
    $('#f-arcade').removeClass("on");
    $('#f-vip').removeClass("on");
    $('#f-blog').removeClass("on");
    $('#f-profile').removeClass("on");
    window.top.location.href = "/main";
  });

  $('#f-shop').on('touchend', function(){    
    $('#f-main').removeClass("on");
    $('#f-shop').addClass("on");
    $('#f-arcade').removeClass("on");
    $('#f-vip').removeClass("on");
    $('#f-blog').removeClass("on");
    $('#f-profile').removeClass("on");
    window.top.location.href = "/shop";
  });

  $('#f-arcade').on('touchend', function(){    
    $('#f-main').removeClass("on");
    $('#f-shop').removeClass("on");
    $('#f-arcade').addClass("on");
    $('#f-vip').removeClass("on");
    $('#f-blog').removeClass("on");
    $('#f-profile').removeClass("on");
    window.top.location.href = "/arcade";
  });

  $('#f-vip').on('touchend', function(){
    $('#f-main').removeClass("on");
    $('#f-shop').removeClass("on");
    $('#f-arcade').removeClass("on");
    $('#f-vip').addClass("on");
    $('#f-blog').removeClass("on");
    $('#f-profile').removeClass("on");
    window.top.location.href = "/vip";
  });

  $('#f-blog').on('touchend', function(){
    $('#f-main').removeClass("on");
    $('#f-shop').removeClass("on");
    $('#f-arcade').removeClass("on");
    $('#f-vip').removeClass("on");
    $('#f-blog').addClass("on");
    $('#f-profile').removeClass("on");
    window.top.location.href = "/blog";
  });

  $('#f-profile').on('touchend', function(){
    $('#f-main').removeClass("on");
    $('#f-shop').removeClass("on");
    $('#f-arcade').removeClass("on");
    $('#f-vip').removeClass("on");
    $('#f-blog').removeClass("on");
    $('#f-profile').addClass("on");
    window.top.location.href = "/profile";
  });

    </script>