@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/sharev2.css') }}" />
    
@endsection

@section('top-javascript')
    @parent

@endsection

@section('title', '分享给好友')

@section('top-navbar')    
@endsection

@section('content')
<?php

$affiliate_id = Auth::Guard( 'member' )->user()->affiliate_id;
if (env('THISVIPAPP', false)) {
  $url = env('APP_URL_share', 'http://wabao777.com') . '/external/register/' . $affiliate_id;
} else {
  $url = env('APP_URL_share', 'http://wabao777.com') . '/register/' . $affiliate_id;  
}


include(app_path().'/Lib/qr/qrlib.php');

$filename = public_path().'/client/qr/'.$affiliate_id.'.png';

//QRcode::png($url, $filename, 'L', '3', 2);  //old
QRcode::png($url, $filename, 'L', '5.5', 2); 

$showIcon = $filename;

$showimage = $showIcon; //public_path( 'client/bar/'.$data->filename );
//$showIcon = "https://chart.googleapis.com/chart?chs=190x190&cht=qr&chl=$url&choe=UTF-8";
//$mainimg = imagecreatetruecolor( 500, 500 );

$mainimg = imagecreatefrompng( $showIcon );

if (strpos(strtolower($showimage), '.png') !== false) {
    $image = imagecreatefrompng( $showimage );
}else {
  $image = imagecreatefromjpeg( $showimage );
}

$white = imagecolorallocate( $mainimg, 255, 255, 255 );

//imagecolortransparent( $mainimg, $white );
imagefill( $mainimg, 0, 0, $white );

// Merge the red image onto the PNG image
//imagecopymerge( $image, $mainimg, -10, 611, 0, 0, 190, 190, 100 );

// imagecopymerge( $image, $mainimg, 13, 641, 0, 0, 132, 132, 100 );
//imagecopymerge( $image, $mainimg, 21, 663, 0, 0, 100, 100, 100 ); //old
// imagecopymerge( $image, $mainimg, 190, 400, 9, 9, 120, 120, 100 ); //for img3.jpeg
imagecopymerge( $image, $mainimg, 0, 0, 0, 0, 0, 0, 0);

ob_start();
imagepng( $image );
$imgData = ob_get_clean();
imagedestroy( $image );

?>

<div class="box">
        <div class="back-ground">
          <div class="c-header">
            <div class="pageHeader rel">
              <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/zero-back-.png') }}"><span>返回</span></a>
              <h2 class="h-title">分享给好友</h2>
              <a class="rules">活动规则</a>
            </div>
          </div>       
          
          <div class="shareBox">
            <div class="qrcode">
              <?php echo '<img  class="small-img" src="data:image/png;base64,'.base64_encode($imgData).'"/>';?>
            </div>
            <div class="instruction1"><img class="icon-thumb" src="{{ asset('/clientapp/images/share/icon-thumb.png') }}">长按扫一扫</div>
            <div class="instruction2">注册下载APP有福利</div>
            <div class="instruction3">
              <p>分享先请载图保存</p>
              <p>再发微信好友或朋友圈</p>
            </div>
          </div>

        </div>

        
        <hr class="h36">
</div>
<!-- <span id="copy" class="offscreen url" aria-hidden="true">{{$url}}</span> -->
@endsection

@section('footer-javascript')      
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

@endsection
