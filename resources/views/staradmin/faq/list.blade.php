<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
</div>

<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('faq.filter')
</section>

<section class="datalist">
	@include('faq.ajaxlist')
</section>

<!-- Modal starts -->
<form class="form-sample" name="formfaq" id="formfaq" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.add') @lang('dingsu.faq')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="title" class="col-sm-3 col-form-label">@lang('dingsu.title') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="title" name="title" class="form-control" type="text" autofocus value="{{ old('title')}}">
								</div>
							</div>
						</div>
						
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="seq" class="col-sm-3 col-form-label">@lang('dingsu.seq') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="seq" name="seq" class="form-control" type="text" autofocus value="{{ old('seq')}}">
								</div>
							</div>
						</div>
						
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group row">
								<label for="code" class="col-sm-3 col-form-label">@lang('dingsu.content')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<textarea class="form-control" name="content" id="content" placeholder="{{ old('content')}}">{{ old('content')}}</textarea>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="savebtn" class="btn btn-success savebtn" onclick="return addfaq();return false;">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
				<input type="hidden" name="mode" id="mode" value="create">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	function openmodel() {
		$("#savebtn").html('@lang("dingsu.add")');
		$('#formfaq')[0].reset();
		$('#mode').val('create');
		$( '#openeditmodel' ).modal( 'show' );
	}
	
	$(".faqtable").on("click",".editfaq", function(){
			var id=$(this).data('id');
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
				url: "{{route('faq.get')}}",
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
								$('#title').val(data.title);
								$('#content').val(data.content);
								$('#seq').val(data.seq);
								
								$('#hidden_void').val(id);
								
								$("#savebtn").html('@lang("dingsu.update")');
								
								$('#openeditmodel').modal('show');
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

	function addfaq() {
		
		
		
		var datav = $( "#formfaq" ).serializeArray();
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
			url: "{{route('faq.create')}}",
			type: 'post',
			dataType: "json",
			data: {
				_token: "{{ csrf_token() }}",
				_datav: datav,
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
						swal( {
							type: 'success',
							title: '@lang("dingsu.done")',
							text: '@lang("dingsu.faq_update_success_msg")',
							showConfirmButton: true,
							timer: 1000
						} );
						var id = $('#hidden_void').val();
						$('#st_'+id).html(data.title);
						$('#sc_'+id).html(data.content);
						$('#ss_'+id).html(data.seq);
						
					}
					else
					{
						swal( {
							type: 'success',
							title: '@lang("dingsu.done")',
							text: '@lang("dingsu.faq_added_success_msg")',
							showConfirmButton: true,
							timer: 1000
						} );
						$( '#faqtable tr:first' ).after( result.record );
						
					}
					
					$( "input[type=text], textarea" ).val( "" );
					$( '#openeditmodel' ).modal( 'hide' );
					
				}
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
			}
		} );
	}


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
					url: '{{route('faq.remove')}}',
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
				var url = "{{route('faq.list')}}";
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