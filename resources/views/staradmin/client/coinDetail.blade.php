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
<input id="hidReSellId" type="hidden" value="{{!empty($resell_id) ? $resell_id : 0}}" />
<div class="loading2" id="loading2"></div>

<dl class="coinDetail">
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
                      $.each(data.result.data, function(i, item) {
                        var formattedDate = new Date(item.updated_at);
                        var d = formattedDate.getDate();
                        var m =  formattedDate.getMonth();
                            m += 1;  // JavaScript months are 0-11
                        var y = formattedDate.getFullYear();
                        var h = formattedDate.getHours();
                        var mm = formattedDate.getMinutes();
                        mm = (mm > 9) ? mm : '0' + mm;
                        var txt_date = d + "-" + m;
                        var txt_time = h + ':' + mm;
                        var txt_status = '';
                        var txt_dec = '';
                        var txt_img = '';

                        if (item.status_id == 1) {
                          txt_status = '正在匹配买家'; 
                          txt_dec = '订单正在转卖中，等待匹配买家'; 
                          txt_img = '/clientapp/images/coinUserT2.png';  
                        } else if (item.status_id == 2) {
                          txt_status = '已匹配到买家 <font color="#609cff">135****8888</font>'; 
                          txt_dec = '已匹配到买家，等待买家充值'; 
                          txt_img = '/clientapp/images/coinUser2.png'; 
                        } else if (item.status_id == 3) {
                          txt_status = '<font color="#fe8686">买家付款失败</font>'; 
                          txt_dec = '已匹配到买家，等待买家充值'; 
                          txt_img = '/clientapp/images/coinClose2.png'; 
                        } else if (item.status_id == 4) {
                          txt_status = '已匹配到买家<font color="#609cff">135****8888</font>'; 
                          txt_dec = '买家已完成付款，请核实收款金额<font color="#ff6b6b">￥'+item.amount+'</font>'; 
                          txt_img = '/clientapp/images/coinRight2.png'; 
                        }

                        html += '<dd>' +
                                  '<div class="inTtimeBox">' +
                                    '<h2>'+txt_date+'</h2>' +
                                    '<p>'+txt_time+'</p>' +
                                  '</div>' +
                                  '<div class="inIcon">' +
                                    '<img src="'+txt_img+'">' +
                                  '</div>' +
                                  '<div class="inDetail">' +
                                    '<h2>'+txt_status+'</h2>' +
                                    '<p>'+txt_dec+'</p>' +
                                  '</div>' +
                                '</dd>';

                        if (item.status_id == 1) {
                          formattedDate = new Date(item.created_at);
                          d = formattedDate.getDate();
                          m =  formattedDate.getMonth();
                          m += 1;  // JavaScript months are 0-11
                          y = formattedDate.getFullYear();
                          h = formattedDate.getHours();
                          mm = formattedDate.getMinutes();
                          mm = (mm > 9) ? mm : '0' + mm;
                          txt_date = d + "-" + m;
                          txt_time = h + ':' + mm;

                          html += '<dd>' +
                                  '<div class="inTtimeBox">' +
                                    '<h2>'+txt_date+'</h2>' +
                                    '<p>'+ txt_time +'</p>' +
                                  '</div>' +
                                  '<div class="inIcon">' +
                                    '<img src="/clientapp/images/coinRight2.png">' +
                                  '</div>' +
                                  '<div class="inDetail">' +
                                    '<h2>订单已提交</h2>' +
                                    '<p>转卖订单已提交，正在处理中</p>' +
                                  '</div>' +
                                '</dd>';
                        }
                        
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
        var resell_id = $('#hidReSellId').val();
        //login user
        if (id > 0) {
            
            document.getElementById('loading2').style.visibility="visible";

            $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                // console.log(data);
                if(data.success) {
                    token = data.access_token;
                    getReSellDetail(resell_id);
                }
            });
        }
      }

      
      </script>

@endsection
