@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/coin.css') }}" />
     <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          position: fixed;
          left: 0px;
          top: 0;
          width: 100%;
          height: 100%;
          z-index: 9999;
          background: url(/client/images/preloader.gif) center no-repeat;
          background-color: rgba(255, 255, 255, 0.5);
          background-size: 32px 32px;
          visibility: hidden;
        }

        .in-complete-note {
          color: #9d6dff;
          /*background-color: #ffeded;*/
          height: 0.7rem;
          font-size: 0.3rem;
          text-align: center;
          padding: 0.15rem;
          display: none;
          /*font-weight: 550;*/
        }

        .csBtn {
          background: url(/clientapp/images/coin/beijing.png) center no-repeat;
          font-size: .28rem;
          position: absolute;
          right: 0;
          top: 0;
          line-height: .9rem;
          background-size: cover;
          padding: 0 0.1rem 0.1rem 0.1rem;
        }
        .csBtn img{
          padding: 0 0.1rem 0 0.15rem;
          height: 0.4rem;
        }

        .cionPage .sendBox {
          padding: .2rem .3rem 0.5rem .3rem !important;
        }

        .cJcheng .bd .inBox{
          margin-bottom: 3rem !important;
        }

        .quanBox {
          margin-bottom: 0 !important;
        }

        .cJcheng{
          background: rgba(0, 0, 0, 0.5) !important;
        }

        .coinShade img {
          height: 100% !important;
        }
         
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('test/html_design/css/style.css') }}" />
        
@endsection

@section('top-javascript')
    @parent
      <script src="{{ asset('/clientapp/js/lrz.mobile.min.js') }}"></script>
      <!-- <script type="text/javascript" src="{{ asset('test/html_design/js/being.js') }}"></script> -->

      <script type="text/javascript">
var being2 = {
        //遮罩
  wrapShow: function(cname) {
    var that = this;
    var len = $("body").find(".wrapBox").length;
    if (len > 0) {
      return;
    } else {
      var wrap = '<div class="wrapBox opacity2">&nbsp;</div>';
      var me = this;
      // 遮罩显示
      if (cname) {
        $(cname).append(wrap);
      } else {
        $("body").append(wrap);
      }
    }
  },
  //遮罩
  wrapHide: function(callback) {
    $(".wrapBox").fadeOut(150, function() {
      if(callback && typeof callback == 'function'){
        callback();
      }
      $(this).remove();
      
    });
  },
  //删除全部遮罩
  wrapfaOutAll: function() {
    $(".wrapBox").fadeOut(150, function() {
      $(this).remove();
    });
  },
  //显示--scale
  scaleShow: function(cname, callback) {
    var cname = $(cname);
    cname.addClass("scaleShow").removeClass("scaleHide");
    if (callback && typeof callback == "function") {
      callback();
    }
  },
  //隐藏-scale
  scaleHide: function(cname) {
    var cname = $(cname);
    cname.addClass("scaleHide").removeClass("scaleShow");
  }
  };
      </script>

@endsection

@section('title', '转卖挖宝币')

@section('top-navbar')    
@endsection

@section('content')

<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['103']->point) ? $wallet['gameledger']['103']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />

<div class="loading2" id="loading2"></div>
<div class="topBox fix">
    <div class="pageHeader rel">
      <a class="returnBtn" href="/profile"><img src="{{ asset('/clientapp/images/returnIcon2.png') }}"><span>返回</span></a>
      <h2>我的奖品</h2>
      <!-- <a class="coinListBtn" href="/coin/list">转卖记录</a> -->
      <a class="csBtn" href="{{env('CUSTOMERSERVICELINK', '#')}}"><img src="{{ asset('/clientapp/images/coin/kefu1.png') }}">在线客服</a>
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
        <img src="{{ asset('/clientapp/images/coinIcon2.png') }}">
        <p>提交收款码和吱口令</p>
      </li>
      <li>
        <img src="{{ asset('/clientapp/images/coinIcon3.png') }}">
        <p>转卖收益</p>
      </li>
    </ul>
    <div class="in-complete-note">您有<span class="in-complete-count">1</span>笔挖宝币正在转卖，查看进度 ></div>
  </div>

  <div class="coinBox">
    <div class="inTitle">
      <h2>转卖挖宝币</h2>
      <span>剩余挖宝币&nbsp;<font color="#ffa414"><span class="bal-point">{{$wallet['gameledger']['103']->point}}</span></font></span>
    </div>
    <ul class="inList">
      @php ($i = 0)
      @foreach($resell_amount as $r)
        @php ($i++)
        @if ($i == 1)
          @php ($_init_cash = $r->amount)
          @php ($_init_point = $r->point)
          <li class="on">
        @else
          <li>
        @endif
            <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin" id="{{$r->id}}">{{$r->point}}</span></p>
            <h2>售价&nbsp;<span class="v-cash">{{number_format($r->amount, 0, ".", "")}}</span>元</h2>
          </li>
      @endforeach
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
    <!-- <div class="btnBox">
      <a href="/coin/help/addQrcode">【必看】添加收款码教程</a>
    </div> -->
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
      <!-- <a href="/coin/help/copyTxt">【必看】吱口令提交教程</a> -->
      <a class="cJchengShow">【必看】提交收款码和提交吱口令教程></a>
    </div>

  </div>

  <div class="sendBox">
    <a class="inSendBtn">确认转卖</a>
  </div>

@endsection

@section('footer-javascript')    

<!-- 教程 -->
<div class="cJcheng">
    <div class="inShow">
        <div class="hd"><a class="on">提交收款码</a> <a>提交吱口令</a></div>
        <div class="bd">
            <div class="inBox">
              <dl class="quanBox addQrcode">
                <dt>
                  <font color="#108ee9">01</font><span>支付宝搜索“AA收款”点击进入官方平台</span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/addCoin1.jpg') }}">
                </dd>
                <dt>
                  <font color="#108ee9">02</font><span>进入AA收款，切换为<font color="#108ee9">填写人均金额。</font></span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/addCoin2.jpg') }}">
                </dd>
                <dt>
                  <font color="#108ee9">03</font><span>发起收款设置，出售价格100元，则填写人均
                      金额100元，总人数2人，备注出售金币</span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/addCoin3.jpg') }}">
                </dd>
                <dt>
                  <font color="#108ee9">04</font><span>生成AA收款二维码，用手机自带截屏功能
                      把图片保存到相册，然后在平台<font color="#108ee9">添加收款码图片</font></span>
                </dt>
                <dd>
                    <img src="{{ asset('/clientapp/images/help/addCoin4.jpg') }}">
                    <img src="{{ asset('/clientapp/images/help/addCoin5.jpg') }}">
                </dd>
              </dl>
            </div>
            <div class="inBox">
              <dl class="quanBox addQrcode">
                <dt>
                  <font color="#108ee9">01</font><span>AA收款码生成页面--点击“通知其他好友”</span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/copyTxt1.jpg') }}">
                </dd>
                <dt>
                  <font color="#108ee9">02</font><span>点击“微信好友”,生成AA收款吱口令弹框</span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/copyTxt2.jpg') }}">
                </dd>
                <dt>
                  <font color="#108ee9">03</font><span>生成吱口令后，到平台“提交吱口令”这里粘贴吱口令，如图示。</span>
                </dt>
                <dd>
                  <img src="{{ asset('/clientapp/images/help/copyTxt3.jpg') }}">
                </dd>
              </dl>
            </div>
        </div>
    </div>
</div>  
  
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

      var token = null;

      $(document).ready(function () {
                
        getToken();
        getInCompleteCase();
        
        $('.scrolly').addClass('cionPage');

        $('.close-modal').click(function() {
          $('.modal').modal('hide');
          $('.modal-backdrop').remove(); 
        });

      //判断页面数据是否录入完毕

      let sendData = new Object();
      sendData.upImg = "";
      sendData.copyTxt = "";
      sendData.vCoin = "{{empty($_init_point) ? 680 : $_init_point}}"; //default
      sendData.vCash = "{{empty($_init_cash) ? 68 : $_init_cash}}"; //default
      _point = Number($('#hidPoint').val());

      if (Number(_point) < Number(sendData.vCoin)) {
        $('.cionPage .coinBox .inList li').removeClass('on');
        // alert('挖宝币不足');
      }

      //专卖挖宝
      $('.cionPage .coinBox .inList li').click(function () {
        let vm = $(this);
        
        console.log($('.v-coin', this).text());
        console.log($('.v-cash', this).text());
        sendData.vCoin = $('.v-coin', this).text();
        sendData.vCash = $('.v-cash', this).text();

        if (Number(_point) < Number(sendData.vCoin)) {
          alert('挖宝币不足');
        } else {
          vm.addClass('on').siblings().removeClass('on');  
        }
        
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
        if (sendData.upImg != '' && sendData.copyTxt != "" && Number(sendData.vCoin) > 0) {
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
        submitCoin(sendData);
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
        window.location.href = '/profile';
      });

      // 充值教程
        $(".cJchengShow").click(() => {
            being2.wrapShow();
            $(".cJcheng").slideDown(150);
        });

        $(".cJcheng .hd a").click(function() {
            let that = $(this);
            let i = that.index();
            that
                .addClass("on")
                .siblings()
                .removeClass("on");
            $(".cJcheng .bd .inBox")
                .eq(i)
                .fadeIn(0)
                .siblings()
                .fadeOut(0);
        });
        $(".cJcheng").click(function(e) {
            var target = $(e.target).closest(".inShow").length;
            if (target > 0) {
                return;
            } else {
                $(".cJcheng").slideUp(150);
                being2.wrapHide();
            }
        });

    });


      function submitCoin(sendData) {
        var memberid = $('#hidMemberId').val();
        // var gUpload = [];
        console.log(memberid);
        console.log(sendData.upImg);
        console.log(sendData.copyTxt);
        console.log(sendData.vCoin);
        console.log(sendData.vCash);
        console.log(token);
        // gUpload.push(sendData.upImg);

        document.getElementById('loading2').style.visibility="visible";

        $.ajax({
              type: 'POST',
              url: "/api/resell-request",
              data: { 'memberid': memberid, 'barcode': sendData.upImg, 'passcode': sendData.copyTxt, 'point': sendData.vCoin, 'amount' : sendData.vCash },
              dataType: "json",
              beforeSend: function( xhr ) {
                  xhr.setRequestHeader ("Authorization", "Bearer " + token);
              },
              error: function (error) { 
                  document.getElementById('loading2').style.visibility="hidden";
                  console.log(error.responseText);
                  alert('提交失败');
                },                  
              success: function(data) {
                  document.getElementById('loading2').style.visibility="hidden";
                  if(data.success){
                    $('.bal-point').html(Number($('.bal-point').html()) - Number(sendData.vCoin));
                      being.showMsg('.coinShade'); 
                      setTimeout(function(){ 
                        window.location.href = '/coin';
                      }, 5000);                      
                  }
              }
          });
         
      }

      function getToken(){
        var session = $('#hidSession').val();
        var id = $('#hidMemberId').val();
        //login user
        if (id > 0) {
            $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                // console.log(data);
                if(data.success) {
                    token = data.access_token;
                }
            });
        }
      }

      function getInCompleteCase(){
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/check-pending-resell",
              data: { 'type': 'sell', 'memberid': memberid},
              dataType: "json",
              beforeSend: function( xhr ) {
                  xhr.setRequestHeader ("Authorization", "Bearer " + token);
              },
              error: function (error) { 
                  // document.getElementById('loading2').style.visibility="hidden";
                  console.log(error.responseText);
                  alert('下载失败，重新刷新试试');
                },                  
              success: function(data) {
                  console.log(data);
                  // document.getElementById('loading2').style.visibility="hidden";
                  if(data.success){
                   
                    console.log(data.count);
                    
                    if (data.count > 0) {
                      $('.in-complete-note').css('display', 'block');
                      $('.in-complete-count').html(data.count);
                      $('.in-complete-note').click(function () {
                        window.location.href = '/coin/list/in-complete';
                      });
                    }  else {
                      $('.in-complete-note').css('display', 'none');
                    }
                                 
                  } else {
                    //go bank card
                    // window.location.href = '/recharge/rechargeCard';
                    // alert('提交失败，重新刷新试试');
                  }
              }
          });
      }

    </script>

@endsection

<!-- socket start-->  
<script type="text/javascript">
  @section('socket')
  @parent

    var id = "{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}";
    console.log('prefix --- ' + prefix);
    console.log('id --- ' + id);

    socket.on(prefix+id+"-pending-seller" + ":App\\Events\\EventDynamicChannel" , function(data){
        console.log(prefix+id+"-pending-seller" + ":App\\Events\\EventDynamicChannel");
        console.log(data);
    });
    
  @endsection
</script>
<!-- socket end-->