jQuery( document ).ready(function() {
	
	
	jQuery('#add-row').on('click', function() {
					var row = jQuery('.empty-row.screen-reader-text').clone(true);
					row.removeClass('empty-row screen-reader-text');
					row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
					return false;
				});
				jQuery('.remove-row').on('click', function() {
					jQuery(this).parents('tr').remove();
					return false;
	});
		

           jQuery('#add-supportrow').on('click', function() {
					var row = jQuery('.empty-supportrow.screen-reader-text').clone(true);
					row.removeClass('empty-supportrow screen-reader-text');
					row.insertBefore('#repeatable-support-field tbody>tr:last');
					return false;
				});
				jQuery('.remove-supportrow').on('click', function() {
					jQuery(this).parents('tr').remove();
					return false;
	});
		
 
    
       jQuery(".support-pro").keypress(function (e) {
               
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {	
		        jQuery("#support-proerrmsg").html("Digits Only").show().fadeOut(10000);
			   return false;
		    }
      });
	     
       jQuery(".upsell-pro").keypress(function (e) {
		   
		     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {	
		        jQuery("#upsell-proerrmsg").html("Digits Only").show().fadeOut(10000);
			   return false;
		    }
        });
        
        
	  jQuery('.upsell-product-title').keydown(function (e) {
	          if (e.shiftKey || e.ctrlKey || e.altKey) {
		    jQuery("#upsell-proerrmsg").html("Enter alphabets only").show().fadeOut(10000);
		     return false;
	          } else {
		  var key = e.keyCode;
		  if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
		      jQuery("#upsell-proerrmsg").html("Enter alphabets only").show().fadeOut(10000);
		       return false;
		  }
	          }
	      });
   
   
   
    
    });

        