jQuery( document ).ready(function() {
jQuery(document).on('click', '#wcps-addtocart-btn', function (e) {
        e.preventDefault();
      
       // var product_id =  jQuery(".wcps-product-id").val();
        
             
             var   product_id = jQuery('.wcps-product-id').val();  
	  var  wcps_up_sell_product_price = parseInt(jQuery('.wcps_up_sell_product_price').val());
              var  wcps_product_monthlyprice = parseInt(jQuery('.wcps_product_monthlyprice').val());
	  var product_price = wcps_up_sell_product_price + wcps_product_monthlyprice;    
            
	    alert(product_id +', '+ product_price );
        
        var data = {
            action: 'woocommerce_ajax_add_to_cart',
            product_id: product_id,            
        };

        jQuery(document.body).trigger('adding_to_cart', data);

        jQuery.ajax({
            type: 'post',
            url: wc_add_to_cart_params.ajax_url,
            data: data,
            beforeSend: function (response) {
            //    $thisbutton.removeClass('added').addClass('loading');
            },
            complete: function (response) {
            //    $thisbutton.addClass('added').removeClass('loading');
            },
            success: function (response) {

                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                } else {
                    jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash]);
                }
            },
        });

        return false;
    });
});
        