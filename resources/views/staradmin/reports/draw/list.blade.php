
<section class="filter">
	@include('reports.draw.filter')
</section>

<section class="datalist">
	@include('reports.draw.ajaxlist')
</section>


<section class="models">
	@include('reports.draw.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	
	$( function () {
		
		$(".datalist").on("click",".Showplayedmembers", function() {
			var id    = $(this).data('id');
			var type  = $(this).data('type');
			var count = $(this).data('count');
			//alert(id );
			if (count)
				{
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

					$.ajax({
						url: "{{route('ajax_played_members')}}",
						data: {_method: 'get', _token :"{{ csrf_token() }}",id:id,type:type},
					}).done(function (data) {
						$('.playedmemberlist').html(data);
						swal.close();
						$('#childlist').modal('show');
					}).fail(function () {
						alert('child list could not be loaded.');
						swal.close();
					});					
				}		
		});


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