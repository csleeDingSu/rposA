@extends('layouts.default_app')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/pre_share.css') }}" />
    
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '邀请好友')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="1" />
<input type="hidden" id="page_nextlvl" value="1" />
<input type="hidden" id="max_page_nextlvl" value="1" />

    <div class="shareBox fix">
        <img src="{{ asset('/clientapp/images/shareImg.png') }}" class="big">
        <div class="txtBox">
          <div class="txtIn fix">
            <p>邀请1个好友可获得1次抽奖补贴，而你的好友能获得1次新人抽奖补贴，你的好友每邀请1个好友，你还可以获得1次抽奖补贴，邀请越多，抽奖补贴越多。
              <br><br>
              每次抽奖补贴有98.43%概率获得12元。
              <br><br>
              好友需通过网站的微信认证，你才能得到抽奖补贴次数。 严厉打击小号注册领取福利。
            </p>
          </div>
          <a class="_btn" href="/share"><img src="{{ asset('/clientapp/images/shareBtn.png') }}"></a>
        </div>

        <div class="sMain">
          <p><img src="{{ asset('/clientapp/images/sIcon.png') }}"><i>奖励次数</i><span>
              <font color='#814de5' class="earned_play_times">10</font>次
            </span></p>
          <p><img src="{{ asset('/clientapp/images/sIcon2.png') }}"><i>抽得红包</i><span>
              <font color='#ff4848'>{{number_format($earnedpoint, 2, '.', ',')}}</font>元
            </span></p>
        </div>

        <div class="stitle">
          <img src="{{ asset('/clientapp/images/lTitle.png') }}"><span>邀请记录</span><img src="{{ asset('/clientapp/images/rTitle.png') }}">
        </div>

        <div class="listBox2">
          <div class="snav">
            <a class="tab-my-list on">我的邀请</a>
            <a class="tab-friend-list">好友邀请</a>
          </div>
          <div class="list">
            <ul class="my-list">
              <div class="no-record">
                <img src="{{ asset('/clientapp/images/no-record/invitation.png') }}">
                <div>暂无邀请记录</div>
              </div>
            </ul>
            <ul class="friend-list">
              <div class="no-record">
                <img src="{{ asset('/clientapp/images/no-record/invitation.png') }}">
                <div>暂无邀请记录</div>
              </div>
            </ul>
          </div>
          <hr style=" height: 1.68rem;">
        </div>

      </div>

@endsection

@section('footer-javascript')
    @parent
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
    <script src="{{ asset('/clientapp/js/pre_share.js') }}"></script>

@endsection
