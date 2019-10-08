@if(!$result->isEmpty())       
            
      @include('tabao.render_product')
   




   <div class="col-12" >
     
     {!! $result->render() !!}
   </div>

      @endif