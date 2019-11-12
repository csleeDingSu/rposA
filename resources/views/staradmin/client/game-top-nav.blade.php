@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/client/css/game-top-nav.css') }}" />

@endsection

<!-- ranking start-->
<div class="top-nav-bg">
	<div class="btn-game-normal">补贴抽奖</div>
	<div class="btn-game-vip">高级抽奖</div>
</div>
<!-- ranking end-->

@section('footer-javascript')
	@parent
	<script src="{{ asset('/client/js/game-top-nav.js') }}"></script>
	
@endsection