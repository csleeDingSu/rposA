
<div class="clearfix">&nbsp;</div>
<section class="filter">
	<!-- @ include('redeem.filter') -->
</section>

<section class="datalist">
	@include('cronmanager.ajaxlist')
</section>

<section class="modellist">
	@include('cronmanager.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	function openmodel() {
		$("#savebtn").html('@lang("dingsu.add")');
		$('#dform')[0].reset();
		$('#mode').val('create');
		$( '#openeditmodel' ).modal( 'show' );
	}
	
	$(".listtable").on("click",".editrecord", function(){
			var id=$(this).data('id');
		$('#dform')[0].reset();
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
				url: "{{route('get.cron')}}",
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
								
								$('#c_status').val(data.status);
								$('#lastrun').html(data.last_run);
								$('#total_limit').html(data.total_limit);
								$('#processed').html(data.processed);
								
								
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

	function addrecord() {
				
		var datav = $( "#dform" ).serializeArray();
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
			url: "{{route('update.cron')}}",
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
						swal({  icon: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.cron_update_success_msg")', button: '@lang("dingsu.okay")',});
						
						var id = $('#hidden_void').val();
						$('#sl_'+id).html(data.last_run);
						$('#ss_'+id).html(data.status);
						
						
						//$('#sl_'+id).html('sfff');
						
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
				var url = "{{route('list.cronmanager')}}";
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