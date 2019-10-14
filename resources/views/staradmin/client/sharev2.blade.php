@extends('layouts.default_app')

@section('title', '分享给朋友')

@section('top-css')
    @parent
    <style>
   #loading {
     /*
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    position: fixed;
    display: block;
    opacity: 0.95;
    background-color: #ff4456;
    z-index: 99;
    text-align: center;
     */
     
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('/client/images/preloader.gif') center no-repeat;
    background-color: rgba(0, 0, 0, 0);
  background-color: rgba(255, 255, 255, 0.9);
  background-size: 32px 32px;
}


</style>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

<style>
    
        .offscreen {
            position: absolute;
            left: -999em;
        }
        
        @media only screen and (min-device-width:1000px) {
            .fotos {
                left: -100px;
            }
        }
        
        .child
        {
          overflow: hidden; /* required */
          width: 80%; /* for demo only */
          position: relative; /* required  for demo*/

          margin: 0 auto;
          text-align: center;
          vertical-align:middle;
          
          padding: 25 25 25 25;
          margin-bottom:5px;
          background: url("{{ asset('cshare/images/bg.png') }}") no-repeat;
          background-size: 100%;
         
          /*this to solve "the content will not be cut when the window is smaller than the content": */
          max-width:100%;
          max-height:100%;
        }
        
      .child img {
        max-width: 100%;
        max-height: 100%;
        height: auto;
      }
      .closebtn {
        display: block;
        width: 80%; 
        border: thin;
        font-size: 0.4rem;
        color: #57606f;
        line-height: 0.84rem;
        outline: none;
        border-radius: 0.42rem;
        -webkit-border-radius: 0.42rem;
        -moz-border-radius: 0.42rem;
        -ms-border-radius: 0.42rem;
        -o-border-radius: 0.42rem;
        background-color: #e6e6e6;
      }
        
      .box{
        min-width:160;
        padding: 10 10 10 10;
        text-align: center;
      }
        
      .openFrom{
         background: #fff;
         border-radius:.1rem .1rem 0 0 ;
         -webkit-border-radius:.1rem .1rem 0 0 ;
         -moz-border-radius:.1rem .1rem 0 0 ;
         -ms-border-radius:.1rem .1rem 0 0 ;
         -o-border-radius:.1rem .1rem 0 0 ;
         position: absolute;
         display: none;
         bottom:0;
         max-height: 80%;
         overflow-y: auto;
         z-index: 20;
         width: 100%;
         left: 0;
      }

      .openFrom .title{
          font-size: .36rem; 
          padding: 0 !important;
          text-align: center;
          color: #333;
          border-bottom:.012rem solid #e0e0e0;
          margin-left: 0px !important;
      }

      .modelimg {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-image: url("{{ asset('cshare/images/model.png') }} ");
          background-repeat: no-repeat;
          background-size: contain;float: left;
      }
         
      .swal-size-sm 
      {
         width: 200px !important;
          height: 200px !important;
      }
      
      .fit { /* set relative picture size */
          max-width: 100%;
          max-height: 100%;
      }
      .center {
          display: block;
          margin: auto;
      }
      .head2
      {

        font-size: 0.4rem;
        color: grey;
        line-height: 0.7rem;
        text-align: center;
      }

      .head3
      {

        font-size: 0.3rem;
        color: grey;
        line-height: 0.6rem;
        text-align: center;
      }

      .detail {
        padding: 0.24rem 0.24rem 0.24rem;
      }

      .detail h2 {
        color: grey;
        font-size: 0.5rem;
        line-height: 0.8rem;
        text-align: center;
      }

      .detail h3 {
        font-size: 0.35rem;
        color: grey;
        line-height: 0.7rem;
        text-align: center;
      }
    
    .overlay {
      position: absolute;
      margin-top: 30px;
      margin-right: 30px;
      color:#F5F654;
      right: 0;
      top: 0;
      width: 60px;
      z-index: 1;
      text-align: center;
      /*line-height: 20px;*/
          opacity: 1.2;
      background:rgba(0,0,0,0.3);
    
    vertical-align:middle;
    max-width: 80px;
    padding: 2px;
    /*text-align: center;cursor:pointer;*/

border-radius: 20px;
    font-size: 10px;
  }

       
    </style>

@endsection

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
QRcode::png($url, $filename, 'L', '3.6', 5); 

$showIcon = $filename;

$showimage = public_path( 'client/bar/'.$data->filename );
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
imagecopymerge( $image, $mainimg, 187, 542, 9, 9, 120, 120, 100 );

ob_start();
imagepng( $image );
$imgData = ob_get_clean();
imagedestroy( $image );

?>

    <input id="hidUserId" type="hidden" value="" />
    
    <div class="card-header">
        <div class="header-line">            
              <div class="shop-left-menu">
                <img class="clscoin" src="{{ asset('/clientapp/images/shop/coin.png') }}">
                <div class="shop-balance">99999.99</div>
                <a href="javascript:openModal('faq-coinsource');">
                  <img class="clsquestion" src="{{ asset('/clientapp/images/shop/question-icon.png') }}">
                </a>
              </div>
            <a class="shop-right-menu" href="/redeem/history"><img src="{{ asset('/clientapp/images/shop/icon-my-redeem.png') }}"></a>
        </div>
    </div>

    <div class="redeem-prize-wrapper"></div>

    <hr class="h36">

@endsection

@section('footer-javascript')      
    @parent

@endsection
