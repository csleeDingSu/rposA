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

    @section('title', '添加收货地址')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '添加收货地址')

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
<div class="container">
	<div class="image_wrapper">
		<img src="{{ asset('/client/images/buy/divider.png') }}" />
	</div>

    <form method="post" action="/confirm" id='buy'>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <input id="hidEdit" name="hidEdit" type="hidden" value="{{ $request->hidEdit }}" />
            <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
            <input type="hidden" id="hid_package_id" name="hid_package_id" value="{{ $request->hid_package_id }}">
            <div class="panel panel-default">
                <div class="panel-title">请填写正确的收货地址，如因地址不正确导致无法收到产品，造成损失由您自己承担，平台不负责任。</div>
            </div>
            <div class="panel panel-default">
                <input type="text" id="txt_name" name="txt_name" value="{{ $request->txt_name }}" placeholder="输入收件人姓名（请使用真实姓名）" maxlength="30">
            </div>
            <div class="panel panel-default">
                <input type="text" id="txt_mobile" name="txt_mobile" value="{{ $request->txt_mobile }}" placeholder="输入手机号码" maxlength="30">
            </div>
            <div class="panel panel-default">
                <input type="text" id="txt_city" name="txt_city" value="{{ $request->txt_city }}" placeholder="输入所在地区（如：浙江省杭州市上城区）">
            </div>
            <div class="panel panel-default">
                <textarea id="txt_address" name="txt_address" placeholder="输入街道，小区门牌等详细地址" rows="5">{{ $request->txt_address }}</textarea>
            </div>
            <div class="button-wrapper">
        	   <button class="btn_save">保存</button>
    	    </div>

        </div><!-- panel-group -->
    </form>
    
    
</div><!-- container -->

<!-- field validate modal -->
<div class="modal fade col-md-12" id="modal-validate" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="validate-msg"></div>                 
    </div>
</div>
<!-- field validate modal Ends -->

@endsection


@section('footer-javascript')
	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	<script src="{{ asset('/client/js/buy.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.validate.js') }}"></script>
@endsection
