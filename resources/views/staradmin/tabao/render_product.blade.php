     
            
    @foreach($result as $list)
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-row align-items-top">
            
            <div class="ml-3">
              <h6 class="text-facebook">{{$list->title}}</h6>
              <p class="mt-2 text-muted card-text">{{$list->dtitle}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach