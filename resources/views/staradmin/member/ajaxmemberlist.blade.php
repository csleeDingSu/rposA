<div class="row ">
	@if(!$result->isEmpty())
<div class="col-lg-12 grid-margin stretch-card">	
	<div class="card">
		<div class="card-body">
			<h4 class="card-title">@lang('dingsu.member') @lang('dingsu.list')</h4>
			
			{!! $result->render() !!}
			<div class="table-responsive">				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>@lang('dingsu.id')</th>
							<th>@lang('dingsu.create_Date')</th>
							<th>@lang('dingsu.name')</th>
							<th>@lang('dingsu.referred_by')</th>							
							<th>@lang('dingsu.referred_count')</th>	
							<th>@lang('dingsu.used_life')</th>		
							<th>@lang('dingsu.life')</th>
							<th>@lang('dingsu.current_balance') </th>
							<th>@lang('dingsu.current_point') </th>
							<th>@lang('dingsu.wechat_status')</th>
							<th>@lang('dingsu.status')</th>
							<th class="">@lang('dingsu.action')</th>
						</tr>
					</thead>
					<tbody>
						@foreach($result as $list)
						<tr id="tr_{{ $list->id }}">
							
							<input type="hidden" name="show_wechat_status_{{ $list->id }}" id="show_wechat_status_{{ $list->id }}" value="{{ $list->wechat_verification_status }}">
							
							<input type="hidden" name="show_wechat_name_{{ $list->id }}" id="show_wechat_name_{{ $list->id }}" value="{{ $list->wechat_name }}">

							<input type="hidden" name="show_wechat_id_{{ $list->id }}" id="show_wechat_id_{{ $list->id }}" value="{{ $list->wechat_id }}">
							
							<input type="hidden" name="show_status_{{ $list->id }}" id="show_status_{{ $list->id }}" value="{{ $list->member_status }}">
							
							
							<td>{{ $list->id }}</td>
							<td>
								{{ $list->created_at }}
							</td>
							<td @if($list->referred_by != 0) class="text-primary font-weight-bold" @endif >
								<img class="profile-img-circle" src="{{ $list->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
								
								{{ $list->wechat_name ?? $list->username }}</td>
							<td>
								@if($list->parentuser)
									<img class="profile-img-circle" src="{{ $list->parentuser->profile_pic ?? '/client/images/avatar.png' }}">&nbsp;
								
									{{ $list->parentuser->wechat_name ?? $list->parentuser->username }}
								@endif
							</td>
							
							<td><h6 class="ShowChildMembers text-info font-weight-semibold ml-2" data-id="{{ $list->id }}" data-count="{{ $list->totalcount }}" >{{ $list->totalcount }}</h6> </td>
							<td id="">	{{ $list->usedlife + $list->is_purged_gamelife }}</td>
							<td id="cl_{{ $list->id }}">
								{{ $list->ledger['102']->life ?? '0'  }}
							</td>
							<td id="cb_{{ $list->id }}">
								<h6 class="ShowRecentPlay text-info font-weight-semibold ml-2" data-id="{{ $list->id }}">{{ $list->ledger['102']->balance ?? 0 }}</h6>
							</td>
							<td id="cp_{{ $list->id }}">
								{{ $list->ledger['103']->point ?? 0  }}
							</td>
							<td onClick="OpenWechatVerification('{{ $list->id }}','{{ $list->wechat_notes }}')" class="show_wechat_verification_{{ $list->id }}">
								@if($list->wechat_verification_status == 0)
								<label class="badge badge-success">@lang('dingsu.verified')</label> 
								@elseif ($list->wechat_verification_status == 1)
								<label class="badge badge-info">@lang('dingsu.unverified')</label> 
								@elseif ($list->wechat_verification_status == 2)
								<label class="badge badge-warning">@lang('dingsu.rejected')</label> 
								@elseif ($list->wechat_verification_status == 3)
								<label class="badge badge-danger">@lang('dingsu.suspended')</label> 
								@else 
								@endif
							</td>
							
							<td onClick="OpenUpdateStatus('{{ $list->id }}')" class="show_update_status_{{ $list->id }}">
								@if($list->member_status == 0)
								<label class="badge badge-success">@lang('dingsu.active')</label> 
								@elseif ($list->member_status == 1)
								<label class="badge badge-danger">@lang('dingsu.inactive')</label> 
								@elseif ($list->member_status == 2)
								<label class="badge badge-warning">@lang('dingsu.suspended')</label> 
								@else 
								@endif
							</td>
							<td>							
								<a href="/member/edit/{{ $list->id }}"  class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info"><i class=" icon-pencil "></i></a>
								
								<!-- 	<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-primary opentopupmodel  "> <i class=" icon-arrow-up "></i> </button> 
								 -->
									<button type="button" data-id="{{$list->id}}" id="{{$list->id}}" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-success editrow  "> <i class=" fa fa-plus "></i> </button>
								
								<a href="javascript:void(0)" onClick="resetpassword('{{ $list->id }}')"  class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-warning"><i class="icon-key"></i></a>
								
								
								
								
								<a onClick="confirm_Delete({{ $list->id }})"  href="javascript:void(0)" class="btn btn-icons btn-rounded btn-outline-danger btn-inverse-danger"><i class=" icon-trash  "></i></a>
								
								
								
								
								 
								
								
								
								
								
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

	
