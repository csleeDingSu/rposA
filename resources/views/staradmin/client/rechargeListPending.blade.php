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

        .no-record {
          text-align: center;
          color: #999;
          font-size: 0.3rem;
          padding: 0.5rem;
        }

        .no-record img{
          /*width: 70%;*/
          /*height: 50%;*/
          padding: 0.5rem 0.5rem 0.1rem 0.5rem;
        }

        .countdown{
          color: #333;
          padding: 0 0.1rem 0 1.3rem;
        }

        .txt-red {
          color: #ff8282; 
          padding: 0 0.1rem;
        }

        .btn-go-recharge {
          color: #fff;
          background: #ff8282;
          border-radius: 0.2rem;
          text-align: center;
          line-height: 0.64rem;
          padding: 0.1rem;
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

@section('title', '未完成充值')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['103']->point) ? $wallet['gameledger']['103']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />

<div class="loading2" id="loading2"></div>
<div class="coinList"></div>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
        $(document).ready(function () {
          $('.card-body').addClass('bgf3');
         getToken();
        });

      function getPendingCase() {
        var memberid = $('#hidMemberId').val();       

        $.ajax({
              type: 'GET',
              url: "/api/check-pending-resell",
              data: { 'type': 'buy', 'memberid': memberid },
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
                      $.each(data.records, function(i, item) {
                        var txt_point = '';
                        var txt_status = '';
                        var txt_when = '';
                        var txt_amount = '';
                        var txt_reason = '';
                        var _url = '';
                        var _cls = '';
                        var _fontcolor = '';
                        var countdown = '';

                        txt_point = item.point;
                        txt_when = item.updated_at;
                        txt_amount = item.amount;
                        _url = '#'; //'/coin/list/detail/' + item.id;

                        if (item.status_id == 1) {
                          txt_status = '等待付款';  
                          _cls = 'payIng';
                          _fontcolor = '#6ac2ff'; 
                          countdown = '06:06';                         
                        } else if (item.status_id == 2) {
                          // txt_status = '已匹配到卖家';
                          // _cls = 'payIng';
                          // _fontcolor = '#ffa200';
                        } else if (item.status_id == 3) {
                          txt_status = '等待卖家发币';
                          _cls = 'payIng';
                          _fontcolor = '#6ac2ff';
                        } else if (item.status_id == 4) {
                          txt_status = '卖家已发币';
                          _cls = 'payOver';
                          _fontcolor = '#23ca27';
                        } else if (item.status_id == 5) {
                          txt_status = '拒绝退回';
                          txt_reason = item.reason;
                          _cls = 'payFail';
                          _fontcolor = '#ff8282';
                        }

                        html += '<a href="'+_url+'" class="inBox '+_cls+'">' +
                                  '<h2><span>' +txt_point+ '挖宝币</span>' +
                                    '<font color="'+_fontcolor+'">' + txt_status + '</font>' +
                                  '</h2>' +
                                  '<p><span>' + txt_when +'</span>' +
                                    '<font color="#686868">售价&nbsp;'+txt_amount+'元</font>' +
                                  '</p>';
                                if (txt_reason != '') {
                        html +=   '<h3>失败原因：' +txt_reason+ '</h3>';  
                                }  
                                if (countdown != '') {
                        html += '<h3><span class="countdown">请在<span class="txt-red">'+countdown+'</span>内完成付款，超时需要重新充值</span><span class="btn-go-recharge">去充值</span></h3>';  
                                  }                                 
                        html += '</a>';
                      });

                      if ((html == '') && ($('.coinList').html() == '') ) {
                        html =  '<div class="no-record">' +
                                  '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                                  '<div class="empty">你还没有充值记录<br><a href="/recharge" class="share-link">去充值></a></div>' +
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
            
            document.getElementById('loading').style.visibility="hidden";
            document.getElementById('loading2').style.visibility="visible";

            $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                // console.log(data);
                if(data.success) {
                    token = data.access_token;
                    getPendingCase();
                }
            });
        }
      }
      </script>

@endsection
