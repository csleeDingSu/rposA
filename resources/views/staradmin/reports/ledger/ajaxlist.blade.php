<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.play') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.created_at')</th>
								<th>@lang('dingsu.wechat_name')</th>
								<th>@lang('dingsu.member')</th>
								<th>@lang('dingsu.type')</th>								
								<th>@lang('dingsu.product')</th>
								<th>@lang('dingsu.spent')</th>
								<th>@lang('dingsu.status')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							
							<tr id="tr">
								
								
	<td>{{ $list->created_at }}        </td>
	<td class="card-title text-info">
									<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
									{{ $list->wechat_name ?? $list->username }}
								</td>
								<td class="card-title text-info"><button type="button" data-type="{{ $list->type }}" data-date="{{$list->created_at}}" data-id="{{$list->member_id}}" class="btn  ShowMember"> {{ $list->username }} </button>
								    </td>
	<td>{{ $list->type }}</td>
	<td>{{ $list->pname }}</td>
	<td> 
								
		<button type="button" data-type="{{ $list->type }}" data-date="{{ Carbon\Carbon::parse($list->created_at)->format('Y-m-d H:i') }}" data-id="{{$list->member_id}}" class="btn  ShowLedger"> {{ $list->buy_price ?: $list->used_point }} </button>
								
								</td>
	
	<td>
		@if($list->type == 'softpin')
			@if($list->redeem_state == 0)
			<label class="badge badge-warning">@lang('dingsu.active')</label> @elseif ($list->redeem_state == 1)
			<label class="badge badge-success">@lang('dingsu.redeemed')</label> @elseif ($list->redeem_state == 2)
			<label class="badge badge-success">@lang('dingsu.confirmed')</label> @elseif ($list->redeem_state == 3)
			<label class="badge badge-danger">@lang('dingsu.rejected')</label> @elseif ($list->redeem_state == 4)
			<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> @else
			<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> @endif
		@elseif ($list->type == 'product')
		@elseif ($list->type == 'basicpackage')
			@if($list->redeem_state == 0)
			<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
			@elseif ($list->redeem_state == 1)
			<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> 
			@elseif ($list->redeem_state == 2)
			<label class="badge badge-success">@lang('dingsu.confirmed')</label> 
			@elseif ($list->redeem_state == 3)
			<label class="badge badge-danger">@lang('dingsu.redeemed')</label> 
			@else
			<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> 
			@endif
		
		
		
			
		
		
		@endif
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
	@else
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<h3 class="mt-3 mb-3 text-danger font-weight-medium text-center">
                     @lang('dingsu.no_record_found') </h>               
              </div>
            </div>	
	@endif
	</div>