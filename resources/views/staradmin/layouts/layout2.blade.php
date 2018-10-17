<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials.head')
<body>
  <div class="container-scroller">

    @include('layouts.partials.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
            
      @include('layouts.partials.nav')
      
      @include('layouts.partials.banner')

      <!-- partial -->
      <div class="main-panel">
      
			<!-- Main Content area -->
			
      {{-- @yield('content') --}}
			
			<!-- End -->
			
      </div>

      @include('layouts.partials.footer')
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
</body>

@include('layouts.partials.script')
</html>