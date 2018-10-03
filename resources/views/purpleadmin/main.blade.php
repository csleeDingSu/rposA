<!--
{{ $template= Config::get('view.template').'/' }}
-->




{{$template = ''}}
@include($template.'partials.header')
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    @include($template.'partials.topbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      @include($template.'partials.sidebar')
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
       @include($template.'partials.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  @include($template.'partials.scripts')
</body>

</html>