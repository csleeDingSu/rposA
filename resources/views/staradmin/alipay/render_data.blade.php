@foreach( $result as $list )
<tr id="tr_{{$list->id}}" >
	<td scope="row">{{$list->id}}</td>
	<td>{{$list->created_at}}</td>
	<td>
	@if ($list->member_id)
		{{ $list->member->phone ?? $list->member->wechat_name }}
	@endif	
	</td>
	<td>{{$list->amount ?? '-' }}</td>
	<td>
		@if ($list->status == 1)
			
			<label class="text-capitalize badge badge-danger">
				{{trans('dingsu.failed' )}}
			</label>

		@else
			<label class="text-capitalize badge badge-success">
				{{trans('dingsu.success' )}}
			</label>
		@endif
	</td>
	<td>{{$list->code ?? '-' }}</td>
	<td>{{$list->msg ?? '-' }}</td>
	
</tr>
@endforeach

