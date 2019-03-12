@extends('layouts.default_without_footer')

@section('title', '好友分享給你')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/angpao.css') }}" />
@endsection

@section('footer-javascript')
<script type="text/javascript">
    var sCurrentPathName = window.location.pathname;
    var sNewPathName = sCurrentPathName.replace("vregister", "vvregister");
    var href_ = window.location.origin + sNewPathName; //"http://www.wabao777.com" + sNewPathName;
    var bg_ = window.location.origin + "/vwechat/images/share.png";

    // document.writeln("<div class=\"loginBox\"><a href='"+href_+"'><div id=\"weixinTips2\" style=\"display:block;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg_+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div></a><\/div>");

</script>
@parent

@endsection

@section('content')

	<div class="angpao_container">
	
		<div class="panel-dummy-message">
			<ul>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>
				<li>1秒钟前 *晓峰分享了8个好友 提现了360元</li>

			</ul>
		</div>

    </div>

@endsection
