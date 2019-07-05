@extends('layouts.default')

@section('title', '添加收货地址')

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
            <div class="panel-title">请填写正确的收货地址，如因地址不正确导致无法收到产品，造成损失由您自己承担，平台不负责任。</div>
        </div>
        <div class="panel panel-default">
            <input type="text" id="txt_name" name="txt_name" placeholder="输入收件人姓名（请使用真实姓名）" required="" maxlength="30">
        </div>
        <div class="panel panel-default">
            <input type="text" id="txt_mobile" name="txt_mobile" placeholder="输入手机号码" required="" maxlength="30">
        </div>
        <div class="panel panel-default">
            <input type="text" id="txt_city" name="txt_city" placeholder="输入所在地区（如：浙江省杭州市上城区）" required="">
        </div>
        <div class="panel panel-default">
            <textarea id="txt_address" name="txt_address" placeholder="输入街道，小区门牌等详细地址" rows="5"></textarea>
        </div>
        <div class="button-wrapper">
            <a href="/confirm">
    	        <button class="btn_save">保存</button>
            </a>
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
