@if (!empty($blog))
    @foreach($blog as $b)
        <div class="listBox3">
          <div class="userBox">
            <div class="username">
              <h2>{{substr($b->phone, 0, 3)}}****{{substr($b->phone, 7, strlen($b->phone))}}</h2><span>{{date('Y.m.d H:i:s', strtotime($b->updated_at))}}</span>
            </div>
            <div class="address">{{$b->address}}</div>
          </div>
          <div class="txtBox">{{$b->content}}</div>
          <ul class="imgBox">
            @php ($i = 0)
            @if (!empty($b->uploads) && (!empty(json_decode($b->uploads))))
                @foreach(json_decode($b->uploads) as $photo)
                  @php ($i++)
                  @if ($i <= 2)
                    <li>
                      <div class="_container">
                        <div class="_content">
                          <img class="lazy" src="{{ $photo }}">
                        </div>
                      </div>
                    </li>
                  @else
                    
                    @if ($i > 2)                      
                      <li style="display: none;">
                        <div class="_container">
                          <div class="_content">
                            <img class="lazy" src="{{ $photo }}">
                          </div>
                        </div>
                      </li>
                    @endif

                  @endif
                @endforeach 

                @php ($i = 0)
                @foreach(json_decode($b->uploads) as $photo)
                  @php ($i++)
                    @if ($i >= 3)                      
                      @if ($i == 3)
                        <li>
                          <div class="_container">
                        @endif                 
                            @php($clss = "_content2 pos" .$i)   
                            <div class="{{$clss}}">
                              <img class="lazy" src="{{ $photo }}">
                            </div>
                        @if ($i == 6)
                          </div>
                        </li>
                        @endif
                    @endif
                @endforeach  
            @endif
          </ul>
        </div>        
    @endforeach

@endif


