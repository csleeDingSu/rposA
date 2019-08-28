(function($) {
  'use strict';
  $(function() {
    if ($('#formadd').length) {
      $.fn.editable.defaults.mode = 'inline';
      $.fn.editableform.buttons =
        '<button type="submit" class="btn btn-primary btn-sm editable-submit">' +
        '<i class="fa fa-fw fa-check"></i>' +
        '</button>' +
        '<button type="button" class="btn btn-default btn-sm editable-cancel">' +
        '<i class="fa fa-fw fa-times"></i>' +
        '</button>';
      
		
		$('.editval').click(function(e){  
			
			e.stopPropagation();
			var button = $(this).attr('id');
			$('#'+button).editable({
				url: "/admin/edit-env-record",
				type: 'text',
				pk: 1,
				name: button,
				title: 'Enter value'
			  });
		
		 });
    }
  });
})(jQuery);