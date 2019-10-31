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
         padding: 0.1rem;
          font-size: 0.26rem !important;
          background: #f1f1f1;
          border-radius: 1rem;
          margin: 0 0.1rem;
        }

        .txt-red {
          color: #ff8282 !important;
          padding: 0 0.1rem;
          font-size: .26rem !important;
        }

        .btn-go-recharge {
          background: url(/clientapp/images/recharge/btn-pay.png) center no-repeat;
          color: #fff !important;
          text-align: center;
          line-height: 0.64rem;
          padding: 0.1rem;
          background-size: contain;
          font-size: .3rem !important;
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

      function getInCompleteCase() {
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
                        txt_when = item.created_at;
                        txt_amount = item.amount;

                        if (item.status_id == 1) {
                          txt_status = '等待付款';  
                          // _cls = 'payIng';
                          _fontcolor = '#6ac2ff'; 
                          getCoundown(item.locked_time, item.id);
                          countdown = '<span class="txt-red" id="'+item.id+'">00:00</span>';   
                          _url = '/recharge/type?credit_resell_id=' + item.id + '&coin=' + txt_point + '&cash=' + txt_amount;                    
                        } else if (item.status_id == 2 && item.is_locked == 1) {
                          txt_status = '等待付款';  
                          // _cls = 'payIng';
                          _fontcolor = '#6ac2ff'; 
                          getCoundown(item.locked_time, item.id);
                          countdown = '<span class="txt-red" id="'+item.id+'">00:00</span>';   
                          _url = '/recharge/type?credit_resell_id=' + item.id + '&coin=' + txt_point + '&cash=' + txt_amount;                    
                        } else if (item.status_id == 2  && item.is_locked != 1) {
                          txt_status = '等待买家';
                          // _cls = 'payIng';
                          _fontcolor = '#ffa200';
                        } else if (item.status_id == 3) {
                          txt_status = '等待卖家发币';
                          // _cls = 'payIng';
                          _fontcolor = '#6ac2ff';
                        } else if (item.status_id == 4) {
                          txt_status = '卖家已发币';
                          // _cls = 'payOver';
                          _fontcolor = '#23ca27';
                        } else if (item.status_id == 5) {
                          txt_status = '付款超时';
                          txt_reason = '付款超时';
                          // _cls = 'payFail';
                          _fontcolor = '#ff8282';
                        } else if (item.status_id == 7) {
                          txt_status = '拒绝退回';
                          txt_reason = item.reason;
                          // _cls = 'payFail';
                          _fontcolor = '#ff8282';
                        }

                        if (_url != '') {
                        html += '<a class="inBox '+_cls+'" href="'+_url+'">';  
                        }else{
                          html += '<a class="inBox '+_cls+'">';
                        }
                        
                        html += '<h2><span>' +txt_point+ '挖宝币</span>';

                        if (countdown != '') {
                          html += '<span><span class="countdown">请在'+countdown+'内完成付款</span><span class="btn-go-recharge" id="btn-go-'+item.id+'">去付款</span></span>';  
                        }  else {
                          html += '<font color="'+_fontcolor+'">' + txt_status + '</font>';
                        }

                          html += '</h2>' +
                                  '<p><span>' + txt_when +'</span>' +
                                    '<font color="#686868">售价&nbsp;'+txt_amount+'元</font>' +
                                  '</p>';
                                if (txt_reason != '') {
                        html +=   '<h3>失败原因：' +txt_reason+ '</h3>';  
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
                    getInCompleteCase();
                }
            });
        }
      }

      function getCoundown(_time, id) {
        var t = _time.split(/[- :]/);
        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        var countDownDate = new Date(d).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          var now = new Date().getTime();

          // Find the distance between now and the count down date
          var distance = countDownDate - now;

          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id="demo"
          minutes = minutes <= 9 ? "0" + minutes : minutes;
          seconds = seconds <= 9 ? "0" + seconds : seconds;
          document.getElementById(id).innerHTML = minutes + ":" + seconds;

          // If the count down is finished, write some text
          if (distance < 0) {
            clearInterval(x);
            document.getElementById(id).innerHTML = "00:00";
            $("#btn-go-" + id).off('click');
            $("#btn-go-" + id).css('display','none');
            
          }
        }, 1000);
      }
      </script>

@endsection
