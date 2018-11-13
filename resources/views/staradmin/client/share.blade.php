<?php

$affiliate_id = Auth::Guard('member')->user()->affiliate_id;

$url = 'http://wabao666.com/register/'.$affiliate_id;

$showIcon = public_path('client/bar/showIcon.png');

$showimage = public_path('client/bar/image.jpg');

$showIcon = "https://chart.googleapis.com/chart?chs=190x190&cht=qr&chl=$url&choe=UTF-8";


$redimg = imagecreatetruecolor(500, 500);

$redimg = imagecreatefrompng($showIcon);

$image = imagecreatefromjpeg($showimage);

$white = imagecolorallocate($redimg, 255, 255, 255);

imagecolortransparent($redimg, $white);
imagefill($redimg, 0, 0, $white);

// Merge the red image onto the PNG image
imagecopymerge($image, $redimg, -10,611, 0, 0, 190, 190, 100);


ob_start();
imagepng($image);
$imgData=ob_get_clean();
imagedestroy($image);

?>
@extends('layouts.default')

@section('title', '分享给朋友')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/share.css') }}" />

@endsection



@section('content')



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>
<style>
	.offscreen {
		position: absolute;
		left: -999em;
	}

	.img1
	{
		width: 100%;
		position: relative;
		margin-top: 30px;
		margin-bottom: 30px;
	}

	@media only screen and (max-device-width:1990px) {
	   #qrcode {
			margin:810px 50px 50px 135px;
		}
/*ok*/
		.img2
			{
				width: 49% !important;
				position: absolute;
				top:345px !important;
				left: 390px !important;
			}
	}

	@media only screen and (max-device-width:1882px) {
	   #qrcode {
			margin:810px 50px 50px 135px;
		}
/*ok*/
		.img2
			{
				width: 40% !important;
				position: absolute;
				top:340px !important;
				left: 390px !important;
			}
	}

	@media only screen and (max-device-width:375px) {
	   #qrcode {
			margin:395px 50px 50px 70px;
		}
/*ok*/
		.img2
		{
			width: 59% !important;
			position: absolute;
			top:123px !important;
			left: 77px !important;
		}
	}




</style>

<div class="wrapper full-height" style="padding-top: 0px !important; background-color: #450B72">
	<div class="container center">

		<img class="img1" src="{{ asset('/client/images/8_invitation.jpg') }}" />

		<div>
			<div class="wrapper copyurl" id="copyurl" data-clipboard-target="#copy">
				<!-- <div class="wrapper copyurl"> -->
				<div id="qrcode" class="qrcode"></div>
				<div class="share">
					<?php echo '<img class="img2" src="data:image/png;base64,'.base64_encode($imgData).'" />';?>
				</div>			
			</div>
		</div>
	
		<span id="copy" class="offscreen url" aria-hidden="true"><?php echo $url; ?></span>
				<script type="text/javascript">
					
					var clipboard = new ClipboardJS('.copyurl');
					clipboard.on('success', function(e) {
						
						e.clearSelection();
						swal({  type: 'success',  title: '@lang("dingsu.copied")!',text: '@lang("dingsu.text_copied")', confirmButtonText: '@lang("dingsu.okay")',}).then(
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
					});

					clipboard.on('error', function(e) {
						console.error('Action:', e.action);
						console.error('Trigger:', e.trigger);
					});
					
					function GenerateCode(affiliate_id)
					{
						
						$('#qrcode').html('');
						var qrcode = new QRCode("qrcode", {
						    text: "http://wabao666.com/register/"+affiliate_id,
						    // width: 60,
						    // height: 60,
						    colorDark : "#000000",
						    colorLight : "#ffffff",
						    correctLevel : QRCode.CorrectLevel.H
						});
						var url = 'http://wabao666.com/register/'+affiliate_id;
						$('.url').html(url);
						//qrcode.makeCode(url);

						
					}
				</script>
			
			<script type="text/javascript">
				//GenerateCode('{{Auth::Guard('member')->user()->affiliate_id}}');
			</script>	

	</div>
</div>
@endsection



