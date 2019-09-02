<div class="row">
	@if(!$result->isEmpty())
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<h4 class="card-title">@lang('dingsu.basic') @lang('dingsu.package') @lang('dingsu.list')</h4>
				<div class="table-responsive">
					<table class="table table-hover listtable" id="listtable">
						<thead>
							<tr>
								<th>@lang('dingsu.id')</th>
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.seq')</th>
								<th>@lang('dingsu.name')</th>								
								<th>@lang('dingsu.vip_price')</th>
								<th>@lang('dingsu.life')</th>
								<th>@lang('dingsu.status')</th>		
								<th>@lang('dingsu.action')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->seq }}</td>
								<td>{{ $list->package_name }}</td>
								<td>{{ $list->package_price }}</td>
								<td>{{ $list->package_life }}</td>
								
								<td>									
									@switch($list->package_status)
										@case('1')
											<label class="badge badge-success">@lang('dingsu.active')</label>
											@break
										@case('2')
											<label class="badge badge-warning">@lang('dingsu.inactive')</label>
											@break
										@case('3')
											<label class="badge badge-warning">@lang('dingsu.trash')</label>
											@break	
										@default
											<label class="badge badge-danger">@lang('dingsu.unknown') @lang('dingsu.status')</label>
									@endswitch
									
								</td> 
								<td>
									
								<a href="javascript:void(0)" data-id="{{ $list->id }}" class="editrow btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
									
								<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-primary opentopupmodel  "> <i class=" icon-arrow-up "></i> </button>
									
								<a href="javascript:void(0)" onClick="confirm_Delete({{ $list->id }});return false;" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
								
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