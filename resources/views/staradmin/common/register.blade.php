<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
		<meta name="author" content="PremAdarsh">

		<link rel="shortcut icon" href="assets/images/favicon.ico">

		<meta name="csrf-token" content="{{ csrf_token() }}">
	    <title>@lang('dingsu.company_name')</title>

		<!-- <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap-grid.min.css" integrity="sha256-vl+0p/Z28RcVvC+cofUiIeYusGdOc4CXk/taqgQ2/XU=" crossorigin="anonymous" />
		
		<link rel="stylesheet" href=" {{ asset('staradmin/css/style.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css">

        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('staradmin/images/favicon/apple-touch-icon.png') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('staradmin/images/favicon/favicon-32x32.png') }}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('staradmin/images/favicon/favicon-16x16.png') }}">
		<link rel="manifest" href="{{ asset('staradmin/images/favicon/site.webmanifest') }}">
		<link rel="mask-icon" href="{{ asset('staradmin/images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#da532c">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</head>
	<body>
		
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
          <div class="row w-100">
            <div class="col-lg-4 mx-auto">
              <div class="auto-form-wrapper">
				  
				  
				  @if(!empty($refcode) and !isset($ref->id)) 
				  	<div class="alert alert-danger alert-dismissable" id="">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>

							  @lang('dingsu.unknow_referral_code')

						  </div>
				  @endif
				  
				  <div class="" id="validation-errors"></div>
				  
                <form action="#" method="post" name="registerform" id="registerform" autocomplete="off">
                   @if(!empty($refcode) and isset($ref->id)) 
					 <div class="form-group">
					 
                    
                    <div class="input-group">
                      <input name="refcode" id="refcode" type="text" class="form-control" value="{{$refcode}}" readonly >
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
					 @endif
					<div class="form-group">
					  
					 
					 
                    
                    <div class="input-group">
                      <input name="username" id="username" type="text" class="form-control" placeholder="@lang('dingsu.username')" autofocus required value="">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
					
					<div class="form-group">
                    
                    <div class="input-group">
                      <input name="email" id="email" type="email" class="form-control" placeholder="@lang('dingsu.email')" required value="">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
					
				<div class="form-group">
                    
                    <div class="input-group">
                      <input name="password" id="password" type="password" class="form-control" placeholder="@lang('dingsu.password')" required value="">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>	
                  
				<div class="form-group">
                    
                    <div class="input-group">
                      <input name="confirmpassword" id="confirmpassword" type="password" class="form-control" placeholder="@lang('dingsu.confirm_password')" value="">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
					
					
                  <div class="form-group">
                    <button id="registerbutton" type="submit" class="btn btn-primary submit-btn btn-block">@lang('dingsu.register')</button>
                  </div>
                  
                  
                </form>
              </div>
              <ul class="auth-footer">
                <li>
                  <a href="#">Conditions</a>
                </li>
                <li>
                  <a href="#">Help</a>
                </li>
                <li>
                  <a href="#">Terms</a>
                </li>
              </ul>
              <p class="footer-text text-center">@lang('dingsu.copyright') © 2018
              <a href="#" target="_blank">@lang('dingsu.company_name')</a>. @lang('dingsu.all_rights_reserved').</p>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

	</body>
	
	
	<script type="text/javascript">
	 $('#registerform').on('submit', function(e){
        e.preventDefault();		
		jQuery.ajax({
			type:"POST",
			url: "{{route('submit.member.register')}}",
			data:{
				_token: "{{ csrf_token() }}",
				datav: $("#registerform").serializeArray(),
			},
			dataType:'json',
			beforeSend:function(){
				$("#registerbutton").text('@lang("dingsu.please_wait")');
     			$('#registerbutton').attr('disabled', 'disabled');
				$('#validation-errors').html('');
			},
			success:function(data){
				//alert(data.success);
				if (data.success == true) 
					{						
						var sdf = '@lang("dingsu.member_registration_success_message")';
						$('#validation-errors').append('<div class="alert alert-success">'+sdf+'</div');
					}
				else 
					{
						$.each(data.message, function(key,value) {
							 $('#validation-errors').append('<div class="alert alert-danger">'+value+'</div');
						 });
						
					}
				$("#registerbutton").text('@lang("dingsu.register")');
     			$('#registerbutton').removeAttr('disabled');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$("#registerbutton").text('@lang("dingsu.register")');
     			$('#registerbutton').removeAttr('disabled');
				//alert(thrownError);				
			}
		});
	});
	</script>
</html>