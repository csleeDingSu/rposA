@extends('layouts.default_without_footer')

@section('title', '好友分享給你')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/angpao.css') }}" />
@endsection

@section('footer-javascript')
<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>

<script type="text/javascript">
   
    var data1 = "<li><span style=\"color: #bb88f9;\">01秒钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
    "<span style=\"color: #ffffff;\">晓峰" +
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" +
    "抽奖150次</span>" +
    "&nbsp;&nbsp;&nbsp;" +
    "<span style=\"color: #ffbe22;\">获得红包150元</span><li>";
    var data2 = "<li><span style=\"color: #bb88f9;\">28秒钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">朱琳" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖10次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包10元</span><li>";
    var data3 = "<li><span style=\"color: #bb88f9;\">52秒钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">树凯" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖50次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包50元</span><li>";
    var data4 = "<li><span style=\"color: #bb88f9;\">01分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">豪君" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖75次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包75元</span><li>";
    var data5 = "<li><span style=\"color: #bb88f9;\">03分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">洁" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖30次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包30元</span><li>";
    var data6 = "<li><span style=\"color: #bb88f9;\">04分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">小康" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖20次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包20元</span><li>";
    var data7 = "<li><span style=\"color: #bb88f9;\">06分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">天宇" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖70次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包70元</span><li>";
    var data8 = "<li><span style=\"color: #bb88f9;\">08分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">东" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖80次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包80元</span><li>";
    var data9 = "<li><span style=\"color: #bb88f9;\">09分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">芳芳" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖60次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包60元</span><li>";
    var data10 = "<li><span style=\"color: #bb88f9;\">10分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">华" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖10次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包10元</span><li>";
    var data11 = "<li><span style=\"color: #bb88f9;\">12分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">文秀" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖16次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包16元</span><li>";
    var data12 = "<li><span style=\"color: #bb88f9;\">13分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">乐" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖120次</span>" + 
    "&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包120元</span><li>";
    var data13 = "<li><span style=\"color: #bb88f9;\">15分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">琴晓" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖55次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包55元</span><li>";
    var data14 = "<li><span style=\"color: #bb88f9;\">16分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">兆志" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖35次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包35元</span><li>";
    var data15 = "<li><span style=\"color: #bb88f9;\">18分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">田野" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖75次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包75元</span><li>";
    var data16 = "<li><span style=\"color: #bb88f9;\">20分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">文新" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖106次</span>" + 
    "&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包106元</span><li>";
    var data17 = "<li><span style=\"color: #bb88f9;\">25分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">一兆" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖50次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包50元</span><li>";
    var data18 = "<li><span style=\"color: #bb88f9;\">30分钟前</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffffff;\">文杰" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "抽奖80次</span>" + 
    "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
    "<span style=\"color: #ffbe22;\">获得红包80元</span><li>";
        
    var data = data6 + data5 + data4 + data3 + data2 + data1
    var number = -1;

    function refresh() {
    
        if (number <= 0) {
            number = 6;
        }
        else {
            if (number > 18) {
                number = 0;
            } else {
                if (number == 1) {
                    data = data1;
                }
                else if(number == 2) {
                    data = data2;
                }
                else if(number == 3) {
                    data = data3;
                }
                else if(number == 4) {
                    data = data4;
                }
                else if(number == 5) {
                    data = data5;
                }
                else if(number == 6) {
                    data = data7;
                }
                else if(number == 8) {
                    data = data8;
                }
                else if(number == 9) {
                    data = data9;
                }
                else if(number == 10) {
                    data = data10;
                }
                else if(number == 11) {
                    data = data11;
                }
                else if(number == 12) {
                    data = data12;
                }
                else if(number == 13) {
                    data = data13;
                }
                else if(number == 14) {
                    data = data14;
                }
                else if(number == 15) {
                    data = data15;
                }
                else if(number == 16) {
                    data = data16;
                }
                else if(number == 17) {
                    data = data17;
                }
                else if(number == 18) {
                    data = data18;
                } 
            }
        }

        $('#msg').prepend(data);

        number += 1;    

        setTimeout(refresh, 6000);
     }

     refresh();

</script>
@parent

@endsection

@section('content')

<a href='{{str_replace('vregister','vvregister', \Request::url())}}'>
	<div class="angpao_container">
        <img class="btn_draw" src="{{ asset('vwechat/images/btn_draw.png') }}">    
        
		<div class="panel-dummy-message">

			<ul id="msg">
				               
			</ul>
		</div>

    </div>
</a>

@endsection
