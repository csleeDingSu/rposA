@extends('layouts.default_app')

@section('top-css')
    @parent  
    <style type="text/css">
      .pageHeader {
        background: #5846cf !important;
        color: #fff !important;
      }

      .pageHeader a.returnBtn span{
        color: #fff !important; 
      }

      .pageHeader h2{
       color: #fff !important;  
      }

      .loading2 {
        position: fixed;
        left: 0px;
        top: 1.8rem;
        width: 100%;
        height: 85%;
        z-index: 9999;
        background: url(/client/images/preloader.gif) center no-repeat;
        background-color: rgba(255, 255, 255, 1);
        background-size: 32px 32px;
      }

      .input-form, .input-form-success{
        margin: 0;
          padding: 0.5rem;
      }

      .input-form li {
          padding: 0 0.25rem;
          margin-bottom: 0.28rem;
      }

      .input-form .flexSp {
          background: #fff;
          border-radius: 0.2rem;
          -webkit-border-radius: 0.2rem;
          -moz-border-radius: 0.2rem;
          -ms-border-radius: 0.2rem;
          -o-border-radius: 0.2rem;
          height: 0.84rem;
          align-items: center;
          padding: 0 0.2rem;
          display: flex;
          border: 1px solid #bababa;
          width: 100%;
      }

      .input-form .title{
        color: #5a5a5a;
        font-size: 0.35rem;
      }

      .input-form img{
        height: 0.5rem;
      }

      .input-form .flexSp input {
          display: flex;
          width: 100%;
          box-sizing: border-box;
          padding-left: 0.25rem;
          padding-top: 0rem;
          font-size: 0.32rem;
          line-height: 2em;
          background: none;
          border: none;
      }

      .input-form .warning {
        color: #8f8f8f;
        font-size: 0.25rem;
        text-align: center;
        margin-top: 0.5rem;
      }

      .input-form .modal-confirm-button {
        cursor: pointer;
        border: 1px solid #1baceb;
        font-size: 0.36rem;
        background: #1baceb;
        color: #fff;
        border-radius: 25px;
        padding: 10px;
        text-align: center;
      }

      .input-form-success {
        display: none;
      }

      .input-form-success .title{
        color: #5c4ad0;
        font-size: 0.4rem;
        text-align: center;
        line-height: 0.7rem;
      }

      .input-form-success .title-small{
        color: #b7b7b7;
        font-size: 0.35rem;
        text-align: center;
        line-height: 0.7rem;
      }

      .input-form-success .warning {
        color: #8c8c8c;
        font-size: 0.35rem;
        text-align: center;
        line-height: 0.7rem;
      }

      .input-form-success .warning-small {
        color: #8c8c8c;
        font-size: 0.25rem;
        text-align: center;
      }

      .input-form-success .csimg{
        text-align: center;
      }

      .input-form-success img{
        height: 4.5rem;
      }

    </style>
@endsection

@section('top-javascript')
    @parent   
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="/arcade"><img src="{{ asset('clientapp/images/returnIcon2.png') }}"><span>返回</span></a>
@endsection

@section('title', '幸运转盘')

@section('right-menu')
@endsection

@section('content')
<input id="hidMemberId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidalipayaccount" type="hidden" value="{{isset(Auth::Guard('member')->user()->alipay_account) ? Auth::Guard('member')->user()->alipay_account : 0}}" />

<div class="loading2" id="loading2"></div>
<!-- show alipay form  -->
<div class="input-form">
  <ul>
    <li>
      <p class="title">请填写收款支付宝和手机号</p>  
    </li>
    <li>
        <div class="flexSp">
            <img src="{{ asset('client/images/alipayform/alpay.png') }}">
            <input type="text" id="alipayaccount" name="alipayaccount" placeholder="@lang('dingsu.ph_alipayaccount')" required maxlength="30" autofocus>
        </div>
    </li>
    <li>
        <div class="flexSp">
            <img src="{{ asset('client/images/alipayform/phone.png') }}">
            <input type="text" id="contactno" name="contactno" placeholder="@lang('dingsu.ph_username_mobile_no')" value="{{empty(Auth::Guard('member')->user()->phone) ? '' : Auth::Guard('member')->user()->phone}}" required maxlength="30">
        </div>
    </li>
    <li>
      <p class="warning">*请确认填写信息正确，否则无法提现。</p>  
    </li>
    <li>
      <div class="modal-confirm-button" id="btn-submit-alipayform">提交</div>
    </li>
  </ul>
</div>

<div class="input-form-success">
  <ul>
    <li>
      <p class="title">您已成功绑定支付宝</p>  
    </li>
    <li>
      <p class="title-small">马上联系客服提现</p>  
    </li>
    <li>
      <p class="csimg">
        <img src="{{ asset('/client/images/game-node/csqrcode.JPG') }}"/>
      </p>
    </li>
    <li>
      <p class="warning">长按扫一扫加好友</p>
      <p class="warning-small">谢拒微信小号添加</p>
    </li>
  </ul>
</div>


@endsection

@section('footer-javascript')
  @parent  
  <script type="text/javascript">

    document.onreadystatechange = function () {
      var state = document.readyState
      if (state == 'interactive') {
      } else if (state == 'complete') {
        setTimeout(function(){
            document.getElementById('interactive');
            document.getElementById('loading').style.visibility="hidden";
            $('.loading').css('display', 'initial');
            document.getElementById('loading2').style.visibility="hidden";
        },100);
      }
    }

    $(document).ready(function () {
      $('#pTitle').html('绑定支付宝');
      $bAccount = $('#hidalipayaccount').val();
      console.log($bAccount);

      if ($bAccount == 0) {
        $('.input-form-success').css('display','none');
        $('.input-form').css('display','block');
        
      } else {
        window.location.href = '/arcade';
      }

      $('#btn-submit-alipayform').click(function () {
        if (($('#alipayaccount').val().length > 0) && ($('#contactno').val().length > 0)) {
          storeAlipayAccount(); 
        } else {
          if ($('#alipayaccount').val().length <= 0) {
            alert('请填写支付宝账号');  
          } else {
            alert('请输入手机号');
          }
        }
        
      });
  });

    function storeAlipayAccount() {
    var memberid = $('#hidMemberId').val();
    var session = $('#hidSession').val();
    var alipay_account = $('#alipayaccount').val();
    var phone = $('#contactno').val();

    $('#btn-submit-alipayform').html('提交 - 处理中');

      $.ajax({
        type: 'POST',
          url: "/alipay/api/storeAlipayAccount",
          data: { 'memberid': memberid, 'alipay_account': alipay_account, 'phone': phone},
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + session);
          },
          error: function (error) {
              console.log(error);
              alert(error.message);
              console.log(5);
              $('#btn-submit-alipayform').html('提交 - 失败');
          },
          success: function(data) {
            console.log(data);
            console.log(data.success);
            if (data.success) {
              $('#hidalipayaccount').val(alipay_account);
              $('#btn-submit-alipayform').html('提交 - 成功');
              $('#pTitle').html('提交成功');
              $('.input-form').css('display','none');
              $('.input-form-success').css('display','block');
            } else {
              $('#btn-submit-alipayform').html('提交');
              $('#pTitle').html('提交失败');
              code = data.code;
              if (code.length > 0) {
                msg = data.data; //'已经是wabao666.com会员';
              } else {
                msg = '请联络客服';
              }
              alert(msg);
              setTimeout(function(){ 
                window.location.href = '/arcade';
              }, 500); 
            }

          }
      });

  }


  </script>

@endsection