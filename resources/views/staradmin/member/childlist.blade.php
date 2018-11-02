
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ ++$key }}</td>
	<td>{{ $list->username }}</td>
	<td>
		{{ $list->created_at }}
	</td>							
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
				
