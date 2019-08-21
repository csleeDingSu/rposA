@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div id="so_notification">
</div>
<section class="filter">
	@include('voucher.filter')
</section>


<section class="datalist">
	@include('voucher.ajax_unr_list')
</section>





<!-- Modal starts -->
<form class="form-sample" name="formupdatevoucher" id="formupdatevoucher" action="" method="post" autocomplete="on" >
<div class="modal fade" id="editvouchermode" tabindex="-1" role="dialog" aria-labelledby="editvouchermodelabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			

				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.edit') @lang('dingsu.voucher')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
				</div>
				<div class="modal-body">

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
								<label for="system_category" class="col-sm-3 col-form-label">@lang('dingsu.category') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
										
									@foreach ($category as $cate) 
									<input type="checkbox" id="system_category[{{$cate->id}}]" name="system_category[]" value="{{$cate->id}}" />{{$cate->display_name}}
									@endforeach
								</div>
							</div>
						</div>

						
						
					</div>

					@foreach($sys_title->chunk(2) as $items)
					<div class="row">
					@foreach($items as $item)
						<div class="col-md-6">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.'.$item->title) <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								
								<input id="sys_inp_{{$item->title}}" name="{{$item->title}}" class="form-control" type="text" value="">
							</div>
						</div>
					</div>
					@endforeach 
					</div>
					@endforeach 
					
					 

				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-success" onclick="return Update_voucher();return false;">@lang('dingsu.submit')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>

				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
			
		</div>
	</div>
</div>
	</form> 
<!-- Modal Ends -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

<script language='javascript' >

	@section('socket')
    @parent
	socket.on(perfix+"unr-import" + ":App\\Events\\EventDynamicChannel", function(data) {
				var process = data.data;
				console.log('importprocess:'+process);
				if (process == 'yes')
				{
					$("#import_no_div").remove();
					$( "#so_notification" ).append( '<div id="import_no_div" class="import_no_div alert alert-fill-info" role="alert">   <i class="mdi mdi-alert-circle"></i> @lang("dingsu.import_in_progress")</div>');
					
					$( "#so_notification" ).show();
				}
				else
				{
					$(".import_no_div").remove();
				}
				
			 });
	
     socket.on(perfix+"unr-bulkmove" + ":App\\Events\\EventDynamicChannel", function(data) {
				var process = data.data;
				console.log('moveprocess:'+process);
				if (process == 'yes')
				{
					$(".bulkmove_no_div").remove();
					
					$( "#so_notification" ).append( '<div id="bulkmove_no_div" class="bulkmove_no_div alert alert-fill-danger" role="alert">   <i class="mdi mdi-alert-circle"></i> @lang("dingsu.bulkmove_in_progress")</div>');
					
					$( "#so_notification" ).show();
				}
				else
				{
					$(".bulkmove_no_div").remove();
				}
				
			 });
			
			
			socket.on(perfix+"unr-bulkdelete" + ":App\\Events\\EventDynamicChannel", function(data) {
				var process = data.data;
				console.log('deleteprocess:'+process);
				if (process == 'yes')
				{
					$(".bulkdelete_no_div").remove();
					
					$( "#so_notification" ).append( '<div id="bulkdelete_no_div" class="bulkdelete_no_div alert alert-fill-danger" role="alert">   <i class="mdi mdi-alert-circle"></i> @lang("dingsu.buldelete_in_progress")</div>');
					
					$( "#so_notification" ).show();
				}
				else
				{
					$(".bulkdelete_no_div").remove();
				}
				
			 });
	@endsection


//-------------Save tag category --------------------------------
function save_tag()
{
	var datav =  $("#productdisplayform").serializeArray();
	var datat =  $("#voucher_tag").serializeArray();
	var id    =  $("#hidden_void").val();
	swal( {
		title: '@lang("dingsu.edit_confirmation")',
		text: '@lang("dingsu.edit_conf_text")',
		icon: "warning",
		closeModal: false,
		buttons: [
			'@lang("dingsu.cancel")',
			'@lang("dingsu.update")'
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
					url: "{{route('ajaxupdateunrvouchertag')}}",
					type: 'post',
					dataType: "json",
					data: {
						_method: 'post',
						_token: "{{ csrf_token() }}",
						_data: datav,
						_datat: datat,
						
					},
					success: function ( result ) {
						if ( result.success != true ) {
							swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
						} else {
							swal( "Done!", '@lang("dingsu.voucher_update_success_message")', "success" );
							$('#editvouchermode').modal('hide');

						}
					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );
			}
		} );
}




function Update_voucher()
{
	
	var datav =  $("#formupdatevoucher").serializeArray();
	var id    =  $("#hidden_void").val();
	swal( {
		title: '@lang("dingsu.edit_confirmation")',
		text: '@lang("dingsu.edit_conf_text")',
		icon: "warning",
		closeModal: false,
		buttons: [
			'@lang("dingsu.cancel")',
			'@lang("dingsu.update")'
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
					url: "{{route('ajax_unrv_updatevoucher')}}",
					type: 'post',
					dataType: "json",
					data: {
						_method: 'post',
						_token: "{{ csrf_token() }}",
						_data:datav,
						id:id,
					},
					success: function ( result ) {
						if ( result.success != true ) {
							swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
						} else {
							swal( "Done!", '@lang("dingsu.voucher_update_success_message")', "success" );
							$('#editvouchermode').modal('hide');

						}
					},
					error: function ( xhr, ajaxOptions, thrownError ) {
						swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
					}
				} );
			}
		} );
}

$(document).ready(function() {
	$( 'body' ).on( 'click', '.openeditmodel', function ( e ) {
		//$('.openeditmodel').click(function() {
			var id=$(this).data('id');

			$('#formupdatevoucher')[0].reset();
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
				url: "/voucher/show-unrv/"+ id,
				type: 'get',
				dataType: "json",
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
				},
				success: function ( result ) {
					if ( result.success == true ) {
						
						var data = result.record;
						var data_tagcategory = result.tagcategory;
						console.log(data);
						console.log(data_tagcategory);
						var vcategory = null;
						
						$("input[name='system_category[]']").each( function () {
							cposition = $(this).val();
							$.each( data_tagcategory, function( key, value ) {
							tags= value.category;

							if (document.getElementById('system_category[' + cposition + ']').checked== true)
								{
									console.log('true'+'system_category[' + cposition + ']');
									console.log(tags);
								}

							if (tags == cposition) {
								document.getElementById('system_category[' + cposition + ']').checked = true;		
								// console.log('true');						
							} else if (tags != cposition && document.getElementById('system_category[' + cposition + ']').checked== false){
								document.getElementById('system_category[' + cposition + ']').checked = false;	
								// console.log('unchecked');
							}	
						});
						
					});
						
						@foreach($sys_title as $items)
						var ifv = '{{$items->title}}';
							$('#sys_inp_'+ifv).val(data.{{$items->title}});
						
							if (ifv == 'product_category')
							{
								console.log(ifv);
								console.log(data.category);								
								var vcategory = data.category;
							}
						
						@endforeach 
						var category = result.syscategory;
						
						 $('#system_category')
							  .find('option')
							  .remove()
							  .end();
						
						 $.each(category, function(key, value){
							  $('#system_category')
							  .append($('<option>', { value : value.id })
							  .text(value.display_name));
						});

						$("#system_category").val(vcategory);
					
						$('#hidden_void').val(id);
						swal.close();
						$('#editvouchermode').modal('show');
					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				}
			} );
		});
	});
			
			
			
			function Checkall() {
				if ( $( "#checkall" ).is( ':checked' ) ) {
					$( 'input[id="prc[]"]' ).map( function () {
						this.value = 1;
						myVal = this.getAttribute('data-id'); 
						var id = myVal.substr( myVal.indexOf( '_' ) + 1 );
						$( ".prolist_" + id ).addClass( "popular" );
					} )
				} else {
					$( 'input[id="prc[]"]' ).map( function () {

						this.value = 0;
						myVal = this.getAttribute('data-id'); 
						var id = myVal.substr( myVal.indexOf( '_' ) + 1 );
						$( ".prolist_" + id ).removeClass( "popular" );
					} )
				}
			}

			function CheckorUncheck( id ) {
				if ( $( '.prc_' + id ).val() != 1 ) {
					$( ".prolist_" + id ).addClass( "popular" );
					$( '.prc_' + id ).val( 1 );
				} else {
					$( ".prolist_" + id ).removeClass( "popular" );
					$( '.prc_' + id ).val( 0 );
				}

			}
			
			
			function ProductAction( ) {

				var datav =  $("#productdisplayform").serializeArray();
				var typev =  $( '#product_action' ).val();
			
				swal( {
					title: '@lang("dingsu.delete_confirmation")',
					// text: '@lang("dingsu.move_to_voucher_list_text")',
					icon: "warning",
					closeModal: false,
					buttons: [
						'@lang("dingsu.cancel")',
						'@lang("dingsu.submit")'
					],

					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false

				} ).then(
					function ( preConfirm ) {
						if ( preConfirm ) {
							swal( {
								title: '@lang("dingsu.please_wait")',
								text: '@lang("dingsu.moving_data")..',
								allowOutsideClick: false,
								closeOnEsc: false,
								allowEnterKey: false,
								buttons: false,
								onOpen: () => {
									swal.showLoading()
								}
							} )
							$.ajax( {
								url: "{{route('unrv_update')}}",
								type: 'post',
								dataType: "html",
								data: {
									_method: 'delete',
									_token: "{{ csrf_token() }}",
									_data:datav,
									_type:typev,
								},
								success: function ( result ) {
									if ( result == false ) {
										swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
									} else {
										swal( '@lang("dingsu.done")', '@lang("dingsu.vouchers_deleted_success")', "success" );
										
										var obj = JSON.parse(result);
										$.each(obj, function(key,val){
											 console.log(key);
											 console.log(val); 
											
											$('#divprolist_'+val ).remove();
											var $target = $( '.divprolist_' + val ).parents( 'li' );
											$target.hide( 'slow', function () {
												$target.remove();
											} );
											

										});
										window.location.href = "unreleased";
									}
								},
								error: function ( xhr, ajaxOptions, thrownError ) {
									swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
								}
							} );
						}
					} );

			}


			function Deletevoucher( id ) {


				swal( {
					title: '@lang("dingsu.delete_confirmation")',
					// text: '@lang("dingsu.delete_conf_text")',
					icon: "warning",
					closeModal: false,
					buttons: [
						'@lang("dingsu.cancel")',
						'@lang("dingsu.delete")'
					],

					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false

				} ).then(
					function ( preConfirm ) {
						if ( preConfirm ) {
							swal( {
								title: '@lang("dingsu.please_wait")',
								// text: '@lang("dingsu.deleting_data")..',
								allowOutsideClick: false,
								closeOnEsc: false,
								allowEnterKey: false,
								buttons: false,
								onOpen: () => {
									swal.showLoading()
								}
							} )
							$.ajax( {
								url: "/voucher/ur-delete/" + id,
								type: 'delete',
								dataType: "json",
								data: {
									_method: 'delete',
									_token: "{{ csrf_token() }}",
								},
								success: function ( result ) {
									if ( result == false ) {
										swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
									} else {
										swal( "Done!", '@lang("dingsu.vouchers_deleted_success")', "success" );
										
										
										$('#divprolist_'+id ).remove();
										
										
										var $target = $( '.divprolist_' + id ).parents( 'li' );
										$target.hide( 'slow', function () {
											$target.remove();
										} );
										
										
									}
								},
								error: function ( xhr, ajaxOptions, thrownError ) {
									swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
								}
							} );
						}
					} );

			}



			function PublishFile() {

				var filename = $( "#filedata" ).val();
				if ( filename == '0' ) {
					swal( {
						title: '@lang("dingsu.select_file_error")',
						text: '@lang("dingsu.try_again")',
						type: "success",

						timer: 1000,
						button: false,
					} );
					return false;
				}

				swal( {
					title: '@lang("dingsu.move_confirmation")',
					// text: '@lang("dingsu.move_conf_text")',
					icon: "warning",
					closeModal: false,
					buttons: [
						'@lang("dingsu.cancel")',
						'@lang("dingsu.publish")'
					],

					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false

				} ).then(
					function ( preConfirm ) {
						if ( preConfirm ) {
							swal( {
								title: '@lang("dingsu.please_wait")',
								text: '@lang("dingsu.moving_data")..',
								allowOutsideClick: false,
								closeOnEsc: false,
								allowEnterKey: false,
								buttons: false,
								onOpen: () => {
									swal.showLoading()
								}
							} )
							$.ajax( {
								url: "/voucher/publishfile/" + filename,
								type: 'post',
								dataType: "html",
								data: {
									_method: 'post',
									_token: "{{ csrf_token() }}",
								},
								success: function ( result ) {
									if ( result === 'false' ) {
										swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
									} else {
										swal( "Done!", '@lang("dingsu.vouchers_publish_success")', "success" );

										$( '#filedata option[value="' + filename + '"]' ).remove();

									}
								},
								error: function ( xhr, ajaxOptions, thrownError ) {
									swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
								}
							} );
						}
					} );
			}




			function RemoveDuplicatevoucher() {
				swal( {
					title: '@lang("dingsu.delete_confirmation")',
					// text: '@lang("dingsu.delete_conf_text")',
					icon: "warning",
					closeModal: false,
					buttons: [
						'@lang("dingsu.cancel")',
						'@lang("dingsu.submit")'
					],

					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false

				} ).then(
					function ( preConfirm ) {
						if ( preConfirm ) {
							swal( {
								title: '@lang("dingsu.please_wait")',
								// text: '@lang("dingsu.deleting_data")..',
								allowOutsideClick: false,
								closeOnEsc: false,
								allowEnterKey: false,
								buttons: false,
								onOpen: () => {
									swal.showLoading()
								}
							} )
							$.ajax( {
								url: "/voucher/remove-unr-duplicate/",
								type: 'delete',
								dataType: "html",
								data: {
									_method: 'delete',
									_token: "{{ csrf_token() }}",
								},
								success: function ( result ) {
									swal( "Done!", '@lang("dingsu.delete_success")', "success" );
								},
								error: function ( xhr, ajaxOptions, thrownError ) {
									swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
								}
							} );
						}
					} );
			}

 			$( ".btnduplicate" ).addClass( "disabled" );
			$("#filedata").prop("disabled", true);
	
			$( window ).on( 'load', function () {
				$.ajax( {
					url: '{{route('ajaxfindunrvoucherduplicate')}}',
					type: 'get',
					contentType: 'application/json; charset=utf-8',
					success: function ( response ) {
						if ( response.success == true ) {
							if (response.record>0)
							{
								$( ".btnmove" ).addClass( "disabled" );
								$("#filedata").prop("disabled", false);
								$( ".btnduplicate" ).removeClass( "disabled" ).addClass( "enable" );
								var outdata = '@lang("dingsu.duplicate_ajax_msg")';
								outdata = outdata.replace( "##count##", response.record );
								$( '#duplicatefinder' ).html( '<b>'+outdata+'</b>' );
							}
					   else 
					   {
					   		$( ".btnmove" ).removeClass( "disabled" );
							$("#filedata").prop("disabled", false);
					   }
							
						}


					},
					error: function () {}
				} );
			} );

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
					var url = "{{route('unreleasedvoucherlist')}}";
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
