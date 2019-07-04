@extends('layouts.default')

@section('title', '兑换订单')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true">返回</div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/buy.css') }}" />
@endsection

@section('content')
<div class="container">
	<div class="image_wrapper">
		<img src="{{ asset('/client/images/buy/divider.png') }}" />
	</div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-title">
            	<div class="col-xs-2"><img src="{{ asset('/client/images/buy/location.png') }}" /></div>
            	<div class="col-xs-8">
            		<div class="lbl_name">张三</div>
            		<div class="lbl_address">浙江省杭州市上城区中山路205号</div>
            	</div>
            	<div class="col-xs-2">
            		<a href="/profile" class="back">
				        <div class="icon-next glyphicon glyphicon-menu-right" aria-hidden="true"></div>
				    </a>
            	</div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-title">
            	<div class="col-xs-3"><img src="{{ asset('/client/images/vip/prize_2.png') }}" /></div>
            	<div class="col-xs-9">
            		<div class="lbl_description">Apple/苹果 iPhone X 256G全网通智能手机苹果10 原封正品iPhonex iPhone10
            		</div>
            		<div class="lbl_price">7500 金币</div>
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
			          <input type="text" name="quant[1]" class="form-control input-number" value="1" min="1" max="10">
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
	        	<div class="div_price">支付 <span class="span_price">15000</span><span class="span_currency">金币</span></div>
	        </div>
	        <div class="col-xs-6 no-padding">
	        	<button class="btn-confirm">确认兑换</button>
	        </div>
		</div>

    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection


@section('footer-javascript')
	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	<script src="{{ asset('/client/js/buy.js') }}"></script>
@endsection
