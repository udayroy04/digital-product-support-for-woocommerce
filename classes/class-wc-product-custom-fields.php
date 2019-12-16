<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WCPS_Product_Custom_Fields{

		      public function __construct() {
			  
                                   add_action( 'add_attachment', 'wpse62481_set_default_meta_value' );	  			  
		            add_action( 'woocommerce_product_options_general_product_data', array( $this, 'wcps_create_variation_fields') );
			add_action( 'woocommerce_process_product_meta', array( $this, 'wcps_save_variation_fields') );			
		
		    }	
		 
			    
		public  function wcps_create_variation_fields(){		       
				    
				    global $post;			    
				    $this->currency = get_woocommerce_currency_symbol();
				    
				        // product support services
				      
				        ?>
				    
				         <style type="text/css">
				         .remove{
					         color:#493ce0;
				         }      
				         
				<!--  support css -->    
                                               
							
				#repeatable-support-field.wpps-upsell .wcps-supporttable-subheading td{
					 border-top: 1px solid #e5e5e5;
					 padding: 8px 0px; 					
				}
				p.form-field.support-month-field .wcps-currency-symbol{
					margin-right:50px;
				}
				 table#repeatable-support-field {
				    padding-left: 1%;
				}           
				         
				     <!--  upsell css start -->
				 p.form-field._wcps_up_sell_product_field.show_if_simple label {
					    width: 35%;
				 }
					
				#repeatable-fieldset-one.wpps-upsell thead .wcps-upselltable-heading td{
					 border-top: 1px solid #e5e5e5;
					  border-bottom: 1px solid #e5e5e5;
					 padding: 8px 0px;	
                                                            text-align:center;					 
				}	
				
				#repeatable-fieldset-one.wpps-upsell .wcps-upsellttable-subheading td{
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
                                               
			           <?php  
			           // support product 			          			
				$support = get_post_meta($post->ID, 'support', true);
				wp_nonce_field( 'repeatable_support_meta_nonce', 'repeatable_support_meta_nonce' );
			           ?>
				<table id="repeatable-support-field" class="wcps-support" width="100%">
				<thead>					                 
					 <tr class="wcps-supporttable-heading">						
						<td colspan="3" style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;text-align: center;padding: 8px 0px;">
						Support Product
						</td>					
					</tr>    					     
					<tr class="wcps-supporttable-subheading">						
						<td width="40%">Month Duration</td>
						<td width="40%">Price</td>
						<td width="20%"></td>
					</tr>
				</thead>
				<tbody>
				<?php
				if ( $support ) :
					foreach ( $support as $supportfield ) {
			?>
				<tr>					
					<td><input type="text" class="widefat support-product-title"  name="month[]" value="<?php if( $supportfield['month'] != '' ){  echo esc_attr( $supportfield['month'] );  } ?>"  /></td>
					<td><?php  echo '&nbsp; '. $this->currency ; ?>&nbsp;<input type="text" class="widefat  support-pro" name="supportprice[]" value="<?php if ( $supportfield['supportprice'] != '' ){  echo esc_attr( $supportfield['supportprice'] );  }  ?>" /></td>
					<td><a class="button remove-supportrow" href="#">remove</a></td>			
					
				</tr>
				<?php
					}
				else :
					// show a blank one
			?>
				<tr>					
					<td><input type="text" class="widefat support-product-title" name="month[]" value=""    /></td>
					<td><input type="text" class="widefat  support-pro" name="supportprice[]" value="" /></td>
					<td><a class="button remove-supportrow" href="#">-</a></td>		                        
				</tr>
				
				<?php endif; ?>

				<!-- empty hidden one for jQuery -->
				<tr class="empty-supportrow screen-reader-text">
					
					<td><input type="text" class="widefat support-product-title" name="month[]" value=""  /></td>
					<td><input type="text" class="widefat support-pro" name="supportprice[]"   value="" /></td>	
                                                             <td><a class="button remove-supportrow" href="#">-</a></td>					
					
				</tr>
				</tbody>
				</table>
                                                <p><span id="support-proerrmsg" style="color: #ba0000; font-weight:bold;"></span></p>
				<p><a id="add-supportrow" class="button" href="#">Add Support Product</a></p>
								        

				
                                               
			        <?php  
			        	// upsell product code   				
				$_wcps_up_sell_p_field = get_post_meta($post->ID, '_wcps_up_sell_product_field', true);
				wp_nonce_field( 'repeatable_meta_box_nonce', 'repeatable_meta_box_nonce' );
			        
			         ?>
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
				if ( $_wcps_up_sell_p_field ) :
					foreach ( $_wcps_up_sell_p_field as $field ) {
			?>
				<tr>
					
					<td><input type="text" class="widefat upsell-product-title"  name="name[]" value="<?php if( $field['name'] != '' ){  echo esc_attr( $field['name'] );  } ?>"  /></td>

					<td><?php  echo '&nbsp; '. $this->currency ; ?>&nbsp;<input type="text" class="widefat  upsell-pro" name="price[]" value="<?php if ( $field['price'] != '' ){  echo esc_attr( $field['price'] );  }  ?>" /></td>
					<td><a class="button remove-row" href="#">remove</a></td>			
					
				</tr>
				<?php
					}
				else :
					// show a blank one
			?>
				<tr>
					
					<td><input type="text" class="widefat upsell-product-title" name="name[]" value=""    /></td>
					<td><input type="text" class="widefat  upsell-pro" name="price[]" value="" /></td>
					<td><a class="button remove-row" href="#">-</a></td>		                        
				</tr>
				
				<?php endif; ?>

				<!-- empty hidden one for jQuery -->
				<tr class="empty-row screen-reader-text">
					
					<td><input type="text" class="widefat upsell-product-title" name="name[]" value=""  /></td>
					<td><input type="text" class="widefat upsell-pro" name="price[]"   value="" /></td>	
                                                            <td><a class="button remove-row" href="#">-</a></td>					
					
				</tr>
				</tbody>
				</table>
                                                <p><span id="upsell-proerrmsg" style="color: #ba0000; font-weight:bold;"></span></p>
				<p><a id="add-row" class="button" href="#">Add UP Sell Product</a></p>
				
				        

<?php    }
		     
			    
		 public  function wcps_save_variation_fields( $post_id ) {		     
				  				
                                                // save product support services custom field data 				
				   if ( ! isset( $_POST['repeatable_support_meta_nonce'] ) ||
					! wp_verify_nonce( $_POST['repeatable_support_meta_nonce'], 'repeatable_support_meta_nonce' ) ){					
					return;
				}
				
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){					
					return;
				}
				
				if ( !current_user_can( 'edit_post', $post_id ) ){					
					return;
				}	
					
				$supportold = get_post_meta($post_id, 'support', true);
				$supportnew = array();		
				
				//$count = count( $names );
				for ( $i = 0; $i < 2000; $i++ ) {
					if ( sanitize_text_field( $_POST['month'][$i] ) != '' ){
						$supportnew[$i]['month'] = stripslashes( strip_tags( sanitize_text_field( $_POST['month'][$i] ) ) );      // sanitize text field value 
					}				
					if ( sanitize_text_field( $_POST['supportprice'][$i] ) != '' ){
						$supportnew[$i]['supportprice'] = stripslashes( strip_tags( sanitize_text_field( $_POST['supportprice'][$i] ) ) );         // sanitize text field value 
				             }
				}
				if ( !empty( $supportnew ) && $supportnew != $supportold ){
					//if ( !empty( $names )) {						
					update_post_meta( $post_id, 'support', $supportnew );
					update_post_meta( $post_id, 'support_price', 'allow' );
					//}
				}
				elseif ( empty($supportnew) && $supportold ){
					delete_post_meta( $post_id, 'support', $supportold );
				}			    
				  
				   
				  // save upsell custom field data 
				   if ( ! isset( $_POST['repeatable_meta_box_nonce'] ) ||
					! wp_verify_nonce( $_POST['repeatable_meta_box_nonce'], 'repeatable_meta_box_nonce' ) ){					
					return;
				}
				
				if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){					
					return;
				}
				
				if ( !current_user_can( 'edit_post', $post_id ) ){					
					return;
				}	
					
				$old = get_post_meta($post_id, '_wcps_up_sell_product_field', true);
				$new = array();		
				
				//$count = count( $names );
				for ( $i = 0; $i < 2000; $i++ ) {
					if ( sanitize_text_field( $_POST['name'][$i] ) != '' ){
						$new[$i]['name'] = stripslashes( strip_tags( sanitize_text_field( $_POST['name'][$i] ) ) );      // sanitize text field value 
					}				
					if ( sanitize_text_field( $_POST['price'][$i] ) != '' ){
						$new[$i]['price'] = stripslashes( strip_tags( sanitize_text_field( $_POST['price'][$i] ) ) );         // sanitize text field value 
				             }
				}
				if ( !empty( $new ) && $new != $old ){
					//if ( !empty( $names )) {						
					update_post_meta( $post_id, '_wcps_up_sell_product_field', $new );
					update_post_meta( $post_id, '_wcps_up_sell_product', 'allow' );
					//}
				}
				elseif ( empty($new) && $old ){
					delete_post_meta( $post_id, '_wcps_up_sell_product_field', $old );
				}				   
				   
				   
								    
		     }
		     
		   
}

$wcps_product_custom_fields = new WCPS_Product_Custom_Fields();
	



