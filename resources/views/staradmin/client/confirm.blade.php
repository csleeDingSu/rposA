@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@if(env('THISVIPAPP','false'))
    <!-- top nav -->
    @section('left-menu')
      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
    @endsection

    @section('title', '兑换订单')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '兑换订单')

    @section('left-menu')    
        <a href="javascript:history.back()" class="back">
            <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true">返回</div>
        </a>
    @endsection

@endif

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/buy.css') }}" />
@endsection

@section('content')
<input type="hidden" id="hid_wallet_point" name="hid_wallet_point" value="{{$wallet->point}}">

<div class="container">
	<div class="image_wrapper">
		<img src="{{ asset('/client/images/buy/divider.png') }}" />
	</div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @if ($record->type == 1)
        <div class="panel panel-default">
            <form id="frm_buy" method="post" action="/buy">
                <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
                <input type="hidden" id="hid_package_id" name="hid_package_id" value="{{ $request->hid_package_id }}">
            </form>
            <div class="panel-title">该产品是虚拟产品，换购成功后可在“个人中心-我的奖品”查看充值卡信息</div>
        </div>
        @else
        <div class="panel panel-default">
            <div class="panel-title">
            	<div class="col-xs-2"><img src="{{ asset('/client/images/buy/location.png') }}" /></div>
            	<div class="col-xs-8">
            		<div class="lbl_name">{{ $request->txt_name }}</div>
            		<div class="lbl_address">{{ $request->txt_city }}</div>
            	</div>
            	<div class="col-xs-2">
                    <form id="frm_buy" method="post" action="/buy">
                        <input id="hidEdit" name="hidEdit" type="hidden" value="1" />
                        <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
                        <input type="hidden" id="hid_package_id" name="hid_package_id" value="{{ $request->hid_package_id }}">
                        <input type="hidden" id="txt_name" name="txt_name" value="{{ $request->txt_name }}">
                        <input type="hidden" id="txt_mobile" name="txt_mobile" value="{{ $request->txt_mobile }}">
                        <input type="hidden" id="txt_city" name="txt_city" value="{{ $request->txt_city }}">
                        <input type="hidden" id="txt_address" name="txt_address" value="{{ $request->txt_address }}">           
    			        <div class="icon-next glyphicon glyphicon-menu-right back" aria-hidden="true"></div>                    
                    </form>
            	</div>
            </div>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-title">
            	<div class="col-xs-3"><img src="{{ $record->picture_url }}" /></div>
            	<div class="col-xs-9">
            		<div class="lbl_description">{{ $record->name }}
            		</div>
            		<div class="lbl_price">{{ $record->point_to_redeem }} 金币</div>
            	</div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-title">
            	<div class="col-xs-6 lbl_quantity">兑换数量</div>
            	<div class="col-xs-6">
            		<div class="input-group">
			          <span class="input-group-btn">
			              <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
			                  <span class="glyphicon glyphicon-minus"></span>
			              </button>
			          </span>
			          <input type="text" id="txt_quantity" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">
			          <span class="input-group-btn">
			              <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
			                  <span class="glyphicon glyphicon-plus"></span>
			              </button>
			          </span>
			      </div>
            	</div>
            </div>
        </div>

        <div id="info">
	        <div class="col-xs-6 no-padding">
	        	<div class="div_price">支付 <span class="span_price">{{ $record->point_to_redeem }}</span><span class="span_currency">金币</span></div>
	        </div>
	        <div class="col-xs-6 no-padding">
	        	<button class="btn-confirm">确认兑换</button>
	        </div>
		</div>

    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection


@section('footer-javascript')
<!-- Steps Modal starts -->
    <div class="modal fade col-md-12" id="modal-successful" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
        <div class="modal-dialog modal-lg close-modal" role="document">
            <div class="modal-content">
                <div class="modal-body">                
                    <div class="modal-row">
                        <div class="wrapper modal-full-height">
                            <div class="modal-card">
                                <img src="{{ asset('/client/images/buy/successful.png') }}" class="img-successful" />
                                <div class="modal-title">
                                  订单提交成功
                                </div>
                                <div class="instructions">
                                    你可在<span class="highlight">“个人中心-我的奖品”</span>中查看订单
                                </div>
                                <div class="close-modal modal-warning-button">
                                    完成
                                </div>
                            </div>
                        </div>
                    </div>                          
                </div>
            </div>
        </div>
    </div>
<!-- Steps Modal Ends -->

<!-- error msg modal -->
<div class="modal fade col-md-12" id="modal-error-msg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="error-msg"></div>                 
    </div>
</div>
<!-- error msg modal Ends -->

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	<script src="{{ asset('/client/js/confirm.js') }}"></script>
@endsection
