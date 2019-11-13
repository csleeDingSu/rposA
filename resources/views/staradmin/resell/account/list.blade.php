<div class="row">

	<div class="col-2  ">
		<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add') @lang('dingsu.bank')</a>
	</div>

	<div class="col-2">
		<a onClick="return openmembermodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add') @lang('dingsu.member')</a>
	</div>
</div>
<div class="clearfix">&nbsp;</div>
<section class="filter">
	
</section>

<section class="datalist">
	@include('resell.account.ajaxlist')
</section>

<section class="datamemberlist">
	@include('resell.account.memberajaxlist')
</section>

<section class="models text-capitalize modellist">
	@include('resell.account.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>

@section('bottom_js')
@parent

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
function openmodel() {
		$('#formadd')[0].reset();
		$('.inputTxtError').remove();
		$( '#openaddmodel' ).modal( 'show' );
	}
function openmembermodel() {
		$('#formmemberadd')[0].reset();
		$('.inputTxtError').remove();
		$( '#openmemberaddmodel' ).modal( 'show' );
	}	
$('#formmemberadd').on('submit', function(event){		
		var formData = new FormData();		
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');			

		$.ajax( {			
			url: "{{route('add_resell_member')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,

			success: function ( result ) {				
					swal( {
							type: 'success',
							title: '@lang("dingsu.done")',
							text: '@lang("dingsu.success_msg")',
							showConfirmButton: true,
							timer: 1000
						} );
						$( '#listmembertable tr:first' ).after( result.record );	
					$( '#openmemberaddmodel' ).modal( 'hide' );
					setTimeout(function(){
				    	$("#tr_"+result.id).removeClass('table-info');
					},10000);

				
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal.close();			
				displayFieldErrors(xhr.responseJSON.errors,xhr.status);
			}
		} );
	});

$('#formadd').on('submit', function(event){
		
		var formData = new FormData();		
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');			

		$.ajax( {			
			url: "{{route('add_resell_account')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,

			success: function ( result ) {				
					swal( {
							type: 'success',
							title: '@lang("dingsu.done")',
							text: '@lang("dingsu.success_msg")',
							showConfirmButton: true,
							timer: 1000
						} );
						$( '#listtable tr:first' ).after( result.record );	
					$( '#openaddmodel' ).modal( 'hide' );
					setTimeout(function(){
				    	$("#tr_"+result.id).removeClass('table-info');
					},10000);

				
			},
			error: function ( xhr, ajaxOptions, thrownError ) {
				swal.close();			
				displayFieldErrors(xhr.responseJSON.errors,xhr.status);
			}
		} );
	});
$(".datalist").on("click",".rejectrow", function(){
	var id=$(this).data('id');
		Swal( {
			title: '@lang("dingsu.delete_confirmation")',
			text: '@lang("dingsu.delete_conf_text")',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '@lang("dingsu.delete")',
			cancelButtonText: '@lang("dingsu.cancel")',
			closeOnConfirm: false
		} ).then( ( result ) => {
			if ( result.value ) {

				$.ajax( {
					url: '{{route('delete_resell_account')}}',
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
	} );	



$(".datamemberlist").on("click",".removemember", function(){
	var id=$(this).data('id');
		Swal( {
			title: '@lang("dingsu.delete_confirmation")',
			text: '@lang("dingsu.delete_conf_text")',
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: '@lang("dingsu.delete")',
			cancelButtonText: '@lang("dingsu.cancel")',
			closeOnConfirm: false
		} ).then( ( result ) => {
			if ( result.value ) {

				$.ajax( {
					url: '{{route('delete_resell_member')}}',
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
	} );	

















//edit 
	$('#formedit').on('submit', function(event){
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');				
		var formData = new FormData();		
		$.ajax( {
				url: "{{route('update_resell_account')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) {					
					if ( result.success == true ) {
						swal.close();
						$( '#openmodel' ).modal( 'hide' );			
						var data = result.record;
						swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.update_success_msg")', confirmButtonText: '@lang("dingsu.okay")'});	

						console.log('sd'+result.id);					
						$('#tr_' + result.id).replaceWith(data);
						setTimeout(function(){
				    		$("#tr_"+result.id).removeClass('table-info');
						},10000);

					} else {						
						swal( '@lang("dingsu.no_record_found")', '@lang("dingsu.try_again")', "error" );
					}
										
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal.close();			
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
				}
			} );
		
	});
//get receipt details	
	$(".datalist").on("click",".editrow", function(){
			var id=$(this).data('id');
			$('.inputTxtError').remove();
			show_wait('fetch');
			
			$.ajax( {
				url: "{{route('render_account_edit')}}",
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
								$('.renderdata').html(data);
								$('#openmodel').modal('show');
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

getdatalist("{{route('listcompanymember')}}" , 'member');
getdatalist('');



		function getdatalist( url , type = '' ) {
			if ( !url ) {
				var url = "";
			}
			if (!type)
			{
				window.history.pushState( "", "", url );				
			}
			

			

			$.ajax( {
				url: url,
				data: {
					_method: 'get',
					_token: "{{ csrf_token() }}",
					_data: $( "#searchform" ).serialize()
				},
			} ).done( function ( data ) {
								
				if (!type)
				{
					$( '.datalist' ).html( data );
				}
				else
				{
					$( '.datamemberlist' ).html( data );
				}
				

				swal.close();
			} ).fail( function () {
				alert( 'datalist could not be loaded.' );
				swal.close();
			} );
		}
	} );

</script>






    @endsection 