<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('layouts.partials.head')
<body>
  <div class="container-scroller">

    @include('layouts.partials.header')
            
    @include('layouts.partials.nav')
      
    @include('layouts.partials.banner')
      
		<!-- Main Content area -->
		
     @yield('content')
		
		<!-- End -->

    @include('layouts.footer')

  </div>
  
</body>

@include('layouts.partials.script')
</html>