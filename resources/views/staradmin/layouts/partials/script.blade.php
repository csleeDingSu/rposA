@section('script')
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
@show

<script type="text/javascript">
        $('ul.pagination').hide();
	
	 
        $('.infinite-scroll').jscroll({
            autoTrigger: true,
            debug: true,
            loadingHtml: '<img class="center-block" src=" {{ asset('/client/images/ajax-loader.gif') }} " alt="Loading..." />',
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: '.infinite-scroll',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    
    /* Scroll Category to top */
    // When the user scrolls the page, execute sticky_nav 
    window.onscroll = function() {sticky_nav()};

    // Get the header
    var header = document.getElementById("category-nav");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function sticky_nav() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }
	/* End Scroll Category to top */

    </script>
