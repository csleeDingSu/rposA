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
});