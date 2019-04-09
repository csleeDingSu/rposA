

@section('top-css')
 @parent
	<link rel="stylesheet" href="{{ asset('/client/css/customer_service.css') }}"/>
@endsection

@section('footer-javascript')

<!-- customer service modal -->
<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1><img src="{{ asset('/client/images/weixin.png') }}" width="30" height="29" /> 请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="instructions">
								客服微信在线时间：<span class="highlight">早上9点~晚上9点</span>
							</div>
						</div>
						<div class="row">
							<div id="cut" class="copyvoucher">wabao666</div>
							<div class="cutBtn">点击复制</div>
						</div>
						<div class="modal-card">
							<div class="instructions-dark">
								请按复制按钮，复制成功后到微信添加。<br/> 如复制不成功，请到微信手动输入添加。
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- customer service modal Ends -->

 @parent
 <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script type="text/javascript">
        $(document).ready(function () {
    
            var clipboard = new ClipboardJS('.cutBtn', {
                target: function () {
                    return document.querySelector('#cut');
                }
            });
            clipboard.on('success', function (e) {
                $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
            });

            clipboard.on('error', function (e) {
                 $('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
                ///$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
            });
			
			
			$('#customerservice').click(function () { 
				$('#csModal').modal('show');
			});

        }); 
    </script>

@endsection
