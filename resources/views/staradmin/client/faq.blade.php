@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@if(env('THISVIPAPP','false'))
    <!-- top nav -->
    @section('left-menu')
      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
    @endsection

    @section('title', '常见问题')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '常见问题')

    @section('left-menu')
        <a href="javascript:history.back()" class="back">
            <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
        </a>
    @endsection

    @section('top-navbar')
    @endsection
@endif


@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/faq.css') }}" />
@endsection

@section('content')

@if(env('THISVIPAPP','false'))
    <div>
@else
    <div class="container demo">
@endif

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        @foreach ($faqs as $faq)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading-{{ $faq->id }}">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}" id="btncollapse{{ $faq->id }}">
                        <i class="more-less glyphicon glyphicon-menu-right"></i>
                        <div class="faq-title">{{ $faq->title }}</div>
                    </a>
                </h4>
            </div>
            <div id="collapse{{ $faq->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $faq->id }}">
                <div class="panel-body">
                    {!! $faq->content !!}
                </div>
            </div>
        </div>
        @endforeach

    </div><!-- panel-group -->
    
    
</div><!-- container -->

@endsection


@section('footer-javascript')
	@parent
	<script type="text/javascript">
    var faqid = "{{$faqid}}";

		function toggleIcon(e) {
		    $(e.target)
		        .prev('.panel-heading')
		        .find(".more-less")
		        .toggleClass('glyphicon-menu-right glyphicon-menu-down');
		}
		$('.panel-group').on('hidden.bs.collapse', toggleIcon);
		$('.panel-group').on('shown.bs.collapse', toggleIcon);

        if (faqid > 0) {
            $(document).ready(function(){
              $('#btncollapse' + faqid).trigger('click');
            });    
        }
        
	</script>
@endsection