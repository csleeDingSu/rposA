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
              <font color='#814de5'>10</font>次
            </span></p>
          <p><img src="{{ asset('/clientapp/images/sIcon2.png') }}"><i>抽得红包</i><span>
              <font color='#ff4848'>120</font>元
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
          <div class="list my-list">
            <ul>
              <li>
                <div class="line-1">
                  <h2>112****8090</h2>
                  <span>
                    <font color="#5c86fe">未微信认证</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#333333">认证成功</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                  <div class="tips"> <span>+1</span></div>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#fe5c5c">认证失败</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#5c86fe">未微信认证</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#333333">认证成功</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                  <div class="tips"><img src="{{ asset('/clientapp/images/moneyIcon.png') }}"> <span>+12</span></div>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#fe5c5c">认证失败</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="list friend-list">
            <ul>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#5c86fe">未微信认证</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#333333">认证成功</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                  <div class="tips"> <span>+1</span></div>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#fe5c5c">认证失败</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#5c86fe">未微信认证</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#333333">认证成功</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                  <div class="tips"><img src="{{ asset('/clientapp/images/moneyIcon.png') }}"> <span>+12</span></div>
                </div>
              </li>
              <li>
                <div class="line-1">
                  <h2>112****8887</h2>
                  <span>
                    <font color="#fe5c5c">认证失败</font>
                  </span>
                </div>
                <div class="line-2">
                  <p>2019-02-02 16:05</p>
                </div>
              </li>
            </ul>
          </div>
          <hr style=" height: 1.68rem;">
        </div>

      </div>

@endsection

@section('footer-javascript')
    @parent
    <!-- <script src="{{ asset('/clientapp/js/pre_share.js') }}"></script> -->

    <script type="text/javascript">

      $(document).ready(function () {

        $('.tab-my-list').addClass('on');
        $('.tab-friend-list').removeClass('on');
        $('.my-list').css({'display': 'block'});
        $('.friend-list').css({'display': 'none'});

        $('.tab-my-list').click(function() {
          $('.tab-my-list').addClass('on');
          $('.tab-friend-list').removeClass('on');
          $('.my-list').css({'display': 'block'});
          $('.friend-list').css({'display': 'none'});
        });

        $('.tab-friend-list').click(function() {
          $('.tab-my-list').removeClass('on');
          $('.tab-friend-list').addClass('on');
          $('.my-list').css({'display': 'none'});
          $('.friend-list').css({'display': 'block'});
        });

      });
      
      
    </script>

@endsection
