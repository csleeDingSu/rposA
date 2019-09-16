@extends('layouts.default_app')

@section('top-css')
    @parent
    <style type="text/css">
      .isa_info,
      .isa_success,
      .isa_warning,
      .isa_error {
          margin: 10px 0px;
          padding: 12px;
      }
      
      .isa_info {
          color: #00529B;
          background-color: #BDE5F8;
          margin: 0.1rem 0;
          padding: 0.1rem;
          border-radius: 5px;
      }
      
      .isa_success {
          color: #4F8A10;
          background-color: #DFF2BF;
          margin: 0.1rem 0;
          padding: 0.1rem;
          border-radius: 5px;
      }
      
      .isa_warning {
          color: #9F6000;
          background-color: #FEEFB3;
          margin: 0.1rem 0;
          padding: 0.1rem;
          border-radius: 5px;
      }
      
      .isa_error {
          color: #D8000C;
          background-color: #FFD2D2;
          margin: 0.1rem 0;
          padding: 0.1rem;
          border-radius: 5px;
      }
      
      .isa_info i,
      .isa_success i,
      .isa_warning i,
      .isa_error i {
          margin: 10px 22px;
          font-size: 2em;
          vertical-align: middle;
      }

      #loginvalidation-errors {
        position: absolute;
        z-index: 2;
        width: 50%;
        margin: 0.1rem;
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

@section('title', '用户登录')

@section('right-menu')
@endsection

@section('content')
<div class="" id="loginvalidation-errors"></div>
      <div class="loginBox rel">
        <img src="{{ asset('clientapp/images/loginBg.png') }}" width="100%">        
        <div class="form">
          <dl>
            <dt>手机号码</dt>
            <dd>
              <img src="{{ asset('clientapp/images/telIcon.png') }}">
              <label>
                <input type="tel" placeholder="输入注册手机号码" id="authusername">
              </label>
            </dd>
            <dt>登录密码</dt>
            <dd>
              <img src="{{ asset('clientapp/images/lockIcon.png') }}">
              <label>
                <input type="password" placeholder="输入登录密码" id="authpassword">
              </label>
            </dd>
          </dl>
          <button class="login" id="dologin">登录</button>
          <h2>没有账号，<a href="/app-register">
              <font color="#7c48e4">注册</font>
            </a></h2>

        </div>
      </div>


  <!-- <div class="card-shade"></div> -->
  <div class="loginMsg">
    <div class="inBox">
      <img src="{{ asset('clientapp/images/jiangbei.png') }}">
      <h2>登录成功</h2>
      <p>您有<font color="#f62f5b"><b>12元</b></font>奖励红包等待领取</p>
      <a class="downBtn gdt">下载APP 登录领取</a>
    </div>
  </div>
@endsection

@section('footer-javascript')
    @parent
  <script>
    $(function () {
      // $('.login').click(function () {
      //   being.showMsg('.loginMsg');
      // });
      $('.loginMsg').click(function (e) {
        let a = $(e.target).find('.inBox').length;
        console.log(a);
        if(a>0){
          being.hideMsg('.loginMsg');
        }

      });
    });
    
            $( '#dologin' ).click( function (e) {
                jQuery.ajax({
                type:"POST",
                url: "{{route('submit.member.login')}}",
                data:{
                    _token: "{{ csrf_token() }}",
                    username:$('#authusername').val(),
                    password:$('#authpassword').val(),
                },
                dataType:'json',
                beforeSend:function(){
                    $("#dologin").text('@lang("dingsu.please_wait")');
                    $('#dologin').attr('disabled', 'disabled');
                    $('#loginvalidation-errors').html('');
                },
                success:function(data) {
                    if (data.success == true) 
                        {                       
                            var sdf = '@lang("dingsu.member_login_success_message")';
                            $('#loginvalidation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                            
                            //url = "/cs/{{env('voucher_featured_id','220')}}";
							url = data.url;
                            $(location).attr("href", url);
                        }
                    else 
                        {
                            $.each(data.message, function(key,value) {
                                 $('#loginvalidation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                             });

                        }
                    $("#dologin").text('@lang("dingsu.login")');
                    $('#dologin').removeAttr('disabled');

                    $("#loginvalidation-errors").fadeTo(2000, 500).slideUp(500, function() {
                      $("#loginvalidation-errors").slideUp(500);
                    });

                },
                error: function (data, ajaxOptions, thrownError) {
                    $("#dologin").text('@lang("dingsu.login")');
                    $('#dologin').removeAttr('disabled');                   
                    var merrors = $.parseJSON(data.responseText);
                    var errors = merrors.errors;
                    $.each(errors, function (key, value) {                         
                        $('#loginvalidation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                    });  
                    $("#loginvalidation-errors").fadeTo(2000, 500).slideUp(500, function() {
                      $("#loginvalidation-errors").slideUp(500);
                    });                  
                }
              });   
            } );

        </script>
@endsection