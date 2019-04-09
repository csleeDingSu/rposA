<div class="clearfix">&nbsp;</div>


<section class="datalist">
	@include('voucher.shareajaxlist')
</section>

<input type="hidden" value="" id="copydiv">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.11/dist/sweetalert2.all.min.js"></script>

<script language="javascript">
	function CopyU(url)
	{
		$('#copydiv').val(url)';
		var copyText = document.getElementById("copydiv");
		copyText.select();
		document.execCommand("copy");
	}
function ProductAction( ) {

				var datav =  $("#productdisplayform").serializeArray();
				var typev =  $( '#product_action' ).val();
			
				swal( {
					title: '@lang("dingsu.delete_confirmation")',
					text: '@lang("dingsu.move_to_voucher_list_text")',
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
								url: "{{route('shareproduct_update')}}",
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
										window.location.href = "share-product";
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
								url: "/share-product/delete/" + id,
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
function CheckorUncheck( id ) {
				if ( $( '.prc_' + id ).val() != 1 ) {
					$( ".prolist_" + id ).addClass( "popular" );
					$( '.prc_' + id ).val( 1 );
				} else {
					$( ".prolist_" + id ).removeClass( "popular" );
					$( '.prc_' + id ).val( 0 );
				}

			}
</script>
