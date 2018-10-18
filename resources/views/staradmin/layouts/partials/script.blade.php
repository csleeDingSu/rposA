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
    
	
    </script>
