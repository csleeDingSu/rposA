
<section class="filter">
	@include('resell.filter')
</section>

<section class="datalist">
	@include('resell.ajaxlist')
</section>

<section class="models text-capitalize modellist">
	@include('resell.model')
</section>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>

@section('bottom_js')
@parent
<style type="text/css">
	.highlight
	{
		background-color: coral;
	}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

<script language="javascript">

//edit 
	$('#formedit').on('submit', function(event){
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');				
		var formData = new FormData();		
		$.ajax( {
				url: "{{route('update_resell')}}",
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
				url: "{{route('render_resell_edit')}}",
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

		$(document).ready(function() {								
				var status  = "{{ app('request')->input('status') }}";
				var status = status.trim();
				if (status)
				{
					$("#s_status").val(status);
				}

				getdatalist('');							
			});

		function getdatalist( url ) {
			if ( !url ) {
				var url = "";
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

@section('socket')
    @parent
		
     socket.on(perfix+"add-resell" + ":App\\Events\\EventDynamicChannel", function(result) {
		var record = result.data;
		if (record != null)
			{
				$('#listtable').prepend($(record));
				$("#tr_"+result.id).fadeIn(500).addClass("highlight");
				setTimeout(function(){
				    $("#tr_"+result.id).removeClass('highlight');
				},10000);
			}
	 });

	 socket.on(perfix+"update-resell" + ":App\\Events\\EventDynamicChannel", function(result) {
		var record = result.data;
		if (record != null)
			{
				$("#tr_"+result.id).replaceWith(record);				
				$("#tr_"+result.id).addClass("highlight");				
				setTimeout(function(){
				    $("#tr_"+result.id).removeClass('highlight');
				},10000);
			}
	 });


@endsection	
	
</script>





    @endsection 