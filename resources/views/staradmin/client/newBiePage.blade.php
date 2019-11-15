@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/newBiePage.css') }}" />
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

@section('title', '新人0元购')

@section('top-navbar')    
@endsection

@section('content')

<div class="box">
   <input id="hidPageId" type="hidden" value="" />
   <input id="hidisMacDevices" type="hidden" value="{{empty($isMacDevices) ? false : $isMacDevices}}" />
   <input id="hidDOWNLOAD_APP_IOS" type="hidden" value="{{env('DOWNLOAD_APP_IOS', '#')}}" />
   <input id="hidDOWNLOAD_APP_ANDROID" type="hidden" value="{{env('DOWNLOAD_APP_ANDROID', '#')}}" />

  <div class="logo rel logo3-zero">
    <div class="c-header">
    </div>
    <a class="download-app"><img src="{{ asset('clientapp/images/newbie/download.png') }}"></a>
  </div>

  <div class="listBox">
  @include('/client/newbie_static_product')
     
  </div>
  <div class="lastHint">下拉显示更多产品...</div>
  <hr class="h36">
</div>

@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/clientapp/js/newBiePage.js') }}"></script>
    <script type="text/javascript">
      var gURL = "/download-app";

      $(document).ready(function () {
        checkDownload();
      });      
      
      function checkDownload() {
        var isMacDevices = "{{ $isMacDevices }}";
        var DOWNLOAD_APP_IOS= "{{env('DOWNLOAD_APP_IOS', '#')}}";      
        var DOWNLOAD_APP_ANDROID= "{{env('DOWNLOAD_APP_ANDROID', '#')}}";        
        var ua = navigator.userAgent.toLowerCase();
        var _url = "/download-app";

        if (ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) {
            console.log('in weixin');              
            gURL = _url;
            $('.download-app').click(function () {
                window.location.href = _url;
              });
              $('.go-url').click(function () {
                window.location.href = _url;
              });

          }else{
            console.log('out from weixin');
            gURL = DOWNLOAD_APP_IOS;
              // if (isMacDevices) {
              //   window.location.href = DOWNLOAD_APP_IOS;
              // } else {
              //   window.location.href = DOWNLOAD_APP_IOS; //DOWNLOAD_APP_ANDROID;
              // }
              $('.download-app').click(function () {
                window.location.href = DOWNLOAD_APP_IOS;
              });
              $('.go-url').click(function () {
                window.location.href = DOWNLOAD_APP_IOS;
              });
          }
      }
    
</script>

@endsection