@foreach( $result as $list )
<tr id="tr_{{$list->id}}">
	<td scope="row">{{$list->id}}</td>
	<td>{{$list->created_at}}</td>
	<td>
	@if ($list->member_id)
		{{ $list->member->phone ?? $list->member->wechat_name }}
	@endif	
	</td>
	<td>{{$list->receipt ?? '-' }}</td>
	<td>{{$list->amount ?? '0' }}</td>
	<td>{{$list->reward ?? '0' }}</td>
	<td>
		@if($list->status == 1)
		
		<label class="badge badge-info">@lang('dingsu.inprogress')</label> 
		@elseif ($list->status == 2)
		<label class="badge badge-success">@lang('dingsu.successful')</label> 
		@elseif ($list->status == 3)
		<label class="badge badge-danger">@lang('dingsu.unsuccessful') @lang('dingsu.notqualified')</label> 
		@elseif ($list->status == 4)
		<label class="badge badge-danger">@lang('dingsu.unsuccessful') @lang('dingsu.invalidreceipt')</label> 
		@endif
	</td>
	
	<td>
		@if ($list->reason_id)
		{{ $list->reason->name }}
		@endif
	</td>
	
	<td>				
		@if($list->status == 1)
		<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow"> <i class="fa fa-pencil-alt"></i> </button>
		@endif		
		<!--
<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger "> <i class=" fa fa-trash "></i> </button> -->
	</td>
</tr>
@endforeach

