@extends('layouts.default_app')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/pre_share.css?version=1.0.0') }}" />
    
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
        <img src="{{ asset('/clientapp/images/share/shareImg.png') }}" class="big">
        <img class="pre-share-main-img" src="{{ asset('/clientapp/images/share/pre_share_main.png') }}">
        <div class="shareBtn">
          <a href="/share">
            <img  src="{{ asset('/clientapp/images/share/shareBtn.png') }}">
          </a>
        </div>

        <div class="sMain">
          <p><img src="{{ asset('/clientapp/images/sIcon.png') }}"><i>奖励次数</i><span>
              <font color='#814de5' class="earned_play_times">0</font>次
            </span></p>
          <p><img src="{{ asset('/clientapp/images/sIcon2.png') }}"><i>抽得红包</i><span>
              <font color='#ff4848' class="earned_point">0</font>元
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
