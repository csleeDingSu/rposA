<style>
.hvr-underline-from-center{
    color: white !important;
}

.greedy-nav {
  position: relative;
  min-width: 250px;
  background: #394165;
}
.greedy-nav a {
  display: block;
  padding: 5px 20px;
  background: #394165;
  font-size: 14px;
  color: white;
  text-decoration: none;
}
.greedy-nav a:hover {
  /*color: #ef6c00;*/
}
.greedy-nav button {
  position: absolute;
  height: 100%;
  right: 0;
  padding: 0 15px;
  border: 0;
  outline: none;
  background-color: #394165;
  color: #fff;
  cursor: pointer;
}
.greedy-nav button:hover {
  background-color: black;
}
.greedy-nav button::after {
  content: attr(count);
  position: absolute;
  width: 25px;
  height: 25px;
  left: 30px;
  top: 8px;
  text-align: center;
  background-color: #394165;
  color: #fff;
  font-size: 12px;
  line-height: 20px;
  border-radius: 50%;
  border: 2px solid #fff;
  font-weight: bold;
}
.greedy-nav button:hover::after {
  transform: scale(1.075);
}

.greedy-nav .hamburger {
  position: relative;
  width: 32px;
  height: 4px;
  background: #fff;
  margin: auto;
}
.greedy-nav .hamburger:before,
.greedy-nav .hamburger:after {
  content: '';
  position: absolute;
  left: 0;
  width: 32px;
  height: 4px;
  background: #fff;
}
.greedy-nav .hamburger:before {
  top: -8px;
}
.greedy-nav .hamburger:after {
  bottom: -8px;
}
.greedy-nav .visible-links {
  display: inline-table;
  margin: 0;
  padding: 0;
}
.greedy-nav .visible-links li {
  display: table-cell;
  /*border-left: 1px solid #ff9800;*/
  margin: none !important;
}
.greedy-nav .hidden-links {
  position: absolute;
  right: 0px;
  top: ??px;
  left: ??px;
  z-index: 1;
}
.greedy-nav .hidden-links li {
  display: block;
  border-top: 1px solid white;
}
/*.greedy-nav .visible-links li:first-child {
  font-weight: bold;
}
.greedy-nav .visible-links li:first-child a {
  color: #ff9800 !important;
}*/
.greedy-nav .hidden {
  visibility: hidden;
}
</style>

<header class="container navbar navbar-default">
	@if(isset($category))
	<nav class='greedy-nav'>
	<button><div class="hamburger"></div></button>
	  <ul class='visible-links'>
	  	@foreach($category as $cat)
			
			<li><a class="text-center hvr-underline-from-center" href="/cs/{{$cat->id}}">{{$cat->display_name}}</a></li>
		
		
		@endforeach
	    
	  </ul>
	  <ul class='hidden-links hidden'></ul>
	</nav>
	@endif
</header>
@section('script')
    @parent
	<script type="text/javascript">
	
	var $nav = $('.greedy-nav');
var $btn = $('.greedy-nav button');
var $vlinks = $('.greedy-nav .visible-links');
var $hlinks = $('.greedy-nav .hidden-links');

var breaks = [];

function updateNav() {
  
  var availableSpace = $btn.hasClass('hidden') ? $nav.width() : $nav.width() - $btn.width() - 30;

  // The visible list is overflowing the nav
  if($vlinks.width() > availableSpace) {

    // Record the width of the list
    breaks.push($vlinks.width());

    // Move item to the hidden list
    $vlinks.children().last().prependTo($hlinks);

    // Show the dropdown btn
    if($btn.hasClass('hidden')) {
      $btn.removeClass('hidden');
    }

  // The visible list is not overflowing
  } else {

    // There is space for another item in the nav
    if(availableSpace > breaks[breaks.length-1]) {

      // Move the item to the visible list
      $hlinks.children().first().appendTo($vlinks);
      breaks.pop();
    }

    // Hide the dropdown btn if hidden list is empty
    if(breaks.length < 1) {
      $btn.addClass('hidden');
      $hlinks.addClass('hidden');
    }
  }

  // Keep counter updated
  $btn.attr("count", breaks.length);

  // Recur if the visible list is still overflowing the nav
  if($vlinks.width() > availableSpace) {
    updateNav();
  }

}

// Window listeners

$(window).resize(function() {
    updateNav();
});

$btn.on('click', function() {
  $hlinks.toggleClass('hidden');
});

updateNav();
</script>

@endsection

