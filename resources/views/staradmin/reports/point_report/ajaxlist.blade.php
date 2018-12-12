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
								<th>@lang('dingsu.create_Date')</th>
								<th>@lang('dingsu.username')</th>
								<th>@lang('dingsu.credit')</th>
								<th>@lang('dingsu.debit')</th>
								<th>@lang('dingsu.before_balance')</th>
								<th>@lang('dingsu.after_balance')</th>								
								<th>@lang('dingsu.credit_type')</th>
								<th>@lang('dingsu.notes')</th>
							</tr>
						</thead>
						<tbody>
							@foreach($result as $list)
							<tr id="tr_{{ $list->id }}">
								<td>{{ $list->id }}</td>
								<td>{{ $list->created_at }}</td>
								<td>{{ $list->username }}</td>
								<td>{{ $list->credit }}</td>
								<td>{{ $list->debit }}</td>
								<td>{{ $list->balance_before }}</td>
								<td>{{ $list->balance_after }}</td>
								<td>									
									@switch($list->credit_type)
										@case('BAL')
											@lang('dingsu.credit_type_BAL')
											@break

										@case('BAL_REDEEM')
											@lang('dingsu.credit_type_BAL_REDEEM')
											@break
										@case('CRD_REDEEM')
											@lang('dingsu.credit_type_CRD_REDEEM')
											@break
										@case('LFE')
											@lang('dingsu.credit_type_LFE')
											@break
										@case('PNT')
											@lang('dingsu.credit_type_PNT')
											@break
										@case('PNT_REDEEM')
											@lang('dingsu.credit_type_PNT_REDEEM')
											@break
										@default
											@lang('dingsu.credit_type_UNK')
									@endswitch
									
								</td>
								<td>{{ $list->notes }}</td>
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