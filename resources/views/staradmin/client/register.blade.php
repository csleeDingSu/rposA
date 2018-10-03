@extends('layouts.app')

@section('title', '注册')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/register.css') }}" />
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
			<div class="inputWithIcon">
				<input name="refcode" id="refcode" type="text"  value="{{$refcode}}" readonly >
                     
			</div>
			 @endif
			<div class="inputWithIcon">
				<input type="text" placeholder="@lang('dingsu.username')"  name="username" id="username" autofocus required value=""/>
			</div>
			
			<div class="inputWithIcon">
				<input name="email" id="email" type="text"  placeholder="@lang('dingsu.email')" required value="">
			</div>
			
			
			<div class="inputWithIcon">
				 <input name="password" id="password" type="password"  placeholder="@lang('dingsu.password')" required value="">
			</div>
			<div class="inputWithIcon">
				<input name="confirmpassword" id="confirmpassword" type="password" placeholder="@lang('dingsu.confirm_password')" value="">
			</div>
			
			
			
			<!--div class="inputWithIcon">
				<input type="text" placeholder="您的真实姓名" />
				<i class="far fa-comment-alt" aria-hidden="true" /></i>
			</div-->
			
		</div>
	</div>
	
    <!--div class="row">
		<div class="card">
			<div class="text left">为了防止用户注册多个账户多次领取福利，您必须填写真实姓名，才能通过审核。</div>
		</div>
	</div-->

	<div class="row">
        <div class="card">
			
			<button id="registerbutton" type="submit" class="btn btn-rectangle">@lang('dingsu.register')</button>
        </div>
	</div>
	</form>
	<div class="row">
		<div class="card">
			<div class="text left">
				注册代表你同意用户协议和隐私条款
			</div>
		</div>
	</div>
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
	</script>@endsection