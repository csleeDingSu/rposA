@extends('layouts.login')

@section('title', '账号登录')

@section('left-menu')
    <a href="javascript:history.back()" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection

@section('top-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/public.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/module.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}"/>

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
        }
        
        .isa_success {
            color: #4F8A10;
            background-color: #DFF2BF;
        }
        
        .isa_warning {
            color: #9F6000;
            background-color: #FEEFB3;
        }
        
        .isa_error {
            color: #D8000C;
            background-color: #FFD2D2;
        }
        
        .isa_info i,
        .isa_success i,
        .isa_warning i,
        .isa_error i {
            margin: 10px 22px;
            font-size: 2em;
            vertical-align: middle;
        }

        .flexSp img {
            height: 0.5rem;
        }

        .navbar-brand {
            font-size: 20px !important;
            width: 100% !important;
        }

        .left-menu {
            text-align: left !important;
        }

        .button_reg {
          display: block;
          width: 100%;
          background-color: white;
          text-align: center;
          font-size: 0.32rem;
          color: #ff5949;
          border: 0.03rem solid #ff5949;
          line-height: 0.84rem;
          outline: none;
          border-radius: 0.42rem;
          -webkit-border-radius: 0.42rem;
          -moz-border-radius: 0.42rem;
          -ms-border-radius: 0.42rem;
          -o-border-radius: 0.42rem;
        }

        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/client/images/preloader.gif') center no-repeat;
            background-color: rgba(255, 255, 255, 1);
            background-size: 32px 32px;
        }


    </style>


@endsection

@section('footer-javascript')
<script type="text/javascript">
    //这里是微信和qq遮罩提示层
    function isPIA(){
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
        if(isiOS) {return 1;}
        if(isAndroid) {return 2};
    }
    var bg;
    if (isPIA() == 1) {
        bg = window.location.origin + "/vwechat/images/ios_wx.jpg";
    }else if (isPIA() == 2) {
        bg = window.location.origin + "/vwechat/images/android_wx.jpg";
    }
    document.writeln("<div id=\"weixinTips\" style=\"display:none;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");
    var ua = navigator.userAgent.toLowerCase();
    //alert(ua);
    function checkDownload() {
        var bdisable = true;

        if ((ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) && bdisable == false) {
            document.getElementById("weixinTips").style.display = "block";
            document.title="请在浏览器中打开...";
            // return false;
        }else{

            // var sCurrentPathName = window.location.pathname;
            // var sNewPathName = sCurrentPathName.replace("vregister", "register");
            // window.location.href = "https://www.wabao666.com" + sNewPathName;
        
        }



    }
    checkDownload();
</script>
@parent

@endsection

@section('content')
@parent
<div class="loading" id="loading"></div>
    <div class="loginBox">
                <div class="hd flex">                    
                    <a class="{{ empty($slug) ? 'on' : '' }}">账号登录</a>
                    <a class="{{ !empty($slug)? 'on' : '' }}" id="reg">快速注册</a>
                </div>
                <div class="bd">
                    <div class="inBox {{ empty($slug) ? 'on' : '' }}">
                        <form class="authform" name="authform" id="authform" action="" method="post" autocomplete="on">
                            <ul>
                                <li>
                                    <div class="flgexSp">
                                        <div class="" id="loginvalidation-errors"></div>
                                    </div>
                                </li>
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/telIcon.png') }}">
                                        <input type="text" id="authusername" name="authusername" placeholder="@lang('dingsu.ph_username_mobile_no')" required maxlength="30">
                                    </div>
                                </li>
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/lockIcon.png') }}">
                                        <input type="password" id="authpassword" name="authpassword" placeholder="@lang('dingsu.ph_password')" required maxlength="30">
                                    </div>
                                </li>
                                <li>
                                    <button class="dologin" name="dologin" id="dologin" type="button">登录</button>
                                </li>
                                <li>
                                    <a class="button_reg" name="button_reg" id="button_reg" type="button">还没有注册？ 去注册</a>
                                </li>
                                <li>
                                    <p>忘记密码?<a href="javascript:void(0)" id="customerservice" class="customerservice">请联系客服</a>
                                    </p>
                                </li>
                            </ul>
                        </form>
                    </div>

                    <div class="inBox {{ !empty($slug) ? 'on' : '' }}">
                        <form class="registerform" name="registerform" id="registerform" action="" method="post" autocomplete="off">
                            <ul>
                                @if(!empty($refcode) and !isset($ref->id))
                                <li>
                                    <div class="flgexSp">
                                        <div class="isa_error">@lang('dingsu.unknow_referral_code')</div>
                                    </div>
                                </li>
                                @endif
                                <li>
                                    <div class="flgexSp">
                                        <div class="" id="validation-errors"></div>
                                    </div>
                                </li>
                                
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/telIcon.png') }}">
                                        <input name="phone" id="phone" type="text" placeholder="@lang('dingsu.ph_mobile_no')" required maxlength="30" >
                                    </div>
                                </li>
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/lockIcon.png') }}">
                                        <input name="password" id="password" type="password" placeholder="@lang('dingsu.ph_password')" required maxlength="30">
                                    </div>
                                </li>
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/lockIcon.png') }}">
                                        <input name="confirmpassword" id="confirmpassword" type="password" placeholder="@lang('dingsu.ph_confirm_password')" required maxlength="30">
                                    </div>
                                </li>
                                <li>
                                    <button class="doregi" name="doregi" id="doregi" type="button">注册</button>
                                </li>
                                @if((!empty($refcode) and isset($ref->id)) || !empty(Session::get('refcode')))
                                <li>
                                    <div style="text-align: center">
                                        <!-- <img src="{{ asset('auth/images/telIcon.png') }}"> -->

                                        <span style="color: lightgrey;">注册码 : </span>
                                        <input name="refcode" id="refcode" type="text" value="{{ Session::get('refcode')}}" readonly  style="color: lightgrey; width: 32%; border: 0;">


                                    </div>
                                </li>
                                @endif
                                
                            </ul>
                        </form>
                    </div>

                    
                </div>
            </div>

@endsection


@include('auth.customer_service_model')


@section('footer-javascript')
    @parent
            <script>

                document.onreadystatechange = function () {
                  var state = document.readyState
                  if (state == 'interactive') {
                  } else if (state == 'complete') {
                    setTimeout(function(){
                        document.getElementById('interactive');
                        document.getElementById('loading').style.visibility="hidden";
                    },100);
                  }
                }

                if ($("#refcode").val()) {
                    $( '.loginBox .bd' ).children( '.inBox' ).eq( 1 ).fadeIn( 0 ).siblings().fadeOut( 0 ); 
                    $( '.loginBox .hd a').removeClass('on');
                    $('#reg').addClass( 'on' );
                }

                
            $( function () {
                $( '.loginBox .hd a' ).click( function () {
                    var that = $( this );
                    let i = that.index();
                    console.log( i );
                    that.addClass( 'on' ).siblings().removeClass( 'on' );
                    $( '.loginBox .bd' ).children( '.inBox' ).eq( i ).fadeIn( 0 ).siblings().fadeOut( 0 );
                    
                    if (i == 1)
                    {
                        $( "#username" ).focus();
                    }
                    else
                    {
                        $( "#authusername" ).focus();                        
                    }
                } );

                $( '.button_reg' ).click( function () {
                    $( '.loginBox .bd' ).children( '.inBox' ).eq( 1 ).fadeIn( 0 ).siblings().fadeOut( 0 ); 
                    $( '.loginBox .hd a').removeClass('on');
                    $('#reg').addClass( 'on' );
                } )
            } )



            $( '.authform .dologin' ).click( function (e) {
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
                },
                error: function (data, ajaxOptions, thrownError) {
                    $("#dologin").text('@lang("dingsu.login")');
                    $('#dologin').removeAttr('disabled');                   
                    var merrors = $.parseJSON(data.responseText);
                    var errors = merrors.errors;
                    $.each(errors, function (key, value) {                         
                        $('#loginvalidation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                    });                    
                }
              });   
            } );


           
            $( '.registerform .doregi' ).click( function (e) {
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
                        }
                    else 
                        {
                            $.each(data.message, function(key,value) {
                                 $('#validation-errors').append('<div class="alert alert-danger isa_error">'+value+'</div');
                             });

                        }
                    $("#doregi").text('@lang("dingsu.register")');
                    $('#doregi').removeAttr('disabled');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $("#doregi").text('@lang("dingsu.register")');
                    $('#doregi').removeAttr('disabled');
                    $('#validation-errors').append('<div class="alert isa_error">'+thrownError+'</div');
                }
        });
    });
        </script>


@endsection
