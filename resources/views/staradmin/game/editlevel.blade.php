


<h5 class="my-4">@lang('dingsu.gamelevels')</h5>

<div class="col-lg-12 grid-margin stretch-card">
		
	
	
	
<div class="table-responsive">
		<table class="table table-hover" >
			<thead>
				<tr width="10%">
					<th>@lang('dingsu.gamelevel')</th>
					<th>@lang('dingsu.playtime')</th>
					<th>@lang('dingsu.reward')</th>
				</tr>
			</thead>
			<tbody>
				@foreach($levels as $level)
				<tr>
					<td>{{ $level->id }}</td>
					<td>
					<select id="playtime" name="playtime" class="form-control">
						@foreach ($classname_array as $data)                                       
						<option value="{{ $data->id }}"  >{{ $data->play_time }}</option>                                                      
						@endforeach
					</select>
					</td>
					<td>
					<select id="reward" name="reward" class="form-control">
						@foreach ($classname_array as $data)                                       
						<option value="{{ $data->id }}"  >{{ $data->reward }}</option>                                                      
						@endforeach
					</select>
					</td>
					


				</tr>
				@endforeach
			</tbody>

		</table>
					<td>
						<a href="/game/editlevel/{{ $level->id }}" class="btn btn-info btn-fw">@lang('dingsu.edit')</a>
						<a onClick="confirm_Delete({{ $level->id }}, '{{ csrf_token() }}')" data-token="{{ csrf_token() }}" href="#" class="btn btn-danger btn-fw">@lang('dingsu.delete')</a>
					</td>
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
            url: "/member/delete/"+id,
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
