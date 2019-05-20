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
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.package_name')</th>
								<th>@lang('dingsu.total')</th>
								<th>@lang('dingsu.available')</th>
								<th>@lang('dingsu.redeemed')</th>
								<th>@lang('dingsu.created_at')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)							
							 
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->package_name }}</td>
								<td>{{ $list->total }}</td>
								<td>{{ $list->available }}</td>
								<td>{{ $list->redeemed }}</td>
								<td>{{ $list->created_at }}</td>
								
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