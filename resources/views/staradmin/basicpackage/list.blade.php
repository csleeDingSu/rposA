<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
</div>

<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('basicpackage.filter')
</section>

<section class="datalist">
	@include('basicpackage.ajaxlist')
</section>

<section class="model">
	@include('basicpackage.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
$(".datalist").on("click",".opentopupmodel", function(){
			var id=$(this).data('id');
			$('#rid').val(id);
	
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
				url: "{{route('get.basicpackage.quantity')}}",    
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
								$('#cquantity').val(data.available_quantity);
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
	
function updatequantity()
	{
		var datav =  $("#formtopup").serialize();
		var id =$('#tid').val();
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
				url: "{{route('post.basicpackage.adjustquantity')}}",
				type: 'post',
				dataType: "json",
				data: {
					_method: 'post',
					_token: "{{ csrf_token() }}",
					id:  id,
					_data:datav,
				},
				success: function ( result ) {
					if ( result.success == true ) {
						swal.close();
						var data = result.record;
						$('#atd_'+id).html(result.quantity);
						$('#formtopup')[0].reset();
						$('#topupmode').modal('hide');
						
						swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.quantity_updated_message")', button: '@lang("dingsu.okay")',});
						
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
	
function openmodel() {
		$("#savebtn").html('@lang("dingsu.add")');
		$('#formadd')[0].reset();
		$('#mode').val('create');
		$( '#validation-errors' ).html( '' );
		$('#package_type').attr("disabled", false);
		$( '#openaddmodel' ).modal( 'show' );
	}

	function addpackage() {
		var datav = $( "#formadd" ).serialize();
		$( '#validation-errors' ).html( '' );
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
			url: "{{route('basicpackage.save')}}",
			type: 'post',
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				_data: datav,
			},
			success: function ( result ) {
				if ( result.success != true ) {

					$.each( result.message, function ( key, value ) {
						$( '#validation-errors' ).append( '<div class="alert alert-danger">' + value + '</div' );
					} );
					swal.close()
				} else {
					
					
					
					
					
					if (result.mode == 'edit')
					{
						var data = result.dataval; 
						swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.package_update_success_msg")', confirmButtonText: '@lang("dingsu.okay")'});						
						var id = $('#hidden_void').val();						
						//$( '#tr_' + id ).html(data);
						
						
						$('#tr_' + id).replaceWith(data);
						
					}
					else
					{
						swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.package_added_success_msg")', button: '@lang("dingsu.okay")',});
						
						
						$( '#listtable tr:first' ).after( result.record );
						
					
						
					}
					
					
					
					
					//swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.package_added_success_msg")', confirmButtonText: '@lang("dingsu.okay")',});
					
					//$( "input[type=text], textarea" ).val( "" );
					$( '#openaddmodel' ).modal( 'hide' );
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal({  icon: "error", type: 'error',  title: '@lang("dingsu.error")!',text: '@lang("dingsu.try_again")', confirmButtonText: '@lang("dingsu.okay")'});
			}
		} );
	}

	
	
	$(".listtable").on("click",".editrow", function(){
			var id=$(this).data('id');
		$( '#validation-errors' ).html( '' );
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
				url: "{{route('basicpackage.get')}}",
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
								$('#mode').val('edit');
								$('#package_name').val(data.package_name);
								$('#min_point').val(data.min_point);
								
								$('#price').val(data.package_price);
								$('#status').val(data.package_status);
								$('#package_pic_url').val(data.package_picurl);
								$('#package_description').val(data.package_description);
								$('#package_freepoint').val(data.package_freepoint);
								$('#package_life').val(data.package_life);
								$('#package_type').val(data.package_type);
								
								$('#package_type').attr("disabled", true);
								$('#hidden_void').val(id);
								
								$("#savebtn").html('@lang("dingsu.update")');
								
								$('#openaddmodel').modal('show');
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

	function confirm_Delete( id ) {
		Swal( {
			title: '@lang("dingsu.delete_confirmation")',
			text: '@lang("dingsu.delete_conf_text")',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '@lang("dingsu.delete")',
			cancelButtonText: '@lang("dingsu.cancel")',
			confirmButtonColor: "#DD6B55",
			closeOnConfirm: false
		} ).then( ( result ) => {
			if ( result.value ) {

				$.ajax( {
					url: '{{route('basicpackage.remove')}}',
					headers: {
						'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
					},
					type: 'delete',
					data: {
						id: id,
						_token: "{{ csrf_token() }}",
					},
					dataType: "html",
					success: function ( response ) {

						var response = jQuery.parseJSON( response );
						if ( response.success == false ) {
							swal( '@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error" );
						} else {
							swal( {
								type: 'success',
								title: '@lang("dingsu.done")',
								text: '@lang("dingsu.delete_success")',
								showConfirmButton: true,
								timer: 1000
							} )

							$( '#tr_' + id ).hide();
						}

					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );

			} else if ( result.dismiss === Swal.DismissReason.cancel ) {

			}
		} )
	}
	
	
	
	$( function () {


		$( ".filter" ).on( "click", ".search", function ( e ) {
			e.preventDefault();
			getdatalist( '' );

		} );

		$( ".filter" ).on( "click", "#reset_search", function ( e ) {
			e.preventDefault();
			$( '#searchform' )[ 0 ].reset();
			getdatalist( '' );
		} );


		$( 'body' ).on( 'click', '.pagination a', function ( e ) {
			e.preventDefault();
			var url = $( this ).attr( 'href' );
			getdatalist( url );

		} );

		function getdatalist( url ) {
			if ( !url ) {
				var url = "{{url()->current()}}";
			}
			window.history.pushState( "", "", url );

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
				url: url,
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					_data: $( "#searchform" ).serialize()
				},
			} ).done( function ( data ) {
				$( '.datalist' ).html( data );
				swal.close();
			} ).fail( function () {
				alert( 'datalist could not be loaded.' );
				swal.close();
			} );
		}
	} );
</script>