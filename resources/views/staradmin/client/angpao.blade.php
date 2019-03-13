@extends('layouts.default_without_footer')

@section('title', '好友分享給你')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/angpao.css') }}" />
@endsection

@section('footer-javascript')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript">
    var sCurrentPathName = window.location.pathname;
    var sNewPathName = sCurrentPathName.replace("vregister", "vvregister");
    var href_ = window.location.origin + sNewPathName; //"http://www.wabao777.com" + sNewPathName;
    var bg_ = window.location.origin + "/vwechat/images/share.png";

    // document.writeln("<div class=\"loginBox\"><a href='"+href_+"'><div id=\"weixinTips2\" style=\"display:block;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg_+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div></a><\/div>");


// var displayDate = document.getElementById ('test'); // <-- grab the element from its ID
// displayDate.innerHTML += "<li>dadasd<span style=\"color: #e3d4a2;\">1秒钟前</span> <span style=\"color: #ffffff;\">*晓峰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";

    var data = "<li><span style=\"color: #e3d4a2;\">1秒钟前</span> <span style=\"color: #ffffff;\">*晓峰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
 //$("#test").append(data);

//  setTimeout(function () {
//     $("#test").append(data);
// }, 3000);
var number = 0;

 function refresh() {

    number += 1;
    
    if (number == 1) {
        data = "<li><span style=\"color: #e3d4a2;\">28秒钟前</span> <span style=\"color: #ffffff;\">*朱琳分享了1个好友</span> <span style=\"color: #9bef7e;\">提现了45元</span><li>";
    }
    else if (number == 2) {
        data = "<li><span style=\"color: #e3d4a2;\">52秒钟前</span> <span style=\"color: #ffffff;\">*树凯分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    }
    else if (number == 3) {
        data = "<li><span style=\"color: #e3d4a2;\">1分钟前</span> <span style=\"color: #ffffff;\">*豪君分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    }
    else if (number == 4) {
        data = "<li><span style=\"color: #e3d4a2;\">3分钟前</span> <span style=\"color: #ffffff;\">*洁分享了3个好友</span> <span style=\"color: #9bef7e;\">提现了135元</span><li>";
    }
    else if (number == 5) {
        data = "<li><span style=\"color: #e3d4a2;\">4分钟前</span> <span style=\"color: #ffffff;\">*小康分享了2个好友</span> <span style=\"color: #9bef7e;\">提现了90元</span><li>";
    }
    else if (number == 6) {
        data = "<li><span style=\"color: #e3d4a2;\">6分钟前</span> <span style=\"color: #ffffff;\">*天宇分享了7个好友</span> <span style=\"color: #9bef7e;\">提现了315元</span><li>";
    }
    else if (number == 7) {
        data = "<li><span style=\"color: #e3d4a2;\">8分钟前</span> <span style=\"color: #ffffff;\">*东分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
    }
    else if (number == 8) {
        data = "<li><span style=\"color: #e3d4a2;\">9分钟前</span> <span style=\"color: #ffffff;\">*芳芳分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    }
    else if (number == 9) {
        data = "<li><span style=\"color: #e3d4a2;\">10分钟前</span> <span style=\"color: #ffffff;\">*华分享了10个好友</span> <span style=\"color: #9bef7e;\">提现了450元</span><li>";
    }
    else if (number == 10) {
        data = "<li><span style=\"color: #e3d4a2;\">12分钟前</span> <span style=\"color: #ffffff;\">*文秀分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    }
    else if (number == 11) {
        data = "<li><span style=\"color: #e3d4a2;\">13分钟前</span> <span style=\"color: #ffffff;\">*乐分享了2个好友</span> <span style=\"color: #9bef7e;\">提现了90元</span><li>";
    }
    else if (number == 12) {
        data = "<li><span style=\"color: #e3d4a2;\">15分钟前</span> <span style=\"color: #ffffff;\">*琴晓分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    }
    else if (number == 13) {
        data = "<li><span style=\"color: #e3d4a2;\">16分钟前</span> <span style=\"color: #ffffff;\">*兆志分享了3个好友</span> <span style=\"color: #9bef7e;\">提现了135元</span><li>";
    }
    else if (number == 14) {
        data = "<li><span style=\"color: #e3d4a2;\">18分钟前</span> <span style=\"color: #ffffff;\">*田野分享了7个好友</span> <span style=\"color: #9bef7e;\">提现了315元</span><li>";
    }
    else if (number == 15) {
        data = "<li><span style=\"color: #e3d4a2;\">20分钟前</span> <span style=\"color: #ffffff;\">*文新分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    }
    else if (number == 16) {
        data = "<li><span style=\"color: #e3d4a2;\">25分钟前</span> <span style=\"color: #ffffff;\">*一兆分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    }
    else if (number == 17) {
        data = "<li><span style=\"color: #e3d4a2;\">30分钟前</span> <span style=\"color: #ffffff;\">*文杰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
    }
    else {
        number = 0;
        data = "<li><span style=\"color: #e3d4a2;\">1秒钟前</span> <span style=\"color: #ffffff;\">*晓峰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
    }
     // $("#test").append(number + data); 
    $('#test').prepend(data);

    setTimeout(refresh, 6000);
 }

 setTimeout(refresh, 6000);

</script>
@parent

@endsection

@section('content')

	<div class="angpao_container">

	
		<div class="panel-dummy-message">
			<ul id="test">
				               
			</ul>
		</div>

    </div>


@endsection
