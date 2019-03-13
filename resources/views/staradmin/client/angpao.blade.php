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


function countDown(){ // <-- typo corrected
    var today = new Date()
    var dayofweek = today.toLocaleString()
    dayLocate = dayofweek.indexOf(" ")
    weekDay = dayofweek.substring(0, dayLocate)
    newDay = dayofweek.substring(dayLocate)
    dateLocate = newDay.indexOf(",")
    monthDate = newDay.substring(0, dateLocate+1)
    yearLocate = dayofweek.indexOf("2014")
    year = dayofweek.substr(yearLocate, 4)

    var ColumbusDay = new Date("October 8, 2014")
    var daysToGo = ColumbusDay.getTime()-today.getTime() // <-- typo corrected
    var daysToColumbusDay = Math.ceil(daysToGo/(1000*60*60*24))

    var displayDate = document.getElementById ('displayDate'); // <-- grab the element from its ID
    displayDate.innerHTML = "<h1>Today is "+weekDay+" "+monthDate+" "+year+". We have " // <-- trouble with date bits
                          + daysToColumbusDay+" days until Columbus Day.</h1>";  // <-- missing " added
    }

function scrollColor() {
        styleObject=document.getElementsByTagName('html')[0].style // <-- array index added
        styleObject.scrollbarFaceColor="#fbb04"   // <-- IE specific style elements
        styleObject.scrollbarTrackColor="#ffe700"
}

function loadInfo(myForm) {
    var menuSelect=myForm.Menu.selectedIndex
    var menuUrl=myForm.Menu.options[menuSelect].value+".html"
    window.location=menuUrl
    }

    function copyRight() { // <-- typo corrected
var lastModDate = document.lastModified
var lastModDate = lastModDate.substring(0,10)
displayCopyRight.innerHTML = "<h6>The URL of this document is "+document.URL+"<br />Copyright Oakwood Elementary School"+"<br /> This document was last modified "+lastModDate+".</h6>"
}

countDown();

</script>
@parent

@endsection

@section('content')

	<div class="angpao_container">

	
		<div class="panel-dummy-message">
			<ul>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
				<li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>
                <li><span style="color: #e3d4a2;">1秒钟前</span> <span style="color: #ffffff;">*晓峰分享了8个好友</span> <span style="color: #9bef7e;">提现了360元</span></li>

			</ul>
		</div>

    </div>

    <div id="displayDate"></div>

@endsection
