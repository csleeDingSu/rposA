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
<script src="{{ asset('/test/open-new-browser-2/js/mui.min.js') }}"></script>
      <script type="text/javascript" charset="utf-8">
          mui.init();
      </script>
@endsection

@section('top-navbar')
@endsection

@section('content')
    <div class="userBox fix">
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
        <p class="userTotal"><span>昨日收益&nbsp;&nbsp;<b>+0</b></span><span>累计收益&nbsp;&nbsp;<b>+0</b></span>
        </p>
      </div>
      <div class="sMain">
        <a id="btn-go-topup"><img src="{{ asset('clientapp/images/user-1.png') }}"><span>充值</span></a>
        <a href="/redeem-vip"><img src="{{ asset('clientapp/images/user-2.png') }}"><span>兑奖</span></a>
        <a href="/summary"><img src="{{ asset('clientapp/images/user-3.png') }}"><span>明细</span></a>
        <a><img src="{{ asset('clientapp/images/user-4.png') }}"><span>专卖</span></a>
      </div>


    </div>

    <div class="userMainList">
      <a class="inBox" href="/redeem">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-hb.png') }}"><span>购物补贴</span></p>
        <p><i class="bRed" id="102_point"></i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/arcade">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-cs.png') }}"><span>剩余次数</span></p>
        <p><i class="bBlub" id="game_life"></i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/pre-share">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-invite.png') }}"><span>邀请好友</span></p>
        <p><i class="bYellow">{{$total_intro ?? '0'}}</i><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="/receipt">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-history.png') }}"><span>下单奖励</span></p>
        <p><img class="nIcon" src="{{ asset('clientapp/images/userGt.png') }}"></p>
      </a>
      <a class="inBox" href="blog/my-redeem">
        <p><img class="tIcon" src="{{ asset('clientapp/images/icon-pj.png') }}"><span>晒单评价</span></p>
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

	<script type="text/javascript">
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

            var yesterdaypoint = "{{$yesterdaypoint}}";
            var overallpoint = "{{$overallpoint}}";
            console.log(yesterdaypoint);
            console.log(overallpoint);
            $('#102_point').html('<em class="fs">¥</em>' + normal_game_point);
            $('#game_life').html(game_life);
            $('.userTotal').html("<span>昨日收益&nbsp;&nbsp;<b>+" + getNumeric(yesterdaypoint) + "</b></span><span>累计收益&nbsp;&nbsp;<b>+" + getNumeric(overallpoint) + "</b></span>");


            $('.unverify').click(function(){
                $('#wechat-verification-modal').modal();
            });

        if (platform == 'iOS') {          
          document.getElementById("btn-go-topup").addEventListener("click", function(evt) {
              var a = document.createElement('a');
              a.setAttribute("href", topupurl);
              a.setAttribute("target", "_blank");
              var dispatch = document.createEvent("HTMLEvents");
              dispatch.initEvent("click", true, true);
              a.dispatchEvent(dispatch);
          }, false);          

        } else if (platform == 'AndroidOS') {
          console.log(platform);
            // document.getElementById("btn-go-topup").addEventListener('tap',function(){
            //   console.log(platform);
            //   plus.runtime.openURL(topupurl);
            // });

            var urlStr = encodeURI($('#topupurl').val());
            $('#btn-go-topup').click(function() {
                plus.runtime.openURL(urlStr);
            });

        } else {
            
          $('#btn-go-topup').click(function(){
            window.location.href = topupurl;
          });
        }

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
