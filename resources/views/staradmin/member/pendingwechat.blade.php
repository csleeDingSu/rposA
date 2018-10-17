
<link rel="stylesheet" href=" {{ asset('staradmin/css/voucher.css') }}">

		{!! $result->render() !!}
<div class="row">
	
</div>


		<form action="" name="productdisplayform" id="productdisplayform">


			<ul class="row list-unstyled productlist" id="productlist">
				@foreach($result as $item)
				
				<li class="divprolist_{{$item->id}} col-md-2 row is-flex justify-content-around mr-md-2 mt-2" id="divprolist_{{$item->id}}" >
					
					<div class="d-flex justify-content-around">
					
					<div class="prolist_{{$item->id}} card " >
						<div class="card-body" onclick="CheckorUncheck('{{$item->id}}')">
							<input type="hidden" class="prc_{{$item->id}}" data-id="prc_{{$item->id}}" name="{{$item->id}}" id="prc[]" value="{{$item->id}}">
							
						<img class="card-img-top img-fluid" src="/uploads/avatars/{{ isset($item->profile_pic) ? $item->profile_pic : 'avatar-default' }}.jpg" alt="{{$item->lastname}}">
							
							<h5 class="card-title mt-0">@lang('dingsu.wechat') @lang('dingsu.name'): {{$item->wechat_name}}</h5>
							<p class="card-text mt-0">@lang('dingsu.username') : {{$item->username}} </p>
							<p class="card-text mt-0">@lang('dingsu.name') : {{$item->firstname}} {{$item->lastname}}</p>
							<p class="card-text mt-0">{{$item->phone}}</p>							
						</div>
						
						<div class="card-body border-top pt-1 mt-auto d-flex align-items-end ">
							<div class="btn-toolbar">
							<button onClick="return Approveaccount({{$item->id}});return false;" type="button" data-id="{{$item->id}}" id="{{$item->id}}" class="btn btn-inverse-info ">@lang('dingsu.approve')</button>&nbsp;
							
								<button onClick="return Rejectaccount({{$item->id}});return false;" type="button" class="btn btn-inverse-danger">@lang('dingsu.reject')</button>							
							</div>
						</div>
							
					</div>
					</div>
				</li>
				@endforeach
			</ul>
		</form>
		{!! $result->render() !!}

@unless (count($result))    
	@include ('common.norecord')
@endunless

	

<!-- Modal starts -->
<form class="form-sample" name="formupdatevoucher" id="formupdatevoucher" action="" method="post" autocomplete="on" >
<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			

				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.reject') @lang('dingsu.wechat') @lang('dingsu.account')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					
					<div class="row">					
						<div class="col-md-6">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.notes') <span class="text-danger">*</span></label>
							<div class="col-sm-9">								
								<textarea class="form-control"  name="notes" id="notes"></textarea>
							</div>
						</div>
					</div>					
					</div>
					

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return postaccountreject();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
			
		</div>
	</div>
</div>
	</form> 
<!-- Modal Ends -->


		
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

		<script language="javascript">
function Approveaccount(id)
{	
	swal( {
		title: '@lang("dingsu.approve_confirmation")',
		text: '@lang("dingsu.approve_conf_text")',
		icon: "warning",
		closeModal: false,
		buttons: [
			'@lang("dingsu.cancel")',
			'@lang("dingsu.approve")'
		],
		allowOutsideClick: false,
		closeOnEsc: false,
		allowEnterKey: false
	} ).then(
		function ( preConfirm ) {
			if ( preConfirm ) {
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
						id:id,
					},
					success: function ( result ) {
						if ( result.success != true ) {
							//swal( '@lang("dingsu.approve_error")', '@lang("dingsu.try_again")', "error" );
							
							$.each(result.message, function(key,value) {
								swal( '@lang("dingsu.approve_error")', value, "error" );
							 });
							
							
						} else {
							swal( "Done!", '@lang("dingsu.approve_success_message")', "success" );
							$('#divprolist_'+id ).remove();
						}
					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.approve_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );
			}
		} );
}
	
function Rejectaccount(id)
{	
	$('#hidden_void').val(id);
	$('#notes').val('');
	$('#openeditmodel').modal('show');
}
function postaccountreject()
{
	var id    =  $("#hidden_void").val();
	var notes =  $("#notes").val();
	
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
		url: "{{route('post.wechat.reject')}}",
		type: 'post',
		dataType: "json",
		data: {
			_method: 'post',
			_token: "{{ csrf_token() }}",
			id:id,
			notes:notes,
		},
		success: function ( result ) {
			if ( result.success != true ) {
				//swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				
				$.each(result.message, function(key,value) {
					 $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
				 });
				//errorclass alert alert-danger
				swal.close()
			} else {
				swal( "Done!", '@lang("dingsu.account_reject_success")', "success" );
				$('#divprolist_'+id ).remove();
				$('#openeditmodel').modal('hide');
			}
		},
		error: function ( xhr, ajaxOptions, thrownError ) {
			swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
		}
	} );
}			

		</script>