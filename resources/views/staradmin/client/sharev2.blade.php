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
$url = env('APP_URL_share', 'http://wabao777.com') . '/vvregister/' . $affiliate_id;  

include(app_path().'/Lib/qr/qrlib.php');

$filename = public_path().'/client/qr/'.$affiliate_id.'.png';

//QRcode::png($url, $filename, 'L', '3', 2);  //old
QRcode::png($url, $filename, 'L', '3', 2); 

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

<!-- 活动规则 rules -->
<div class="modal fade col-md-12" id="rules-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
    <div class="modal-dialog modal-lg close-modal" role="document">
      <div class="modal-content">
        <div class="modal-body">        
          <div class="modal-row">
            <div class="wrapper modal-full-height">
              <div class="modal-card">
                <div class="modal-title">
                  活动规则说明
                </div>
                <div class="instructions">
                  <p>邀请1个好友可获得1次抽奖补贴，而你的好友能获得1次新人抽奖补贴，你的好友每邀请1个好友，你还可以获得1次抽奖补贴，邀请越多，抽奖补贴越多。
                    <br><br>
                    每次抽奖补贴有98.43%概率获得12元。
                    <br><br>
                    好友需通过网站的微信认证，你才能得到抽奖补贴次数。 严厉打击小号注册领取福利。
                  </p>
                </div>
                <div class="close-modal modal-warning-button">
                  知道了
                </div>
              </div>
            </div>
          </div>              
        </div>
      </div>
    </div>
  </div>

    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function () {
        $('.rules').click(function () {
          $('#rules-modal').modal();
        });

        $('.close-modal').click(function() {
          $('.modal').modal('hide');
          $('.modal-backdrop').remove(); 
        });

      });
    </script>

@endsection
