<div class="col-12 d-flex  text-right">
	<a onClick="return openmodel();return false;" href="javascript:void(0)" class="btn btn-success mr-2">@lang('dingsu.add')</a>
</div>

<div class="clearfix">&nbsp;</div>

<section class="filter">
	@include('alipay.filter')
</section>

<section class="datalist">
	@include('alipay.ajaxlist')
</section>

<section class="models text-capitalize modellist">
	@include('alipay.model')
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

function openmodel()
	{
		$('.inputTxtError').remove();
		$( '.models #formalipay' )[ 0 ].reset();
		$('#openmodel').modal('show');
	}

$('.models #formalipay').on('submit', function(event){
		event.preventDefault();
		$('.inputTxtError').remove();
		show_wait('update');				
		var formData = new FormData();		
		$.ajax( {
				url: "{{route('store_alipay')}}",
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST', 
				data:new FormData(this),
				cache : false, 
				processData: false,
				success: function ( result ) {	
				console.log(result.record);				
					swal.close();
					if ( result.success == true ) {						
						$( '#openalipaymodel' ).modal( 'hide' );			
						
						swal({ icon: "success",  type: 'success',  title: '@lang("dingsu.done")!',text: '@lang("dingsu.update_success_msg")', confirmButtonText: '@lang("dingsu.okay")'});	
						
					} else {						
						swal( '@lang("dingsu.error") ' + result.record.msg, '@lang("dingsu.code") ' + result.record.code, "error" );
					}
										
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					swal.close();			
					displayFieldErrors(xhr.responseJSON.errors,xhr.status);	
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
					getdatalist('');
				}							
			});
getdatalist('');

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

var prefix = perfix;
@section('socket')
    @parent		
     socket.on(prefix+"update-alipay-record" + ":App\\Events\\EventDynamicChannel", function(result) {
		var record = result.data;
		
		if (record != null)
			{
				$('#listtable').prepend($(record));
				$("#tr_"+result.id).addClass("highlight");				
				setTimeout(function(){
				    $("#tr_"+result.id).removeClass('highlight');
				},10000);				
			}
	 });

@endsection	 


	
</script>



@endsection 