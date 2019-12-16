<?php
/**
 * Plugin Name: Digital Product Support for WooCommerce 
 * Plugin URI: https://github.com/udayroy04/wordpressplugins
 * Description: This plugin add extra product & price supported fields in single product in backend. These fields are also shown in single product page in frontend. 
 * Author: Daffodil Technology
 * Author URI: http://www.daffodilglobal.com/
 * Text Domain: dpsfwc
 * Version: 0.1
 */

function wc_ps_init() {
	
    


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WC_Product_Support' ) ) :

	
	class WC_Product_Support {

		            protected $version;
			
			public function __construct() {	
			
                                               global $woocommerce;
			           
                                                $this->version = '1.0';		

                                               // inlcude code for creating custom field in admin   
				include(plugin_dir_path(__FILE__) . 'classes/class-wc-product-custom-fields.php');    
				
				 // inlcude code for showing custom field in frontend   
				include(plugin_dir_path(__FILE__) . 'classes/class-wc-frontend-additional-support-fileds.php');   
				
				// admin notic hook
				 add_action( 'admin_notices', array($this,'wc_ps_plugin_activation') ); 		

				 // include style
				 add_action( 'wp_enqueue_scripts', array( $this, 'wc_ps_load_plugin_styles_scripts' ) );	
				 
				 // include script
				 add_action( 'admin_enqueue_scripts',  array( $this, 'dps_wc_load_scripts') );
				 
				 // plugin activation hook
				 register_deactivation_hook( __FILE__, array( 'WC_Product_Support', 'plugin_deactivation' ) );	
				 
				 // text domain
				 add_action ( 'init', array($this, 'dpsfwc_setup'));
				
			}
			
			
			
			public function get_version() {
			
				return $this->version;
				
			}
			
			function dpsfwc_setup() {
				
				 load_plugin_textdomain('dpsfwc', false, basename( dirname( __FILE__ ) ) . '/languages');
				 
			}
		
		
		            public function wc_ps_plugin_activation(){         
            
				if( DIGITAL_PRODUCT_SUPPORT_FOR_WOOCOMMERCE != get_option('digital_product_support_for_woocommerce') ){				    
				    
				    add_option('digital_product_support_for_woocommerce', DIGITAL_PRODUCT_SUPPORT_FOR_WOOCOMMERCE);


                                                   if(is_plugin_active('woocommerce/woocommerce.php')) {
                       
						echo '<div class="updated notice is-dismissible">';
							    
						 echo '<p style="color:#0043ff;">'. __(
								"Woocommerce required plugin already activated.",
								'dpsfwc' ) .'</P>';
							    
						echo '</div>'; 
				       
				             }
				             else{			        
			        
						 echo '<div class="error">';			        
						      
						        
						 echo '<p style="color:red;"><strong>'. __(
								"This plugin required woocommerce plugin. Please install before use it.",
								'dpsfwc' ) .'</strong></p>';
						        
						 echo '</div>';					
					  }
            
				    
				    
				    }	
		                }
		
		
			public function wc_ps_load_plugin_styles_scripts() {
		
				      wp_enqueue_style('wc_ps_styles_scripts', plugin_dir_url(__FILE__). 'assets/css/woocommerce-support.css');					      
				
				  }
				  
			function dps_wc_load_scripts() {
				
				 wp_enqueue_script('dps_js_scripts', plugin_dir_url(__FILE__). 'assets/js/dpsf-wc.js');
				 
			}			
    
		
			function plugin_deactivation() {
		 
				           if( false == delete_option( 'digital_product_support_for_woocommerce' ) ) {  				          
					 flush_rewrite_rules();				           
				           }				           
				}

}
endif;
$wc_product_support = new WC_Product_Support();


}
add_action( 'plugins_loaded', 'wc_ps_init' );




