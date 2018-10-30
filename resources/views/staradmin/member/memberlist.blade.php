<div class="row">

<div class="col-12 d-flex  text-right"><a href="/member/add" class="btn btn-success mr-2">@lang('dingsu.add')</a></div>
</div>
<p>&nbsp;</p>
<div class="row">
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.member') @lang('dingsu.list')</h4>
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.id')</th>
							<th>@lang('dingsu.name')</th>
							<th>@lang('dingsu.create_Date')</th>
							<th>@lang('dingsu.referred_by')</th>
							<th>@lang('dingsu.wechat') @lang('dingsu.name')</th>
							<th>@lang('dingsu.wechat_status')</th>
							<th>@lang('dingsu.status')</th>
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr id="tr_{{ $list->id }}">
							
							<input type="hidden" name="show_wechat_status_{{ $list->id }}" id="show_wechat_status_{{ $list->id }}" value="{{ $list->wechat_verification_status }}">
							
							<input type="hidden" name="show_wechat_name_{{ $list->id }}" id="show_wechat_name_{{ $list->id }}" value="{{ $list->wechat_name }}">
							
							<input type="hidden" name="show_status_{{ $list->id }}" id="show_status_{{ $list->id }}" value="{{ $list->member_status }}">
							
							
							<td>{{ $list->id }}</td>
							<td>{{ $list->username }}</td>
							<td>
								{{ $list->created_at }}
							</td>
							<td>
								{{ $list->parent }}
							</td>
							<td class="show_wechat_name_{{ $list->id }}" id="show_wechat_name_{{ $list->id }}">
								{{ $list->wechat_name }}
							</td>
							<td onClick="OpenWechatVerification('{{ $list->id }}','{{ $list->wechat_notes }}')" class="show_wechat_verification_{{ $list->id }}">
								@if($list->wechat_verification_status == 0)
								<label class="badge badge-success">@lang('dingsu.verified')</label> 
								@elseif ($list->wechat_verification_status == 1)
								<label class="badge badge-info">@lang('dingsu.unverified')</label> 
								@elseif ($list->wechat_verification_status == 2)
								<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
								@elseif ($list->wechat_verification_status == 3)
								<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
								@else 
								@endif
							</td>
							
							<td onClick="OpenUpdateStatus('{{ $list->id }}')" class="show_update_status_{{ $list->id }}">
								@if($list->member_status == 0)
								<label class="badge badge-success">@lang('dingsu.active')</label> 
								@elseif ($list->member_status == 1)
								<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
								@elseif ($list->member_status == 2)
								<label class="badge badge-warning">@lang('dingsu.suspended')</label> 
								@else 
								@endif
							</td>
							<td>							
								<a href="/member/edit/{{ $list->id }}"  class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								
								
								
								<a href="javascript:void(0)" onClick="resetpassword('{{ $list->id }}')"  class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-warning"><i class="icon-key"></i></a>
								
								
								
								
								<a onClick="confirm_Delete({{ $list->id }})"  href="javascript:void(0)" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
								
								
								
								
								 
								
								
								
								
								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
				{!! $result->render() !!}
			</div>
		</div>
	</div>
</div>
</div>

<!-- Wechat status Modal starts -->
<form class="form-sample" name="formupdatewechatstatus" id="formupdatewechatstatus" action="" method="post" autocomplete="on" >
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
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.wechat') @lang('dingsu.name') <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								
								<input type="text" class="form-control" name="model_wechat_name" id="model_wechat_name" value="">
									
							</div>
						</div>
					</div>				
						
					</div>
					
					<div class="row">
						
						<div class="col-md-12">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.category') <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								
								<select class="form-control" name="model_wechat_status" id="model_wechat_status">
								  <option value="0" >@lang('dingsu.verified')</option>
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
								<textarea class="form-control" required  name="notes" id="notes"></textarea>
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
<form class="form-sample" name="formupdatestatus" id="formupdatestatus" action="" method="post" autocomplete="on" >
<div class="modal fade" id="editstatusmode" tabindex="-1" role="dialog" aria-labelledby="editstatusmodelabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">			

				<div class="modal-header">
					<h5 class="modal-title" >@lang('dingsu.change') @lang('dingsu.status')</h5>
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
								  <option value="0" >@lang('dingsu.active')</option>
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
<form class="form-sample" name="formresetpassword" id="formresetpassword" action="" method="post" autocomplete="on" >
<div class="modal fade" id="resetpasswordmode" tabindex="-1" role="dialog" aria-labelledby="resetpasswordmode" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">			

				<div class="modal-header">
					<h5 class="modal-title" >@lang('dingsu.reset') @lang('dingsu.password') </h5>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>




<script language="javascript">
	
	function OpenWechatVerification(id, notes)
	{
		var wename = $("#show_wechat_name_"+id).val();		
		var status = $("#show_wechat_status_"+id).val();
		
		$('#hidden_void').val(id);
		$('#notes').val(notes);
		$('#validation-errors').html('');
		$("#model_wechat_status").val(status);		
		$("#model_wechat_name").val(wename);		
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
				//id:id,
				//notes:notes,
				//status:status,
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
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.approve_error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
	}
	
	
function confirm_Delete(id)
	{
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


	
</script>
