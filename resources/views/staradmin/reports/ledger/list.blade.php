
<section class="filter">
	@include('reports.ledger.filter')
</section>

<section class="datalist">
	@include('reports.ledger.ajaxlist')
</section>


<section class="models">
	@include('reports.ledger.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">
	
	//ShowMember ShowLedger
	
	$( function () {
		
		$(".datalist").on("click",".ShowMember", function() {
			var id    = $(this).data('id');
			
			//alert(id );
			
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
				url: "{{route('ajax_wallet_members')}}/"+id,
				data: {_method: 'get', _token :"{{ csrf_token() }}",id:id},
			}).done(function (response) {
				$('.memberlist').html(response);
				swal.close();
				$('#childlist').modal('show');
			}).fail(function () {
				alert('child list could not be loaded.');
				swal.close();
			});					
						
		});
		
		$(".datalist").on("click",".ShowLedger", function() {
			var id    = $(this).data('id');
			var type  = $(this).data('type');
			var date  = $(this).data('date');
			
			//alert(id );
			
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
					url: "{{route('ajax_ledger_trx')}}",
					data: {_method: 'get', _token :"{{ csrf_token() }}",id:id,type:type,cdate:date},
				}).done(function (data) {
					$('.ledgerlist').html(data);
					swal.close();
					$('#ledgertrxlist').modal('show');
				}).fail(function () {
					alert('list could not be loaded.');
					swal.close();
				});					
						
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