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
										@case('CRPNT')
											@lang('dingsu.credit') @lang('dingsu.point')
											@break
										@case('RPNT')
											@lang('dingsu.redeem') @lang('dingsu.point')
											@break
										@case('RBAL')
											@lang('dingsu.redeem') @lang('dingsu.balance')
											@break	
										@case('ABAL')
											@lang('dingsu.added') @lang('dingsu.balance')
											@break
										@case('APNT')
											@lang('dingsu.added') @lang('dingsu.point')
											@break
										@case('DBAL')
											@lang('dingsu.deducted') @lang('dingsu.balance')
											@break
										@case('DPNT')
											@lang('dingsu.deducted') @lang('dingsu.point')
											@break
										@case('APPNT')
											@lang('dingsu.acpoint') @lang('dingsu.redeemed')
											@break
										@case('ALFE')
											@lang('dingsu.added') @lang('dingsu.life')
											@break	
										@case('APVIP')
											@lang('dingsu.added') @lang('dingsu.vip') @lang('dingsu.point')
											@break
										@case('DPVIP')
											@lang('dingsu.deducted') @lang('dingsu.vip') @lang('dingsu.point')
											@break
										@case('ALVIP')
											@lang('dingsu.added') @lang('dingsu.vip') @lang('dingsu.life')
											@break
										@case('DLVIP')
											@lang('dingsu.deducted') @lang('dingsu.vip') @lang('dingsu.life')											
											@break
										@case('DLRVL')
											@lang('dingsu.reset') @lang('dingsu.vip') @lang('dingsu.life')
											@break
										@case('APMNT')
											@lang('dingsu.vip') @lang('dingsu.point') @lang('dingsu.merged')
											@break
										@case('APRFN')
											@lang('dingsu.vip') @lang('dingsu.refund')
											@break
										@case('ALPRV')
											@lang('dingsu.added_vip_life_by_redeemed package')
											@break
										@case('APLRV')
											@lang('dingsu.added_vip_point_by_redeemed')
											@break
										@case('ALACL')
											@lang('dingsu.admin') @lang('dingsu.amended') @lang('dingsu.life')
											@break
										@case('WVRFE')
											@lang('dingsu.fee') 
											@break	
										@case('ALILE')
											@lang('dingsu.introduction') @lang('dingsu.life') 
											@break
										@case('APACP')
											@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.point') 
											@break 
										@case('ADAVP')
											@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.vip') @lang('dingsu.point')  
											@break
										@case('ALAVL')
											@lang('dingsu.admin') @lang('dingsu.add') @lang('dingsu.vip') @lang('dingsu.life')  
											@break
										@case('DPRPO')
											@lang('dingsu.redeem_product_using_point') 
											@break
										@case('DPBVP')
											@lang('dingsu.buy_vip_using_point') 
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