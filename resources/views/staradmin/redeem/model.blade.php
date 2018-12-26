
<!-- Modal starts -->
<form class="form-sample" name="dform" id="dform" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.edit') @lang('dingsu.tips')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="seq" class="col-sm-3 col-form-label">@lang('dingsu.num_of_redeem') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="seq" name="seq" class="form-control" type="text"  min="0" max="99" size="1" maxlength="2" autofocus value="{{ old('seq')}}">
								</div>
							</div>
							
						</div>
						
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="description" class="col-sm-3 col-form-label">@lang('dingsu.description')</label>
								<div class="col-sm-9">
									<textarea class="form-control" name="description" id="description"></textarea>
								</div>
							</div>
							
						</div>
						
						
					</div>
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="min_point" class="col-sm-3 col-form-label">@lang('dingsu.min_point') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="min_point" name="min_point" class="form-control" type="text" autofocus value="{{ old('min_point')}}">
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