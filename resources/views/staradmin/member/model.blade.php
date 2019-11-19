

<!-- Edit Modal starts -->
<form class="form-sample" name="formedit" id="formedit" action="" method="post" autocomplete="on" enctype="multipart/form-data">
	<div class="modal fade" id="openmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.adjust_wallet') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					 	<span aria-hidden="true">&times;</span>
				  	</button>
					@csrf
				</div>
				<div class="modal-body renderdata">										
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="savebtn">@lang('dingsu.update')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="mode" id="mode" value="edit">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->






<!-- Ali pay starts -->
<form class="form-sample" name="formalipay" id="formalipay" action="" method="post" autocomplete="on" >
	<div class="modal fade" id="openalipaymodel" tabindex="-1" role="dialog" aria-labelledby="openalipaymodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.alipay') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					 	<span aria-hidden="true">&times;</span>
				  	</button>
					@csrf
				</div>
				<div class="modal-body renderdata">	
				<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.acupoint') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<span id="pay_acupoint"></span>
								</div>
							</div>
						</div>
					</div>									
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.payee_account') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="payee_account" name="payee_account" class="form-control" type="text" value="" maxlength="50">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="amount" class="col-sm-3 col-form-label">@lang('dingsu.amount') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="amount" name="amount" class="form-control" type="text" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="savebtn">@lang('dingsu.make') @lang('dingsu.payment')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hi_pay_id" id="hi_pay_id" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->
