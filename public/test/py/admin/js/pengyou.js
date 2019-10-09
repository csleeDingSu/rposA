// JavaScript Document
		function colorgb(color){
			$('#pengyou_set_openshk').css('background-color',color);
		}
$('#pengyou_set_opensh').click(function(){
	if($('#pengyou_set_opensh').css('left')!=28+"px"){
		$('#pengyou_set_opensh').css('left','28px');
		setTimeout('colorgb("#51C122")',300);
		
	}else{
		$('#pengyou_set_opensh').css('left','-2px');
		setTimeout('colorgb("#fff")',300);
	};
});
$('#pengyou_set_opensh').click(function(){
	$.get("openshenhe.php", {
			 "shenhe":1
		 },
		  function(data){
			if(data.success==true){
				 
			}else{
				
			}
		  },"json");
});
$('#pengyou_set_baocun').click(function(){
	var title = $('#pengyou_js_title').val(),
		url = $('#pengyou_js_url').val(),
		bg = $('#pengyou_js_bg').val(),
		qq = $('#pengyou_js_qq').val();
		$.post("shezhi.php", { 
					"title":title,
					"url":url,
					"bg":bg,
					"qq":qq
				},
				   function(data){
					if(data.success){
						tishi(2,data.msg,1500,'webset.php');
					}else{
						tishi(1,data.msg,1500);
					}
				   }, "json");
});
