<?php
class WCPS_Product_Custom_Fields{

                       

		    function __construct() {
			  
                                   add_action( 'add_attachment', 'wpse62481_set_default_meta_value' );	  			  
		            add_action( 'woocommerce_product_options_general_product_data', array( $this, 'wcps_create_variation_fields') );
			add_action( 'woocommerce_process_product_meta', array( $this, 'wcps_save_variation_fields') );			
		
		    }	
		 	
		    function wcps_create_variation_fields(){		       
				    
				    global $custom_downloads, $post;
				    
				    global $woocommerce;
				   $currency = get_woocommerce_currency_symbol();
				    
				        // product support services
				        // Use nonce for verification
				        echo '<input type="hidden" name="tz_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


				        ?>
				    <div id="wcps_meta_inner">
				        <?php
				 
				        //get the saved meta as an array
				       $support = get_post_meta($post->ID,'support',true);				       

				       $c = 0;
				       
				       if (!empty($support)) :
				       if ( count( $support ) > 0 ) {
						foreach( $support as $track ) {
						    if ( isset( $track['month'] ) || isset( $track['support_price'] ) ) {				    
							
							
						        printf( '		        		
						        <p class="form-field support-month-field">
						        <label>Support Services</label><input type="text" name="support[%1$s][month]" value="%2$s"  placeholder="Enter Month Duration"  /><span class="wcps-currency-symbol">%5$s</span><input type="text" name="support[%1$s][support_price]" value="%3$s" placeholder="Enter Support Price" /> <span class="remove">%4$s</span>					    							 
						        </p>', $c, $track['month'], $track['support_price'], __( 'Remove' ),$currency );
						        $c = $c +1;
						    }
						}
					        }
				      endif;	        

				        ?>
				        <span id="here"></span>
				         <div class="row-dynamic-support-fields" style="border-bottom: 1px solid #e5e5e5;"><p><input class="button tagadd add" type="button" value="<?php _e('Add Support Price Field'); ?>"></p></div>
				         
				         <style type="text/css">
				         .remove{
					         color:#493ce0;
				         }      
				         #general_product_data p.form-field.support-month-field input {
					    width: 32%;
					    margin-right: 20px;
				         }
				         .wcps_meta_inner{
					         border: 1px solid #e5e5e5;
				         }
				       p.form-field._wcps_up_sell_product_field.show_if_simple label {
					    width: 35%;
					}
					
				#repeatable-fieldset-one.wpps-upsell thead .wcps-upselltable-heading td{
					 border-top: 1px solid #e5e5e5;
					 padding: 8px 0px;	
                                                            text-align:center;					 
				}	
				
				#repeatable-fieldset-one.wpps-upsell .wcps-upselltable-subheading td{
					 border-top: 1px solid #e5e5e5;
					 padding: 8px 0px;					
				}
				p.form-field.support-month-field .wcps-currency-symbol{
					margin-right:50px;
				}
				 table#repeatable-fieldset-one {
				    padding-left: 1%;
				}    
 				         
				         </style>
				        <script>
				        var $ =jQuery.noConflict();
				        $(document).ready(function() {
				        var count = <?php echo $c; ?>;
				        $(".add").click(function() {
				        count = count + 1;

				       $('#here').append('<p class="form-field support-month-field"><input type="text" name="support['+count+'][month]" value="" placeholder="Enter Month Duration"  /><span> </span><input type="text" name="support['+count+'][support_price]" value="" placeholder="Enter Support Price" /><span class="remove">Remove </span></p>' );
                                                      return false;
				        });
				        $(".remove").live('click', function() {
				        $(this).parent().remove();
				        });
				        });
				        </script>
				        
				        
					        
				        </div>
				        <?php
				        
				
				// upsell product      
				
				$_wcps_up_sell_product_field = get_post_meta($post->ID, '_wcps_up_sell_product_field', true);
				wp_nonce_field( 'repeatable_meta_box_nonce', 'repeatable_meta_box_nonce' );
			?>
				<script type="text/javascript">
			jQuery(document).ready(function($) {
				
				$('#add-row').on('click', function() {
					var row = $('.empty-row.screen-reader-text').clone(true);
					row.removeClass('empty-row screen-reader-text');
					row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
					return false;
				});
				$('.remove-row').on('click', function() {
					$(this).parents('tr').remove();
					return false;
				});
				/* $('#repeatable-fieldset-one tbody').sortable({
					opacity: 0.6,
					revert: true,
					cursor: 'move',
					handle: '.sort'
				}); */
			});
				</script>
                                               
			        
				<table id="repeatable-fieldset-one" class="wpps-upsell" width="100%">
				<thead>				
				                 
					 <tr class="wcps-upselltable-heading">						
						<td colspan="3">UP Sell Product</td>
					
					</tr>    
					     
					<tr class="wcps-upselltable-subheading">						
						<td width="40%">Product Name</td>
						<td width="40%">Price</td>
						<td width="20%"></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if ( $_wcps_up_sell_product_field ) :
					foreach ( $_wcps_up_sell_product_field as $field ) {
			?>
				<tr>
					
					<td><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>

					<td><?php  echo '&nbsp; '.$currency; ?>&nbsp;<input type="text" class="widefat" name="price[]" value="<?php if ($field['price'] != '') echo esc_attr( $field['price'] );  ?>" /></td>
					<td><a class="button remove-row" href="#">remove</a></td>			
					
				</tr>
				<?php
					}
				else :
					// show a blank one
			?>
				<tr>
					
					<td><input type="text" class="widefat" name="name[]" value="" /></td>
					<td><input type="text" class="widefat" name="price[]" value="" /></td>
					<td><a class="button remove-row" href="#">-</a></td>		                        
				</tr>
				
				<?php endif; ?>

				<!-- empty hidden one for jQuery -->
				<tr class="empty-row screen-reader-text">
					
					<td><input type="text" class="widefat" name="name[]" value="" /></td>
					<td><input type="text" class="widefat" name="price[]" value="" /></td>	
                                                             <td><a class="button remove-row" href="#">-</a></td>					
					
				</tr>
				</tbody>
				</table>

				<p><a id="add-row" class="button" href="#">Add UP Sell Product</a></p>
				
					        
				        
				        

<?php    }
		     
		     
		     function wcps_save_variation_fields( $post_id ) {		     
				  				
                                                // save product support services custom field data 
				// verify nonce
				    if (!wp_verify_nonce($_POST['tz_meta_box_nonce'], basename(__FILE__))) {
				        return $post_id;
				    }
				    // check autosave
				    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				        return $post_id;
				    }
				    // check permissions
				    if ('page' == $_POST['post_type']) {
				        if (!current_user_can('edit_page', $post_id)) {
					return $post_id;
				        }
				    } elseif (!current_user_can('edit_post', $post_id)) {
				        return $post_id;
				    }
                                                    
				
				   
				   $support = $_POST['support'];
				   $support_price = 'allow';
				   
				   if ( !empty( $support) || ! isset( $_POST['support'] ) ){
				   update_post_meta($post_id,'support',$support);
				   update_post_meta($post_id,'support_price',$support_price);
				   }  
				   
				  
				   
				  // save upsell custom field data 
				   if ( ! isset( $_POST['repeatable_meta_box_nonce'] ) ||
					! wp_verify_nonce( $_POST['repeatable_meta_box_nonce'], 'repeatable_meta_box_nonce' ) )
					return;
				if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
					return;
				if (!current_user_can('edit_post', $post_id))
					return;
				$old = get_post_meta($post_id, '_wcps_up_sell_product_field', true);
				$new = array();
				$names = $_POST['name'];
				$price = $_POST['price'];
				$count = count( $names );
				for ( $i = 0; $i < $count; $i++ ) {
					if ( $names[$i] != '' ){
						$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );
					}				
					if ( $price[$i] != '' ){
						$new[$i]['price'] = stripslashes( strip_tags( $price[$i] ) );
				             }
				}
				if ( !empty( $new ) && $new != $old ){
					if ( !empty( $names )) {
					update_post_meta( $post_id, '_wcps_up_sell_product_field', $new );
					update_post_meta( $post_id, '_wcps_up_sell_product', 'allow' );
					}
				}
				elseif ( empty($new) && $old ){
					delete_post_meta( $post_id, '_wcps_up_sell_product_field', $old );
				}
				   
				   
				   
								    
		     }
		     
		     
		
		       
		    
}

$wcps_product_custom_fields = new WCPS_Product_Custom_Fields();
	



