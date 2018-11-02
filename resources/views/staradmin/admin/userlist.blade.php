
<section class="filter">
@include('admin.filter')
</section>

<div class="clearfix">&nbsp;</div>

<section class="datalist">
@include('admin.ajaxlist')
</section>

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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>


<script language="javascript">
	
	
	
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
			url: "{{route('post.user.resetpass')}}",
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
			url: "{{route('post.user.status')}}",
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
            url: "/user/delete/"+id,
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

            function getdatalist(url) {				
				if (!url) {
					var url = "{{route('userlist')}}" ;	
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
</script>
