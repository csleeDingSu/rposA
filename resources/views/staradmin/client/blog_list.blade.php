@if (!empty($blog))
@php ($i = 0)
    @foreach($blog as $b)
    @php ($i++)
    @if ($i == 1 || $i == 6)
    <div class="item">
    @endif
      
      <div class="inBox">
        <div class="imgBox">
        @if (!empty($b->uploads) && (!empty(json_decode($b->uploads))))
         <img src="{{json_decode($b->uploads)[0]}}">
        @endif
        </div>
        <h2>{{$b->content}}</h2>
        <div class="inDetail">
          <p>{{substr($b->phone, 0, 3)}}****{{substr($b->phone, 7, strlen($b->phone))}}</p>
          <span>{{$b->address}}</span>
        </div>
      </div>

    @if ($i == 5)
    </div>
    @endif
  @endforeach
  
  @if ($i > 5) 
  </div>
  @endif


@endif


