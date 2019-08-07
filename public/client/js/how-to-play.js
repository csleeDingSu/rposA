$(function () {
    getProduct();
});

function getProduct(){
    $.getJSON( "/api/get-product-list", function( data ) {
        // console.log(data);

        var html = '';
        var htmlmodel = '';

        $.each(data.records, function(i, item) {
            var available_quantity = item.available_quantity;
            var used_quantity = 0;
            var reserved_quantity = item.reserved_quantity;
            var cannot_redeem = false;
            var cls_cannot_redeem = '';
            
            html += '<div class="redeem-prize openeditmodel_'+ i + '">' + 
                        '<div class="left-box">' +
                        '<div class="prize-box">' +
                            '<div class="image-wrapper">' +
                                '<img src="'+ item.picture_url +'">' +
                            '</div>' +
                            '<div class="redeem-product">'+ item.name +'</div>' +
                            '<div class="redeem-details">' +
                                '<div class="redeem-price">'+ Math.ceil(item.point_to_redeem) +' 金币</div>' +
                            '</div>' +
                        '</div>' +
                        '</div>' +
                    '</div>';

            htmlmodel += '<!-- Modal starts -->' +
                            '<div class="modal fade col-lg-12" id="viewvouchermode_'+ i +'" tabindex="-1" >' +
                                '<div class="modal-dialog modal-sm" role="document">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-body">' +
                                            '<div class="modal-row">' +
                                                '<div class="modal-img-voucher">' +
                                                    '<img src="' + item.picture_url +'" alt=" ' + item.name + ' " class="img-voucher" />' +
                                                '</div>' +

                                                '<div class="wrapper modal-full-height">' +
                                                    '<div class="modal-card">' +
                                                        '<div class="modal-center">' +
                                                            '兑换本产品需要消耗:' +
                                                        '</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                            // '<div class="icon-coin-wrapper modal-icon">' +
                                                            //     '<div class="icon-coin"></div>' +
                                                            // '</div>' +
                                                            '<div class="wabao-price">'+ item.point_to_redeem +' 金币</div>' +
                                                    '</div>' +

                                                    

                                                    '<div id="error-'+ item.id + '" class="error"></div>';

                                                     htmlmodel += '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' + 
                            '<!-- Modal Ends -->';
        });

        $('.product').html(html);
         $( ".cardFull" ).after(htmlmodel);

         $.each(data.records, function(i, item) {
            if (i > 12) {
                return false;
            }

            $('.openeditmodel_' + i).click(function() {
                $('#viewvouchermode_' + i).modal('show');
            });
        });

        $('.open-card-no-modal').click(function() {
            $('#card-no-modal').modal('show');
        });

        $('.btn-close-card').click(function() {
            $('#card-no-modal').modal('hide');
        });
        
    });
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }