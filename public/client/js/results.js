$(function () {
  
	$.getJSON( "/api/result-history/101", function( data ) {
		var records = data.records.data;

        $.each(records, function(i, item) {
        	var counter = i + 1;
		    $('#result-' + counter).html(item.result);
		});
    });

});