

<!-- Edit Modal starts -->
<form class="form-sample" name="formedit" id="formedit" action="" method="post" autocomplete="on" enctype="multipart/form-data">
	<div class="modal fade" id="openmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title formtitle" id="editmodelabel formtitle">@lang('dingsu.edit') @lang('dingsu.receipt')</h5>
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
