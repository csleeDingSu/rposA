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
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.product') @lang('dingsu.name')</th>
								<th>@lang('dingsu.phone')</th>
								<th>@lang('dingsu.wechat_name')</th>
								<th>@lang('dingsu.product') @lang('dingsu.price')</th>
								<th>@lang('dingsu.status')</th>
								<th class="">@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->product_name }}</td>

								<td>
									{{ $list->phone }}
								</td>
								<td>
									<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
									{{ $list->wechat_name ?? $list->username }}
								</td>
								<td>
									{{ $list->product_price }}
								</td>
								<td id="statustd_{{ $list->id }}">
									@if($list->pin_status == 0)
									<label class="badge badge-warning">@lang('dingsu.active')</label> @elseif ($list->pin_status == 1)
									<label class="badge badge-success">@lang('dingsu.redeemed')</label> @elseif ($list->pin_status == 2)
									<label class="badge badge-success">@lang('dingsu.confirmed')</label> @elseif ($list->pin_status == 3)
									<label class="badge badge-danger">@lang('dingsu.rejected')</label> @elseif ($list->pin_status == 4)
									<label class="badge badge-info">@lang('dingsu.pending') @lang('dingsu.confirmation')</label> @else
									<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label> @endif
								</td>
								<td id="actiontd_{{ $list->id }}">
									@if($list->pin_status == 4 )
									<a href="javascript:void(0)" onClick="confirm_redeem({{ $list->id }})" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-check  "></i></a>
									<a href="javascript:void(0)" onClick="confirm_Delete({{ $list->id }})" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-close  "></i></a> @endif
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