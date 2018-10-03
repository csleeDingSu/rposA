<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    @yield('nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      
      @yield('sidebar')
      
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
         @yield('footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  @yield('script')
</body>