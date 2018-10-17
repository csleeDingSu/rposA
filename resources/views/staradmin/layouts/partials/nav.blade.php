<header class="container navbar navbar-default">
  
				@if(isset($category))
				

				<ul class="nav navbar-nav">
					
					@foreach($category as $cat)
					
					<li><a href="/cs/{{$cat->id}}">{{$cat->display_name}}</a></li>
					
					
					@endforeach
				</ul>
			
				@endif
		
	</header>
