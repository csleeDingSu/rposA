
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ ++$key }}</td>	
	<td>{{ $list->played_time }}</td>
	<td>{{ $list->draw_id }}</td>
	<td>{{ $list->bet }}</td>
	<td>{{ $list->game_result }}</td>
	<td>
		@if($list->is_win == 1)
		<label class="badge badge-success">@lang('dingsu.win')</label> 		
		@else 
		<label class="badge badge-danger">@lang('dingsu.lose')</label> 		
		@endif
	</td>
	<td>{{ $list->username }}</td>							
	<td>
		{{ $list->wechat_name }}
	</td>
	<td>
		@if($list->wechat_verification_status == 0)
		<label class="badge badge-success">@lang('dingsu.verified')</label> 
		@elseif ($list->wechat_verification_status == 1)
		<label class="badge badge-info">@lang('dingsu.unverified')</label> 
		@elseif ($list->wechat_verification_status == 2)
		<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
		@elseif ($list->wechat_verification_status == 3)
		<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
		@else 
		@endif
	</td>
	<td>
		@if($list->member_status == 0)
		<label class="badge badge-success">@lang('dingsu.active')</label> 
		@elseif ($list->member_status == 1)
		<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
		@elseif ($list->member_status == 2)
		<label class="badge badge-warning">@lang('dingsu.suspended')</label> 
		@else 
		@endif
	</td>							
</tr>
@endforeach
				
