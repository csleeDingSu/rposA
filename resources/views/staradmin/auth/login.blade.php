@extends('layouts.default')

@section('title', '登录 / 注册')

@section('top-css')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/public.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/module.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}"/>

    <link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />

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
            display:none !important;
        }

    </style>


@endsection

@section('content')
    <div class="loginBox">
                <div class="hd flex">                    
                    <a class="on">账号登录</a>
                    <a id="reg">快速注册</a>
                </div>
                <div class="bd">
                    <div class="inBox on">
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
                                    <p>忘记密码?<a href="javascript:void(0)">请联系客服</a>
                                    </p>
                                </li>
                            </ul>
                        </form>
                    </div>

                    <div class="inBox">
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
                                @if(!empty($refcode) and isset($ref->id))
                                <li>
                                    <div class="flexSp">
                                        <!-- <img src="{{ asset('auth/images/telIcon.png') }}"> -->

                                        <span><i class="fa fa-hashtag fa-2x" style="color: lightgrey;height: 0.5rem;"></i></span>
                                        <input name="refcode" id="refcode" type="text" value="{{$refcode}}" readonly  style="color: lightgrey;">
                                    </div>
                                </li>
                                @endif
                                <li>
                                    <div class="flexSp">
                                        <!-- <img src="{{ asset('auth/images/telIcon.png') }}"> -->
                                        <span><i class="fa fa-user fa-2x" style="color: lightgrey; height: 0.5rem;"></i></span>
                                        <input name="username" id="username" type="text" placeholder="@lang('dingsu.username')" required maxlength="30" autofocus>
                                    </div>
                                </li>
                                <li>
                                    <div class="flexSp">
                                        <img src="{{ asset('auth/images/telIcon.png') }}">
                                        <input name="phone" id="phone" type="text" placeholder="@lang('dingsu.ph_mobile_no')" required maxlength="30" autofocus>
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
                            
                            url = "/cs/1";
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
                            
                            url = "/profile";
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
