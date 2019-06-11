
@foreach ($result as $key=>$list)
<tr id="tr">
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
										@case('APAVP')
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
										@case('APBPR')
											@lang('dingsu.addedbasicpoint') 
											@break	
										@case('ALBPR')
											@lang('dingsu.addedbasiclife') 
											@break	
									
										@default
											@lang('dingsu.credit_type_UNK')
									@endswitch									
								</td>
								<td>{{ $list->notes }}</td>
	
								
</tr>
@endforeach
				
