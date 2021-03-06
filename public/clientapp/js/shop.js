var from = 0;
var to = 1;
$(function () {
    getProduct();
    // getHighlight();
});

function getProduct(){
    
    document.getElementById('loading2').style.visibility="visible";

    $.getJSON( "/api/get-product-list", function( data ) {
        // console.log(data);

        var html = '<form id="frm_buy" method="post" action="/buy">' +
                        '<input id="hid_package_id" name="hid_package_id" type="hidden" value="">';

        $.each(data.records, function(i, item) {
            
            if(i % 2 === 0){
                html += '<div class="redeem-prize">' + 
                            '<div class="left-box">' +
                            '<div class="prize-box">' +
                                '<div class="image-wrapper">' +
                                    '<img class="redeem-img" rel="'+ item.id +'" src="'+ item.picture_url +'">' +
                                '</div>' +
                                '<div class="redeem-product">'+ item.name +'</div>' +
                                '<div class="redeem-details">' +
                                    '<div class="redeem-price">'+ Math.ceil(item.point_to_redeem) +' <span class="redeem-currency">币</span></div>' +
                                    '<div class="redeem-button-wrapper">' +
                                        '<div class="redeem-button" rel="'+ item.id +'">兑换</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div></div>' +
                        '</div>';
            } else {
                html += '<div class="redeem-prize">' + 
                            '<div class="right-box">' +
                            '<div class="prize-box">' +
                                '<div class="image-wrapper">' +
                                    '<img class="redeem-img" rel="'+ item.id +'" src="'+ item.picture_url +'">' +
                                '</div>' +
                                '<div class="redeem-product">'+ item.name +'</div>' +
                                '<div class="redeem-details">' +
                                    '<div class="redeem-price">'+ Math.ceil(item.point_to_redeem) +' <span class="redeem-currency">币</span></div>' +
                                    '<div class="redeem-button-wrapper">' +
                                        '<div class="redeem-button" rel="'+ item.id +'">兑换</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div></div>' +
                        '</div>';
            }
            html += '<input id="hid_price_'+ item.id +'" name="hid_price_'+ item.id +'" type="hidden" value="'+item.point_to_redeem+'">';
        });

        html += '<div class="redeem-prize">' + 
                    '<div class="left-box" style="height: 1rem; display: flex;"></div>' +
                    '<div class="right-box" style="height: 1rem; display: flex;"></div>' +
                '</div>';

        html += '</form>';

        $('.redeem-prize-wrapper').html(html);
        $('.redeem-button').click(function(){
            var g_vip_point = $('.shop-balance').html();

            var user_id = $('#hidUserId').val();
            if(user_id == 0){
                // window.top.location.href = "/member";
                // $( '#login-intropopup' ).modal( 'show' );
                // $( '#nonloginmodal' ).modal( 'show' );
                $( '#modal-no-login' ).modal( 'show' );
                $('.btn-login').click(function(){
                    window.top.location.href = "/profile";
                });

            } else {

                $( "#hid_package_id" ).val($(this).attr('rel'));
                // console.log($(this).attr('rel'));
                var price = getNumeric($("#hid_price_"+ $(this).attr('rel')).val());
                console.log(price);
                console.log(g_vip_point);
                console.log(getNumeric(price) > getNumeric(g_vip_point));
                if (getNumeric(price) > getNumeric(g_vip_point)) {
                    // console.log(1);
                    $('#modal-insufficient-point').modal();
                    // $('.modal-backdrop').remove();
                    setTimeout(function(){ 
                        $('#modal-insufficient-point').modal('hide');
                    }, 3000);      
                    console.log('insufficient point');          
                    return false;
                } else {
                    // console.log(2);
                    $( "#frm_buy" ).submit();    
                }

            }
            
        });

        $('.redeem-img').click(function(){
            var g_vip_point = $('.shop-balance').html();
            var user_id = $('#hidUserId').val();
            if(user_id == 0){
                // window.top.location.href = "/member";
                // $( '#login-intropopup' ).modal( 'show' );
                // $( '#nonloginmodal' ).modal( 'show' );
                $( '#modal-no-login' ).modal( 'show' );
            } else {

                $( "#hid_package_id" ).val($(this).attr('rel'));
                console.log($(this).attr('rel'));
                var price = getNumeric($("#hid_price_"+ $(this).attr('rel')).val());
                if (getNumeric(price) > getNumeric(g_vip_point)) {
                    $('#modal-insufficient-point').modal();
                    // $('.modal-backdrop').remove();
                    setTimeout(function(){ 
                        $('#modal-insufficient-point').modal('hide');
                    }, 3000);           
                    console.log('insufficient point');          
                    return false;     
                } else {
                    $( "#frm_buy" ).submit();    
                }

            }
            
        });
    
        document.getElementById('loading2').style.visibility="hidden";
    });
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
    // console.log(parseFloat(value).toFixed(2));
    // return parseFloat(value).toFixed(2);
  }

function getHighlight() {
    var txt = null;
    setInterval(function () {
      $.ajax({
            type: "GET",
            url: "/shop/api/getProductForHighlight?from=" + from + "&to=" + to,
            dataType: "json",
            error: function (error) { console.log(error) },
            success: function(data) {
                console.log(data.data[0]);
                d = data.data[0];
                if (typeof d === "undefined") {
                    from = 0;
                    to = 1;
                } else {
                    txt = '<span class="highlight">' + d.phone.substring(0,3) + '*****' + d.phone.substring(d.phone.length - 4) + '</span> 换购 ' + d.package_name;
                    $('.txt-ellipsis').html(txt);
                    from++;
                    to++;
                    $('.txt-ellipsis').html(txt);    
                }
                
            }
        });
    }, 3000);
}