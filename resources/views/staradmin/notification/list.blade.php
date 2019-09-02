
<div class="clearfix">&nbsp;</div>
<section class="filter">
	@include('notification.filter')
</section>

<section class="datalist">
	@include('notification.ajaxlist')
</section>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css"/>

@section('bottom_js')
@parent

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.min.js"></script>

@endsection 