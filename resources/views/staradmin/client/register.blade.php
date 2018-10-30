@extends('layouts.app')

@section('title', '注册')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/register.css') }}" />
	
@endsection

@section('content')

<div class="wrapper full-height">
	<form action="" method="post" name="registerform" id="registerform" autocomplete="off">

	<div class="row">


		
		<div class="card">

			 @if(!empty($refcode) and !isset($ref->id)) 
                <div class="alert alert-danger alert-dismissable" id="">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
								×
							</button>

							  @lang('dingsu.unknow_referral_code')

						  </div>
			@endif
				  
				  <div class="" id="validation-errors"></div>
			
			@if(!empty($refcode) and isset($ref->id)) 
				<div class="input-group">				
					<span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
					<input name="refcode" id="refcode" type="text"  value="{{$refcode}}" readonly >
				</div>
			 @endif

			 <div class="input-group">
			 	<span class="input-group-addon"><i class="fa fa-user"></i></span>
				<input type="text" placeholder="@lang('dingsu.username')"  name="username" id="username" autofocus value="" />
			</div>
			
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				<input name="phone" id="phone" type="text"  placeholder="@lang('dingsu.ph_mobile_no')" value="" >
			</div>
									
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				 <input name="password" id="password" type="password"  placeholder="@lang('dingsu.ph_password')" value="" >
			</div>
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				<input name="confirmpassword" id="confirmpassword" type="password" placeholder="@lang('dingsu.ph_confirm_password')" value="" >
			</div>

			<div class="input-group">
		        <div class="card">
					
					<button id="registerbutton" type="submit" class="btn btn-rectangle">@lang('dingsu.register')</button>
		        
					<div class="text left">
						注册代表你同意用户协议和隐私条款
					</div>
				</div>
			</div>

		</div>
	</div>

	
	</form>
</div>


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
						
						url = "/profile";
      					$(location).attr("href", url);
						
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
	@endsection

@section('top-javascript')
    @parent
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection