<!-- Modal starts -->
<form class="form-sample" name="formadd" id="formadd" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openaddmodel" tabindex="-1" role="dialog" aria-labelledby="openaddmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editmodelabel">@lang('dingsu.add') @lang('dingsu.record')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="name" class="col-sm-3 col-form-label">@lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="name" name="name" class="form-control" type="text" autofocus value="">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="env_value" class="col-sm-3 col-form-label">@lang('dingsu.value') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="env_value" name="env_value" class="form-control" type="text" autofocus value="">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						
						<div class="col-md-12">
							<div class="form-group row">
								<label for="comment" class="col-sm-3 col-form-label">@lang('dingsu.comment') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="comment" name="comment" class="form-control" type="text" autofocus value="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="savebtn">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->