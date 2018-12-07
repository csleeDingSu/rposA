<!-- Modal starts -->
<form class="form-sample" name="formadd" id="formadd" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openaddmodel" tabindex="-1" role="dialog" aria-labelledby="openaddmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editmodelabel">@lang('dingsu.add') @lang('dingsu.package')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_name" class="col-sm-3 col-form-label">@lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="package_name" name="package_name" class="form-control" type="text" autofocus value="{{ old('package_name')}}" required>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="price" class="col-sm-3 col-form-label">@lang('dingsu.package') @lang('dingsu.vip_price') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="price" name="price" class="form-control" type="text" value="{{ old('price')}}" required maxlength="5"> 
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="min_point" class="col-sm-3 col-form-label">@lang('dingsu.vip_consumed_point')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="min_point" name="min_point" class="form-control" type="text" value="{{ old('min_point')}}" required maxlength="10">
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_description" class="col-sm-3 col-form-label">@lang('dingsu.description')  </label>
								<div class="col-sm-9">
									<textarea class="form-control" id="package_description" name="package_description" >{{ old('package_description')}}</textarea>
									
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_life" class="col-sm-3 col-form-label">@lang('dingsu.vip_convertible_life')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="package_life" name="package_life" class="form-control" type="text" value="{{ old('package_life')}}"  maxlength="3">
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_freepoint" class="col-sm-3 col-form-label">@lang('dingsu.vip_convertible_point')  </label>
								<div class="col-sm-9">
									<input id="package_freepoint" name="package_freepoint" class="form-control" type="text" value="{{ old('package_freepoint')}}"  maxlength="10">
								</div>
							</div>
						</div>
						
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="package_pic_url" class="col-sm-3 col-form-label">@lang('dingsu.vip_package_image_url')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="package_pic_url" name="package_pic_url" class="form-control" type="text" required value="{{ old('package_pic_url')}}" >
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')  </label>
								<div class="col-sm-9">
									 <select id="status" name="status" class="form-control">
									  <option value="1">@lang('dingsu.active')</option>
									  <option value="2">@lang('dingsu.inactive')</option>
									</select>									
								</div>
							</div>
						</div>
						
					</div>
					
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="savebtn" onclick="return addpackage();return false;">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->