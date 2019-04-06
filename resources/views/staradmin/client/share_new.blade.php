<?php

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




                
<script type="text/javascript">
 

</script>

@endsection 

@extends( 'layouts.share' )

@section( 'title', '分享给朋友' )



@section( 'top-css' )
@parent
 

@endsection 
@section('content')


<style>
	
	body {overflow: hidden;background-color: #FF6d7d;}
	html { 
	 
		background-color: #FF6d7d;
	}
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
		position: absolute;
    	top: 0; right: 0; bottom: 0; left: 0;
		background-image: url("{{ asset('cshare/images/bgnew.png') }}");
        background-repeat: no-repeat;
        background-size: cover;
		background-size: 100% 100%;
		background-color: #FF6d7d;
		max-width: 100%;
    	max-height: 100%;
		background-position: top;
		
		display: flex;
  		flex-flow: column wrap;
    	width: auto;
		max-width: 65%;
        max-height: 80%;
    /*height: 2000px;*/
		
	}
	.child{
		
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
  overflow: hidden;
  position: relative;
		max-width: 72%;

margin-left: 7%;

margin-top: 47%;
}
.ribbon {
  position: absolute;
  background: yellow;
  color: black;
  transform: rotate(-45deg);
  text-align: center;
  top: -21%;
  left: -19%;
  width: 145px;
}
	
	
	.clickribbon {
  position: absolute;
  background: yellow;
  color: black;
  background-color: #e43;
  text-align: center;
  top: -22%;
  right: 6%;
  min-width: 90px;
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
  top: 43%;
  right: 10%;
  min-width: 255px;
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
	
	
	<div class="ribbon-holder">
  <div class="ribbon ribbon-holder">@lang('dingsu.ads_picture')</div>
		
		<div class="clickribbon ribbon-holder"> <img  src="{{ asset('client/bar/refresh.png') }}" style="height: 15px; margin-bottom: 3px;">&nbsp; @lang('dingsu.ads_picture')</div>
		<div class="btn_ribbon ribbon-holder">查看分享方法</div>
		
		
 <?php echo '<img  class="small-img" src="data:image/png;base64,'.base64_encode($imgData).'"/>';?><div class="bottom">
			<h1>This</h1>
			<div class="bottomdiv">
			asfasdf asdfasdfas dfasfsdaf asdf<br>asdfdsafsdfsafdf
			</div>
		</div>
</div>
	
	

	<!--
	<div class="child copyurl" align="center" data-clipboard-target="#copy">

		<div class="myov"><div class="cr cr-top cr-left cr-sticky cr-red ">@lang('dingsu.ads_picture')</div>
			<!--
			<div class="rpic ">
			<a href="javascript:void(0)" class="icon"> 
			<img  src="{{ asset('client/bar/refresh.png') }}" style="height: 15px; margin-bottom: 3px;">&nbsp;@lang('dingsu.change_picture')
			</a>						
			</div>
			<button class="c_button" name="c_button" id="c_button" type="button">查看分享方法</button>
			-- >
			
		</div>
		
		

	</div> -->
	 
</div>


@endsection