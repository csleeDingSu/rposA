<div class="col-12 grid-margin">
	<div class="card">
		<div class="card-body">
			<h5 class="card-title">@lang('dingsu.edit_game')</h4>
			<form class="form-sample" action="" method="post" autocomplete="on">

				{{ csrf_field() }} @foreach ($errors->all() as $error)
				<div class="alert alert-danger" role="alert">@lang($error)</div>
				@endforeach 
				
				@if(session()->has('message'))
				<div class="alert alert-success" role="alert">
					{{ session()->get('message') }}
				</div>
				@endif
				@if(session()->has('error'))
				<div class="alert alert-danger" role="alert">
					{{ session()->get('error') }}
				</div>
				@endif
				
				
				<p>&nbsp;</p>
				@foreach ($sys_title as $title)  
				@php @$tval = $title->title @endphp
				
				<div class="row">
					<div class="col-md-10">
						<div class="form-group row">
							<label for="game_name" class="col-sm-3 col-form-label">@lang('dingsu.'.$title->title) <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								
								<input type="hidden" name="sys_tit[{{$title->id}}]" id="{{$title->id}}" value="{{$title->title}}">
								
								<input id="{{$title->id}}" name="vi[{{$title->id}}]" class="form-control" type="text" value="{{$record->$tval}}">
							</div>
						</div>
					</div>
					
				</div>
			@endforeach 
				

				


			
			
			<button type="submit" class="btn btn-success mr-2">@lang('dingsu.submit')</button>
			<a href="" type="submit" class="btn btn-light mr-2">@lang('dingsu.reset')</a>
				
				</form>
		</div>
	
	






</div>
</div>


<script type="text/javascript">
	
//	$('#addlevelmodel').dialog('open');
	
	
	$.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    $(".addlevel").click(function(e){
		
		
		$(".addlevel").prop("disabled",true);
		$(".addlevel").prop('value', "@lang('dingsu.please_wait')"); //versions newer than 1.6
        e.preventDefault();



        var name = $("input[name=name]").val();

        var password = $("input[name=password]").val();

        var email = $("input[name=email]").val();



        $.ajax({

           type:'POST',

           url:'game/addlevel/',

           data:{name:name, password:password, email:email},

           success:function(data){

              alert(data.success);

           }

        });



	});
	
	
	
	$( document ).ready( function () {
		$( ".moveup,.moveup" ).click( function () {

			var $element = this;
			var row = $( $element ).parents( "tr:first" );

			if ( $( this ).is( '.up' ) ) {
				row.insertBefore( row.prev() );
			} else {
				row.insertAfter( row.next() );
			}

		} );
	} );
</script>