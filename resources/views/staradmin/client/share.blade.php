<style>
	.fotos {
		display: inline-block;
		position: relative;
	}
	
	.big-img {
		width: 100%;
		max-width: 100%;
	}
	
	.small-img {
		position: absolute;
		left: 18%;
		top: 13.39%;
		width: 65%;
		max-width: 65%;
		max-height: 44%;
	}

	.offscreen {
		position: absolute;
		left: -999em;
	}

	@media only screen and (min-device-width:1000px) {
	   
		.fotos {
    	 left: -100px;   
		}
	}

	.swal-wide{
	    /*margin: auto; transform: translateX(-50%);*/
	    /*width: 50%;*/
	    /*height: 50%;*/
        /*transform: scale3d(0.1, 0.1, 0.1);*/

	}

</style>
<?php

$affiliate_id = Auth::Guard( 'member' )->user()->affiliate_id;

$url = 'http://wabao666.com/register/' . $affiliate_id;

$showIcon = public_path( 'client/bar/showIcon.png' );

$showimage = public_path( 'client/bar/image.jpg' );

$showIcon = "https://chart.googleapis.com/chart?chs=190x190&cht=qr&chl=$url&choe=UTF-8";


$redimg = imagecreatetruecolor( 500, 500 );

$redimg = imagecreatefrompng( $showIcon );

$image = imagecreatefromjpeg( $showimage );

$white = imagecolorallocate( $redimg, 255, 255, 255 );

imagecolortransparent( $redimg, $white );
imagefill( $redimg, 0, 0, $white );

// Merge the red image onto the PNG image
imagecopymerge( $image, $redimg, -10, 611, 0, 0, 190, 190, 100 );


ob_start();
imagepng( $image );
$imgData = ob_get_clean();
imagedestroy( $image );

?>
@extends( 'layouts.default' )

@section( 'title', '分享给朋友' )

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section( 'top-css' )
@parent
<link rel="stylesheet" href="{{ asset('/client/css/share.css') }}"/> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.0/sweetalert2.min.css"/>

@endsection 
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<div class="wrapper full-height" style="padding-top: 0px !important; background-color: #450B72">
	<div class="container center" style="background-color: #450B72;">
		
			<div id="fotos" class="fotos">
				<img class="big-img" id="imgdisplay1" src="{{ asset('/client/images/8_invitation.jpg') }}"/>

			
				<?php echo '<img  class="small-img" id="imgdisplay2" src="data:image/png;base64,'.base64_encode($imgData).'"/>';?>
			</div>

			<div class="wrapper copyurl" id="copyurl" data-clipboard-text="{{$url}}" style="-webkit-transform-origin:left top;">					
				</div>

			
		
		<script type="text/javascript">
			new ClipboardJS( '.copyurl' );

			var clipboard = new ClipboardJS( '.copyurl' );
			clipboard.on( 'success', function ( e ) {
				e.clearSelection();
				swal( {
					type: 'success',
					title: '@lang("dingsu.copied")!',
					text: '@lang("dingsu.text_copied")',
					confirmButtonText: '@lang("dingsu.okay")',
				   customClass: 'swal-wide',
				     position: 'center',
				     width: 500,
				     timer:1000,
  					// padding: '3em',

				       
				} )
			} );

			clipboard.on( 'error', function ( e ) {
				console.error( 'Action:', e.action );
				console.error( 'Trigger:', e.trigger );
			} );
		</script>
	</div>
</div>
@endsection