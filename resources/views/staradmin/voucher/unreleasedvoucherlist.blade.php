
		<div class="row">
			<div class="col-md-6">

				<a href="/voucher/upload" class="btn btn-success mr-2">@lang('dingsu.add')</a>

				<a href="/voucher/import" class="btn btn-info mr-2">@lang('dingsu.upload')</a>

			</div>

			<div class="col-md-6">
				<form class="form-sample" action="" method="post" name="publishsource" id="publishsource">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group row">

								<div class="col-sm-9">
									<select class="form-control" name="filedata" id="filedata">
										<option value="0">@lang('dingsu.please_select_to_move')</option>
										@foreach ($files as $file)
										<option value="{{$file->filename}}">{{$file->filename}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group row">


								<a onClick="PublishFile()" data-token="{{ csrf_token() }}" href="#" class="btn btn-inverse-success  btn-outline-success btnmove" id="btnmove">@lang('dingsu.move')</a>
					
								

							</div>
						</div>
					</div>
				</form>
			</div>
		</div>


		{!! $result->render() !!}
<div class="row">
	<!--
<div class="card">
<div class="card-body">-->
	<div class=" col-md-7">
		<p class="card-description display-4" id="">
			<span class="duplicatefinder" id="duplicatefinder"></span>
			<a onClick="RemoveDuplicatevoucher()" data-token="{{ csrf_token() }}" href="#" class="btn btn-inverse-success  btn-outline-danger btnduplicate" id="btnduplicate">@lang('dingsu.remove') @lang('dingsu.duplicate')</a>
		</p>
	</div>
	<div class=" col-md-5 ">

		<div class="form-group row">
			<div class="col">
				<div class=" form-check form-check-flat">
					<label for="checkall" class="form-check-label">
                                <input class="form-check-input " type="checkbox" name="checkall" id="checkall" onClick="return Checkall();"> @lang('dingsu.check_all')</label>
				</div>
			</div>
			<div class="col">
				<select class="form-control" name="product_action" id="product_action">
					<option value="0">@lang('dingsu.please_select_to_move')</option>
					@foreach ($files as $file)
					<option value="move">@lang('dingsu.move')</option>
					<option value="delete">@lang('dingsu.delete')</option>
					@endforeach
				</select>
			</div>
			<div class="col">
				<a onClick="ProductAction()" data-token="{{ csrf_token() }}" href="#" class="btn btn-inverse-success  btn-outline-success btnsubmit" id="btnsubmit">@lang('dingsu.submit')</a>
			</div>
		</div>


		<!--
</div>
</div>-->
	</div>
</div>


		<form action="" name="productdisplayform" id="productdisplayform">


			<ul class="row list-unstyled">
				@foreach($result as $item)
				<li class="col-md-2 divprolist_{{$item->id}}" id="divprolist_{{$item->id}}" onclick="CheckorUncheck('{{$item->id}}')">

					<input type="hidden" class="prc_{{$item->id}}" data-id="prc_{{$item->id}}" name="{{$item->id}}" id="prc[]" value="{{$item->id}}">

					<div class="prolist_{{$item->id}} card m-b-5 ">
						<div class="price-off">{{$item->product_price}} $</div>
						<img class="card-img-top img-fluid" src="{{$item->product_picurl}}" alt="{{$item->product_name}}">
						<div class="card-body">
							<h5 class="card-title mt-0">{{$item->product_name}}</h5>
							<p class="card-text">Seller : {{$item->product_category}}</p>
							<p class="card-text">Seller : {{$item->seller_name}}</p>
							<button type="button" class="btn btn-inverse-info">Edit</button>
							<button type="button" onClick="return Deletevoucher('{{ csrf_token() }}',{{$item->id}});return false;" class="btn btn-inverse-danger">Delete</button>
						</div>
					</div>
				</li>
				@endforeach
			</ul>
		</form>
		{!! $result->render() !!}

		<!--

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

-->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

		<script language="javascript">
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
				//var sdsdf= $( "prc_"+ id  ).data( "foo" );
				//alert(sdsdf);
				if ( $( '.prc_' + id ).val() != 1 ) {
					$( ".prolist_" + id ).addClass( "popular" );
					$( '.prc_' + id ).val( 1 );
				} else {
					$( ".prolist_" + id ).removeClass( "popular" );
					$( '.prc_' + id ).val( 0 );
				}

			}
			/*
			function CheckorUncheck( id ) {
				if ( $( '#prc_' + id ).val() != 1 ) {
					$( ".prolist_" + id ).addClass( "popular" );
					$( '#prc_' + id ).val( 1 );
				} else {
					$( ".prolist_" + id ).removeClass( "popular" );
					$( '#prc_' + id ).val( 0 );
				}

			}*/
			
			
			function ProductAction( ) {

				//var pid =  $( '#prc_' + id ).val();
				var datav =  $("#productdisplayform").serializeArray();
				//var datav =  $("#productdisplayform").val();
				var typev =  $( '#product_action' ).val();
				//var datav =  '';
				//productdisplayform
				
				swal( {
					title: '@lang("dingsu.delete_confirmation")',
					text: '@lang("dingsu.delete_conf_text")',
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
								text: '@lang("dingsu.deleting_data")..',
								allowOutsideClick: false,
								closeOnEsc: false,
								allowEnterKey: false,
								buttons: false,
								onOpen: () => {
									swal.showLoading()
								}
							} )
							$.ajax( {
								url: "/voucher/bulkupdate/",
								type: 'post',
								dataType: "html",
								data: {
									_method: 'delete',
									_token: "{{ csrf_token() }}",
									_data:datav,
									_type:typev,
								},
								success: function ( result ) {
									if ( result === 'false' ) {
										swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
									} else {
										swal( "Done!", '@lang("dingsu.vouchers_deleted_success")', "success" );
										/*$( '.divprolist_' + id ).remove();

										var $target = $( '.divprolist_' + id ).parents( 'li' );
										$target.hide( 'slow', function () {
											$target.remove();
										} );
										*/
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
					text: '@lang("dingsu.delete_conf_text")',
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
								text: '@lang("dingsu.deleting_data")..',
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
								dataType: "html",
								data: {
									_method: 'delete',
									_token: "{{ csrf_token() }}",
								},
								success: function ( result ) {
									if ( result === 'false' ) {
										swal( '@lang("dingsu.publish_error")', '@lang("dingsu.try_again")', "error" );
									} else {
										swal( "Done!", '@lang("dingsu.vouchers_deleted_success")', "success" );
										$( '.divprolist_' + id ).remove();

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
					text: '@lang("dingsu.move_conf_text")',
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
					text: '@lang("dingsu.delete_conf_text")',
					icon: "warning",
					closeModal: false,
					buttons: [
						'@lang("dingsu.cancel")',
						'@lang("dingsu.move")'
					],

					allowOutsideClick: false,
					closeOnEsc: false,
					allowEnterKey: false

				} ).then(
					function ( preConfirm ) {
						if ( preConfirm ) {
							swal( {
								title: '@lang("dingsu.please_wait")',
								text: '@lang("dingsu.deleting_data")..',
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



			$( window ).on( 'load', function () {
				$.ajax( {
					url: '{{route('ajaxfindunrvoucherduplicate')}}',
					type: 'get',
					contentType: 'application/json; charset=utf-8',
					success: function ( response ) {
						if ( response ) {
							//$( ".btnmove" ).addClass( "disabled" );
							//$("#filedata").prop("disabled", true);
							var outdata = '@lang("dingsu.duplicate_ajax_msg")';
							outdata = outdata.replace( "##count##", response );
							$( '#duplicatefinder' ).html( outdata );
						}


					},
					error: function () {}
				} );
			} );
		</script>