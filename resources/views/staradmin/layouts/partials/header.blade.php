<style type="text/css">
	
	.div-icon > a:hover {
	  color: white;
	}
</style>

 @if (Config::get('app.APP_DEBUG') == '' ) 
<script type="text/javascript">

  window.onload = function() {
    document.addEventListener("contextmenu", function(e){
      e.preventDefault();
    }, false);
    document.addEventListener("keydown", function(e) {
    //document.onkeydown = function(e) {
      // "I" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
        disabledEvent(e);
      }
      // "J" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        disabledEvent(e);
      }
      // "S" key + macOS
      if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        disabledEvent(e);
      }
      // "U" key
      if (e.ctrlKey && e.keyCode == 85) {
        disabledEvent(e);
      }
      // "F12" key
      if (event.keyCode == 123) {
        disabledEvent(e);
      }
    }, false);
    function disabledEvent(e){
      if (e.stopPropagation){
        e.stopPropagation();
      } else if (window.event){
        window.event.cancelBubble = true;
      }
      e.preventDefault();
      return false;
    }
  };	
</script>

@endif
<header class="container navbar navbar-default text-center">
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="col left div-icon">
		@if (isset(Auth::Guard('member')->user()->username))
		<a href="/member"><i class="fas fa-user"></i> {{ Auth::Guard('member')->user()->username }}</a>
		@else
	  	<a href="/register"><i class="fas fa-user-plus"></i> 注册</a>
	  	@endif
	</div>
	
	  <a href="/home">
		<img src="/client/images/wabao_logo.png" alt="{{env('APP_NAME')}}" class = "landscape"/>
	  </a>
	
	<div class="col right div-icon">
		 <a href="#"><i class="fas fa-rss"></i> 关注</a>		  
	</div>

</header>