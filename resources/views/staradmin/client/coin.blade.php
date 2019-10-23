@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/coin.css') }}" />
    
@endsection

@section('top-javascript')
    @parent

@endsection

@section('title', '专卖挖宝币')

@section('top-navbar')    
@endsection

@section('content')

<div class="topBox fix">
    <div class="pageHeader rel">
      <a class="returnBtn"><img src="{{ asset('/clientapp/images/returnIcon2.png') }}"><span>返回</span></a>
      <h2>我的奖品</h2>
      <a class="coinListBtn" href="/coin/list">专卖记录</a>
    </div>
    <div class="inBox">
      <img class="inBanner" src="{{ asset('/clientapp/images/coinTxt.png') }}">
      <span>无售出，可退回</span>
    </div>
    <ul class="cionAbout">
      <li>
        <img src="{{ asset('/clientapp/images/coinIcon1.png') }}">
        <p>选择转卖挖宝币</p>
      </li>
      <li>
        <img src="{{ asset('/clientapp/images/coinIcon1.png') }}">
        <p>提交收款码和吱口令</p>
      </li>
      <li>
        <img src="{{ asset('/clientapp/images/coinIcon1.png') }}">
        <p>转卖收益</p>
      </li>
    </ul>
  </div>

  <div class="coinBox">
    <div class="inTitle">
      <h2>转卖挖宝币</h2>
      <span>剩余挖宝币&nbsp;<font color="#ffa414">360</font></span>
    </div>
    <ul class="inList">
      <li class="on">
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>50</span></p>
        <h2>售价&nbsp;48元</h2>
      </li>
      <li>
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>100</span></p>
        <h2>售价&nbsp;96元</h2>
      </li>
      <li>
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>200</span></p>
        <h2>售价&nbsp;196元</h2>
      </li>
      <li>
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>500</span></p>
        <h2>售价&nbsp;490元</h2>
      </li>
      <li>
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>1000</span></p>
        <h2>售价&nbsp;980元</h2>
      </li>
      <li>
        <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>2000</span></p>
        <h2>售价&nbsp;1980元</h2>
      </li>
    </ul>
  </div>

  <div class="coinBox coinBox25">
    <div class="inTitle">
      <h2>提交收款码</h2>
      <span>
        <font color="#3284ff">仅限支付宝AA收款码</font>
      </span>
    </div>
    <div class="inUpFile">
      <a class="fileBtn">
        <input type="file">
        <img src="{{ asset('/clientapp/images/qrcodeDemo.png') }}">
      </a>
    </div>
    <div class="btnBox">
      <a href="/coin/help/addQrcode">【必看】添加收款码教程</a>
    </div>
  </div>


  <div class="coinBox">
    <div class="inTitle">
      <h2>提交吱口令</h2>
      <span>
        <font color="#3284ff">AA收款码生成的吱口令</font>
      </span>
    </div>

    <div class="copyBox">
      <!-- #在口令#长安复制词条消息，去支付宝首页进行搜索粘贴即可付AA账单TL34D992SZ -->
      <textarea rows="3" class="copyWord"></textarea>
      <span class="textPlace">粘贴AA收款码吱口令</span>
    </div>

    <div class="btnBox">
      <a href="/coin/help/copyTxt">【必看】吱口令提交教程</a>
    </div>

  </div>

  <div class="sendBox">
    <a class="inSendBtn">确认转卖</a>
  </div>

@endsection

@section('footer-javascript')      
  
  <div class="coinShade ">
    <div class="inBox fix">
      <img src="{{ asset('/clientapp/images/coinShare.png') }}">
      <h2>转卖成功</h2>
      <p> 您的挖宝币已售出，正在匹配买家，<br>
        您可以在-<font color="#ff9528">转卖记录</font>-查看进展</p>
        <a class="inClostBtn">我知道了</a>
    </div>
  </div>


    @parent

    <script type="text/javascript">
      $(document).ready(function () {
        $('.scrolly').addClass('cionPage');

        $('.close-modal').click(function() {
          $('.modal').modal('hide');
          $('.modal-backdrop').remove(); 
        });

      //判断页面数据是否录入完毕

      let sendData = new Object();
      sendData.upImg = "";
      sendData.copyTxt = "";

      //专卖挖宝
      $('.cionPage .coinBox .inList li').click(function () {
        let vm = $(this);
        vm.addClass('on').siblings().removeClass('on');
      });

      //口令上传
      $('.fileBtn input').change(function () {
        let that = $(this);
        let obj = this;
        lrz(obj.files[0], {
          width: 800,
          height: 600,
          before: function () {
            console.log('压缩开始');
          },
          fail: function (err) {
            console.error(err);
          },
          always: function () {
            console.log('压缩结束');
          },
          done: function (results) {
            // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
            var data = results.base64;
            that.parent('a').find('img').attr('src', data);

            sendData.upImg = data;


            if (sendData.upImg != '' && sendData.copyTxt != "") {
              $('.inSendBtn').addClass('on');
            } else {
              $('.inSendBtn').removeClass('on');
            }



          }
        });
      });

      //监听口令
      $('.copyWord').bind('input propertychange', function () {

        let vm = $(this);
        sendData.copyTxt = vm.val();
        if (vm.val() != "") {
          $('.textPlace').hide(0);
        }
        if (sendData.upImg != '' && sendData.copyTxt != "") {
          $('.inSendBtn').addClass('on');
        } else {
          $('.inSendBtn').removeClass('on');
        }
      });

      $('.copyWord').focus(function () {
        $('.textPlace').hide(0);
      });

      $('.copyWord').blur(function () {
        let vm = $(this);
        if (vm.val() == "") {
          $('.textPlace').show(0);
        }
      });


      //出售

      $('.sendBox').on('click','a.on',function () {
        being.showMsg('.coinShade');
      });
      $('.coinShade ').click(function (e) {
        console.log($(e.target).html());
        let a = $(e.target).find('.inBox').length;
        if(a>0){
          being.hideMsg('.coinShade');
        }
      });

      $('.inClostBtn').click(function(){
        being.hideMsg('.coinShade');
      });

    });

    </script>

@endsection
