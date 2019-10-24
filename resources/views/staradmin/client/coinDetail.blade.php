@extends('layouts.default_app')

@section('top-css')
    @parent      
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

@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '订单详情')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['102']->point) ? $wallet['gameledger']['102']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<div class="loading2" id="loading2"></div>

<dl class="coinDetail">
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinRight2.png') }}">
            </div>
            <div class="inDetail">
              <h2><font color="#51c000">买家付款完成</font></h2>
              <p>买家已完成付款，请核实收款金额<font color="#ff6b6b">￥198</font>
              </p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinUser2.png') }}">
            </div>
            <div class="inDetail">
              <h2>已匹配到买家<font color="#609cff">135****8888</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinClose2.png') }}">
            </div>
            <div class="inDetail">
              <h2>
                <font color="#fe8686">买家付款失败</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinUser2.png') }}">
            </div>
            <div class="inDetail">
              <h2>已匹配到买家<font color="#609cff">135****8888</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
              <div class="inTtimeBox">
                <h2>08-22</h2>
                <p>15:30</p>
              </div>
              <div class="inIcon">
                <img src="{{ asset('/clientapp/images/coinUserT2.png') }}">
              </div>
              <div class="inDetail">
                <h2>正在匹配买家</h2>
                <p>订单正在转卖中，等待匹配买家</p>
              </div>
            </dd>
            <dd>
                <div class="inTtimeBox">
                  <h2>08-22</h2>
                  <p>15:30</p>
                </div>
                <div class="inIcon">
                  <img src="{{ asset('/clientapp/images/coinRight2.png') }}">
                </div>
                <div class="inDetail">
                  <h2>订单已提交</h2>
                  <p>转卖订单已提交，正在处理中</p>
                </div>
              </dd>
        </dl>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
      $(document).ready(function () {
        $('.card-body').addClass('bgf3');
        $('.scrolly').addClass('fix');
        getToken();
      });

      function getReSellDetail(id) {
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/resell-tree",
              data: { 'memberid': memberid, 'id' : id },
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
                  var html = '';
                  console.log(data);
                  document.getElementById('loading2').style.visibility="hidden";
                  if(data.success){
                      $.each(data, function(i, item) {
                        var txt_date = '08-22';
                        var txt_time = '15:30';
                        var txt_status = '买家付款完成';
                        var txt_point = '';
                        var txt_amount = '买家已完成付款，请核实收款金额<font color="#ff6b6b">￥198</font>';
                        var txt_reason = '失败原因：提交收款码金额与出售金币金额不一致！';

                        html += '<div class="inTtimeBox">' +
                                  '<h2>08-22</h2>' +
                                  '<p>15:30</p>' +
                                '</div>' +
                                '<div class="inIcon">' +
                                  '<img src="/clientapp/images/coinRight2.png">' +
                                '</div>' +
                                '<div class="inDetail">' +
                                  '<h2><font color="#51c000">买家付款完成</font></h2>' +
                                  '<p>买家已完成付款，请核实收款金额<font color="#ff6b6b">￥198</font>' +
                                  '</p>' +
                                '</div>';
                              });

                      if ((html == '') && ($('.coinDetail').html() == '') ) {
                        html =  '<div class="no-record">' +
                                  '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                                  '<div class="empty">你没有转卖记录<br><a href="/coin" class="share-link">去转卖></a></div>' +
                                '</div>';
                      }
                      
                      $('.coinDetail').append(html);
                      
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
                    getReSellDetail(1);
                }
            });
        }
      }

      
      </script>

@endsection
