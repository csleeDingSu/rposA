<section id="filter">
  
@include('tabao.filter')
</section>

<div class="d-flex align-items-center py-3 px-4 col-md-6" id="render_cron">
                      
                      <div class="d-flex align-items-end">
                        <h6 class="font-weight-medium mb-0 ml-0 ml-md-3">@lang('dingsu.cron') @lang('dingsu.status')</h6>
                      </div>
            
            @php
            $cron_status = '';
            @endphp
            <div class="text-right ml-auto font-weight-medium" id="cronstatuslabel">
            @if($record->status == 1)
              <h1 class="text-success ">@lang('dingsu.active')</h1>
            @elseif($record->status == 2) 
                <h1 class="text-warning ">@lang('dingsu.processing')</h1>
            @elseif($record->status == 3) 
              <h1 class="text-primary">@lang('dingsu.completed')</h1>
            @else
              
            @endif
            </div>
            
            <div class="d-flex align-items-center  py-3 px-4">
              <div class=" d-flex flex-column">
              <div class="d-flex align-items-end" id="cronaction">
                
                  @if($record->status == 1)
                
                  <a href="javascript:void(0)" data-id="{{ $record->id }}" data-status="start"  class="runcron btn btn-outline-info ">@lang('dingsu.start')</a>
                  
                @elseif($record->status == 3) 
                  <a href="javascript:void(0)" data-id="{{ $record->id }}" data-status="start"  class="runcron btn btn-outline-info ">@lang('dingsu.start')</a>
                @else
                  
                @endif
                
              </div>
              </div>                      
                        </div>
            
            
            
                      
            
                    </div>

 
<div class="row datalist" id="tabaolist">

          @include('tabao.ajax_product')

      

  </div>






<style type="text/css">
  
.card .card-body
{
  /*padding: 3px 0px 0px 10px !important;*/
}
.card
{
  width: 20% !important;
}


</style>







<script language="javascript">
@section('socket')
    @parent

    var perfix = 'RR';
    var perfix = 'RR';

    socket.on(perfix+"add-tabao-product" + ":App\\Events\\EventDynamicChannel", function(result) {
      console.log('dataaa-'+JSON.stringify(result));
      var record = result.data;
      
      $( "#tabaolist" ).append( record );
    });
	
	
    socket.on(perfix+"-tabao-cron" + ":App\\Events\\EventDynamicChannel", function(result) {
		var record = result.data;
		 
		//console.log(JSON.stringify(result))
		var cronaction = '';
		 var cronstatuslabel = '';
		 
		if (record.status == 1)
		{
			var cronaction =' <a href="javascript:void(0)" data-id="{{ $record->id }}" data-status="start"  class="runcron btn btn-outline-primary ">'+"@lang('dingsu.start')"+'</a> ';
			
			var cronstatuslabel = '<h1 class="text-success ">'+"@lang('dingsu.active')"+'</h1>';
		}
		 else if (record.status == 2)
		{
			var cronstatuslabel = '<h1 class="text-warning ">'+"@lang('dingsu.processing')"+'</h1>';
		}
		else if (record.status == 3)
		{
			var cronaction =' <a href="javascript:void(0)" data-id="{{ $record->id }}" data-status="start"  class="runcron btn btn-outline-primary ">'+"@lang('dingsu.start')"+'</a> ';
			var cronstatuslabel = '<h1 class="text-primary ">'+"@lang('dingsu.completed')"+'</h1>';
		}		 		 
		 
		$('#cronaction').html(cronaction);
		$('#cronstatuslabel').html(cronstatuslabel);
		 
		 
		 //cronstatuslabel
		 
		
	 });
@endsection
	
  function Gototop(id) {
//$("#render_cron").on("click",".gototop", function(){	

  $("#moveproduct_"+id).html('@lang("dingsu.please_wait")');
  
  //var id     = $(this).data('id');
  $.ajax( {
        url: "{{route('tabao_changeorder')}}",
        type: 'get',
        dataType: "json",
        data: {
          _method: 'post',
          _token: "{{ csrf_token() }}",
          id:  id,
        },
        success: function ( result ) {
          //swal.close();
          console.log('success');
         var ss = $("#product_"+id).wrap('<p/>').parent().html();
        
         $("#product_"+id).remove();
         $("#tabaolist").prepend(ss);
         $("#moveproduct_"+id).html('@lang("dingsu.change")');
        },
        error: function ( xhr, ajaxOptions, thrownError ) {
          swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
        },        
      } );

}
//);
	
$("#render_cron").on("click",".runcron", function(){
	
	
	var cronstatuslabel = '<h1 class="text-primary ">'+"@lang('dingsu.initiating')"+'</h1>';
	$('#cronaction').html('');
	$('#cronstatuslabel').html(cronstatuslabel);
	
	var id     = $(this).data('id');
	var status = $(this).data('status');	
	/*
	var xhr = $.ajax({
    type: "POST",
	url: "{{route('update_tabao_cron')}}",
    data: {
			_method: 'post',
			_token: "{{ csrf_token() }}",
			id:  id,
			status:  status,
		},
    success: function(msg){
       alert( "Data Saved: " + msg );
    }
});

//kill the request
xhr.abort()
	*/
	
	
	
			var xhr = $.ajax( {
				url: "{{route('update_tabao_cron')}}",
				type: 'get',
				dataType: "json",
				data: {
					_method: 'post',
					_token: "{{ csrf_token() }}",
					id:  id,
					status:  status,
				},
				success: function ( result ) {
					swal.close();
					console.log('success');
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					xhr.abort(); 
					//console.log('abort');
					//swal( '@lang("dingsu.error")', '@lang("dingsu.try_again")', "error" );
				},
				timeout: 3000 // sets timeout to 3 seconds
			} );
	
	if (xhr)
		{
		//xhr.abort();
		}
	
			//xhr.abort();
			
			
	
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

		function getdatalist( url ) {
			if ( !url ) {
				var url = "{{route('tips.list')}}";
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