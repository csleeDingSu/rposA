@extends('layouts.default')

@section('title', '个人主页')

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
			
			<div class="wabao-coin">500.00</div>
		</div>
		<!-- end wabao coin info -->


		<div class="full-width-tabs">
			<!-- redeem tabs -->
			<ul class="nav nav-pills">
			  <li class="active take-all-space-you-can"><a data-toggle="tab" href="#prize">奖品商城</a></li>
			  <li class="take-all-space-you-can"><a data-toggle="tab" href="#history">我的充值卡</a></li>
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
					<div class="history-row">
						<div class="col-xs-3 column-1">
							1001
						</div>
						<div class="col-xs-6 column-2">
							<div class="description">中国移动充值卡 50元</div>
							<div class="balance">兑换时间:2018-10-24 17:29</div>
						</div>
						<div class="col-xs-3 column-3">
							<div class="btn-pending">等待发放</div>
						</div>	
					</div>

					<div class="history-row">
						<div class="col-xs-3 column-1">
							1002
						</div>
						<div class="col-xs-6 column-2">
							<div class="description">中国移动充值卡 50元</div>
							<div class="balance">兑换时间:2018-10-24 17:29</div>
						</div>
						<div class="col-xs-3 column-3">
							<div class="btn-card" data-toggle="collapse" data-target="#content-1002">查看卡号</div>
						</div>	
					</div>
					<div id="content-1002" class="collapse">
						<div>卡号： <span class="numbers">3718371837382943</span> 密码：<span class="numbers">384u983984324321</span></div>
						<div class="balance">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！
						</div>
					</div>

					<div class="history-row">
						<div class="col-xs-3 column-1">
							1003
						</div>
						<div class="col-xs-6 column-2">
							<div class="description">中国移动充值卡 50元</div>
							<div class="balance">兑换时间:2018-10-24 17:29</div>
						</div>
						<div class="col-xs-3 column-3">
							<div class="btn-card" data-toggle="collapse" data-target="#content-1003">查看卡号</div>
						</div>	
					</div>
					<div id="content-1003" class="collapse">
						<div>卡号： <span class="numbers">3718371837382943</span> 密码：<span class="numbers">384u983984324321</span></div>
						<div class="balance">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！
						</div>
					</div>

					<div class="history-row">
						<div class="col-xs-3 column-1">
							1004
						</div>
						<div class="col-xs-6 column-2">
							<div class="description">中国移动充值卡 50元</div>
							<div class="balance">兑换时间:2018-10-24 17:29</div>
						</div>
						<div class="col-xs-3 column-3">
							<div class="btn-card" data-toggle="collapse" data-target="#content-1004">查看卡号</div>
						</div>	
					</div>
					<div id="content-1004" class="collapse">
						<div>卡号： <span class="numbers">3718371837382943</span> 密码：<span class="numbers">384u983984324321</span></div>
						<div class="balance">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！
						</div>
					</div>

					<div class="history-row">
						<div class="col-xs-3 column-1">
							1005
						</div>
						<div class="col-xs-6 column-2">
							<div class="description">中国移动充值卡 50元</div>
							<div class="balance">兑换时间:2018-10-24 17:29</div>
						</div>
						<div class="col-xs-3 column-3">
							<div class="btn-card" data-toggle="collapse" data-target="#content-1005">查看卡号</div>
						</div>	
					</div>
					<div id="content-1005" class="collapse">
						<div>卡号： <span class="numbers">3718371837382943</span> 密码：<span class="numbers">384u983984324321</span></div>
						<div class="balance">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！
						</div>
					</div>
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
			$.getJSON( "/api/product-list?memberid={{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}", 
				function( data ) {
			        var records = data.records.data;
			        var html = '';

			        $.each(records, function(i, item) {
			            
			            html += '<div class="row">' +
									'<div class="col-xs-3 column-1">' +
										'<img class="img-voucher" src="'+ item.product_picurl +'" alt="alipay voucher 50">' +
									'</div>' +
									'<div class="col-xs-6 column-2">' +
										'<div class="description">中国移动充值卡50元</div>' +
										'<div class="note">*可兑换支付宝余额48.5元</div>' +
										'<div class="icon-coin-wrapper">' +
											'<div class="icon-coin"></div>' +
										'</div>' +
										'<div class="w-coin">'+ item.min_point +'</div>' +
										'<div style="clear: both;"></div>' +
										'<div class="balance">剩余 221 张 已兑换 3884 张</div>' +
									'</div>' +
									'<div class="col-xs-3 column-3">' +
										'<div class="btn-redeem openeditmodel'+ i +'">兑换</div>' +
									'</div>' +
								'</div>';

						html += '<!-- Modal starts -->' +
								'<form class="form-sample" name="formvoucher" id="formvoucher" action="" method="post" autocomplete="on" >' +
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
															'<div class="wabao-balance">您当前拥有 680 挖宝币</div>' +
														'</div>' +

														'<div>' +
															'<a href="/arcade" class="btn btn_submit">确定兑换</a>' +
														'</div>' +

														'<div>' +
															'<a href="/arcade" class="btn btn_cancel" data-dismiss="modal">暂不兑换</a>' +
														'</div>' +
													'</div>' +
												'</div>' +
											'</div>' +
										'</div>' +
									'</div>' +
								'</div>' +
								'</form>' +
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
		
		
	
	</script>
@endsection