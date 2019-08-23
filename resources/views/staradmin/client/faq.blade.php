@extends('layouts.default')

@section('title', '常见问题')

@section('left-menu')
    <a href="/profile" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/faq.css') }}" />
@endsection

@section('content')
<div class="container demo">

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