@if (!empty($receipt))
    @foreach($receipt as $b)
        <div class="listBox">
          <div class="userBox">
            <div class="username">
              <h2>{{substr($b->phone, 0, 3)}}****{{substr($b->phone, 7, strlen($b->phone))}}</h2><span>{{date('Y.m.d h:i:s A', strtotime($b->updated_at))}}</span>
            </div>
            <div class="address">{{$b->address}}</div>
          </div>
          <div class="txtBox">{{$b->content}}</div>
          <ul class="imgBox">
            @if (!empty($b->uploads) && (!empty(json_decode($b->uploads))))
                @foreach(json_decode($b->uploads) as $photo)
                    <li><a href="#" onclick="viewPhoto('{{ $photo }}');"><img src="{{ $photo }}"></a></li>
                @endforeach  
            @endif
          </ul>
        </div>
    @endforeach 
@endif
