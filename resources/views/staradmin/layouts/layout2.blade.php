<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  
    <title>{{env('APP_NAME')}} - @yield('title')</title>
    
    @section('top-css')
      <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
      <link rel="stylesheet" href="{{ asset('/client/css/layout.css') }}" />
      <link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" />
    @show
    
    @section('top-javascript')
      <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
      <!-- <script type="text/javascript" src="//js.users.51.la/19985793.js"></script> -->
    @show
<body>

  @include('layouts.partials.notification')

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