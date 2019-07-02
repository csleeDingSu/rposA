<!--Confirm card product Modal starts -->
<form class="form-sample" name="formrender" id="formrender" action="" method="post" autocomplete="on">
	<div class="modal fade" id="carddetailmode" tabindex="-1" role="dialog" aria-labelledby="carddetailmode" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.confirm') @lang('dingsu.redeem') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="validation-errors" id="validation-errors"></div>


					<div class="carddata" id="carddata"></div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return confirm_redeem();return false;">@lang('dingsu.confirm')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->



