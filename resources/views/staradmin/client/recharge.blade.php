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

        #modal-find-seller .modal-dialog {
          margin: 0;
          position: absolute;
          top: 30%;
          left: 50%;
          transform: translate(-50%, -50%);
        }

        #modal-find-seller .find-seller {
          color: #fff;
            font-size: 16px;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            background-color: #000;
            padding: 10px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .in-complete-note {
          color: #ff5858;
          background-color: #ffeded;
          height: 0.7rem;
          font-size: 0.3rem;
          text-align: center;
          padding: 0.15rem;
          display: none;
          /*font-weight: 550;*/
        }

        .csBtn {
          position: absolute;
          z-index: 1;
          right: .3rem;
          top: 0;
          font-size: .20rem;
          color: #2baef9;
          line-height: 1.7rem;
          display: block;
        }

        .csBtn img {
          position: absolute;
          height: 0.7rem;
          padding: 0.1rem 0.1rem 0 0.1rem;
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
  <a class="returnBtn" href="/profile"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '购买挖宝币')

@section('right-menu')
<!-- <a href="/recharge/list" class="rechargeListBtn">充值记录</a> -->
<a class="csBtn" href="{{env('CUSTOMERSERVICELINK', '#')}}"><img src="{{ asset('/clientapp/images/coin/kefu2.png') }}">在线客服</a>
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['102']->point) ? $wallet['gameledger']['102']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<div class="loading2" id="loading2"></div>

<div class="hrf3"></div>
<div class="in-complete-note">您有<span class="in-complete-count">1</span>笔充值还未完成，继续充值 ></div>

<form method="post" action="/recharge/type" id='recharge_type'>
  <input id="hidSelectedCoin" name="hidSelectedCoin" type="hidden" value="0" />
  <input id="hidSelectedCash" name="hidSelectedCash" type="hidden" value="0" />
  <input id="hidTypeContent" name="hidTypeContent" type="hidden" value="0" />
        <div class="coinBox">
          <div class="inTitle">
            <h2>选择数量</h2>
          </div>
          <ul class="inList">
            @php ($i = 0)
            @foreach($resell_amount as $r)
              @php ($i++)
              @if ($i == 1)
                <li class="on" id = "_id_{{number_format($r->amount, 0, '.', '')}}">
                  @php ($_init_cash = $r->amount)
                  @php ($_init_point = $r->point)
              @else
                <li id = "_id_{{number_format($r->amount, 0, '.', '')}}">
              @endif
                  <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span class="v-coin" id="{{$r->id}}">{{$r->point}}</span></p>
                  <h2>售价&nbsp;<span class="v-cash">{{number_format($r->amount, 0, ".", "")}}</span>元</h2>
                </li>
            @endforeach
          </ul>
          <div class="sendBox">
            <a class="rechargeBtn">确认充值</a>
          </div>

          <p class="rechargetHint"><font color="#333333">充值须知：</font>充值挖宝币均由平台用户提供转卖，平台仅提供出售信息，不出售挖宝币。充值前请先确认好支付信息，确认无误后再进行支付，若因操作失误导致损失由自己承担，平台不负责任。</p>


        </div>
</form>
@endsection

@section('footer-javascript')    
<!-- insufficient point modal -->
<div class="modal fade col-md-12" id="modal-find-seller" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="find-seller">正在匹配卖家...</div>          
  </div>
</div>

      @parent
      <script type="text/javascript">
        var vCoin = "{{empty($_init_point) ? 680 : $_init_point}}";
        var vCash = "{{empty($_init_cash) ? 68 : $_init_cash}}";
        var token = null;
        // var inCompleteCaseAmount = [];

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
              $('#modal-find-seller').modal();
              setTimeout(function(){
                getBuyer(vCoin);
              }, 2000);
            });

            getInCompleteCase();  
            
        });

      function getBuyer(point) {
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/getbuyer",
              data: { 'point': point, 'memberid': memberid},
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
                    $('#hidSelectedCoin').val(vCoin);
                    $('#hidSelectedCash').val(vCash);
                    $('#hidTypeContent').val(JSON.stringify(data));
                    // console.log(data.type);
                    //go alipay       
                    // window.location.href = '/recharge/rechargeAlipay'; 
                    $( "#recharge_type" ).submit();              
                  } else {
                    //go bank card
                    // window.location.href = '/recharge/rechargeCard';
                    alert('提交失败，重新刷新试试');
                  }
              }
          });
         
      }

      function getToken(){
        var session = $('#hidSession').val();
        var id = $('#hidMemberId').val();
        //login user
        if (id > 0) {
            
            // document.getElementById('loading').style.visibility="hidden";
            document.getElementById('loading').style.visibility="visible";

            $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                // console.log(data);
                if(data.success) {
                    token = data.access_token;
                    document.getElementById('loading').style.visibility="hidden";
                } else{
                  document.getElementById('loading').style.visibility="hidden";
                }
            });
        }
      }

      function getInCompleteCase(){
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/check-pending-resell",
              data: { 'type': 'buy', 'memberid': memberid},
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

                      $.each(data.records, function(i, item) { 
                        // inCompleteCaseAmount.push(item.amount);
                        // console.log("#_id_" + parseInt(item.amount));
                        $("#_id_" + parseInt(item.amount)).unbind();
                        $("#_id_" + parseInt(item.amount)).removeClass('on');
                      });

                      // console.log(inCompleteCaseAmount);
                      
                      $('.in-complete-note').css('display', 'block');
                      $('.in-complete-count').html(data.count);
                      $('.hrf3').css('display', 'none');
                      $('.in-complete-note').click(function () {
                        window.location.href = '/recharge/list/in-complete';
                      });
                    }  else {
                      $('.in-complete-note').css('display', 'none');
                      $('.hrf3').css('display', 'block');
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
