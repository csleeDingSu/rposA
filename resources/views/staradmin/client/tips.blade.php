@extends('layouts.default')

@section('title', '挖宝攻略')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/tips.css') }}" />
@endsection

@section('content')

<div class="full-height">

	@parent
	<script src="{{ asset('/client/js/allhistory.js') }}"></script>
	<div class="tips_container">
	
		<div class="panel-step1">
		</div>
		<a href="/share"><div class="panel-step1-btn"></div></a>
        <div class="panel-step2"></div>
        <a href="/arcade"><div class="panel-step2-btn"></div></a>
   
    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection
