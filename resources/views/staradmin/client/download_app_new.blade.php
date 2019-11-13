@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/download_app_new.css') }}" />
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
    
@endsection

@section('top-javascript')
    @parent
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

@endsection

@section('title', '下载挖宝APP')

@section('top-navbar')    
@endsection

@section('content')

<div class="box">
        
        <div class="logo rel logo3-zero">
          <div class="c-header">
            <div class="pageHeader rel">
              <p>点击右上角</p>
              <p>选着Safari或浏览器</p>
              <p>即可下载<span class="highlight">挖宝APP</span></p>
            </div>
          </div>
        </div>

        <div class="listBox">
          <div class="inBox-download">
            <a><img class="logo" src="{{ asset('clientapp/images/newbie/logo.png') }}"></a>            
            <p class="guanfang">挖宝商城<img src="{{ asset('clientapp/images/newbie/guanfang.png') }}"></p>
            <p>6 万次下载 | 5.8MB</p>
            <p><img class="star" src="{{ asset('clientapp/images/newbie/star.png') }}"></p>
          </div>
        </div>
</div>

@endsection

@section('footer-javascript')
    @parent  
    <script type="text/javascript">
      $(document).ready(function () {
        checkDownload();
      });      
      
      function checkDownload() {
        var isMacDevices = "{{ $isMacDevices }}";
        var DOWNLOAD_APP_IOS= "{{env('DOWNLOAD_APP_IOS', '#')}}";      
        var DOWNLOAD_APP_ANDROID= "{{env('DOWNLOAD_APP_ANDROID', '#')}}";        
        var ua = navigator.userAgent.toLowerCase();

        if (ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) {
            console.log('in weixin');              
            return false;
          }else{
            console.log('out from weixin');
              if (isMacDevices) {
                window.location.href = DOWNLOAD_APP_IOS;
              } else {
                window.location.href = DOWNLOAD_APP_IOS; //DOWNLOAD_APP_ANDROID;
              }
          }
      }
    
</script>

@endsection