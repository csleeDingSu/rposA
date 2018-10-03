 <!-- Modal starts -->

<div class="modal fade" id="addlevelmodel" tabindex="-1" role="dialog" aria-labelledby="addlevelmodelLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<form class="form-sample" action="" method="post" autocomplete="on">

				<div class="modal-header">
					<h5 class="modal-title" id="addlevelmodelLabel">@lang('dingsu.view') @lang('dingsu.voucher')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
				</div>
				<div class="modal-body">

					{{ csrf_field() }} @foreach ($errors->all() as $error)
					<div class="alert alert-danger" role="alert">@lang($error)</div>
					@endforeach @if(session()->has('message'))
					<div class="alert alert-success" role="alert">
						{{ session()->get('message') }}
					</div>
					@endif
					<p>&nbsp;</p>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="level_name" class="col-sm-3 col-form-label">@lang('dingsu.level_name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="level_name" name="level_name" class="form-control" type="text" required autofocus value="">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="playtime" class="col-sm-3 col-form-label">@lang('dingsu.playtime')<span class="text-danger">*</span></label></label>
								<div class="col-sm-9">
									<input readonly class="form-control" type="text" value="" required>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="status" class="col-sm-3 col-form-label">@lang('dingsu.status')</label>
								<div class="col-sm-9">
									<select id="status" name="status" class="form-control">
										<option  value="0">@lang('dingsu.active')</option>
										<option value="1">@lang('dingsu.inactive')</option>
										<option value="2">@lang('dingsu.suspended')</option>
									</select>
								</div>
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group row">
								<label for="notes" class="col-sm-3 col-form-label"> @lang('dingsu.notes')</label>
								<div class="col-sm-9">
									<textarea id="notes" name="notes" placeholder="" class="form-control">{{ $out->notes}}</textarea>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success addlevel">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>

			</form>
		</div>
	</div>
</div>
 <!-- Modal Ends -->