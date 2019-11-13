@foreach( $members as $mem )
<tr id="tr_{{$mem->id}}" class="{{$highlight ?? ''}}" >
	<td scope="row">{{$mem->id}}</td>
	<td>{{$mem->created_at}}</td>
	<td>{{$mem->member->username ?? '' }}</td>
	<td>
		@if($mem->member->status == 0)
		<label class="badge badge-success">@lang('dingsu.active')</label> 
		@elseif ($mem->member->status == 1)
		<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
		@elseif ($mem->member->status == 2)
		<label class="badge badge-warning">@lang('dingsu.suspended')</label> 
		@else 
		@endif
	</td>
	<td>
		
		<button type="button" data-id="{{$mem->id}}" id="{{$mem->id}} removemember" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger removemember"> <i class="fa fa-trash"></i> </button>
	</td>
</tr>
@endforeach

