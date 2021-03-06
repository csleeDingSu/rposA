<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.redeem') @lang('dingsu.history') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.type')</th>
								<th>@lang('dingsu.total_quantity')</th>
								<th>@lang('dingsu.used_quantity')</th>
								<th>@lang('dingsu.reserved_quantity')</th>
								<th>@lang('dingsu.rejected_quantity')</th>
								<th>@lang('dingsu.package_name')</th>
								<th>@lang('dingsu.package_price')</th>
								
								<th>@lang('dingsu.package_discount_price')</th>
								<th>@lang('dingsu.package_status')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							
							<tr id="tr">
								<td>{{ $list->type }}</td>
								<td>
									@if($list->total > 0)
									<a target="_blank" href="/report/redeem-details?type=all&pid={{$list->package_id}}&producttype={{$list->type}}"  data-type="all" data-id="{{$list->package_id}}" data-count="{{$list->total}}" data-producttype="{{$list->type}}" class="badge badge-pill badge-primary "> {{ $list->total }} </a>
									@else 
										0
									@endif
								</td>
								<td>
									@if($list->used_quantity > 0)
									
									<a target="_blank" href="/report/redeem-details?type=used&pid={{$list->package_id}}&producttype={{$list->type}}"
									    data-type="used" data-id="{{$list->package_id}}" data-count="{{$list->used_quantity}}" data-producttype="{{$list->type}}" class="badge badge-pill badge-success "> {{ $list->used_quantity }} </a>
									@else 
										0
									@endif
								</td>
								
								<td id="reserved_quantity">
									@if($list->reserved_quantity > 0)
								<a target="_blank" href="/report/redeem-details?type=reserved&pid={{$list->package_id}}&producttype={{$list->type}}"
									data-type="reserved" data-id="{{$list->package_id}}" data-count="{{$list->reserved_quantity}}" data-producttype="{{$list->type}}" class="badge badge-pill badge-warning "> {{ $list->reserved_quantity }} </a>
									@else 
										0
									@endif
								</td>
								<td id="rejected_quantity">
									@if($list->rejected_quantity > 0)
								<a target="_blank" href="/report/redeem-details?type=rejected&pid={{$list->package_id}}&producttype={{$list->type}}"
									 data-type="rejected" data-id="{{$list->package_id}}" data-count="{{$list->rejected_quantity}}" data-producttype="{{$list->type}}" class="badge badge-pill badge-danger "> {{ $list->rejected_quantity }} </a>
									@else 
										0
									@endif
								</td>
								<td>{{ $list->package_name }}</td>
								<td>{{ $list->package_price }}</td>
								
								<td>{{ $list->package_discount_price }}</td>
								<td>
									@if($list->package_status == 1)
									<label class="badge badge-success">@lang('dingsu.active')</label> 
									@elseif ($list->package_status == 2)
									<label class="badge badge-warning">@lang('dingsu.inactive')</label> 
									@elseif ($list->package_status == 3)
									<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
									@elseif ($list->package_status == 0)
									<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
									@else 
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