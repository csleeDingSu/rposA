@extends('layouts.default_without_footer')

@section('title', '好友分享給你')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/angpao.css') }}" />
@endsection

@section('footer-javascript')
<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>

<script type="text/javascript">
   
    var data1 = "<li><span style=\"color: #e3d4a2;\">1秒钟前</span> <span style=\"color: #ffffff;\">*晓峰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
    var data2 = "<li><span style=\"color: #e3d4a2;\">28秒钟前</span> <span style=\"color: #ffffff;\">*朱琳分享了1个好友</span> <span style=\"color: #9bef7e;\">提现了45元</span><li>";
    var data3 = "<li><span style=\"color: #e3d4a2;\">52秒钟前</span> <span style=\"color: #ffffff;\">*树凯分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    var data4 = "<li><span style=\"color: #e3d4a2;\">1分钟前</span> <span style=\"color: #ffffff;\">*豪君分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    var data5 = "<li><span style=\"color: #e3d4a2;\">3分钟前</span> <span style=\"color: #ffffff;\">*洁分享了3个好友</span> <span style=\"color: #9bef7e;\">提现了135元</span><li>";
    var data6 = "<li><span style=\"color: #e3d4a2;\">4分钟前</span> <span style=\"color: #ffffff;\">*小康分享了2个好友</span> <span style=\"color: #9bef7e;\">提现了90元</span><li>";
    var data7 = "<li><span style=\"color: #e3d4a2;\">6分钟前</span> <span style=\"color: #ffffff;\">*天宇分享了7个好友</span> <span style=\"color: #9bef7e;\">提现了315元</span><li>";
    var data8 = "<li><span style=\"color: #e3d4a2;\">8分钟前</span> <span style=\"color: #ffffff;\">*东分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
    var data9 = "<li><span style=\"color: #e3d4a2;\">9分钟前</span> <span style=\"color: #ffffff;\">*芳芳分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    var data10 = "<li><span style=\"color: #e3d4a2;\">10分钟前</span> <span style=\"color: #ffffff;\">*华分享了10个好友</span> <span style=\"color: #9bef7e;\">提现了450元</span><li>";
    var data11 = "<li><span style=\"color: #e3d4a2;\">12分钟前</span> <span style=\"color: #ffffff;\">*文秀分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    var data12 = "<li><span style=\"color: #e3d4a2;\">13分钟前</span> <span style=\"color: #ffffff;\">*乐分享了2个好友</span> <span style=\"color: #9bef7e;\">提现了90元</span><li>";
    var data13 = "<li><span style=\"color: #e3d4a2;\">15分钟前</span> <span style=\"color: #ffffff;\">*琴晓分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    var data14 = "<li><span style=\"color: #e3d4a2;\">16分钟前</span> <span style=\"color: #ffffff;\">*兆志分享了3个好友</span> <span style=\"color: #9bef7e;\">提现了135元</span><li>";
    var data15 = "<li><span style=\"color: #e3d4a2;\">18分钟前</span> <span style=\"color: #ffffff;\">*田野分享了7个好友</span> <span style=\"color: #9bef7e;\">提现了315元</span><li>";
    var data16 = "<li><span style=\"color: #e3d4a2;\">20分钟前</span> <span style=\"color: #ffffff;\">*文新分享了6个好友</span> <span style=\"color: #9bef7e;\">提现了270元</span><li>";
    var data17 = "<li><span style=\"color: #e3d4a2;\">25分钟前</span> <span style=\"color: #ffffff;\">*一兆分享了5个好友</span> <span style=\"color: #9bef7e;\">提现了225元</span><li>";
    var data18 = "<li><span style=\"color: #e3d4a2;\">30分钟前</span> <span style=\"color: #ffffff;\">*文杰分享了8个好友</span> <span style=\"color: #9bef7e;\">提现了360元</span><li>";
        
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

	
		<div class="panel-dummy-message">
			<ul id="msg">
				               
			</ul>
		</div>

    </div>
</a>

@endsection
