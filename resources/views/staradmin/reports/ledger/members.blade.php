
@foreach ($result as $key=>$list)
<tr id="tr">
	<td>{{ $list->id }}</td>
	<td @if($list->referred_by == 0) class="text-primary font-weight-bold" @endif >{{ $list->username }} {{ $list->referred_by }}</td>
	<td>
		{{ $list->created_at }}
	</td>
	<td><h6 class="ShowChildMembers text-info font-weight-semibold ml-2" data-id="{{ $list->id }}" data-count="{{ $list->totalcount }}" >{{ $list->totalcount }}</h6> </td>
	<td id="cl_{{ $list->id }}">
		{{ $list->current_life }}
	</td>
	<td id="cp_{{ $list->id }}">
		{{ $list->current_point }}
	</td>
	<td onClick="OpenWechatVerification('{{ $list->id }}','{{ $list->wechat_notes }}')" class="show_wechat_verification_{{ $list->id }}">
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

	<td onClick="OpenUpdateStatus('{{ $list->id }}')" class="show_update_status_{{ $list->id }}">
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
				
