
<div class="col-12 d-flex  text-right"><a href="/game/add" class="btn btn-success mr-2">@lang('dingsu.add')</a></div>
<p>&nbsp;</p>
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.game') @lang('dingsu.list')</h4>
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.game') @lang('dingsu.id')</th>	
							<th>@lang('dingsu.created') @lang('dingsu.at')</th>
							<th>@lang('dingsu.game') @lang('dingsu.name')</th>	
							<th>@lang('dingsu.game') @lang('dingsu.category')</th>	
							<th>@lang('dingsu.game') @lang('dingsu.status')</th>	
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr id="tr_{{ $list->id }}">
							<td>{{ $list->game_id }}</td>
							<td>{{ $list->created_at }}</td>
							<td>{{ $list->game_name }}</td>
							
							<td>
								{{ $list->game_category }}
							</td>
							<td>
								@if($list->game_status == 0)
								<label class="badge badge-success">@lang('dingsu.active')</label> 
								@elseif ($list->game_status == 1)
								<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
								@elseif ($list->game_status == 2)
								<label class="badge badge-warning">@lang('dingsu.reserved')</label>
								@else 
								<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label>
								@endif
							</td>
							
							
							<td>
								
								
								
								<a href="/game/edit/{{ $list->id }}"  class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								
								<!-- <a href="javascript:void(0)" onClick="confirm_Delete({{ $list->id }}, '{{ csrf_token() }}')" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a> -->
								
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>				
				{!! $result->render() !!}
			</div>
		</div>
	</div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>




<script language="javascript">
function confirm_Delete(id,token)
	{
Swal({
  title: '@lang("dingsu.delete_confirmation")',
  text: '@lang("dingsu.delete_conf_text")',
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: '@lang("dingsu.delete")',
  cancelButtonText: '@lang("dingsu.cancel")',
	confirmButtonColor: "#DD6B55",
  closeOnConfirm: false
}).then((result) => {
  if (result.value) {
	  
	  $.ajax({
            url: "/game/delete/"+id,
            type: "POST",
            data: {_method: 'delete', _token :token},
            dataType: "html",
            success: function (data) {
				if (data === 'false')
					{
						swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
					}
				else 
					{
						swal("Done!", '@lang("dingsu.delete_success")', "success");
						
						$('#tr_'+id).hide(); 
					}
                
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal('@lang("dingsu.delete_error")', '@lang("dingsu.try_again")', "error");
            }
        });
	  
  } else if (result.dismiss === Swal.DismissReason.cancel) {
   
  }
})
	}
	
	
</script>
