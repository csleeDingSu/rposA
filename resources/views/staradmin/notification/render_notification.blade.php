@foreach($result as $list)

<tr id="tr_{{$list->id}}">

	<td scope="row">{{$loop->iteration}}</td>
	<td>{{$list->created_at}}</td>
	<td>{{$list->read_at ?? '-'}}</td>
	<td>{{$list->member->phone ?? '-'}}</td>
	<td>{{$list->ledger->ledger_type ?? ''}}</td>
	<td>{{$list->ledger->credit ?? 0}}</td>
	<td>
		@if($list->is_read == 0)
		<label class="badge badge-info">@lang('dingsu.unread')</label> 
		@else 
		<label class="badge badge-success">@lang('dingsu.read')</label> 
		@endif
	</td>
	<td>{{$list->ledger->notes ?? '-' }}</td>
</tr>
@endforeach