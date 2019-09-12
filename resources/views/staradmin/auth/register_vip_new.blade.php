<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta name="format-detection" content="telephone=no" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <title>注册</title>
  <link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/public.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/swiper.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/style.css') }}" />
  <script type="text/javascript" src="{{ asset('clientapp/js/swiper.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('clientapp/js/jquery-1.9.1.js') }}"></script>
  <script type="text/javascript" src="{{ asset('clientapp/js/being.js') }}"></script>

  <style type="text/css">
    <style>
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

        #validation-errors {
          position: absolute;
          z-index: 4;
          width: 50%;
          margin: 0.1rem;
        }

    </style>
  </style>

</head>

<body>
<div class="" id="validation-errors"></div>
  <section class="card">
    <div class="card-body over">
      <div class="loginBox rel">
        <img src="{{ asset('clientapp/images/loginBg.png') }}" width="100%">
        <form class="registerform" name="registerform" id="registerform" action="" method="post" autocomplete="off">
        <div class="form">
          <dl>
            <dt>手机号码</dt>
            <dd>
              <img src="{{ asset('clientapp/images/telIcon.png') }}">
              <label>
                <input type="tel" placeholder="输入注册手机号码" id="phone" name="phone">
              </label>
            </dd>
            <dt>密码</dt>
            <dd>
              <img src="{{ asset('clientapp/images/lockIcon.png') }}">
              <label>
                <input type="password" placeholder="输入登录密码" id="password" name="password">
                <input name="confirmpassword" id="confirmpassword" name="confirmpassword" type="hidden">
              </label>
            </dd>
          </dl>
          <button class="login" id="doregi">下一步</button>
          <h2>已有账号，<a href="/app-login">
              <font color="#7c48e4">登录</font>
            </a></h2>
        </div>
        </form>
      </div>
    </div>

  </section>


  <!-- <div class="card-shade"></div> -->
  <div class="loginMsg">
    <div class="inBox">
      <img src="{{ asset('clientapp/images/jiangbei.png') }}">
      <h2>恭喜你&nbsp;注册成功</h2>
      <p>您有<font color="#f62f5b"><b>12元</b></font>奖励红包等待领取</p>
      <a class="downBtn gdt" href="/download-app">下载APP 登录领取</a>
    </div>
  </div>

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
                    $('#validation-errors').html('');
                },
                success:function(data) {
                    if (data.success == true) 
                        {                       
                            var sdf = '@lang("dingsu.member_registration_success_message")';
                            $('#validation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                            
                            url = data.url;
                            $(location).attr("href", url);
                            // being.showMsg('.loginMsg');
                        }
                    else 
                        {
                            $.each(data.message, function(key,value) {
                                 $('#validation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                             });

                        }
                    $("#doregi").text('下一步');
                    $('#doregi').removeAttr('disabled');
                    $("#validation-errors").fadeTo(2000, 500).slideUp(500, function() {
                      $("#validation-errors").slideUp(500);
                    });  
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#doregi").text('下一步');
                    $('#doregi').removeAttr('disabled');
                    $('#validation-errors').append('<div class="alert isa_error">'+thrownError+'</div');
                    $("#validation-errors").fadeTo(2000, 500).slideUp(500, function() {
                      $("#validation-errors").slideUp(500);
                    }); 
                }
        });
    });
        </script>

</body>

</html>