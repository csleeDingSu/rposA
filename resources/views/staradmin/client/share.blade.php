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
}


</style>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<div id="loading">
    
</div>
<?php

$affiliate_id = Auth::Guard( 'member' )->user()->affiliate_id;

$url = env('APP_URL_share', 'http://wabao777.com') . '/vregister/' . $affiliate_id;

include(app_path().'/Lib/qr/qrlib.php');

$filename = public_path().'/client/qr/'.$affiliate_id.'.png';

QRcode::png($url, $filename, 'L', '7', 2); 

$showIcon = $filename;


//echo $filename;
//die();
$showimage = public_path( 'client/bar/image.jpg' );

//$showIcon = "https://chart.googleapis.com/chart?chs=190x190&cht=qr&chl=$url&choe=UTF-8";

//$mainimg = imagecreatetruecolor( 500, 500 );

$mainimg = imagecreatefrompng( $showIcon );

$image = imagecreatefromjpeg( $showimage );

$white = imagecolorallocate( $mainimg, 255, 255, 255 );

//imagecolortransparent( $mainimg, $white );
imagefill( $mainimg, 0, 0, $white );

// Merge the red image onto the PNG image
//imagecopymerge( $image, $mainimg, -10, 611, 0, 0, 190, 190, 100 );

// imagecopymerge( $image, $mainimg, 13, 641, 0, 0, 132, 132, 100 );
imagecopymerge( $image, $mainimg, 133, 412, 0, 0, 230, 230, 100 );


ob_start();
imagepng( $image );
$imgData = ob_get_clean();
imagedestroy( $image );

?>

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
        
      .ribbon {
        position: absolute;
        left: -5px; top: -5px;
        z-index: 1;
        overflow: hidden;
        width: 75px; height: 75px;
        text-align: right;
      }
      .ribbon span {
        font-size: 10px;
        font-weight: bold;
        color: #FFF;
        text-transform: uppercase;
        text-align: center;
        line-height: 20px;
        transform: rotate(-45deg);
        -webkit-transform: rotate(-45deg);
        width: 100px;
        display: block;
        background: #FFBA00;
        background: linear-gradient(#FFBA00 0%, #FFBA00 100%);
        box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
        position: absolute;
        top: 19px; left: -21px;
      }
      .ribbon span::before {
        content: "";
        position: absolute; left: 0px; top: 100%;
        z-index: -1;
        border-left: 3px solid #FFBA00;
        border-right: 3px solid transparent;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #FFBA00;
      }
      .ribbon span::after {
        content: "";
        position: absolute; right: 0px; top: 100%;
        z-index: -1;
        border-left: 3px solid transparent;
        border-right: 3px solid #FFBA00;
        border-bottom: 3px solid transparent;
        border-top: 3px solid #FFBA00;
      }
        
      .c_button {
        display: block;
        width: 100%;
       
        border: none;
        font-size: 0.4rem;
        color: #fff;
        line-height: 0.84rem;
        outline: none;
        border-radius: 0.42rem;
        -webkit-border-radius: 0.42rem;
        -moz-border-radius: 0.42rem;
        -ms-border-radius: 0.42rem;
        -o-border-radius: 0.42rem;
              
        background-image: url("{{ asset('cshare/images/btn.png') }}");
        background-repeat: no-repeat;
        background-size: cover;background-size: 100% 100%;
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

       
    </style>

@section('top-javascript')
@endsection 

@section('modelcontent')

<section class="openFrom">
   
      <div class="row justify-content-center headrow" style="margin-top: 10px; padding-left: 33%">    
       <span class="head2">分享到微信的方法</span>
     </div>     
     <div class="row justify-content-center headrow" style="margin-top: 10px; padding-left: 16%">    
       <span class="head3">按住宣传图3秒 > 选择分享图片 > 选择微信</span>
     </div>
    
    
    
    
    <div class="modelfimgs">
        <img class="center fit" src="{{ asset('cshare/images/model.png') }}"><br>
    </div>
    
    <div class="menu" align="center" style="padding-bottom: 60px;">
             
              <button class="closebtn rounded" name="closebtn" id="closebtn" type="button">知道了</button>
            </div>
    
</section>

<span id="copy" class="offscreen url" aria-hidden="true">{{$url}}</span>



                
<script type="text/javascript">
 function set_body_height() { // set body height = window height
        $('body').height($(window).height());
    }
    $(document).ready(function() {
        $(window).bind('resize', set_body_height);
        set_body_height();
    });
                                
					var clipboard = new ClipboardJS('.copyurl');
                    console.log(clipboard);
					clipboard.on('success', function(e) {
						
						e.clearSelection();
                       // alert('success');
						/*swal({  type: 'success',  title: '@lang("dingsu.copied")!',text: '@lang("dingsu.text_copied")', confirmButtonText: '@lang("dingsu.okay")',customClass: 'swal-size-sm',}).then(
						  function () { 
							   if( navigator.userAgent.match(/Android/i)
								 || navigator.userAgent.match(/webOS/i)
								 || navigator.userAgent.match(/iPhone/i)
								 || navigator.userAgent.match(/iPad/i)
								 || navigator.userAgent.match(/iPod/i)
								 || navigator.userAgent.match(/BlackBerry/i)
								 || navigator.userAgent.match(/Windows Phone/i)
								 ){
							  // window.open(
								  // 'weixin://',
								  // '_blank' 
								// ); 
							   }
						  },

						)
                        */
					});

					clipboard.on('error', function(e) {
						console.error('Action:', e.action);
						console.error('Trigger:', e.trigger);
					});

    
    
                    $("#closebtn").click(() => {
                        being.wrapHide();
                        $(".openFrom").slideDown(150);
                        $(".openFrom").hide();
                        
                      });
    
                            $(".c_button").click(() => { 
                                being.wrapShow();
                                $(".openFrom").slideDown(150);
                                $(".wrapBox ").click(function (e) {
                                  being.wrapHide();
                                  $(".openFrom").slideUp(150);
                                });
                              });

</script>

@endsection 

@extends( 'layouts.share' )

@section( 'title', '分享给朋友' )



@section( 'top-css' )
@parent
 

@endsection 
@section('content')

 <div class="container">
  <div class="detail">
      
      <h2>分享给好友赚挖宝机会</h2>
       <h3>每邀请<span style="color: red;"> 1 </span>个好友获得<span style="color: red;"> {{ env('sharetofriend_youwillget', '3') }} </span>次机会</h3>
     <h3>被邀请的好友获得<span style="color: red;"> {{ env('sharetofriend_friendwillget', '1') }} </span>次机会</h3>
     
</div>



    <div class="container9 center" style="background-color: #ffff; padding-bottom: 25px !important;">

        <div class="box box-horizontal">
            <div class="parent">
                
                <div class="child copyurl" data-clipboard-target="#copy">
                    
                    
                    <div class="ribbon ribbon-top-left">
                      <span>@lang('dingsu.copy')</span>
                    </div>
                    
                    
                    <?php echo '<img  class="small-img" id="copyurl"  src="data:image/png;base64,'.base64_encode($imgData).'"/>';?>
                </div>
            </div>
        </div>


        <div class="box box-horizontal" >
            <div class="btndiv" align="center" style="display: inline-block; width: 80%;">
                <button class="c_button" name="c_button" id="c_button" type="button">查看分享方法</button>
            </div>
            
        </div>
    

    </div>
</div>



<script>
  $(window).load(function() {
    
    $('#loading').hide();
});
</script>
@endsection