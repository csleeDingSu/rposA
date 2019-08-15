$(document).ready(function(){
    $("#buy").validate({
    rules :{
        txt_name : {
            required : true
        },
        txt_mobile : {
        	required : true	
        },
        txt_city : {
        	required : true	
        },
        txt_address : {
        	required : true	
        }
    },
    messages :{
        txt_name : {
            required : '*请输入收件人姓名'
        },
        txt_mobile : {
        	required : '*请输入手机号码'	
        },
        txt_city : {
        	required : '*请输入所在地区'
        },
        txt_address : {
        	required : '*请输入街道，小区门牌等详细地址'
        }
    }
    });

    getAddress();
});

function getAddress(){
    var id = $('#hidUserId').val();
    var edit = $('#hidEdit').val();

    if(edit == 1){
        $('.navbar-brand').html('修改收货地址');
    } else {
        $.ajax({
            type: 'GET',
            url: "/api/get-latest-address",
            data: { 'memberid': id },
            dataType: "json",
            error: function (error) { console.log(error.responseText) },
            success: function(data) {
                if(data.success) {
                    if(data.records !== undefined){
                        if($('#txt_name').val() === ''){
                            $('#txt_name').val(data.records.receiver_name);
                        }
                        if($('#txt_mobile').val() === ''){
                            $('#txt_mobile').val(data.records.contact_number);
                        }
                        if($('#txt_city').val() === ''){
                            $('#txt_city').val(data.records.city);
                        }
                        if($('#txt_address').val() === ''){
                            $('#txt_address').val(data.records.address);
                        }

                        $( "#buy" ).submit();
                    }
                }
            }
        });
    }
}