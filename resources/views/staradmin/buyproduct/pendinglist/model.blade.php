<!--Confirm product Modal starts -->
<form class="form-sample" name="formcard" id="formcard" action="" method="post" autocomplete="on">
	<div class="modal fade" id="carddetailmode" tabindex="-1" role="dialog" aria-labelledby="carddetailmode" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.confirm') @lang('dingsu.redeem') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="rvalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="card_num" class="col-sm-6 col-form-label">@lang('dingsu.card') <span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="card_num" id="card_num" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="card_pass" class="col-sm-6 col-form-label">@lang('dingsu.pass')<span class="text-danger">*</span></label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="card_pass" id="card_pass" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return confirm_new();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="rid" id="rid" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->



