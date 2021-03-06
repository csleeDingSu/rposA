@extends('layouts.default')

@section('title', '分享给朋友')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/share.css') }}" />

@endsection



@section('content')

@if (is_null(Auth::Guard('member')->user()->affiliate_id)))
dd('not yet')
@else
dd(Auth::Guard('member')->user()->affiliate_id)
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>
<style>
	.offscreen {
		position: absolute;
		left: -999em;
	}

	@media only screen and (max-device-width:2000px) {
	   #qrcode {
			margin:1280px 50px 50px 220px;
		}

		img {
	    	width: 200px;
		}
	}


	@media only screen and (max-device-width:1990px) {
	   #qrcode {
			margin:810px 50px 50px 135px;
		}

		img {
	    	width: 130px;
		}
	}


	@media only screen and (max-device-width:1024px) {
	   #qrcode {
			margin:1060px 50px 50px 180px;
		}

		img {
	    	width: 165px;
		}
	}

	@media only screen and (max-device-width:950px) {
	   #qrcode {
			margin:815px 50px 50px 140px;
		}

		img {
	    	width: 125px;
		}
	}


	@media only screen and (max-device-width:800px) {
	   #qrcode {
			margin:815px 50px 50px 140px;
		}

		img {
	    	width: 125px;
		}
	}

	@media only screen and (max-device-width:750px) {
	   #qrcode {
			margin:395px 50px 50px 68px;
		}

		img {
	    	width: 60px;
		}
	}

	@media only screen and (max-device-width:500px) {
	   #qrcode {
			margin:437px 50px 50px 75px;
		}

		img {
	    	width: 65px;
		}
	}

	@media only screen and (max-device-width:414px) {
	   #qrcode {
			margin:440px 50px 50px 75px;
		}

		img {
	    	width: 65px;
		}
	}

	@media only screen and (max-device-width:375px) {
	   #qrcode {
			margin:395px 50px 50px 70px;
		}

		img {
	    	width: 60px;
		}
	}


	@media only screen and (max-device-width:360px) {
	   #qrcode {
			margin:378px 50px 50px 65px;
		}

		img {
	    	width: 60px;
		}
	}

	@media only screen and (max-device-width:320px) {
	   #qrcode {
			margin:335px 50px 50px 60px;
		}

		img {
	    	width: 50px;
		}
	}

</style>

<div class="wrapper full-height" style="padding-top: 0px !important; background-color: #450B72">
	<div class="container center">
		
		<div class="wrapper copyurl" id="copyurl" data-clipboard-target="#copy">
			<div id="qrcode" class="qrcode"></div>
			<div class="share">
				<img src="{{ asset('/client/images/8_invitation.jpg') }}">
			</div>			
		</div>
	
		<span id="copy" class="offscreen url" aria-hidden="true">123</span>
				<script type="text/javascript">
					
					var clipboard = new ClipboardJS('.copyurl');

					clipboard.on('success', function(e) {
						console.info('Action:', e.action);
						console.info('Text:', e.text);
						console.info('Trigger:', e.trigger);

						e.clearSelection();
						swal({  type: 'success',  title: '@lang("dingsu.copied")!',text: '@lang("dingsu.text_copied")', confirmButtonText: '@lang("dingsu.okay")',}).then(
  function () { window.open(
  'weixin://',
  '_blank' 
); },
 
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
				GenerateCode('{{Auth::Guard('member')->user()->affiliate_id}}');
			</script>	

	</div>
</div>
@endsection



