
<section class="filter">
@include('member.filter')
</section>

<div class="clearfix">&nbsp;</div>

<section class="datalist">
@include('member.ajaxmemberlist')
</section>
<section class="models text-capitalize modellist">
	@include('member.model')
</section>

<!-- Wechat status Modal starts -->
<form class="form-sample" name="formupdatewechatstatus" id="formupdatewechatstatus" action="" method="post" autocomplete="on">
	<div class="modal fade" id="editwechatstatusmode" tabindex="-1" role="dialog" aria-labelledby="editwechatstatusmodelabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.change') @lang('dingsu.wechat') @lang('dingsu.status')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="model_alipay_account" class="col-sm-3 col-form-label">@lang('dingsu.alipay_account') </label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="model_alipay_account" id="model_alipay_account" value="">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="model_wechat_name" class="col-sm-3 col-form-label">@lang('dingsu.wechat') @lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="model_wechat_name" id="model_wechat_name" value="">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="model_wechat_id" class="col-sm-3 col-form-label">@lang('dingsu.wechat') @lang('dingsu.id') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="model_wechat_id" id="model_wechat_id" value="">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="model_wechat_status" class="col-sm-3 col-form-label">@lang('dingsu.category') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select class="form-control" name="model_wechat_status" id="model_wechat_status">
										<option value="0">@lang('dingsu.verified')</option>
										<option value="1">@lang('dingsu.unverified')</option>
										<option value="2">@lang('dingsu.rejected') / @lang('dingsu.account_closed')</option>
										<option value="3">@lang('dingsu.suspended')</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.notes') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<textarea class="form-control" required name="notes" id="notes"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return savewechatstatus();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<!-- Member status Modal starts -->
<form class="form-sample" name="formupdatestatus" id="formupdatestatus" action="" method="post" autocomplete="on">
	<div class="modal fade" id="editstatusmode" tabindex="-1" role="dialog" aria-labelledby="editstatusmodelabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.change') @lang('dingsu.status')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="svalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.status') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select class="form-control" name="model_status" id="model_status">
										<option value="0">@lang('dingsu.active')</option>
										<option value="1">@lang('dingsu.inactive')</option>
										<option value="2">@lang('dingsu.suspended')</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return updatetatus();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="myid" id="myid" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<!--Reset Password Modal starts -->
<form class="form-sample" name="formresetpassword" id="formresetpassword" action="" method="post" autocomplete="on">
	<div class="modal fade" id="resetpasswordmode" tabindex="-1" role="dialog" aria-labelledby="resetpasswordmode" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.reset') @lang('dingsu.password') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="rvalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.password') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" required class="form-control" name="password" id="password" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.confirm_password')<span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="text" required class="form-control" name="confirmpassword" id="confirmpassword" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return saveresetpass();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="rid" id="rid" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<!--Add Life/point Modal starts -->
<form class="form-sample" name="formtopup" id="formtopup" action="" method="post" autocomplete="on">
	<div class="modal fade" id="topupmode" tabindex="-1" role="dialog" aria-labelledby="topupmode" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.adjust_wallet')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="rvalidation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="clife" class="col-sm-3 col-form-label">@lang('dingsu.current_life')</label>
								<div class="col-sm-9">
									<input type="text" readonly class="form-control" name="clife" id="clife" value="" maxlength="50">
								</div>
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="form-group row">
								<label for="addlife" class="col-sm-3 col-form-label">@lang('dingsu.add_life')</label>
								<div class="col-sm-9">
									<select class="form-control" name="addlife" id="addlife">
										<option value="0">@lang('dingsu.nothing_to_change')</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="cpoint" class="col-sm-3 col-form-label">@lang('dingsu.current_point') </label>
								<div class="col-sm-9">
									<input type="text" readonly class="form-control" name="cpoint" id="cpoint" value="" maxlength="50">
								</div>
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="form-group row">
								<label for="apoint" class="col-sm-3 col-form-label">@lang('dingsu.add_point')</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="apoint" id="apoint" value="" maxlength="5" placeholder="@lang('dingsu.nothing_to_change')">
								</div>
							</div>
						</div>
					</div>
					
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="cviplife" class="col-sm-3 col-form-label">@lang('dingsu.current_vip_life')</label>
								<div class="col-sm-9">
									<input type="text" readonly class="form-control" name="cviplife" id="cviplife" value="" maxlength="50">
								</div>
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="form-group row">
								<label for="viplife" class="col-sm-3 col-form-label">@lang('dingsu.add_vip_life')</label>
								<div class="col-sm-9">
									<select class="form-control" name="viplife" id="viplife">
										<option value="0">@lang('dingsu.nothing_to_change')</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</div>
							</div>
						</div>
					</div>				
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="cvapoint" class="col-sm-3 col-form-label">@lang('dingsu.current_vip_point') </label>
								<div class="col-sm-9">
									<input type="text" readonly class="form-control" name="cvapoint" id="cvapoint" value="" maxlength="50">
								</div>
							</div>
						</div>
					
						<div class="col-md-6">
							<div class="form-group row">
								<label for="vapoint" class="col-sm-3 col-form-label">@lang('dingsu.add_vip_point')</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="vapoint" id="vapoint" value="" maxlength="5" placeholder="@lang('dingsu.nothing_to_change')">
								</div>
							</div>
						</div>
					</div>
					
					
					
								
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.notes') </label>
								<div class="col-sm-9">
									<textarea class="form-control" name="tnotes" id="tnotes"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return updatelife();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="tid" id="tid" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->



<!--Member list Modal starts -->
	<div class="modal fade" id="childlist" tabindex="-1" role="dialog" aria-labelledby="childlist" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.member') @lang('dingsu.list') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="mvalidation-errors"></div>
					<div class="row">
						<div class="col-md-12">	
							<div class="table-responsive">				
							<table class="table table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>@lang('dingsu.name')</th>
										<th>@lang('dingsu.create_Date')</th>
										<th>@lang('dingsu.wechat') @lang('dingsu.name')</th>
										<th>@lang('dingsu.wechat_status')</th>
										<th>@lang('dingsu.status')</th>
									</tr>
								</thead>
								<tbody class="childmemberlist" id="childmemberlist">
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
<!-- Modal Ends -->


<!--Member play Modal starts -->
	<div class="modal fade" id="memberplaylist" tabindex="-1" role="dialog" aria-labelledby="childlist" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('dingsu.member') @lang('dingsu.play') @lang('dingsu.list') </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body" id="memberplayajaxlist">
					
				</div>				
			</div>
		</div>
	</div>
<!-- Modal Ends -->


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>


<script language="javascript">
	
	function OpenWechatVerification(id, notes)
	{
		var wename = $("#show_wechat_name_"+id).val();		
		var status = $("#show_wechat_status_"+id).val();
		var wechat_id = $("#show_wechat_id_"+id).val();
		var alipay_account = $("#show_alipay_account_"+id).val();

		$('#hidden_void').val(id);
		$('#notes').val(notes);
		$('#validation-errors').html('');
		$("#model_wechat_status").val(status);		
		$("#model_wechat_name").val(wename);		
		$("#model_wechat_id").val(wechat_id);	
		$("#model_alipay_account").val(alipay_account);	
		$('#editwechatstatusmode').modal('show');
	}
	
	function OpenUpdateStatus(id)
	{
		var status = $("#show_status_"+id).val();		
		
		
		$('#myid').val(id);
		$('#svalidation-errors').html('');
		$("#model_status").val(status);	
		$('#editstatusmode').modal('show');
	}
	
	function resetpassword(id)
	{
		$('#formresetpassword')[0].reset();
		$('#rid').val(id);
		$('#rvalidation-errors').html('');
		$('#resetpasswordmode').modal('show');
	}
	
	function updatelife()
	{
		var datav =  $("#formtopup").serializeArray();
		var id =$('#rid').val();
		swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.fetching_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )
			$.ajax( {
				url: "{{route('post.ledger.adjustwallet')}}",
				type: 'post',
				dataType: "json",
				data: {
					_method: 'post',
					_token: "{{ csrf_token() }}",
					id:  id,
					datav:datav,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						var data = result.record;
						
						$('#formtopup')[0].reset();
						$('#topupmode').modal('hide');
						
						$("#cl_"+id).html(data.life);
						$("#cp_"+id).html(result.point);
						
						
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		
		$('#topupmode').modal('hide');
	}
	
		
	function saveresetpass()
	{
		var id     =  $("#rid").val();
		var datav =  $("#formresetpassword").serializeArray();
		
		$('#rvalidation-errors').html('');
		swal( {
			title: '@lang("dingsu.please_wait")',
			text: '@lang("dingsu.updating_data")..',
			allowOutsideClick: false,
			closeOnEsc: false,
			allowEnterKey: false,
			buttons: false,
			onOpen: () => {
				swal.showLoading()
			}
		} )
		$.ajax( {
			url: "{{route('ajaxchange.member.resetpass')}}",
			type: 'post',
			dataType: "json",
			data: {
				_method: 'post',
				_token: "{{ csrf_token() }}",
				id:id,
				datav:datav,
			},
			success: function ( result ) {
				if ( result.success != true ) {
					
					$.each(result.message, function(key,value) {
						$('#rvalidation-errors').append('<div class="alert alert-danger">'+value+'</div');
					 });
					swal.close();

				} else {
					swal( '@lang("dingsu.done")', '@lang("dingsu.change_passsword_success")', "success" );
					$('#resetpasswordmode').modal('hide');					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.change_passsword_error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
	}
	
	
	function updatetatus()
	{
		var id     =  $("#myid").val();
		var status =  $("#model_status").val();
		
		$('#svalidation-errors').html('');
		swal( {
			title: '@lang("dingsu.please_wait")',
			text: '@lang("dingsu.updating_data")..',
			allowOutsideClick: false,
			closeOnEsc: false,
			allowEnterKey: false,
			buttons: false,
			onOpen: () => {
				swal.showLoading()
			}
		} )
		$.ajax( {
			url: "{{route('ajaxchange.member.status')}}",
			type: 'post',
			dataType: "json",
			data: {
				_method: 'post',
				_token: "{{ csrf_token() }}",
				id:id,
				status:status,
			},
			success: function ( result ) {
				if ( result.success != true ) {
					
					$.each(result.message, function(key,value) {
						$('#svalidation-errors').append('<div class="alert alert-danger">'+value+'</div');
					 });
					swal.close();

				} else {
					swal( '@lang("dingsu.done")', '@lang("dingsu.approve_success_message")', "success" );
					$('#editstatusmode').modal('hide');
					
					$(".show_update_status_"+id).html(result.badge);
					
					$("#show_status_"+id).val(result.memberstatus);					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.approve_error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
	}
	
	function savewechatstatus()
	{
		var id     =  $("#hidden_void").val();
		var datav =  $("#formupdatewechatstatus").serializeArray();
		
		$('#validation-errors').html('');
		swal( {
			title: '@lang("dingsu.please_wait")',
			text: '@lang("dingsu.updating_data")..',
			allowOutsideClick: false,
			closeOnEsc: false,
			allowEnterKey: false,
			buttons: false,
			onOpen: () => {
				swal.showLoading()
			}
		} )
		$.ajax( {
			url: "{{route('ajaxapprovewechat')}}",
			type: 'post',
			dataType: "json",
			data: {
				_method: 'post',
				_token: "{{ csrf_token() }}",
				_data:datav,
			},
			success: function ( result ) {
				if ( result.success != true ) {
					
					$.each(result.message, function(key,value) {
						$('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
					 });
					swal.close();

				} else {
					swal( '@lang("dingsu.done")', '@lang("dingsu.approve_success_message")', "success" );
					$('#editwechatstatusmode').modal('hide');
					
					$(".show_wechat_name_"+id).html(result.wechat_name);
					
					$(".show_wechat_verification_"+id).html(result.badge);
					
					$("#show_wechat_name_"+id).val(result.wechat_name);		
					$("#show_wechat_status_"+id).val(result.wechat_status);

					$("#show_wechat_id_"+id).val(result.wechat_id);
					$(".show_wechat_id_"+id).val(result.wechat_id);	

					$("#show_alipay_account_"+id).val(result.alipay_account);
					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.approve_error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
	}
	
	
function confirm_Delete(id)	{
	Swal({
	  title: '@lang("dingsu.delete_confirmation")',
	  text: '@lang("dingsu.delete_conf_text")',
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonText: '@lang("dingsu.delete")',
	  cancelButtonText: '@lang("dingsu.cancel")',
		confirmButtonColor: "#DD6B55",
	  closeOnConfirm: false
	}).then((result) => {
	  if (result.value) {
	  
	  $.ajax({
            url: "/member/delete/"+id,
            type: "POST",
            data: {_method: 'delete', _token :"{{ csrf_token() }}"},
            dataType: "html",
            success: function (data) {
				if (data === 'false')
					{
						swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
					}
				else 
					{
						swal('@lang("dingsu.done")', '@lang("dingsu.delete_success")', "success");
						
						$('#tr_'+id).hide(); 
					}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
            }
        });
	  
  } else if (result.dismiss === Swal.DismissReason.cancel) {
   
  }
})
	}	
	

	$(function() {
		
		$(".datalist").on("click",".ShowRecentPlay", function() {
			var id    = $(this).data('id');		
			
			swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.updating_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )			

			$.ajax({
				url: "{{route('played_member_details')}}",
				data: {_method: 'get', _token :"{{ csrf_token() }}",id:id},
			}).done(function (data) {
				$('#memberplayajaxlist').html(data);
				swal.close();
				$('#memberplaylist').modal('show');
			}).fail(function () {
				alert('child list could not be loaded.');
				swal.close();
			});					
						
		});
		
		$(".datalist").on("click",".ShowChildMembers", function() {
			var id    = $(this).data('id');
			var count = $(this).data('count');			
			if (count)
				{
					swal( {
						title: '@lang("dingsu.please_wait")',
						text: '@lang("dingsu.updating_data")..',
						allowOutsideClick: false,
						closeOnEsc: false,
						allowEnterKey: false,
						buttons: false,
						onOpen: () => {
							swal.showLoading()
						}
					} )			

					$.ajax({
						url: "{{route('ajax.child.members')}}",
						data: {_method: 'get', _token :"{{ csrf_token() }}",id:id},
					}).done(function (data) {
						$('.childmemberlist').html(data);
						swal.close();
						$('#childlist').modal('show');
					}).fail(function () {
						alert('child list could not be loaded.');
						swal.close();
					});					
				}		
		});
		
		
		$(".datalist").on("click",".opentopupmodel", function(){
			
			var id=$(this).data('id');
			$('#rid').val(id);
			$('#formtopup')[0].reset(); 
			swal( {
				title: '@lang("dingsu.please_wait")',
				text: '@lang("dingsu.fetching_data")..',
				allowOutsideClick: false,
				closeOnEsc: false,
				allowEnterKey: false,
				buttons: false,
				onOpen: () => {
					swal.showLoading()
				}
			} )
			$.ajax( {
				url: "{{route('get.ledger.detail')}}",
				type: 'get',
				dataType: "json",
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					id:  id,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						var data = result.record;
						
						if (data != null)
							{
								$('#clife').val(data.life);
								$('#cpoint').val(data.point);	
								
								$('#cviplife').val(data.vip_life);
								$('#cvapoint').val(data.vip_point);
								
								
								$('#tid').val(id);
								$('#topupmode').modal('show');
							}
						else 
							{
								swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
							}
						
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		});
		
			$(".filter").on("click",".search", function(e) {
				e.preventDefault();				
				 getdatalist('');			
				
			});
		
			$(".filter").on("click","#reset_search", function(e) {
				e.preventDefault();				
				$('#searchform')[0].reset();
				getdatalist('');	
			});
		
		
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();               
                var url = $(this).attr('href');				
                getdatalist(url);
                
            });
		
		
			$(document).ready(function() {								
				var wes  = "{{ app('request')->input('wechat') }}";
				var west = wes.trim();
				if (west == 12)
				{
					$("#s_wechatstatus").val("1");
					getdatalist('');
				}							
			});

            function getdatalist(url) {				
				if (!url) {
					var url = "{{route('memberlist')}}" ;	
				}
				window.history.pushState("", "", url);
				swal( {
					title: '@lang("dingsu.please_wait")',
					text: '@lang("dingsu.updating_data")..',
					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false,
					buttons: false,
					onOpen: () => {
						swal.showLoading()
					}
				} )				
				
                $.ajax({
                    url : url,
					data: {_method: 'delete', _token :"{{ csrf_token() }}",_data:$("#searchform").serialize()},
                }).done(function (data) {
					$('.datalist').html(data);
					swal.close();
                }).fail(function () {
                    alert('datalist could not be loaded.');
					swal.close();
                });
            }
        });	
		
		
			$('#formedit').on('submit', function(event){
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');				
		var formData = new FormData();		
		$.ajax( {
				url: "{{route('update_gameledger')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) {
					console.log('imhere');
					if ( result.success == true ) {
						swal.close();
						$( '#openmodel' ).modal( 'hide' );			
						var data = result.record;
						swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.update_success_msg")', confirmButtonText: '@lang("dingsu.okay")'});						
						$('#tr_' + result.id).replaceWith(data);
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
										
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal.close();			
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
				}
			} );
		
	});
//get receipt details	
	$(".datalist").on("click",".editrow", function(){
			var id=$(this).data('id');
			$('.inputTxtError').remove();
			show_wait('fetch');
			
			$.ajax( {
				url: "{{route('get_gameledger')}}",
				type: 'get',
				dataType: "json",
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					id:  id,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						var data = result.record;						
						if (data != null)
							{
								$('.renderdata').html(data);
								$('#openmodel').modal('show');
							}
						else 
							{
								swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
							}						
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		});	
</script>
