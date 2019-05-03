


<!-- login modal -->
<form class="form-sample" name="loginform" id="loginform" action="" method="post" autocomplete="on">
<div class="modal fade col-md-12 intropopup" id="login-intropopup" tabindex="-1" role="dialog" aria-labelledby="intropopupl" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1>请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						
						
												
						<div class="row">
							<input class="namer" type="text" id="namer authusername" name="authusername" placeholder="@lang('dingsu.ph_username_mobile_no')" required maxlength="30"><span class="mmcl lerror-username hidespan" ></span>
							
						</div>
						<div class="row">
							<input class="namer" type="password" id="authpassword" name="authpassword" placeholder="@lang('dingsu.ph_password')" required maxlength="30"><span class="mmcl lerror-password hidespan" ></span>						
						</div>
						<div class="row">
							<button class="btnsubmit" name="dologin" id="dologin" type="button">登录</button>							
						</div>
						<div class="row">
							<button class="sec_reg_btn" name="sec_reg_btn" id="sec_reg_btn" type="button">注册</button>							
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
							<input class="namer" name="confirmpassword" id="confirmpassword" type="password" placeholder="@lang('dingsu.ph_confirm_password')" required maxlength="30">
							<span class="mmcl error-confirmpassword hidespan" ></span>						
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
						<button class="successmsg hidespan" name="doregi" id="doregi" type="button">登录</button>							
		</div>
	</div>
</div>
	
	
</form>
<!-- registration modal Ends -->


<script language="javascript">
	function openmodel() {
		$('#loginform')[0].reset();
		$( '#login-intropopup' ).modal( 'show' );
	}
	
</script>










@section('footer-javascript')
    @parent
            <script>
				
				 $( '.sec_reg_btn' ).click( function (e) {
					 $( '#login-intropopup' ).modal( 'hide' );
					 $( '#regis-intropopup' ).modal( 'show' );
				 } );
				
				 $( '.sec_login_btn' ).click( function (e) {
					 $( '#regis-intropopup' ).modal( 'hide' );
					 $( '#login-intropopup' ).modal( 'show' );					 
				 } );


            $( '#dologin' ).click( function (e) {
				
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
                            url = "/cs/1";
							//url = data.url;
							$(location).attr("href", url);
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
						console.log(key);
						$( ".lerror-"+key ).addClass( "showspan" ).removeClass("hidespan").html(value);
                    });                    
                }
              });   
            } );


           
            $( '#doregi' ).click( function (e) { 
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
                            $( ".successmsg" ).addClass( "showspan" ).removeClass("hidespan").html('success redirect msg');
							
							$("#doregi").text('@lang("dingsu.member_registration_success_message")');
                            url = "/profile";
                            $(location).attr("href", url);
                        }
					
					
                   
                    $("#doregi").text('@lang("dingsu.register")');
                    $('#doregi').removeAttr('disabled');
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
        </script>


@endsection











