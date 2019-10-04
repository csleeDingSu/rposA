<!-- Modal starts -->
<form class="form-sample" name="dform" id="dform" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.change') @lang('dingsu.status')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="c_status" class="col-sm-3 col-form-label">@lang('dingsu.current') @lang('dingsu.status')</label>
								<div class="col-sm-9">
									<select class="form-control" name="c_status" id="c_status" disabled >
										<option value="1">@lang('dingsu.active')</option>
										<option value="2">@lang('dingsu.onhold')</option>
										<option value="3">@lang('dingsu.suspended')</option>
										<option value="4">@lang('dingsu.restart')</option>
									</select>
								</div>
							</div>
						</div>						
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="c_totallimit" class="col-sm-3 col-form-label">@lang('dingsu.total_limit')</label>
								<div class="col-sm-9">
									<span id="total_limit" class="total_limit">&nbsp;</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="model_processed" class="col-sm-3 col-form-label">@lang('dingsu.processed') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<span id="processed" class="processed">&nbsp;</span>
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="c_status" class="col-sm-3 col-form-label">@lang('dingsu.last_run')</label>
								<div class="col-sm-9">
									<span id="lastrun" class="lastrun">&nbsp;</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="model_status" class="col-sm-3 col-form-label">@lang('dingsu.status') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select class="form-control" name="model_status" id="model_status">
										<option value="2">@lang('dingsu.onhold')</option>
										<option value="3">@lang('dingsu.suspended')</option>
										<option value="4">@lang('dingsu.restart')</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" id="savebtn" class="btn btn-success savebtn" onclick="return addrecord();return false;">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->