<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
</div>

<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('env.filter')
</section>

<section class="datalist">
	@include('env.ajaxlist')
</section>

<section class="model">
	@include('env.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/css/bootstrap-editable.css" integrity="sha256-YsJ7Lkc/YB0+ssBKz0c0GTx0RI+BnXcKH5SpnttERaY=" crossorigin="anonymous" />


<script src="{{ asset('staradmin/js/bootstrap-editable.min.js') }}"></script>

<script src="{{ asset('staradmin/js/editable.js') }}"></script>

<script language="javascript">
	
	
function openmodel() {
		$("#savebtn").html('@lang("dingsu.add")');
		$('#formadd')[0].reset();
		$( '#openaddmodel' ).modal( 'show' );
	}
$('#formadd').on('submit', function(event){
		event.preventDefault();
		var formData = new FormData();	
		$( '#validation-errors' ).html( '' );
			//$('#rid').val(id);
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
				url: "{{route('add_env_record')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) 
				{					
					$( '#openaddmodel' ).modal( 'hide' );
					swal.close();
					var data = result.record;
					swal({  icon: 'success',  title: '@lang("lang.done")!',text: '@lang("lang.record_added_success_msg")', button: '@lang("lang.okay")',});
					$( '#listtable tr:first' ).after( result.record );
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
					console.log(xhr.status);;
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
				}
			} );
		});	
	

$(".datalist").on("click",".editrow", function(){
			var key=$(this).data('key');
	
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
				url: "{{route('edit_env_record')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) 
				{					
					$( '#openaddmodel' ).modal( 'hide' );
					swal.close();
					var data = result.record;
					swal({  icon: 'success',  title: '@lang("lang.done")!',text: '@lang("lang.record_added_success_msg")', button: '@lang("lang.okay")',});
					$( '#listtable tr:first' ).after( result.record );
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
					console.log(xhr.status);;
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
				}
			} );
	
	
		});	
	
	
$(".datalist").on("click",".deleterow", function(){
			var key=$(this).data('key');
			Swal( {
			title: '@lang("lang.delete_confirmation")',
			text: '@lang("lang.delete_conf_text")',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '@lang("lang.delete")',
			cancelButtonText: '@lang("lang.cancel")',
			confirmButtonColor: "#DD6B55",
			closeOnConfirm: false
		} ).then( ( result ) => {
			if ( result.value ) {

				$.ajax( {
					url: '{{route('delete_env_record')}}',
					headers: {
						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
					},
					type: 'delete',
					data: {
						name: key,
						_token: "{{ csrf_token() }}",
					},
					dataType: "html",
					success: function ( response ) {

							swal( {
								type: 'success',
								title: '@lang("lang.done")',
								text: '@lang("lang.delete_success")',
								showConfirmButton: true,
								timer: 1000
							} )

							$( '#tr_' + key ).hide();
						

					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("lang.delete_error")', '@lang("lang.try_again")', "error" );
					}
				} );

			}
		} )
		});	
</script>