<div class="row">
	@if($result)
	<form id="editable-form" class="editable-form">	
		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">@lang('dingsu.product') @lang('dingsu.list')</h4>
					<div class="table-responsive">
						<table class="table table-hover listtable" id="listtable">
							<thead>
								<tr>
									<th>@lang('dingsu.id')</th>
									<th>@lang('dingsu.name')</th>
									<th>@lang('dingsu.value')</th>
									<th>@lang('dingsu.action')</th>
								</tr>
							</thead>
							<tbody>
								@foreach($result as $key => $list)
								<tr id="tr_{{$key}}">
									<td>{{ $loop->iteration }}</td>
									<td>{{$key}}</td>
									<td>
										<a href="javascript:void(0)" id="{{$key}}" data-type="text" data-pk="1" class="editval editable editable-click">{{$list['value']}}</a>
									</td>
									<td>
										@if(!in_array($key, $protec))
										<a href="javascript:void(0)" data-key="{{ $key }}" class="deleterow btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a> @endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</form>
	@else
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<h3 class="mt-3 mb-3 text-danger font-weight-medium text-center">
                     @lang('dingsu.no_record_found') </h>               
              </div>
            </div>	
	@endif
	</div>