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
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
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
				  	<div class="point numbers"><div class="sign">¥</div>99.00</div>
				  	<input type="hidden" id="cut" value="i8I2yX408f" />
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
				<input type="text" value="" id="txt_name" name="txt_name" placeholder="输入姓名" />
			</div>
			<div class="button-submit">确认提交</div>
			<div class="error">未输入姓名无法提交，请填写真实姓名</div>

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
				<a href="/vipmember">
					<div class="col-xs-6 button-status">
						查看状态
					</div>
				</a>
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

		    $('.button-submit').click(function(){
		    	var txt_name = $('#txt_name').val();
		    	if(txt_name == ''){
		    		$('.error').show();
		    	} else {
    				var username = $('#hidUsername').val();
				    var session = $('#hidSession').val();
				    var id = $('#hidUserId').val();

				    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
				        //console.log(data);
				        if(data.success) {
				        	$.ajax({
						        type: 'POST',
						        url: "/api/request-vip-upgrade",
						        data: { 'memberid': id, 'packageid': 29, 'ref_note': txt_name },
						        dataType: "json",
						        beforeSend: function( xhr ) {
						            xhr.setRequestHeader ("Authorization", "Bearer " + data.access_token);
						        },
						        error: function (error) { console.log(error.responseText) },
						        success: function(data) {
						            if(data.success) {
						                $('.error').hide();
				        				$('#modal-successful').modal();
						            } else {
						                $('.error').html(data.message);
						            }
						        }
						    });
				        }      
				    });

				    

		    		
		        }
		    });

			var clipboard = new ClipboardJS('.cutBtn', {
				text: function (trigger) {
					return $('#cut').val();
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
