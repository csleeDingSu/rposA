<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.vip') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.package') @lang('dingsu.name')</th>
								<th>@lang('dingsu.phone')</th>
								<th>@lang('dingsu.wechat_name')</th>
								<th>@lang('dingsu.ref_note')</th>
								<th>@lang('dingsu.package') @lang('dingsu.price')</th>
								<th>@lang('dingsu.point')</th>
								<th>@lang('dingsu.status')</th>
								<th>@lang('dingsu.receipt')</th>
								<th>@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->package_name }}</td>
								<td>
									{{ $list->phone }}
								</td>
								<td>
									<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
									{{ $list->wechat_name ?? $list->username }}
								</td>
								<td>{{ $list->ref_note }}</td>
								<td>
									{{ $list->package_price }}
								</td>
								<td>
									{{ $list->used_point }}
								</td>
								<td id="statustd_{{ $list->id }}">
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