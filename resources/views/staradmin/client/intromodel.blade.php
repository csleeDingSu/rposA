<div id="preload"></div>
<!-- <div id="load"></div> -->
<div id="contents">
<!-- show alipay form modal -->
<div class="modal fade col-md-12" id="alipayform" tabindex="-1" role="dialog" aria-labelledby="intropopupl" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-body">				
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<p class="title">恭喜获得<em class="spanAcuPointAndBalance">0</em>元补贴</p>
							<p class="title-small">请填写收款信息</p>	
							<div class="input-form">
								<ul>
	                                <li>
	                                    <div class="flexSp">
	                                        <img src="{{ asset('client/images/alipayform/alpay.png') }}">
	                                        <input type="text" id="alipayaccount" name="alipayaccount" placeholder="@lang('dingsu.ph_alipayaccount')" required maxlength="30" autofocus>
	                                    </div>
	                                </li>
	                                <li>
	                                    <div class="flexSp">
	                                        <img src="{{ asset('client/images/alipayform/phone.png') }}">
	                                        <input type="text" id="contactno" name="contactno" placeholder="@lang('dingsu.ph_username_mobile_no')" value="{{empty(Auth::Guard('member')->user()->phone) ? '' : Auth::Guard('member')->user()->phone}}" required maxlength="30">
	                                    </div>
	                                </li>
	                            </ul>
							</div>
							<div class="modal-confirm-button" id="btn-submit-alipayform">提交</div>

						</div>
					</div>
				</div>							
			</div>
		</div>
		<div class="icon-close">
          <img class="close-modal" src="{{ asset('/clientapp/images/main/close.png') }}">
        </div>
	</div>
</div>
<!-- show not yet login modal -->
<div class="modal fade col-md-12 intropopup" name="nonloginmodal" id="nonloginmodal" tabindex="-1" role="dialog" aria-labelledby="intropopupl" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title-non-login-icon">
			<img src="{{ asset('/client/images/non-logged/non-logged-icon.png') }}" />
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="row">
							<div class="non-login-desc">你还未登录，登录后才能赢红包</div>
						</div>
						<div class="row">
							<button class="btnsubmit" id="sec_login_btn_new" type="button">登录</button>							
						</div>
						<div class="row">
							<button class="sec_reg_btn" type="button">没有帐号，去注册</button>	
							<!-- <a class="ssec_reg_btn"  href="googlechrome://navigate?url=dev.boge56.com/member/login/register" >没有帐号，去注册</a> -->
							
							<!-- <button class="button1" id="button1" onclick="window.open('http://dev.boge56.com/api/mytestview','_blank','resizable=yes')" >clcick </button> -->
													
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- show not yet login modal Ends -->

<!-- login modal -->
<form class="form-sample" name="loginform" id="loginform" action="" method="post" autocomplete="on">
<div class="modal fade col-md-12 intropopup" id="login-intropopup" tabindex="-1" role="dialog" aria-labelledby="intropopupl" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1>账号登录</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						
						
												
						<div class="row">
							<input class="namer" type="text" id="authusername" name="authusername" placeholder="@lang('dingsu.ph_username_mobile_no')" required maxlength="30"><span class="mmcl lerror-username hidespan" ></span>
							
						</div>
						<div class="row">
							<input class="namer" type="password" id="authpassword" name="authpassword" placeholder="@lang('dingsu.ph_enter_password')" required maxlength="30"><span class="mmcl lerror-password hidespan" ></span>						
						</div>
						<div class="row">
							<button class="btnsubmit" name="dologin" id="dologin" type="button">登录</button>							
						</div>
						<div class="row">
							<button class="sec_reg_btn" name="sec_reg_btn" id="sec_reg_btn" type="button">没有帐号，去注册</button>							
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
<!-- login modal Ends -->



<!-- registration modal -->
<form class="form-sample" name="registerform" id="registerform" action="" method="post" autocomplete="on">
<div class="modal fade col-md-12 intropopup" id="regis-intropopup" tabindex="-1" role="dialog" aria-labelledby="intropopupl" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1>请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						
						
												
						<div class="row">
							
							<input class="namer" name="username" id="username" type="text" placeholder="@lang('dingsu.username')" required maxlength="30" autofocus>
							<span class="mmcl error-username hidespan" ></span>
							
						</div>
						<div class="row">
							<input class="namer" name="phone" id="phone" type="text" placeholder="@lang('dingsu.ph_mobile_no')" required maxlength="30">
							<span class="mmcl error-phone hidespan" ></span>						
						</div>
						
						<div class="row">
							<input class="namer" name="password" id="password" type="password" placeholder="@lang('dingsu.ph_password')" required maxlength="30">
							<span class="mmcl error-password hidespan" ></span>						
						</div>
						<div class="row">
							<input class="namer" name="password_confirmation" id="password_confirmation" type="password" placeholder="@lang('dingsu.ph_confirm_password')" required maxlength="30">
							<span class="mmcl error-password_confirmation hidespan" ></span>					
						</div>
						
						 
						
						
						<div class="row">
							<button class="btnsubmit" name="doregi" id="doregi" type="button">登录</button>							
						</div>
						<div class="row">
							<button class="sec_login_btn" name="sec_login_btn" id="sec_login_btn" type="button">注册</button>							
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="row">
						<button class="successmsg hidespan" name="doregi" id="doregi2" type="button">登录</button>							
		</div>
	</div>
</div>
</form>

<!-- registration modal Ends -->
</div>

<script language="javascript">

	function openmodel() {
		
		$('#loginform')[0].reset();
		// $( '#login-intropopup' ).modal( 'show' );
		$( '#nonloginmodal' ).modal( 'show' );
	}
	
</script>

@section('footer-javascript')
    @parent
   		<script>
   			
   			$(document).on('ready', function() {

   				document.getElementById('preload').style.visibility="hidden";

            	var temp = "<?php Print(Session::put('re_route','yes'));?>";
            					
				 $( '.sec_reg_btn' ).click( function (e) {
					//switch to register 
					 // $( '#nonloginmodal' ).modal( 'hide' );
					 // $( '#login-intropopup' ).modal( 'hide' );
					 // $( '#regis-intropopup' ).modal( 'show' );
					 // $( '.sec_login_btn' ).html( '已有账号，去登录' );					 
					 // $( '.modal-title' ).html( '<h1>快速注册</h1>' );
					 // $( '.btnsubmit' ).html( '注册' );
				
					//link to register
					window.location.href = "<?php Print(URL::to('/member/login/register'));?>";

				 } );
				
				//switch to login form
				 $( '.sec_login_btn' ).click( function (e) {
				 	 $( '#nonloginmodal' ).modal( 'hide' );
					 $( '#regis-intropopup' ).modal( 'hide' );
					 $( '#login-intropopup' ).modal( 'show' );
					 $( '.sec_login_btn' ).html( '没有帐号，去注册' );					 
					 $( '.modal-title' ).html( '<h1>账号登录</h1>' );
					 $( '.btnsubmit' ).html( '登录' );
				 } );

				 //switch to login form
				 $( '#sec_login_btn_new' ).click( function (e) {
				 	 $( '#nonloginmodal' ).modal( 'hide' );
					 $( '#regis-intropopup' ).modal( 'hide' );
					 $( '#login-intropopup' ).modal( 'show' );
					 $( '.sec_login_btn' ).html( '没有帐号，去注册' );					 
					 $( '.modal-title' ).html( '<h1>账号登录</h1>' );
					 $( '.btnsubmit' ).html( '登录' );
				 } );


            $( '#loginform #dologin' ).click( function (e) {
				
				$( ".lerror-username" ).addClass( "hidespan" ).removeClass("showspan").html('');
				$( ".lerror-password" ).addClass( "hidespan" ).removeClass("showspan").html('');
				
				
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
                            $("#dologin").text('@lang("dingsu.member_login_success_message")');
                            url = "/arcade";
                            // url = "/cs/1";
							//url = data.url;

							setTimeout(function(){
								$(location).attr("href", url);
							}, 2000);
                        }
                    
                },
                error: function (data, ajaxOptions, thrownError) {
                    $("#dologin").text('@lang("dingsu.login")');
                    $('#dologin').removeAttr('disabled');                   
                    var merrors = $.parseJSON(data.responseText);
                    var errors = merrors.errors;
                    $.each(errors, function (key, value) {   
						console.log(key);
						$( ".lerror-"+key ).addClass( "showspan" ).removeClass("hidespan").html(value);						
						if (key == 'error')
							{
								$( ".lerror-username" ).addClass( "showspan" ).removeClass("hidespan").html(value);
							}
                    });                    
                }
              });   
            } );


           
            $( '#doregi' ).click( function (e) { 
            e.preventDefault();     

            $( ".error-username" ).addClass( "hidespan" ).removeClass("showspan").html('');
			$( ".error-phone" ).addClass( "hidespan" ).removeClass("showspan").html('');
			$( ".error-password" ).addClass( "hidespan" ).removeClass("showspan").html('');
			$( ".error-password_confirmation" ).addClass( "hidespan" ).removeClass("showspan").html('');				

            jQuery.ajax({
                type:"POST",
                url: "{{route('api.member.newregister')}}",
                data:{
                    _token: "{{ csrf_token() }}",
                    datav: $( "#registerform" ).serialize(),
					username:$('#username').val(),
					phone:$('#phone').val(),
                    password:$('#password').val(),	
					password_confirmation:$('#password_confirmation').val(),
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
                        
							$( ".successmsg" ).addClass( "showspan" ).removeClass("hidespan").html('@lang("dingsu.member_registration_success_message")');

							$("#doregi").text('@lang("dingsu.member_registration_success_message")');
                             url = "/arcade";
                             
							setTimeout(function(){
								$(location).attr("href", url);
							}, 2000);
							/*
                            setTimeout(function(){
	                            //temp
	                            jQuery.ajax({
				                type:"POST",
				                url: "{{route('submit.member.login')}}",
				                data:{
				                    _token: "{{ csrf_token() }}",
				                    username:$('#username').val(),
				                    password:$('#password').val(),
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
				                            $("#dologin").text('@lang("dingsu.member_login_success_message")');
				                            url = "/arcade";
				                            // url = "/cs/1";
											//url = data.url;
											$(location).attr("href", url);
				                        }
				                    
				                },
				                error: function (data, ajaxOptions, thrownError) {
				                    $("#dologin").text('@lang("dingsu.login")');
				                    $('#dologin').removeAttr('disabled');                   
				                    var merrors = $.parseJSON(data.responseText);
				                    var errors = merrors.errors;
				                    $.each(errors, function (key, value) {   
										console.log(key);
										$( ".lerror-"+key ).addClass( "showspan" ).removeClass("hidespan").html(value);						
										if (key == 'error')
											{
												$( ".lerror-username" ).addClass( "showspan" ).removeClass("hidespan").html(value);
											}
				                    });                    
				                }
				              }); 
	                        }, 3000);
							*/
                        }			
                   
                    $("#doregi").text('@lang("dingsu.register")');
                    // $('#doregi').removeAttr('disabled');
                },
                error: function (data, ajaxOptions, thrownError) {
                    $("#doregi").text('@lang("dingsu.register")');
                    $('#doregi').removeAttr('disabled');
					var merrors = $.parseJSON(data.responseText);
                    var errors = merrors.errors;
                     $.each(errors, function (key, value) {   
						console.log(key);
						$( ".error-"+key ).addClass( "showspan" ).removeClass("hidespan").html(value);
                    });
                }
        });
    });
});
        </script>


@endsection











