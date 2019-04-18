@extends('layouts.default')

@section('title', '开通会员')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/membership.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

<div class="full-height no-header">
	<div class="container">
		
		<div class="member-box">
			<div class="card">
				<div class="col-xs-3 left-menu">
					<a href="/profile" class="back">
				        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
				    </a>
				</div>

				<div class="col-xs-6 brand-title">
					开通会员
				</div>
			
				<div class="col-xs-3"></div>
			</div>
			<img class="img_flow" src="{{ asset('/client/images/membership/flow.png') }}"  />
			<!-- end member id -->

			<!-- member details -->
			<div class="information-table">
				  <div class="col-xs-12">
				  	<span class="label-title">付款金额</span><br />
				  	<div class="point numbers" id="cut"><div class="sign">¥</div>99.00</div>
				  	<div class="button-copy cutBtn">复制支付口令</div>
				  </div>
			</div>
			<!-- end member details -->
		</div>
		
		<div class="top-background">
			<img src="{{ asset('/client/images/membership/bg.png') }}" />
		</div>
		<div class="bottom-background"></div>

		<!-- member listing -->
		<div class="listing-table member-box">
			<div class="col-xs-4">
				重要提示：
			</div>
			<div class="col-xs-8">
				付款成功后，一定要在这里提交姓名，否则后台无法确认。
			</div>
			<div style="clear: both;"></div>
			<div class="input-wrapper">
				<input type="text" value="" name="txt_name" placeholder="输入姓名" />
			</div>
			<div class="button-submit">确认提交</div>

		</div>
		<!-- end member listing -->
	</div>
</div>

@endsection



@section('footer-javascript')
<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="modal-successful" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/membership/successful.png') }}" width="60" height="60" alt="successful" />
								<div class="instructions">
									提交成功，等待开通
								</div>								
							</div>
							
						</div>
					</div>							
				</div>
			</div>
			<div class="modal-footer">
				<div class="col-xs-6 close-modal">
					取消
				</div>
				<div class="col-xs-6 button-status">
					查看状态
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	
	<script type="text/javascript">
		$(document).ready(function () {

			$('.close-modal').click(function(){
		        $('#modal-successful').modal('hide');
		    });

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});

			clipboard.on('success', function (e) {
				$('.cutBtn').html('复制成功打开支付宝');
			});

			clipboard.on('error', function (e) {
				//$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
				$('.cutBtn').html('复制成功打开支付宝');
			});

		});	
	</script>
@endsection
