@if (!empty($blog))
    @foreach($blog as $b)
    <div class="_pg{{$page}}">
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
                  @endif                  
                @endforeach 
                
                @php ($_i = 0)
                @if ($i > 2)
                  <li><div class='_container'>
                  @foreach(json_decode($b->uploads) as $photo)
                    @php ($_i++)
                    @if ($_i > 2)
                      @if ($i > 3)                    
                        @php($clss = "_content2 pos" .$_i)   
                        <div class="{{$clss}}"><img class="lazy" src="{{$photo}}"></div>                    
                      @else
                        <div class="_content"><img class="lazy" src="{{$photo}}"></div>
                      @endif
                    @endif
                  @endforeach 
                  </div></li> 

                  @if ($i > 3)
                    @php ($__i = 0)
                    @foreach(json_decode($b->uploads) as $photo)
                      @php ($__i++)
                      @if ($__i > 3)
                      <li class="hide">
                        <div class="_container">
                          <div class="_content">
                            <img class="lazy" src="{{ $photo }}">
                          </div>
                        </div>
                      </li>
                      @endif
                    @endforeach
                  @endif
              @endif
            @endif
          </ul>
        </div> 
    </div>       
    @endforeach

@endif


