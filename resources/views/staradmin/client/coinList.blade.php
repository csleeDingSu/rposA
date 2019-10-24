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

@section('title', '转卖记录')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['102']->point) ? $wallet['gameledger']['102']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<div class="loading2" id="loading2"></div>
<div class="coinList">
          <a href="/coin/ready" class="inBox payReady">
            <h2><span>200挖宝币</span>
              <font color="#6ac2ff">正在匹配买家</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/payIng" class="inBox payIng">
            <h2><span>200挖宝币</span>
              <font color="#ffa200">已匹配到买家 125****6839</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/payOver" class="inBox payOver">
            <h2><span>200挖宝币</span>
              <font color="#51c000">买家付款完成</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/fail" class="inBox payFail">
              <h2><span>200挖宝币</span>
                <font color="#ff8282">发布失败</font>
              </h2>
              <p><span>2019-08-22 15:30</span>
                <font color="#686868">售价&nbsp;198元</font>
              </p>
              <h3>失败原因：提交收款码金额与出售金币金额不一致！</h3>
            </a>
        </div>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
      $(document).ready(function () {
        $('.card-body').addClass('bgf3');
        getToken();
      });

      function getReSellList() {
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/resell-list",
              data: { 'memberid': memberid },
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
                        var txt_point = '200挖宝币';
                        var txt_status = '正在匹配买家';
                        var txt_when = '2019-08-22 15:30';
                        var txt_amount = '售价&nbsp;198元';
                        var txt_reason = '失败原因：提交收款码金额与出售金币金额不一致！';

                        html += '<a href="/coin/fail" class="inBox payFail">' +
                                  '<h2><span>200挖宝币</span>' +
                                    '<font color="#ff8282">发布失败</font>' +
                                  '</h2>' +
                                  '<p><span>2019-08-22 15:30</span>' +
                                    '<font color="#686868">售价&nbsp;198元</font>' +
                                  '</p>' +
                                  '<h3>失败原因：提交收款码金额与出售金币金额不一致！</h3>' +
                                '</a>';
                      });

                      if ((html == '') && ($('.coinList').html() == '') ) {
                        html =  '<div class="no-record">' +
                                  '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                                  '<div class="empty">你没有转卖记录<br><a href="/coin" class="share-link">去转卖></a></div>' +
                                '</div>';
                      }
                      
                      $('.coinList').append(html);
                      
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
                    getReSellList();
                }
            });
        }
      }

      
      </script>

@endsection
