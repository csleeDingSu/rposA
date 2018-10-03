
<script src="{{ asset('staradmin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('staradmin/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('staradmin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('staradmin/js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->




<button onclick="topFunction()" id="gototopbtn" title="Go to top"><i class="icon-arrow-up "></i></button>

<script language="javascript">

	$( ".pagination" ).addClass( "rounded-flat" );
	
	
	//To top
	// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("gototopbtn").style.display = "block";
		
		$( "#gototopbtn" ).addClass( "btn btn-icons btn-inverse-secondary  btn-rounded btn-outline-secondary " );
		
    } else {
        document.getElementById("gototopbtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    //document.body.scrollTop = 0; // For Safari
    //document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	
	$('html, body').animate({scrollTop:0}, 'slow');
	
}
</script>