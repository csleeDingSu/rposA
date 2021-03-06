@extends('layouts.default_app')

@section('title', '个人中心')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/clientapp/css/member_vip.css') }}" />
    <meta name="viewport" content ="width=device-width,initial-scale=1,user-scalable=yes" />
	
@endsection

@section('top-javascript')
@parent

@endsection

@section('top-navbar')
@endsection

@section('content')
    <div class="userViews fix">
      <div class="userName">
        <h2>HI,{{ substr($member->phone,0,3) }}*****{{ substr($member->phone, -4) }}</h2>
        @if(!empty($member) && $member->wechat_verification_status == 0)   <!-- wechat verified -->    
          <a class="set on"><img src="{{ asset('clientapp/images/ation_2.png') }}"><span>已认证</span></a>
        @else
          <a class="set unverify"><img src="{{ asset('clientapp/images/ation_1.png') }}"><span>去认证</span></a>
        @endif
      </div>
      <div class="userDetail rel">
        <a class="gobtn" href="/vip">去高级抽奖&nbsp;<b class="fhei">&gt;</b></a>
        <p class="userTitle"><img src="{{ asset('clientapp/images/user-coin.png') }}"><span>我的挖宝币</span></p>
        <h2 class="userMoney" id='103_point'></h2>
        <p class="userTotal"><span>昨日收益&nbsp;&nbsp;<b>+0</b></span><span>累计收益&nbsp;&nbsp;<b><span id="granttotal">+0</span></b></span>
        </p>
      </div>
      <div class="sMain">
        <a href="/recharge"><img src="{{ asset('clientapp/images/user-1.png') }}"><span>买入</span></a>        
        <a href="/shop"><img src="{{ asset('clientapp/images/user-2.png') }}"><span>换购</span></a>
        <a href="/summary"><img src="{{ asset('clientapp/images/user-3.png') }}"><span>明细</span></a>
        <a class="not-available"><img src="{{ asset('clientapp/images/user-4.png') }}"><span>卖出</span></a>
      </div>


    </div>

    <div class="userMainList2">
      <div class="inBox">
        <p><img class="tIcon" src="{{ asset('clientapp/images/buTieIcon.png') }}"><span>我的补贴</span><em></em><span class="102_point"></span></p>
        <a href="/redeem"><i class="bRed">去提现&nbsp;<img class="nIcon" src="{{ asset('clientapp/images/leftIcon.png') }}"></i></a>
      </div>
    </div>

    <div class="userMainList">
      <!-- <a class="inBox" href="/redeem">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-hb.png') }}"><span>购物补贴</span></p>
        <p><i class="bRed" id="102_point"></i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a> -->
      <a class="inBox" href="/arcade">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-cs.png') }}"><span>剩余抽奖</span></p>
        <p><i class="bBlub" id="game_life"></i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/pre-share">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-invite.png') }}"><span>邀请好友</span><span class="highlight">奖励大量补贴抽奖</span></p>
        <p><i class="bYellow">{{$total_intro ?? '0'}}</i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/receipt">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-history.png') }}"><span>下单奖励</span></p>
        <p><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="blog/my-redeem">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-pj.png') }}"><span>我要晒单</span></p>
        <p><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
    </div>

    <div class="userMainList">
      <a class="inBox" href="/faq">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-faq.png') }}"><span>常见问题</span></p>
        <p><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/logout">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-logout.png') }}"><span>退出</span></p>
        <p><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
    </div>

    <hr class="h36">

@endsection

@section('footer-javascript')
<!-- not available modal -->
<div class="modal fade col-md-12" id="modal-not-available" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="txt">暂不提供卖出服务，请耐心等待</div>         
  </div>
</div>


<!-- wechat verify Modal starts -->
  <div class="modal fade col-md-12" id="wechat-verification-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-body">        
          <div class="modal-row">
            <div class="wrapper modal-full-height">
              <div class="modal-card">
                <img src="{{ asset('/client/images/avatar.png') }}" width="80" height="82" alt="avatar" />
                <div class="wechat-instructions">
                  你的账号还未通过微信认证，<br />
                  不能兑换红包，请先认证。
                </div>                
              </div>
              <div>
                <a href="/validate">
                  <img src="{{ asset('/client/images/btn-verify.png') }}" width="154" height="44" alt="Verify" />
                </a>
              </div>
            </div>
          </div>              
        </div>
      </div>
    </div>
  </div>
<!-- wechat verify Modal Ends -->

  @parent
	<script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
	<script src="{{ asset('/client/js/js.cookie.js') }}"></script>
  <script src="{{ asset('/clientapp/js/mui.min.js') }}"></script>
    <!-- <link href="{{ asset('/clientapp/css/mui.min.css') }}" rel="stylesheet"/> -->
    <script type="text/javascript" charset="utf-8">
        mui.init();

		$(document).ready(function() {
			var wechat_status = "<?php Print($member->wechat_verification_status);?>";
			var normal_game_point = getNumeric("<?php Print(empty($wallet['gameledger']['102']->point) ? 0 : $wallet['gameledger']['102']->point);?>");
			var current_point = getNumeric("<?php Print(empty($wallet['gameledger']['103']->point) ? 0 : $wallet['gameledger']['103']->point);?>");
			var usedpoint = getNumeric("<?php Print(empty($wallet['gameledger']['102']->used_point) ? 0 : $wallet['gameledger']['102']->used_point);?>");
      var previous_point = Cookies.get('previous_point');
      var wbp = "{{$wbp['wbp']}}";
      var platform = "{{$wbp['platform']}}";
      var browser = "{{$wbp['browser']}}";
      var topupurl = decodeEntities("{{env('TOPUP_URL','#')}}");
      var game_life = "<?php Print(empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life);?>";
            game_life = game_life > 0 ? game_life : 0;            

            if(previous_point !== undefined && previous_point > 0){
                previous_point = (getNumeric(previous_point));

                $('#103_point')
                  .prop('number', previous_point)
                  .animateNumber(
                    {
                      number: (current_point)
                    },
                    1000
                  );
                Cookies.remove('previous_point');
            } else {
                $('#103_point').html((current_point));
            }

            var yesterdaypoint = "{{empty($yesterdaypoint) ? '+0' : (($yesterdaypoint >= 0) ? '+'.$yesterdaypoint : $yesterdaypoint)}}";
            var overallpoint = "{{empty($overallpoint) ? '+0' : (($overallpoint >= 0) ? '+'.$overallpoint : $overallpoint)}}";
            console.log(yesterdaypoint);
            console.log(overallpoint);
            $('#102_point').html('<em class="fs">¥</em>' + normal_game_point);
            $('.102_point').html('￥' + normal_game_point +'元');

            
            $('#game_life').html(game_life);
            $('.userTotal').html("<span>昨日收益&nbsp;&nbsp;<b>" + yesterdaypoint + "</b></span><span>累计收益&nbsp;&nbsp;<b><span id='granttotal'>" + overallpoint + "</span></b></span>");


            $('.unverify').click(function(){
                $('#wechat-verification-modal').modal();
            });

            $('.not-available').click(function() {
                $('#modal-not-available').modal();
                setTimeout(function(){ 
                  $('.modal').modal('hide');
                  $('.modal-backdrop').remove();
              }, 3000);
            });

        // if (platform == 'iOS') {          
        //   document.getElementById("btn-go-topup").addEventListener("click", function(evt) {
        //       var a = document.createElement('a');
        //       a.setAttribute("href", topupurl);
        //       a.setAttribute("target", "_blank");
        //       var dispatch = document.createEvent("HTMLEvents");
        //       dispatch.initEvent("click", true, true);
        //       a.dispatchEvent(dispatch);
        //   }, false);          

        // } else if (platform == 'AndroidOS') {

        //   document.getElementById("btn-go-topup").addEventListener('tap',function(){
        //     plus.runtime.openURL(topupurl);
        //   });

        // } else {
            
        //   $('#btn-go-topup').click(function(){
        //     window.location.href = topupurl;
        //   });
        // }

		});

		function getNumeric(value) {
		  	// return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
		  	return parseFloat(value).toFixed(2);
		  }

		function decodeEntities(encodedString) {
		  var textArea = document.createElement('textarea');
		  textArea.innerHTML = encodedString;
		  return textArea.value;
		}
	</script>
  
@endsection
 
 <!-- socket start-->  
<script type="text/javascript">
  @section('socket')
  @parent

    var id = "{{$member->id}}";
    console.log('prefix --- ' + prefix);
    console.log('id --- ' + id);

    socket.on(prefix+ id + "-ledger" + ":App\\Events\\EventLedger" , function(data){
        console.log(prefix+ id + "-ledger" + ":App\\Events\\EventLedger");
        console.log(data.data);
        var gameid = data.data.game_id;

        if (gameid == 103) {
          var previous_103_point = $('#103_point').html();
          var previous_granttotal = $('#granttotal').html();

          var updated_103_point = data.data.point;
          if (!(previous_103_point == updated_103_point)) {
            $('#103_point').html(updated_103_point);

            var updated_granttotal = Number(previous_granttotal) - Number(previous_103_point) + Number(updated_103_point);
            $('#granttotal').html(updated_granttotal);  
          }
          
        }

        if (gameid == 102) {
          var updated_102_point = data.data.point;
          var updated_102_life = data.data.life;
          $('#102_point').html('<em class="fs">¥</em>' + updated_102_point);
          $('.102_point').html('￥' + updated_102_point +'元');
          $('#game_life').html(updated_102_life);
        }
    });

  @endsection
</script>
<!-- socket end-->
