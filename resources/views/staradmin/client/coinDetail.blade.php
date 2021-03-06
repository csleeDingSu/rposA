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

        .order-bar {
          margin: 0.24rem;
          display: -webkit-box;
          font-size: .24rem;
          color: #333;
        }

        .orderid {
          width: 73%;
          color: #666;
        }

        .copyBtn {
          color: #f96579;
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
<div class="order-bar"><span>订单骗号：</span><p class="orderid"></p><a class="copyBtn">复制</a></div>
<dl class="coinDetail">
</dl>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">

      document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
        } else if (state == 'complete') {
            document.getElementById('interactive');
            document.getElementById('loading').style.visibility="hidden";
            // document.getElementById('loading2').style.visibility="visible";
            $('.loading').css('display', 'initial');
        }
      }

      $(document).ready(function () {
        $('.card-body').addClass('bgf3');
        $('.scrolly').addClass('fix');
        getToken();

        //复制
        $('.copyBtn').click(function () {
          $(this).html("复制");
          let txt = $(this).prev('p').html();
          console.log(txt);
          copyText(txt);
          $(this).html("成功");
          $(this).css('color','#65d51a');
        });
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
                  var orderid = 0;
                  var is_locked = '';
                  var phone = 0;
                  console.log(data);
                  document.getElementById('loading2').style.visibility="hidden";
                  if(data.success){
                      
                      orderid = data.record.uuid;
                      is_locked = data.record.is_locked;
                      count = data.result.data.length;

                      $.each(data.result.data, function(i, item) {

                        var t = item.updated_at.split(/[- :]/);
                        var _t = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                        var formattedDate = new Date(_t);
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
                        var txt_status_pre = '';
                        var txt_dec_pre = '';
                        var txt_img_pre = '';

                        if (item.status_id == 1) {
                          txt_status = '已提交审核'; 
                          txt_dec = '等待管理员核准信息'; 
                          txt_img = '/clientapp/images/summary/1-.png';  
                        } else if (item.status_id == 2) {
                          txt_status = '正在匹配买家'; 
                          txt_dec = '请耐心等待'; 
                          txt_img = '/clientapp/images/summary/2-1.png';  
                        }
                        //  else if (item.status_id == 2) {
                        //   _phone = data.record.buyer.phone;
                        //   _phone = _phone.substring(0,3) + '*****' + _phone.slice(-4)
                        //   txt_status = '匹配到买家 <font color="#609cff">' + _phone + '</font>'; 
                        //   txt_dec = '已匹配到买家，等待买家付款'; 
                        //   txt_img = '/clientapp/images/summary/3-1.png';
                        // } 
                        else if (item.status_id == 3) {
                          txt_status = '买家已付款'; 
                          txt_dec = '等待系统审核'; 
                          txt_img = '/clientapp/images/summary/6-1.png'; 
                        } else if (item.status_id == 4) {
                          txt_status = '交易成功'; 
                          txt_dec = '买家已付款至你支付宝'; 
                          txt_img = '/clientapp/images/summary/7.png';
                        } else if (item.status_id == 5) {
                          txt_status = '<font color="#fe8686">付款超时</font>'; 
                          txt_dec = '买家未在规定时间完成付款'; 
                          txt_img = '/clientapp/images/summary/5-1.png';

                          txt_status_pre = '重新匹配买家'; 
                          txt_dec_pre = '上个买家付款失败'; 
                          txt_img_pre = '/clientapp/images/summary/2-1.png';

                        } else if (item.status_id == 7) {
                          console.log(count);
                          if (count > 2) {
                            txt_status = '重新匹配买家'; 
                            txt_dec = '上个买家付款失败'; 
                            txt_img = '/clientapp/images/summary/2-1.png';
                          } else {
                            txt_status = '<font color="#fe8686">发布失败</font>'; 
                            txt_dec = '发布信息有误，请修改。'; 
                            txt_img = '/clientapp/images/summary/4-1.png';  
                          }
                          
                        } else if (item.status_id == 8) {
                          console.log(data.record.buyer);
                          phone = (item.buyer == null) ? '' : item.buyer.phone;
                          phone = phone.substring(0,3) + '*****' + phone.slice(-4);
                          txt_status = '买家正在付款'; 
                          txt_dec = '会员<font color="#609cff">' + phone + '</font>'; 
                          txt_img = '/clientapp/images/summary/3-1.png';
                        }

                        if (txt_status_pre != '') {
                          
                         html += '<dd>' +
                                  '<div class="inTtimeBox">' +
                                    '<h2>'+txt_date+'</h2>' +
                                    '<p>'+txt_time+'</p>' +
                                  '</div>' +
                                  '<div class="inIcon">' +
                                    '<img src="'+txt_img_pre+'">' +
                                  '</div>' +
                                  '<div class="inDetail">' +
                                    '<h2>'+txt_status_pre+'</h2>' +
                                    '<p>'+txt_dec_pre+'</p>' +
                                  '</div>' +
                                '</dd>';
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
                        
                      });

                      if ((html == '') && ($('.coinDetail').html() == '') ) {
                        html =  '<div class="no-record">' +
                                  '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                                  '<div class="empty">你没有转卖记录<br><a href="/coin" class="share-link">去转卖></a></div>' +
                                '</div>';
                      }
                      
                      $('.orderid').html(orderid);
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
