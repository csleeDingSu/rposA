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
  background-size: 62px 62px;
}


</style>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<div id="loading">
    
</div><?php

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


    <style>
    
    </style>


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

@section('top-javascript')
@endsection 

@section('modelcontent')

<section class="openFrom">
   
      <div class="row justify-content-center headrow" style="margin-top: 10px; padding-left: 33%">    
       <span class="head2">分享到微信的方法</span>
     </div>     
     <div class="row justify-content-center headrow" style="margin-top: 10px; padding-left: 16%">    
       <span class="head3">按住广告图3秒 > 分享图片 > 微信好友</span>
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
    
                            $(".btn_ribbon").click(() => {  
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


<style>
  
  body {overflow: hidden;}
  
  .bottom {
  text-align: -webkit-auto;
  ;color: #FFF;font-style: normal;
         margin-bottom: 0.4rem;
         margin-top: 1rem;
         line-height: 2;
         height: 15%;
}
h1 {
  text-align: center;color: #FFF;font-size: 0.35rem;
  padding:0.2rem;
}

h1:before, h1:after {
  display: inline-block;
  width: 81px;
  height: 1px;
  content: '';
}

h1:before {
  background: url("{{ asset('cshare/images/bottomline.png') }}") ;
  vertical-align: middle;
  background-position: 6%,10%;
  margin-right:20px;
}

h1:after {
  background: url("{{ asset('cshare/images/bottomline.png') }}") right no-repeat ;
  vertical-align: middle;
  background-position: 96%;
  margin-left:20px;
}
  .bottomdiv
  {
    font-size: 0.25rem;
  }
  .container
  {
    background-image: url("{{ asset('cshare/images/bgnew.png') }}");
    background-size:contain;
    background-repeat:no-repeat;
    background-color: #FF6d7d;
    /*height: 12.4rem;*/
  }
  
  .small-img
  {
    border:0.25rem solid #fff9dc;
      background-color:#EFEFEF;
    /*width: auto;*/
    width: 5rem;
    height: auto;
    max-width: 100%;
        max-height: 100%;
    margin-bottom: 0.2rem;

    background: linear-gradient(#FFDE03 0%, #FFDE03 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);

  }
  .ribbon-holder {
  
  position: relative;
  padding: 0.2rem !important;
  padding-top: 2.1rem !important;
}

.ribbon {
  position: absolute;
  object-fit: contain;
  /*left: -5px; top: 141px;*/
  z-index: 1;
  overflow: hidden;
  width: 2.5rem; height: 1.5rem;
  /*text-align: right;*/
  margin-left:0.88rem;
}
.ribbon span {
  margin:0.2rem;
  font-size: 0.3rem;
  font-weight: bold;
  color: #FFF;
  text-transform: uppercase;
  text-align: center;
  line-height: 0.6rem;
  /*transform: rotate(-45deg);*/
  -webkit-transform: rotate(-45deg);
  width: 100%;
  display: block;
  /*background: #FFDE03;*/
  background: linear-gradient(#FFDE03 0%, #FFDE03 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  left: -1rem;
} 
  
  .clickribbon {
    position: absolute;
  object-fit: contain;
  overflow: hidden;
  
  background: #fff;
  background-color: #fff;
  top: 2.6rem;
  right: 1.5rem;
    opacity: 1.2;
      background:rgba(0,0,0,0.3);
    color: #fff;
    z-index: 1;
    text-align: center;vertical-align:middle;
    border-radius: 0.3rem;
    padding: 0.1rem;
    cursor: pointer;
    width: 15%;
    font-size:0.2rem;
}
  
.btn_ribbon_old {
  position: absolute;
  background-color: #e43;
  top: 9.9rem;
  right: 1.3rem;
    opacity: 1.2;
      background:rgba(0,0,0,0.0);
    color: #FFF;z-index: 1;
    text-align: center;vertical-align:middle;
    border-radius: 0.25rem;
    padding: 0.1rem;
    cursor: pointer;
   background-image: url("{{ asset('cshare/images/btn.png') }}");
        background-repeat: no-repeat;
        background-size: cover;background-size: 100% 100%;
  font-size: 0.35rem;
  width: 4.5rem;
} 

.btn_ribbon {
    position: absolute;
    width: 4.5rem;
    margin-left: -4.75rem;
    margin-top: 7.9rem;
}

.ribbon_img {
  position: absolute;
    width: 15%;
}

ol {
    counter-reset:item; 
    margin:0; 
    padding-left:0; 
}
ol>li {
    counter-increment:item; 
    /*list-style:none inside; 
    margin: 40px 0;*/
    overflow: hidden;
    /*font-size: 16px !important;
    line-height: 1.3;*/

}

ol>li:before {
    content:counter(item) ;
    /*margin-right: 0.1rem;*/
    /*padding-bottom: 0.25rem;*/
    display: block;
    /*-webkit-border-radius: 50%;*/
    /*-moz-border-radius: 50%;*/
    border-radius: 50%;
    width: 0.25rem;
    height: 0.25rem;
    background: #f7d344;
    color: #fff;
    text-align: center; 
    font: 0.2rem 'Lato', Helvetica, Arial, sans-serif;
    font-weight: 100;
    float: left;
    color: #8873e1;
    margin-top:0.14rem;
}

.padding-left {
  padding-left: 0.4rem;
}

  .header_pr {
        left: 0;
        width: 100%;
        top: 0;
        zoom: 1;

        -webkit-transform: translateY(0) translateX(0);
        transform: translateY(0) translateX(0);
        -webkit-transform: 0;
        -moz-transform: 0;
        -ms-transform: 0;
        transform: 0;
        position: fixed;
        z-index: 160;
        border-bottom: solid 1px #ddd;

    }

    .header_goods {
        background: 0 0;
        border-bottom: 0;
        padding:10px;
    }
    .icon_header {
        width: 100%;
        line-height: 45px;
        position: relative;
    }
    .icon_header, .icon_header>a {
        z-index: 5;
        height: 45px;
        zoom: 1;
    }

    .header_goods .icon_header>a {
        display: inline-block;
        height: 50px;
        color: #fff;
        width: 50px;
        line-height: 30px;
        background: rgba(0,0,0,.3);
        border-radius: 100px;
        top: 7px;
        left: 7px;
    }

  .icon-zuojiantou:before {
      content: "<";
  }
  .fa-angle-left {
    color: white;
    padding:10px;
    padding-left:16px;
  }
  
  @media only screen and (min-width: 300px) { .ribbon { margin-left: 0.71rem !important; } }

@media only screen and (min-width: 350px) { .ribbon { margin-left: 0.74rem !important; } }

@media only screen and (min-width: 370px) { .ribbon { margin-left: 0.75rem !important; } }

@media only screen and (min-width: 400px) { .ribbon { margin-left: 0.88rem !important; } }

@media only screen and (min-width: 410px) { .ribbon { margin-left: 0.78rem !important; } }

@media only screen and (min-width: 500px) { .ribbon { margin-left: 0.88rem !important; } }

@media only screen and (min-width: 700px) { .ribbon { margin-left: 0.91rem !important; } }

@media only screen and (min-width: 900px) { .ribbon { margin-left: 2.5rem !important; } }

@media only screen and (min-width: 950px) { .ribbon { margin-left: 2rem !important; } }

@media only screen and (min-width: 1100px) { .ribbon { margin-left: 3rem !important; } }

   </style>

  <div class="header_pr header_goods ">
    <header class="icon_header">
      <a href="javascript:history.back()" class="iconfont fa fa-angle-left fa-2x" aria-hidden="true"></a>
    </header> 
  </div>

<div class="container">

  <div class="ribbon-holder" align="center">
    <!-- <div class="ribbon"><span>@lang('dingsu.ads_picture')</span></div> -->
    <!-- <div class="clickribbon" onClick="location.reload();"> @lang('dingsu.change_picture') </div> -->
    <img class="ribbon_img" src="{{asset('/cshare/images/ribbon.png')}}" >
    <!-- <div class="btn_ribbon ">&nbsp;</div> -->

    <?php echo '<img  class="small-img" src="data:image/png;base64,'.base64_encode($imgData).'"/>';?>
    
    <img class="btn_ribbon" src="{{asset('/cshare/images/btn.png')}}" >

      <div class="bottom">
        <h1>奖励说明</h1>
        <div class="bottomdiv">
          <ol>
            <li><div class="padding-left">邀请1个好友可获得1次抽奖补贴，而你的好友能获得2次新人抽奖补贴，你的好友每邀请1个好友，你还可以获得1次抽奖补贴，邀请越多，抽奖补贴越多。              
            </div>
          </li>
          <li><div class="padding-left">
            每次抽奖补贴有98.43%概率获得6元。
          </div>
          </li>
          <li><div class="padding-left">好友需通过网站的微信认证，你才能得到抽奖补贴次数。 严厉打击小号注册领取福利。
          </div>
          </li>
        </ol>
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