@extends('layouts.default_app')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/receipt.css') }}" />    

@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:goBack();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '下单奖励')

@section('right-menu')
  <a class="cionAbout" href="#">积分说明</a>
@endsection
<!-- top nav end-->

@section('content')
  <div class="rewDetail">
    <h2>购物返回分&nbsp;抽奖拿红包</h2>
    <h3><span>1200积分=1场次，系统自动兑换</span></h3>
    <ul class="rewIn">
      <li>①平台领券淘宝下单</li>
      <li>②提交淘宝订单号</li>
      <li>③系统到账兑换场次</li>
    </ul>
    <div class="formBox fix">
      <h4><span>淘宝订单号</span><a href="/receipt/guide">查看教程</a></h4>
      <label>
        <input type="text" placeholder="复制淘宝订单号 粘贴提交">
      </label>
      <a class="sendBtn">确认提交</a>
    </div>
  </div>

  <dl class="coinExchange">
    <dd>
      <p>你已累计积分</p>
      <span>1200</span>
    </dd>
    <dt>
      <img src="{{ asset('clientapp/images/echange.png') }}">
    </dt>
    <dd>
      <p>自动兑换场次</p>
      <span>
        <font color="#000">1</font>
      </span>
    </dd>
  </dl>

  <hr class="h20F3">

  <div class="orderRwdList">
    <ul>
      <li>
        <h2><span>订单号&nbsp;25653562df5s3235</span>
          <font color="#a144ff">正在处理</font>
        </h2>
        <p><span>2019-01-01 20:30</span></p>
      </li>
      <li>
        <h2><span>订单号&nbsp;25653562df5s3235</span>
          <font color="#1dc901">奖励到账</font>
        </h2>
        <p><span>2019-01-01 20:30</span><font color="#ff6161">+260</font></p>
      </li>
      <li>
        <h2><span>订单号&nbsp;25653562df5s3235</span>
          <font color="#ff6161">奖励失效</font>
        </h2>
        <p><span>2019-01-01 20:30</span></p>
      </li>
      <li>
        <h2><span>订单号&nbsp;25653562df5s3235</span>
          <font color="#ff6161">订单号无效</font>
        </h2>
        <p><span>2019-01-01 20:30</span></p>
      </li>
    </ul>
  </div>

  <!-- Game Rules starts -->
  <div class="modal fade col-md-12" id="game-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
    <div class="modal-dialog modal-lg close-modal" role="document">
      <div class="modal-content">
          <div class="modal-title">
            积分说明
          </div>
          <div class="instructions">
            <p>
              积分是奖励给通过平台领券去淘宝下单的用户，积分可兑换抽奖场次。
            </p>
            <p>
              1200积分兑换1场次，抽最高12元红包，系统自动兑换。
            </p>
          </div>
          <div class="modal-close-btn">
            知道了
          </div>        
        
      </div>
    </div>
  </div>
@endsection

@section('footer-javascript')
    @parent
    <script type="text/javascript">
      $('.cionAbout').click(function() {
        $('#game-rules').modal();
      });

      $('.modal-close-btn').click(function () {
          $('.modal').modal('hide');
          $('.modal-backdrop').remove();
      });
    </script>

@endsection