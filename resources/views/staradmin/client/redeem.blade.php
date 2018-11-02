@extends('layouts.default')

@section('title', '兑换奖品')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/redeem.css') }}" />
@endsection

@section('top-javascript')
	@parent
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<!-- wabao coin info -->
		<div class="card left">
			<div class="icon-coin-wrapper">
				<div class="icon-coin"></div>
			</div>
			<div class="label-coin">当前可用挖宝币</div>
			<div class="label-coin right"><a href="#">历史明细</a></div>

			<div style="clear: both;"></div>
			
			<div class="wabao-coin">&nbsp;</div>
		</div>
		<!-- end wabao coin info -->


		<div class="full-width-tabs">
			<!-- redeem tabs -->
			<ul class="nav nav-pills">
			  <li class="active take-all-space-you-can"><a class="tab" data-toggle="tab" href="#prize">奖品兑换</a></li>
			  <li class="take-all-space-you-can"><a class="tab" data-toggle="tab" href="#history">我的充值卡</a></li>
			</ul>
			<!-- end redeem tabs -->

			<!-- tab content -->
			<div class="tab-content">
				<!-- redeem list content -->
				<div id="prize" class="tab-pane fade in active">
				</div>


				<!-- end redeem list content -->

				<!-- redeem history content -->
				<div id="history" class="tab-pane fade">
				</div>
				<!-- end redeem list content -->
			</div>
		</div>
		
		<!-- End listing -->
	</div>
</div>
@endsection

@section('footer-javascript')
    @parent
	<script type="text/javascript">
		$(document).ready(function () {
			$('.tab').click(function(){
				var title = $(this).html();
				$('.navbar-brand').html(title); 
			});

			$.getJSON( "/api/product-list?memberid={{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}", 
				function( data ) {
					$('.wabao-coin').html(data.current_point);

			        var records = data.records.data;
			        var html = '';

			        $.each(records, function(i, item) {
			            
			            html += '<div class="row">' +
									'<div class="col-xs-3 column-1">' +
										'<img class="img-voucher" src="'+ item.product_picurl +'" alt="'+item.product_name+'">' +
									'</div>' +
									'<div class="col-xs-6 column-2">' +
										'<div class="description">' + item.product_name + '</div>' +
										'<div class="note">您还剩' + parseInt(data.current_point) + '挖宝币</div>' +
										'<div class="icon-coin-wrapper">' +
											'<div class="icon-coin"></div>' +
										'</div>' +
										'<div class="w-coin">'+ item.min_point +'</div>' +
										'<div style="clear: both;"></div>' +
										'<div class="remaining">剩余 221 张 已兑换 3884 张</div>' +
									'</div>' +
									'<div class="col-xs-3 column-3">' +
										'<div class="btn-redeem openeditmodel'+ i +'">兑换</div>' +
									'</div>' +
								'</div>';

						html += '<!-- Modal starts -->' +
								'<div class="modal fade col-md-12" id="viewvouchermode'+ i +'" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">' +
									'<div class="modal-dialog modal-lg" role="document">' +
										'<div class="modal-content">' +
											'<div class="modal-body">' +
												'<div class="modal-row">' +
													'<div class="modal-img-voucher">' +
														'<img src="' + item.product_picurl +'" alt="alipay voucher 50" class="img-voucher" />' +
											        '</div>' +

													'<div class="wrapper modal-full-height">' +
														'<div class="modal-card">' +
															'<div class="modal-center">' +
																'兑换本产品需要消耗:' +
															'</div>' +
														'</div>' +

														'<div class="modal-card">' +
																'<div class="icon-coin-wrapper modal-icon">' +
																	'<div class="icon-coin"></div>' +
																'</div>' +
																'<div class="wabao-price">'+ item.min_point +'挖宝币</div>' +
														'</div>' +

														'<div class="modal-card">' +
															'<div class="wabao-balance">您当前拥有 '+ parseInt(data.current_point) +' 挖宝币</div>' +
														'</div>' +

														'<div id="error-'+ item.id + '" class="error"></div>' +

														'<div id="redeem-'+ item.id +'" onClick="redeem(\''+ item.id +'\');">' +
															'<a class="btn btn_submit" >确定兑换</a>' +
														'</div>' +

														'<div>' +
															'<a href="#" class="btn btn_cancel" data-dismiss="modal">暂不兑换</a>' +
														'</div>' +
													'</div>' +
												'</div>' +
											'</div>' +
										'</div>' +
									'</div>' +
								'</div>' + 
								'<!-- Modal Ends -->';
			        });

			        $('#prize').html(html);

			        $.each(records, function(i, item) {
				        $('.openeditmodel' + i).click(function() {
							$('#viewvouchermode' + i).modal('show');
						});
				    });

		    });					
		});
		

		
		$.getJSON( "/api/redeem-history?memberid={{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}", 
			function( data ) {
				var records = data.records.data;
			    var html = '';

			    $.each(records, function(i, item) {
			    	var counter = i + 1;

			    	html += '<div class="history-row">' +
						'<div class="col-xs-2 column-4">' +
							counter +
						'</div>' +
						'<div class="col-xs-7 column-5">' +
							'<div class="description">'+ item.product_name + ' ' + item.pin_name + '</div>' +
							'<div class="balance">兑换时间:'+ item.created_at +'</div>' +
						'</div>';

					if(item.pin_status == 4) { // Pending
						html += '<div class="col-xs-3 column-6">' +
									'<div class="btn-pending">等待发放</div>' +
								'</div>' + 
							'</div>';

					} else if (item.pin_status == 2) { // Confirmed
						html += '<div class="col-xs-3 column-6">' +
									'<div class="btn-card" data-toggle="collapse" data-target="#content-' + item.id + '">查看卡号</div>' +
								'</div>' + 
							'</div>' +
						'<div id="content-' + item.id + '" class="collapse">' +
							'<div>卡号： <span class="numbers">'+ item.code +'</span> 密码：<span class="codes"></span></div>' +
							'<div class="instruction">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！' +
							'</div>' +
						'</div>';
					} else {
						html += '</div>';
					}

				});

				$('#history').html(html);
			});

		function redeem(product_id){

			$.post("/api/request-redeem", { 
				'memberid': {{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}},
				'productid': product_id
			}, function(data) {
				if(data.success) {
					window.location.href = "/redeem";
				} else {
					$('#error-' + product_id).html(data.message);
				}
			});
		}

	
	</script>
@endsection