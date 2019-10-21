@if (!empty($blog))
@php ($i = 0)
@php ($html1 = '')
@php ($html2 = '')
@php ($line1 = true)
    @foreach($blog as $b)
    @php ($i++)
    @php ($line1 = ($i % 2) > 0 ? true : false)
    @php ($photo = (!empty($b->uploads) && (!empty(json_decode($b->uploads)))) ? json_decode($b->uploads)[0] : null)
    @php ($content = $b->content)
    @php ($phone = substr($b->phone, 0, 3) . '****' . substr($b->phone, 7, strlen($b->phone)))
    @php ($address = $b->address)

    @php ($_html = "<div class='inBox'>
        <div class='imgBox'>
         <img src='{{$photo}}'>
        </div>
        <h2>{{$content}}</h2>
        <div class='inDetail'>
          <p>{{$phone}}</p>
          <span>{{$address}}</span>
        </div>
      </div>")

    @if ($line1)
    
      @php ($html1 .= $_html)
    @else
      @php ($html2 .= $_html)
    
    @endif
      

  @endforeach
  
  <div class="item">
    <div class="item-line-1">{!! empty($html1) ? '' : $html1 !!}}</div>
  </div>
  <div class="item">
    <div class="item-line-2">{!! empty($html2) ? '' : $html2 !!}}</div>
  </div>

@endif

