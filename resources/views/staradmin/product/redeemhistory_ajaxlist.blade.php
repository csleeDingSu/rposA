<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.redeem') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.product') @lang('dingsu.name')</th>
								<th>@lang('dingsu.name')</th>
								<th>@lang('dingsu.code')</th>
								<th>@lang('dingsu.passcode')</th>
								<th>@lang('dingsu.product') @lang('dingsu.price')</th>
								<th>@lang('dingsu.status')</th>
								<th>@lang('dingsu.receipt')</th>
								<th>@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->s_id }}">
								
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->product_name }}</td>
								<td>
									<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
									{{ $list->wechat_name ?? $list->username }}
								</td>
								<td>{{ $list->code }}</td>
								<td>{{ $list->passcode }}</td>
								<td>
									<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
									{{ $list->wechat_name }}
								</td>
								<td>
									{{ $list->product_price }}
								</td>
								<td id="statustd_{{ $list->s_id }}">
									@if($list->redeem_state == 0)
										<label class="badge badge-warning">@lang('dingsu.active')</label> 
									@elseif ($list->redeem_state == 1)
										<label class="badge badge-success">@lang('dingsu.redeemed')</label> 
									@elseif ($list->redeem_state == 2)
										<label class="badge badge-success">@lang('dingsu.confirmed')</label> 
									@elseif ($list->redeem_state == 3)
										<label class="badge badge-danger">@lang('dingsu.rejected')</label> 
									@elseif ($list->redeem_state == 4)
										<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> 
									@else
										<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> 
									@endif
								</td>
								<td id="tdr_{{ $list->id }}">
									{{ $list->receipt }}
								</td>
								
								<td>
									<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow"> <i class="fa fa-pencil-alt"></i> </button>
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

@section('top-css')
    @parent	
	<style>
		.profile-img-circle
		{
			border-radius: 50% !important; 
			max-width: 40px;
			max-height: 40px;
			width: 40px !important;
			height: 40px;
			
		}

	</style>
@endsection