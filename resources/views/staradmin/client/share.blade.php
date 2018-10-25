@extends('layouts.default')

@section('title', '分享给朋友')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/share.css') }}" />

@endsection

@section('content')
<div class="wrapper full-height" style="padding-top: 0px !important; background-color: #450B72">
	<div class="container center">
		<!-- <div class="col-xs-4 col-md-3"> -->
			<img src="/client/images/8_invitation.jpg" class="share"/>		
		<!-- </div> -->
	</div>
</div>
@endsection