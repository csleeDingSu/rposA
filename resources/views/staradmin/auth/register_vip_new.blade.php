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

      #validation-errors {
          position: absolute;
          z-index: 4;
          width: 50%;
          margin: 0.1rem;
        }

        .loginMsg{
          background-color: rgba(0, 0, 0, 0.5);
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

  @section('title', '用户注册')

  @section('right-menu')
  @endsection
@else
  @section('title', '用户注册')

  @section('top-navbar')    
  @endsection

@endif

@section('content')

@if(!empty($refcode) and !isset($ref->id))
<div class="isa_error">@lang('dingsu.unknow_referral_code')</div>
@endif

<div class="" id="validation-errors"></div>
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
            <dt>注册密码</dt>
            <dd>
              <img src="{{ asset('clientapp/images/lockIcon.png') }}">
              <label>
                <input type="password" placeholder="输入注册密码" id="password" name="password">
                <input name="confirmpassword" id="confirmpassword" name="confirmpassword" type="hidden">
              </label>
            </dd>
            @if((!empty($refcode) and isset($ref->id)) || !empty(Session::get('refcode')))
              <div style="text-align: center; margin-top: -0.2rem;">
                <span style="color: lightgrey;">注册码 : </span>
                <input name="refcode" id="refcode" type="text" value="{{ Session::get('refcode')}}" readonly  style="color: lightgrey; width: 32%; border: 0;">
              </div>
            @endif
          </dl>
          <button class="login" id="doregi">下一步</button>
          <h2>已有账号，<a href="/app-login">
              <font color="#7c48e4">登录</font>
            </a></h2>
        </div>

        </form>
      </div>

 @endsection

@section('footer-javascript')
<!-- <div class="card-shade"></div> -->
  <div class="loginMsg">
    <div class="inBox">
      <img src="{{ asset('clientapp/images/jiangbei.png') }}">
      <h2>恭喜你&nbsp;注册成功</h2>
      <p>您有<font color="#f62f5b"><b>12元</b></font>奖励红包等待领取</p>
      <a class="downBtn gdt" href="/download-app">下载APP 登录领取</a>
    </div>
  </div>

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
                            var refcode = "{{ Session::get('refcode')}}";     
                            var sdf = '@lang("dingsu.member_registration_success_message")';
                            $('#validation-errors').append('<div class="alert alert-success isa_success">'+sdf+'</div');
                            
                            url = data.url;

                            console.log(refcode);
                            if (refcode != '') {
                              being.showMsg('.loginMsg');
                            } else {
                              $(location).attr("href", url);  
                            } 
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
@endsection