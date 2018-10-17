<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials.head')
<body>
  <div class="container-scroller">

    @include('layouts.partials.header')
            
    @include('layouts.partials.nav')
      
    @include('layouts.partials.banner')

      <div class="main-panel">
      
			<!-- Main Content area -->
			
      {{-- @yield('content') --}}
			
			<!-- End -->
			
      </div>

    @include('layouts.partials.footer')

  </div>
  
</body>

@include('layouts.partials.script')
</html>