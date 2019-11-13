

<!-- Edit Modal starts -->
<form class="form-sample" name="formedit" id="formedit" action="" method="post" autocomplete="on" >
	<div class="modal fade" id="openmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.edit') @lang('dingsu.company') @lang('dingsu.account')</h5>
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



<!-- Add Modal starts -->
<form class="form-sample" name="formadd" id="formadd" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openaddmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.add') @lang('dingsu.company') @lang('dingsu.account')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					 	<span aria-hidden="true">&times;</span>
				  	</button>
					@csrf
				</div>
				<div class="modal-body renderadddata">										
					@include('resell.account.render_add')
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="addbtn">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="mode" id="mode" value="edit">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->



<!-- Add Modal starts -->
<form class="form-sample" name="formmemberadd" id="formmemberadd" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openmemberaddmodel" tabindex="-1" role="dialog" aria-labelledby="openmembermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.add') @lang('dingsu.member')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					 	<span aria-hidden="true">&times;</span>
				  	</button>
					@csrf
				</div>
				<div class="modal-body renderadddata">										
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="phone" class="col-sm-3 col-form-label">@lang('dingsu.phone') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="phone" name="phone" class="form-control" type="text" value="" maxlength="150">
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="addbtn">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="mode" id="mode" value="edit">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->
