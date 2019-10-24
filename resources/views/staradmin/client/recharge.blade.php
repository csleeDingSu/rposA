@extends('layouts.default_app')

@section('top-css')
    @parent
    <style type="text/css">
      body {
        background: #f2f2f2;
      }
    </style>
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
         
    </style>       
@endsection

@section('top-javascript')
    @parent
     <script src="{{ asset('clientapp/js/lrz.mobile.min.js') }}"></script>
  <!-- <script type="text/javascript" src="{{ asset('clientapp/js/being.js') }}"></script> -->


@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '充值挖宝币')

@section('right-menu')
<a href="/recharge/list" class="rechargeListBtn">充值记录</a>
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['102']->point) ? $wallet['gameledger']['102']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<div class="loading2" id="loading2"></div>

<div class="hrf3"></div>

        <div class="coinBox">
          <div class="inTitle">
            <h2>选择数量</h2>
          </div>
          <ul class="inList">
            <li class="on">
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">50</span></p>
              <h2>售价&nbsp;<span class="v-cash">48</span>元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">100</span></p>
              <h2>售价&nbsp;<span class="v-cash">96</span>元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">200</span></p>
              <h2>售价&nbsp;<span class="v-cash">196</span>元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">500</span></p>
              <h2>售价&nbsp;<span class="v-cash">490</span>元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">1000</span></p>
              <h2>售价&nbsp;<span class="v-cash">980</span>元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin">2000</span></p>
              <h2>售价&nbsp;<span class="v-cash">1980</span>元</h2>
            </li>
          </ul>

          <div class="sendBox">
            <a class="rechargeBtn">确认充值</a>
          </div>

          <p class="rechargetHint"><font color="#333333">充值须知：</font>充值挖宝币均由平台用户提供转卖，平台仅提供出售信息，不出售挖宝币。充值前请先确认好支付信息，确认无误后再进行支付，若因操作失误导致损失由自己承担，平台不负责任。</p>


        </div>
<!-- </div> -->
@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
        var vCoin = 50;
        var vCash = 48;
        $(document).ready(function () {
            $('.scrolly').addClass('cionPage rechargePage');
            getToken();

            //选择数量
            $('.cionPage  li').click(function () {
              let vm = $(this);
              vm.addClass('on').siblings().removeClass('on');
              vCoin = $('.v-coin', this).text();
              vCash = $('.v-cash', this).text();
            });

            $('.sendBox').on('click',function () {
              getBuyer(vCoin);
            });
            
        });

      function getBuyer(point) {
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/getbuyer",
              data: { 'point': point },
              dataType: "json",
              beforeSend: function( xhr ) {
                  xhr.setRequestHeader ("Authorization", "Bearer " + token);
              },
              error: function (error) { 
                  document.getElementById('loading2').style.visibility="hidden";
                  console.log(error.responseText);
                  alert('下载失败，重新刷新试试');
                },                  
              success: function(data) {
                  console.log(data);
                  document.getElementById('loading2').style.visibility="hidden";
                  if(data.success){
                    //go alipay       
                    // window.location.href = '/recharge/rechargeAlipay';               
                  } else {
                    //go bank card
                    // window.location.href = '/recharge/rechargeCard';
                  }
              }
          });
         
      }

      function getToken(){
        var session = $('#hidSession').val();
        var id = $('#hidMemberId').val();
        //login user
        if (id > 0) {
            
            document.getElementById('loading2').style.visibility="visible";

            $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                // console.log(data);
                if(data.success) {
                    token = data.access_token;
                    document.getElementById('loading2').style.visibility="hidden";
                } else{
                  document.getElementById('loading2').style.visibility="hidden";
                }
            });
        }
      }

      
      </script>

@endsection
