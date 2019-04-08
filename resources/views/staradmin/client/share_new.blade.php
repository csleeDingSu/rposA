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
    
</div><?php

$affiliate_id = Auth::Guard( 'member' )->user()->affiliate_id;

$url = env('APP_URL_share', 'http://wabao777.com') . '/vregister/' . $affiliate_id;

include(app_path().'/Lib/qr/qrlib.php');

$filename = public_path().'/client/qr/'.$affiliate_id.'.png';

//QRcode::png($url, $filename, 'L', '3', 2);  //old
QRcode::png($url, $filename, 'L', '3.6', 5); 
$showIcon = $filename;

$showimage = public_path( 'client/bar/'.$data->filename );

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
//imagecopymerge( $image, $mainimg, 21, 663, 0, 0, 100, 100, 100 ); //old
imagecopymerge( $image, $mainimg, 177, 355, 0, 0, 140, 125, 100 );

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
  text-align: center;color: #FFF;font-style: normal;
			   margin-bottom: 40px;
}h1 {
  text-align: center;color: #FFF;font-size: 32px;
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
}

h1:after {
  background: url("{{ asset('cshare/images/bottomline.png') }}") right no-repeat ;
	vertical-align: middle;
	background-position: 96%;
}
	.bottomdiv
	{
		font-size: 24px;
	}
	.container
	{
		/*position: absolute; new*/
		/*padding-bottom: 20px !important;*/
		position: relative;
    	/*top: 0; right: 0; bottom: 0; left: 0;*/
		background-image: url("{{ asset('cshare/images/bgnew.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
		background-size: 100% 100%;
		background-color: #FF6d7d;
		max-width: 500px;
		background-position: top;
		
		display: flex;
  		flex-flow: column wrap;
    	width: auto;
		/*max-width: 65%;*/
        /*max-height: 80%;*/
		/*height: calc(100vh - 50px);
    /*height: 2000px;*/
		
		background-position: 0px -30px; 
		max-height: 800px;
		
	}
	
	.small-img
	{
		border:15px solid #EFEFEF;
   		background-color:#EFEFEF;
		width: auto;
		height: auto;
		max-width: 100%;
        max-height: 100%;
		margin-bottom: 15px;
	}
	.ribbon-holder {
  
  position: relative;
		/**/
/*


margin-top: 47%;*/
		max-width: 77%;
		margin-left: 13%;
		
		padding: 44% 0 0 0;
		padding-right: 4px;
        clip: rect(auto, 80px, auto, auto);
	border-top: solid 35% rgba(0, 0, 0, 0);
}
 .ribbons {
	
  position: absolute;
  background: yellow;
  color: black;
  transform: rotate(-45deg);
  text-align: center;
  top: -21%;
  left: -19%;
  width: 145px;
	
	 /*
	width: 250px;
  background: #e43;
  position: absolute;
  /*top: 25px;* /
  left: -50px;
  text-align: center;
  line-height: 30px;
  letter-spacing: 1px;
  color: #f0f0f0;
  transform: rotate(-45deg);
  -webkit-transform: rotate(-45deg);
  overflow: hidden;
	 text-overflow:ellipsis;
	white-space: nowrap;*/
}
.ribbon {
  position: absolute;
  /*left: -5px; top: 141px;*/
  z-index: 1;
  overflow: hidden;
  width: 75px; height: 75px;
  text-align: right;
	top: 21.6%;
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
  background: #FFDE03;
  background: linear-gradient(#FFDE03 0%, #FFDE03 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
 
	left: -27px;
}
	/*
.ribbon span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #A72107;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #A72107;
}
.ribbon span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #A72107;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #A72107;
}*/	
	
	
	.clickribbon {
  position: absolute;
  background: yellow;
  color: black;
  background-color: #e43;
  text-align: center;
  top: 25%;
  right: 10%;
  min-width: 70px;
		opacity: 1.2;
		  background:rgba(0,0,0,0.3);
		color: #F5F654;z-index: 1;
		text-align: center;vertical-align:middle;
		border-radius: 25px;
		padding: 4px;
		cursor: pointer;
}
	
.btn_ribbon {
  position: absolute;
  background: yellow;
  color: black;
  background-color: #e43;
  text-align: center;
  top: 68%;
  right: 12%;
  min-width: 195px;
		opacity: 1.2;
		  background:rgba(0,0,0,0.3);
		color: #FFF;z-index: 1;
		text-align: center;vertical-align:middle;
		border-radius: 25px;
		padding: 14px;
		cursor: pointer;
	 background-image: url("{{ asset('cshare/images/btn.png') }}");
        background-repeat: no-repeat;
        background-size: cover;background-size: 100% 100%;
	font-size: 0.2rem;
}	
	
	
	 </style>
<div class="container">
	
	
	<div class="ribbon-holder" align="center">
  
		
		<div class="ribbon"><span>@lang('dingsu.ads_picture')</span></div>
		
		<div class="clickribbon"> <img  src="{{ asset('client/bar/refresh.png') }}" style="height: 15px; margin-bottom: 3px;">&nbsp; @lang('dingsu.ads_picture')</div>
		
		<div class="btn_ribbon ">查看分享方法</div>
		
		
 <?php echo '<img  class="small-img" src="data:image/png;base64,'.base64_encode($imgData).'"/>';?><div class="bottom">
			<h1>This</h1>
			<div class="bottomdiv">
			asfasdf asdfasdfas sd<br>asdfdsafsdfsafdf
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