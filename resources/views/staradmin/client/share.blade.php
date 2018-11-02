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
<div class="wrapper full-height" style="padding-top: 0px !important; background-color: #450B72">
	<div class="container center">
		<!-- <div class="col-xs-4 col-md-3"> -->
			<div class="wrapper">
				<div id="qrcode"></div>
				</div>
				<script type="text/javascript">
					function GenerateCode(affiliate_id)
					{
						
						$('#qrcode').html('');
						var qrcode = new QRCode("qrcode",{
							// position: relative,
							//top: 80px,
							//left: 80px,
							width: 50,
							height: 50,
							//z-index: 1,

							//colorDark : "#000000",
							//colorLight : "#ffffff",
							//correctLevel : QRCode.CorrectLevel.H
						});
						var url = 'http://wabao666.com/register/'+affiliate_id;
						qrcode.makeCode(url);
						
					}
				</script>
			
			<img src="/client/images/8_invitation.jpg" class="share"/>		
			
			<!-- <input id="h_affiliate_id" name="h_affiliate_id" type="hidden" value="{{Auth::Guard('member')->user()->affiliate_id}}" /> -->
			<script type="text/javascript">
				GenerateCode('{{Auth::Guard('member')->user()->affiliate_id}}');
				//GenerateCode(90);
			</script>	


			
		<!-- </div> -->
	</div>
</div>
@endsection



