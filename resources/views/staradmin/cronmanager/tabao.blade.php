
					<div class="row">
					<div class="col-md-6 col-lg-6 grid-margin">
                <div class="card">
                  <div class="card-header header-sm d-flex justify-content-between align-items-center">
                    <h4 class="card-title">@lang('dingsu.tabao_cron')</h4>
                    <div class="dropdown">
                      <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                        <a class="dropdown-item" href="#">Today</a>
                        <a class="dropdown-item" href="#">Yesterday</a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body no-gutter">
                    
					  <div class="d-flex align-items-center border-bottom py-3 px-4" id="render_cron">
                      
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
                    
                  </div>
                </div>
              </div>
				  </div>

<script language="javascript">
@section('socket')
    @parent
	
	
     socket.on(perfix+"-tabao-cron" + ":App\\Events\\EventDynamicChannel", function(result) {
		var record = result.data;
		 
		console.log(JSON.stringify(result))
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
		
	 });
@endsection
	
	
	
$("#render_cron").on("click",".runcron", function(){	
	
	var cronstatuslabel = '<h1 class="text-primary ">'+"@lang('dingsu.initiating')"+'</h1>';
	$('#cronaction').html('');
	$('#cronstatuslabel').html(cronstatuslabel);
	
	var id     = $(this).data('id');
	var status = $(this).data('status');	
	
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
					
					console.log('success');
				},
				error: function ( xhr, ajaxOptions, thrownError ) {
					xhr.abort(); 
					console.log('abort');
				},
				timeout: 3000 // sets timeout to 3 seconds
			} );
});
	

</script>