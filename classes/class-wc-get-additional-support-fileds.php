<?php
/**
 * Followig class handling frontend inputs  
 * dependencies. Do not make changes in code
 * Create on: 5 November, 2019 
 **/

class WCPS_AS_FIELDS{

                       /**
			 * __construct function.
			 *
			 * @access public
			 * @param 
		  **/

		 public  function __construct() {			    
			    
			add_action('woocommerce_before_add_to_cart_button', array( $this, 'wcps_support_custom_field') );   			
		           add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data'), 58, 3 );
		           add_action( 'woocommerce_before_calculate_totals', array( $this, 'before_calculate_totals'), 58, 1 );
		       
		 }	
		 
		 
		 /**
		   * creating create fields in single product page
		  **/
		 function wcps_support_custom_field(){
			 
		   global $product;	 
		   
		   global $woocommerce;
		   
		   if ($product->is_downloadable('yes')) {   
		   $id = $product->get_id();
		    
		 ?>	            
			
		<div class="digital-product-form-container">
			<div class="products wcps <?php  echo $id; ?>">
						  
		 <?php				  
			 
			$args = array( 
			        'post_type' => 'product',
			        'p' => $id,
			        'posts_per_page' => -1, 
			        'orderby' => 'ASC' ,
				
			          'meta_query' =>
			       array(
			         'relation' => 'AND' ,    

					      array(
						'key' => '_downloadable',
						'value' => 'yes',
						'compare' => '=',	
					       ),
					       
					       array(
						'key' => '_wcps_up_sell_product',
						'value' => 'allow',
						'compare' => '=',	
					       ),
					       array(
						'key' => 'support_price',
						'value' => 'allow',	
						'compare' => '=',
					       ),  
					       
					 ) 					        
			 );
			        
			 $loop = new WP_Query( $args );    
			
			    
			 if ( $loop->have_posts() ) :
			    
			  echo  '<p id="value-on-single-product"><select name="wcps_product_monthlyprice" class="wcps_product_monthlyprice">';
			
			 while ( $loop->have_posts() ) : $loop->the_post();                                                    
				         
				        $permalink = get_permalink($loop->post->ID);
				        $title = $loop->post->post_title;
				        $ID = $loop->post->ID;
				        
			
			
		 $support_frontend = get_post_meta($ID,'support',true);				
			
		$currency = get_woocommerce_currency_symbol();
		$c = 0;
		       
		       if (!empty($support_frontend)) :
		       if ( count( $support_frontend ) > 0 ) {
				foreach( $support_frontend as $track ) {
				    if ( isset( $track['month'] ) || isset( $track['support_price'] ) ) {				    
					
				  echo  '<option value="' . esc_html($track['support_price']) . '">'. esc_html($track['month']) .' Month Service Support - '. $currency . esc_html($track['support_price']) .'</option>';	
				  
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
					       
					$permalink = get_permalink($loop->post->ID);							      
					$ID = $loop->post->ID;
					$_wcps_up_sell_product_field = get_post_meta($ID, '_wcps_up_sell_product_field', true);       
					
					       
			if ( $_wcps_up_sell_product_field ) :
			
			foreach ( $_wcps_up_sell_product_field as $field ) {
				$name =  sanitize_text_field($field['name']);
				$price =  floatval($field['price']);
				 echo  '<label><input type="checkbox" class="wcps_up_sell_product_price"  name="wcps_up_sell_product_price[]" value="'. esc_html($price).'"/> <span class="upsell title">'. esc_html($name) . '</span><span class="upsell price"> ' . $currency .' '. $price .'</span></label>';
			
				echo  '<input type="hidden" name="wcps_product_id" value="'. $ID .' " class="wcps-product-id">';
				
				

			}	
			endif;
					   endwhile;

					   wp_reset_postdata();
					  
					  echo  '</p></p>';	

			else :

					 echo  '<p>No support products found<p>';

			endif;		      
					         
					wp_reset_query();
					     ?>
				
			</div>	   
		 </div>
		 <?php	

		      }  //end if
		   }
		 
		 
		
		
		
		 
		 /**
		   * creating add fields value in add to cart
		  **/
		 function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
			
			 if( ! empty( $_POST['wcps_up_sell_product_price'] )  ||  ! empty( $_POST['wcps_product_monthlyprice'] ) ) {
			
                                     $upsell = $_POST['wcps_up_sell_product_price'][0] + $_POST['wcps_up_sell_product_price'][1]; 			
			 $product = wc_get_product( $product_id );
			 $price = $product->get_price();
			
			 $cart_item_data['warranty_price'] = $price + $upsell + $_POST['wcps_product_monthlyprice'];
			 }
			 return $cart_item_data;
		}

                         /**
		   * calculating extra fields price in in cart
		 **/
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

$wcps_as_fields = new WCPS_AS_FIELDS();
	



