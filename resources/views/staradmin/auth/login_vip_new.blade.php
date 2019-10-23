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

      .loginMsg{
          background-color: rgba(0, 0, 0, 0.5);
        }

        .loginBox2 .form {
          min-height: 100%;
        }
    </style>
@endsection

@section('top-javascript')
    @parent
    
@endsection

@if($RunInApp)
  <!-- top nav -->
  @section('left-menu')
    <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
  @endsection

  @section('title', '用户登录')

  @section('right-menu')
  @endsection
@else
  @section('title', '用户登录')

  @section('top-navbar')    
  @endsection

@endif

@section('content')
<div class="" id="loginvalidation-errors"></div>
      <div class="loginBox2 rel fix">

        <img class="imgBanner" src="{{ asset('clientapp/images/loginBanner.png') }}">
        <div class="form">

          <div class="hd">
            <a class="on">用户登录</a>
            <a>用户注册</a>
          </div>

          <div class="bd">
            <div class="inBox loginIn">
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
              <h2>没有账号，<a class="goRegistBtn">
                  <font color="#7c48e4">注册</font>
                </a></h2>
            </div>
            <div class="inBox registIn dn">
              <form class="registerform" name="registerform" id="registerform" action="" method="post" autocomplete="off">
              <dl>
                <dt>手机号码</dt>
                <dd>
                  <img src="{{ asset('clientapp/images/telIcon.png') }}">
                  <label>
                    <input type="tel" placeholder="输入注册手机号码" id="phone" name="phone">
                  </label>
                </dd>
                <dt>注册密码</dt>
                <dd>
                  <img src="{{ asset('clientapp/images/lockIcon.png') }}">
                  <label>
                    <input type="password" placeholder="输入注册密码" id="password" name="password">
                    <input name="confirmpassword" id="confirmpassword" name="confirmpassword" type="hidden">
                  </label>
                </dd>
                @if((!empty($refcode) and isset($ref->id)) || !empty(Session::get('refcode')))
                  <div style="text-align: center; margin-top: 0;">
                    <span style="color: lightgrey;">注册码 : </span>
                    <input name="refcode" id="refcode" type="text" value="{{ Session::get('refcode')}}" readonly  style="color: lightgrey; width: 32%; border: 0;">
                  </div>
                @endif
              </dl>
              <button class="registBtn" id="doregi">下一步</button>
              <h2>已有账号，<a class="goLoginBtn">
                  <font color="#7c48e4">登录</font>
                </a></h2>
              </form>
            </div>
          </div>


        </div>
      </div>


  <!-- <div class="card-shade"></div> -->
  <div class="loginMsg loginShade">
    <div class="inBox">
      <img src="{{ asset('clientapp/images/jiangbei.png') }}">
      <h2>登录成功</h2>
      <p>您有<font color="#f62f5b"><b>12元</b></font>奖励红包等待领取</p>
      <a class="downBtn gdt" href="{{env('DOWNLOAD_APP_URL','https://cixiapp.com/app.php/491')}}">下载APP 登录领取</a>
    </div>
  </div>

  <div class="loginMsg registShade">
      <div class="inBox">
        <img src="{{ asset('clientapp/images/jiangbei.png') }}">
        <h2>恭喜你&nbsp;注册成功</h2>
        <p>您有<font color="#f62f5b"><b>12元</b></font>奖励红包等待领取</p>
        <a class="downBtn gdt" href="{{env('DOWNLOAD_APP_URL','https://cixiapp.com/app.php/491')}}">下载APP 登录领取</a>
      </div>
    </div>

@endsection

@section('footer-javascript')
    @parent
  <script>
    $(function () {
      
      //   $('.login').click(function () {
      //   being.showMsg('.loginShade');
      // });
      // $('.registBtn').click(function () {
      //   being.showMsg('.registShade');
      // });

      $('.loginMsg').click(function (e) {
        console.log($(e.target).html());
        let a = $(e.target).find('.inBox').length;
        console.log(a);
        if (a > 0) {
          being.hideMsg('.loginMsg');
        }
      });

      $('.loginBox2 .form .hd a').click(function () {
        let i=$(this).index();
        $(this).addClass('on').siblings().removeClass('on');
        console.log(i);
        $('.loginBox2 .bd .inBox').eq(i).fadeIn(0).siblings().hide(0);
      });

      $('.goRegistBtn').click(function(){
        let i=1;
        $('.loginBox2 .form .hd a').eq(i).addClass('on').siblings().removeClass('on');
        $('.loginBox2 .bd .inBox').eq(i).fadeIn(0).siblings().hide(0);
      });

      $('.goLoginBtn').click(function(){
        let i=0;
        $('.loginBox2 .form .hd a').eq(i).addClass('on').siblings().removeClass('on');
        $('.loginBox2 .bd .inBox').eq(i).fadeIn(0).siblings().hide(0);
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
                            var _runinapp = "{{ $RunInApp }}";                          
                            var sdf = '@lang("dingsu.member_login_success_message")';
                            $('#loginvalidation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                            
                            //url = "/cs/{{env('voucher_featured_id','220')}}";
							             url = data.url;
                           if (_runinapp) {
                            $(location).attr("href", url);
                           }else {
                            // being.showMsg('.loginMsg');
                            being.showMsg('.loginShade');
                           }
                            
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

            $( '#doregi' ).click( function (e) {
                $('#confirmpassword').val($('#password').val());
                e.preventDefault();     
                jQuery.ajax({
                    type:"POST",
                    url: "{{route('submit.member.newregister')}}",
                    data:{
                        _token: "{{ csrf_token() }}",
                        datav: $( "#registerform" ).serialize(),
                    },
                    dataType:'json',
                    beforeSend:function(){
                        $("#doregi").text('@lang("dingsu.please_wait")');
                        $('#doregi').attr('disabled', 'disabled');
                        // $('#validation-errors').html('');
                        $('#loginvalidation-errors').html('');
                    },
                    success:function(data) {
                        if (data.success == true) 
                            { 
                                var _runinapp = "{{ $RunInApp }}";   
                                var refcode = "{{ Session::get('refcode')}}";     
                                var sdf = '@lang("dingsu.member_registration_success_message")';
                                // $('#validation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                                $('#loginvalidation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                                
                                url = data.url;

                                console.log(refcode);
                                if (refcode != '' || _runinapp == false) {
                                  // being.showMsg('.loginMsg');
                                  being.showMsg('.registShade');
                                } else {
                                  $(location).attr("href", url);  
                                } 
                            }
                        else 
                            {
                                $.each(data.message, function(key,value) {
                                     // $('#validation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                                     $('#loginvalidation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                                 });

                            }
                        $("#doregi").text('下一步');
                        $('#doregi').removeAttr('disabled');
                        // $("#validation-errors").fadeTo(2000, 500).slideUp(500, function() {
                        //   $("#validation-errors").slideUp(500);
                        // });

                        $("#loginvalidation-errors").fadeTo(2000, 500).slideUp(500, function() {
                          $("#loginvalidation-errors").slideUp(500);
                        });  
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $("#doregi").text('下一步');
                        $('#doregi').removeAttr('disabled');
                        // $('#validation-errors').append('<div class="alert isa_error">'+thrownError+'</div');
                        // $("#validation-errors").fadeTo(2000, 500).slideUp(500, function() {
                          // $("#validation-errors").slideUp(500);
                        // }); 

                        $('#loginvalidation-errors').append('<div class="alert isa_error">'+thrownError+'</div');
                         $("#loginvalidation-errors").fadeTo(2000, 500).slideUp(500, function() {
                          $("#loginvalidation-errors").slideUp(500);
                        }); 
                    }
            });
        });

        </script>
@endsection