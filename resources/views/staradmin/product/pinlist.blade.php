<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
	<a href="/product/import" class="btn btn-info mr-2">@lang('dingsu.import')</a>
</div>

<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('product.pin_filter')
</section>

<section class="datalist">
	@include('product.pin_ajaxlist')
</section>

<!-- Modal starts -->
<form class="form-sample" name="formupdatevoucher" id="formupdatevoucher" action="" method="post" autocomplete="on">
	<div class="modal fade" id="openeditmodel" tabindex="-1" role="dialog" aria-labelledby="openeditmodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editvouchermodelabel">@lang('dingsu.add') @lang('dingsu.softpin')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>				
				</div>
				<div class="modal-body">
					<div class="" id="validation-errors"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="pin_name" class="col-sm-3 col-form-label">@lang('dingsu.pin_name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="pin_name" name="pin_name" class="form-control" type="text" autofocus value="{{ old('pin_name')}}">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="product_list" class="col-sm-3 col-form-label">@lang('dingsu.product') @lang('dingsu.name') <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<select name="product_list" id="product_list" class="form-control"></select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label for="code" class="col-sm-3 col-form-label">@lang('dingsu.code')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="code" name="code" class="form-control" type="text" autofocus value="{{ old('code')}}">
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="passcode" class="col-sm-3 col-form-label">@lang('dingsu.passcode')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="passcode" name="passcode" class="form-control" type="text" autofocus value="{{ old('passcode')}}">
								</div>
							</div>
						</div>
						
					</div>

					<div class="row">						
						<div class="col-md-6">
							<div class="form-group row">
								<label for="code_hash" class="col-sm-3 col-form-label">@lang('dingsu.codehash')  <span class="text-danger">*</span></label>
								<div class="col-sm-9">
									<input id="code_hash" name="code_hash" class="form-control" type="text" autofocus value="{{ old('code_hash')}}">
								</div>
							</div>
						</div>
						
					</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="return addpins();return false;">@lang('dingsu.add')</button>
					<button type="button" class="btn btn-dark" data-dismiss="modal">@lang('dingsu.cancel')</button>
				</div>
				<input type="hidden" name="hidden_void" id="hidden_void" value="">
			</div>
		</div>
	</div>
</form>
<!-- Modal Ends -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	function openmodel() {
		$( '#openeditmodel' ).modal( 'show' );
	}

	function addpins() {
		var datav = $( "#formupdatevoucher" ).serializeArray();
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
			url: "{{route('pin.create')}}",
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
					//swal( '@lang("dingsu.done")', '@lang("dingsu.pin_added_success_msg")', "success" );

					swal( {
						type: 'success',
						title: '@lang("dingsu.done")',
						text: '@lang("dingsu.pin_added_success_msg")',
						showConfirmButton: true,
						timer: 1000
					} );
					$( "input[type=text], textarea" ).val( "" );
					$( '#pintable tr:first' ).after( result.record );
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
					url: '{{route('pin.remove')}}',
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

	$( window ).on( 'load', function () {
		$.ajax( {
			url: '{{route('product.ajax.list')}}',
			type: 'get',
			contentType: 'application/json; charset=utf-8',
			success: function ( response ) {
				if ( response.success == true ) {
					var category = response.records;
					$( '#product_list' )
						.find( 'option' )
						.remove()
						.end();
					$.each( category, function ( key, value ) {
						$( '#product_list' )
							.append( $( '<option>', {
									value: value.id
								} )
								.text( value.product_name ) );
					} );
	
					$('#pin_name').val($( '#product_list' ).find("option:first-child").text());
				
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
				var url = "{{route('pin.list')}}";
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
	
	
	$('#product_list').on('change', function() {
		$('#pin_name').val($(this).find(":selected").text());
	}).trigger('change');
</script>