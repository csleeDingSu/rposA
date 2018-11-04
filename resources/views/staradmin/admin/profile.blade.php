<div class="row">

	<div class="col-12 d-flex  text-right"><a href="javascript:void(0)" onClick="resetpassword('{{ $user->id }}')" class="btn  btn-outline-danger btn-inverse-warning">@lang('dingsu.change') @lang('dingsu.password')</a>
	</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="row">

	<div class="col-12 grid-margin">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.edit_user')</h4>
				<form class="form-sample" action="" method="post" autocomplete="off">

					{{ csrf_field() }} @foreach ($errors->all() as $error)
					<div class="alert alert-danger" role="alert">@lang($error)</div>
					@endforeach @if(session()->has('message'))
					<div class="alert alert-success" role="alert">
						{{ session()->get('message') }}
					</div>
					@endif






					<div class="row">

						<div class="col-md-6">
							<div class="form-group row">
								<label for="firstname" class="col-sm-3 col-form-label">@lang('dingsu.firstname')</label>


								<div class="col-sm-9">
									<input id="firstname" name="firstname" class="form-control" type="text" autofocus value="{{ old('firstname', $user->name) }}">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="username" class="col-sm-3 col-form-label">@lang('dingsu.username')</label>
								<div class="col-sm-9">
									<input disabled id="" name="" class="form-control" type="text" value="{{$user->username}}">
								</div>
							</div>
						</div>
					</div>

					<div class="row">


						<div class="col-md-6">
							<div class="form-group row">
								<label for="email" class="col-sm-3 col-form-label">@lang('dingsu.email')</label>
								<div class="col-sm-9">
									<input id="email" name="email" class="form-control" type="text" required value="{{ old('email', $user->email) }}">
								</div>
							</div>
						</div>


					</div>





					<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
					<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
					<div class="row">






				</form>
				</div>
			</div>
		</div>
	</div>
	
	
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
									<input type="password" required class="form-control" name="password" id="password" value="" maxlength="50">
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.confirm_password')<span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input type="password" required class="form-control" name="confirmpassword" id="confirmpassword" value="" maxlength="50">
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
	</script>