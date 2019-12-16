<?php
class WCPS_FRONTENDAS_FIELDS{

                       

		 function __construct() {			    
			    
			add_action('woocommerce_before_add_to_cart_button', array( $this, 'wcps_support_custom_field') );   			
		           add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data'), 58, 3 );
		           add_action( 'woocommerce_before_calculate_totals', array( $this, 'before_calculate_totals'), 58, 1 );
		 }	
		 
	
		
		 function wcps_support_custom_field(){
			 
		   global $product;	 
		   
		   global $woocommerce;
		   
		   if ($product->is_downloadable('yes')) {   
		   
		   $current_product_id = get_the_ID();
		 
		
		
		 ?>	            
			
		<div class="digital-product-form-container">
			<div class="products wcps">
							  
			 <?php				  
				 
				$args = array( 
				        'p' => $current_product_id,
				        'post_type' => 'product',   
			                     'meta_key' => '_downloadable',
				        'meta_value' => 'yes',
				         'meta_compare' => '='						        
				 );
				        
				 $loop = new WP_Query( $args );   
				    
				 if ( $loop->have_posts() ) :
				    
				  echo  '<p id="value-on-single-product"><select name="wcps_product_monthlyprice" class="wcps_product_monthlyprice">';
				
				 while ( $loop->have_posts() ) : $loop->the_post();                                                    
					         
					        $permalink = get_permalink($loop->post->ID);
					        $title = $loop->post->post_title;
					        $ID = $loop->post->ID;        
				
				 $support_front = get_post_meta( $ID, 'support', true );				
				
				$this->currency = get_woocommerce_currency_symbol();
				$c = 0;
		       
		       if ( !empty( $support_front ) ) :
		       if ( count( $support_front ) > 0 ) {
				foreach( $support_front as $track ) {
				    if ( isset( $track['month'] ) || isset( $track['supportprice'] ) ) {				    
					
				  echo  '<option value="' . esc_attr( $track['supportprice'] ) . '" class="' . esc_attr( $ID ) . '">'. esc_attr( $track['month'] ) .' Month Service Support - '. esc_attr( $this->currency ) . esc_attr( $track['supportprice'] ) .'</option>';	
				  
				        $c = $c +1;
				    }
				}
			        }
		      endif;	  	      
					        
				endwhile;

				 wp_reset_postdata();
				  echo  '</select></p>';

				  echo  '<p id="value-on-single-product"><p class="wcps-checkbox-field">';
					
				while ( $loop->have_posts() ) : $loop->the_post();                                     
					       
					$permalink = get_permalink( $loop->post->ID );							      
					$ID = $loop->post->ID;
					$_wcps_frontentup_sell_p_field = get_post_meta( $ID, '_wcps_up_sell_product_field', true );       
					
					       
			if ( $_wcps_frontentup_sell_p_field ) :
			
			foreach ( $_wcps_frontentup_sell_p_field as $field ) {
				$name = sanitize_text_field( $field['name'] );
				$price = floatval( $field['price'] );
				echo  '<label><input type="checkbox" class="wcps_up_sell_product_price"  name="wcps_up_sell_product_price[]" value="'. esc_attr( $price ) .'"/> <span class="upsell title">'. esc_attr( $name ) . '</span><span class="upsell price"> ' . esc_attr( $this->currency ) .' '. esc_attr( $price ) .'</span></label>';
			            echo  '<input type="hidden" name="wcps_product_id" value="'. esc_attr( $ID ) .' " class="wcps-product-id">';			
			}	
			endif;
					   endwhile;

					   wp_reset_postdata();
					  
					  echo  '</p></p>';	

			else :

					 echo  '<p>No products found<p>';

			endif;		      
					         
					wp_reset_query();
					     ?>
				
			</div>	   
		 </div>
		 <?php	

		   }  //end if
		 }
		 
		
		 
		
		 
		 
		 function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
			
			 if( ! empty( $_POST['wcps_up_sell_product_price'] )  ||  ! empty( $_POST['wcps_product_monthlyprice'] ) ) {
			
                                     $upsell = $_POST['wcps_up_sell_product_price'][0] + $_POST['wcps_up_sell_product_price'][1]; 			
			 $product = wc_get_product( $product_id );
			 $price = $product->get_price();
			
			 $cart_item_data['warranty_price'] = $price + $upsell + $_POST['wcps_product_monthlyprice'];
			 }
			 return $cart_item_data;
		}

                        function before_calculate_totals( $cart_obj ) {
			 if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			 return;
			 }
				 // Iterate through each cart item
				 foreach( $cart_obj->get_cart() as $key=>$value ) {
				 if( isset( $value['warranty_price'] ) ) {
				 $price = $value['warranty_price'];
				 $value['data']->set_price( ( $price ) );
				 }
			 }
		}
	       
	       
		
		    
}

$wcps_frontendas_fields = new WCPS_FRONTENDAS_FIELDS();
	



