
@include('partials.head')
<body class="sidebar-fixed">
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    @include('partials.nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      
      @include('partials.sidebar')
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
			
			<!-- Main Content area -->
			
			@if (isset($page))
				@include($page)
			@endif
			
			<!-- End -->
			
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
         @include('partials.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  @include('partials.script')
</body>
</html>