<?php

require_once( __DIR__ . '/helpers/members.php');

if (function_exists('acf_add_options_page')) {
	$parent = acf_add_options_page(array(
		'page_title' => 'Site Content',
		'menu_title' => 'Site Content',
		'redirect' => false
	));
	
	acf_add_options_sub_page(array(
		'page_title' => 'Homepage',
		'menu_title' => 'Homepage',
		'parent_slug' => $parent['menu_slug'],
  ));
  
  acf_add_options_sub_page(array(
		'page_title' => 'About Us',
		'menu_title' => 'About Us',
		'parent_slug' => $parent['menu_slug'],
	));
}

/**
 * We need a custom implementation of the "Submit order --> order details page" user flow.
 * 
 * Tapping into this Woo hook lets us redirect to a custom "thank you" template once the 
 * purchase method has been charged. This should not affect any email & automation workflows.
 */
function go_to_thank_you($order_id) {
  WC()->cart->empty_cart(); // otherwise this doesn't happen

  wp_redirect(site_url() . '/order-received', 301);

  die();
}
add_action('woocommerce_checkout_order_processed', 'go_to_thank_you');

// == begin AJAX fn's == //
/**
 * Create new veteran user
 * 
 * Required for veteran program signup.
 * 
 * 
 */
function k_ajax_create_veteran_user() {
  $email = $_POST['email'];
  $password = $_POST['password'];

  wp_insert_user(array(
    'user_login' => $email,
    'user_email' => $email,
    'user_pass' => $password,
    'role' => 'veteran',
  ));

  wp_send_json(get_user_by('email', $email));

  die();
}
add_action('wp_ajax_create_veteran_user', 'k_ajax_create_veteran_user');
add_action('wp_ajax_nopriv_create_veteran_user', 'k_ajax_create_veteran_user');

function k_ajax_customer_logout() {
  wp_logout();

  wp_send_json(array('logged_out' => true));

  die();
}
add_action('wp_ajax_customer_logout', 'k_ajax_customer_logout');
add_action('wp_ajax_nopriv_customer_logout', 'k_ajax_customer_logout');

/**
 * Add product to cart
 * args - product_id
 */
function k_ajax_add_product() {
  $product_id = intval($_POST['product_id']);
  $quantity = intval($_POST['quantity']);

  WC()->cart->add_to_cart($product_id, $quantity);

  wp_send_json(WC()->cart->get_cart());

  die();
}
add_action('wp_ajax_add_product', 'k_ajax_add_product');
add_action('wp_ajax_nopriv_add_product', 'k_ajax_add_product');

/**
 * Add bundle to cart
 * args - product_id, selected_child_items[]
 * 
 * selected_child_items is an array of products. Each product must have this shape:
 * array(
 *   *-- required props --*
 *   'product_id' => 401123,
 *   'bundled_product_key' => 7, // WC_Product_Bundle->get_bundled_items() to get at this data
 *   'quantity' => 1,
 *
 *   *-- you only need the below props if this bundle is made up of WC_Product_Variable --*
 *   'variation_id' => 123456, // WC_Product_Variable['variation_id'] or WC_Product_Bundle->get_available_variations()
 *   'attributes' => array(
 *     'strength' => '250 MG', // WC_Product_Vairable->get_attributes()
 *   )
 * )
 */
function k_ajax_add_bundle_to_cart() {
  $product_id = intval($_POST['product_id']);
  $selected_child_items = $_POST['selected_child_items'];

  /**
   * Even though we're checking this client-side, we need server-side checking
   * to make sure that no one can spoof min/max items from the client by changing
   * data-attr's.
   * 
   * There was a plugin managing this (WC Product Bundles - Min/Max Items) but it 
   * was a total clusterfuck to integrate with. This is a quick workaround.
   */
  $product_acf = get_fields($product_id);
  $min_items = intval($product_acf['min_items']);
  $max_items = intval($product_acf['max_items']);
  $num_selected_items = count($selected_child_items);

  if ($num_selected_items < $min_items) {
    $err = new WP_Error('num_items_err', __('Expected minimum '.$min_items.' items, received '.$num_selected_items.' items'));
    
    wp_send_json_error($err, 400);
    
    die();
  }

  if ($num_selected_items > $max_items) {
    $err = new WP_Error('num_items_err', __('Expected maximum '.$max_items.' items, received '.$num_selected_items.' items'));
    
    wp_send_json_error($err, 400);
    
    die();
  }

  /**
   * The array passed to add_bundle_to_cart() must be indexed by the
   * item keys that you get from WC_Product_Bundle->get_bundled_items(). 
   * 
   * This array is not necessarily 0-indexed as you may expect.
   */
  $reshaped_items = array();
  foreach($selected_child_items as $index => $item) {
    $reshaped_items[$item['bundled_product_key']] = $item;
  }

  WC_PB()->cart->add_bundle_to_cart($product_id, 1, $reshaped_items);

  k_ajax_get_cart();
  
  die();
}
add_action('wp_ajax_add_bundle', 'k_ajax_add_bundle_to_cart');
add_action('wp_ajax_nopriv_add_bundle', 'k_ajax_add_bundle_to_cart');

/**
 * Get cart contents
 * no args
 */
function k_ajax_get_cart() {
  $cart_items = WC()->cart->get_cart();
  $response = array();
  $expanded = array();

  foreach($cart_items as $index => $cart_item) {
    $product = wc_get_product($cart_item['product_id']);

    if ($product->get_type() == 'variable') {
      $product = wc_get_product($cart_item['variation_id']);
    } else {
      $product = wc_get_product($cart_item['product_id']);
    }

    $product_data = $product->get_data();
    
    $_product = array(
      'name' => $product_data['name'],
      'permalink' => $product->get_permalink(),
      'thumbnail_url' => wp_get_attachment_image_url($product->get_image_id()),
      'quantity' => $cart_item['quantity'],
      'price' => $product->get_price(),
      'is_bundle' => wc_pb_is_bundle_container_cart_item($cart_item),
      'is_bundled_item' => wc_pb_is_bundled_cart_item($cart_item),
      'key' => $cart_items[$index]['key'],
    );
    $cart_items[$index]['product_name'] = $_product['name'];

    array_push($expanded, $_product);
  }

  // some AJAX fn's need the actual cart items, which have a different shape/schema than the actual products they represent
  $response['cart_items'] = $cart_items;
  // and other fn's need more granular product data
  $response['expanded_products'] = $expanded;

  wp_send_json($response);
  
  die();
}
add_action('wp_ajax_k_get_cart', 'k_ajax_get_cart');
add_action('wp_ajax_nopriv_k_get_cart', 'k_ajax_get_cart');

/**
 * Remove a single item from cart
 * args - product_id
 * 
 * Update - replaceed this with standard WC remove item from cart fn
 */
// function k_ajax_remove_cart_item() {
//   $this_item_key = intval($_POST['cart_item_key']);
//   $cart_items = WC()->cart->get_cart();

//   foreach ($cart_items as $cart_item_key => $cart_item) {
//     if ($cart_item_key == $this_item_key) {
//       WC()->cart->remove_cart_item($cart_item_key);
//     }
//   }

//   k_ajax_get_cart();

//   die();
// }
// add_action('wp_ajax_remove_cart_item', 'k_ajax_remove_cart_item');
// add_action('wp_ajax_nopriv_remove_cart_item', 'k_ajax_remove_cart_item');

/**
 * Remove all items from cart
 * no args
 */
function k_ajax_remove_all_cart_items() {
  WC()->cart->empty_cart();

  k_ajax_get_cart();

  die();
}
add_action('wp_ajax_remove_all_cart_items', 'k_ajax_remove_all_cart_items');
add_action('wp_ajax_nopriv_remove_all_cart_items', 'k_ajax_remove_all_cart_items');

function k_decrement_cart_item() {
  $cart_item_key = $_POST['cart_item_key'];
  $cart_item_quantity = intval($_POST['cart_item_quantity']);

  $new_quantity = --$cart_item_quantity;

  WC()->cart->set_quantity($cart_item_key, $new_quantity);

  wp_redirect($_SERVER['HTTP_REFERRER']);

  die();
}
add_action('wp_ajax_decrement_cart_item', 'k_decrement_cart_item');
add_action('wp_ajax_nopriv_decrement_cart_item', 'k_decrement_cart_item');

function k_increment_cart_item() {
  $cart_item_key = $_POST['cart_item_key'];
  $cart_item_quantity = intval($_POST['cart_item_quantity']);

  var_dump($cart_item_key, $cart_item_quantity);

  $new_quantity = ++$cart_item_quantity;

  WC()->cart->set_quantity($cart_item_key, $new_quantity);

  wp_redirect($_SERVER['HTTP_REFERRER']);

  die();
}
add_action('wp_ajax_increment_cart_item', 'k_increment_cart_item');
add_action('wp_ajax_nopriv_increment_cart_item', 'k_increment_cart_item');

function k_update_item_quantity() {
  $cart_item_key = $_POST['cart_item_key'];
  $cart_item_new_quantity = intval($_POST['cart_item_quantity']);

  WC()->cart->set_quantity($cart_item_key, $cart_item_new_quantity);

  die();
}
add_action('wp_ajax_update_item_quantity', 'k_update_item_quantity');
add_action('wp_ajax_nopriv_update_item_quantity', 'k_update_item_quantity');

function k_update_all_item_quantities() {
  $update_keys = $_POST['cart_item_keys'];
  $update_quantities = $_POST['cart_item_quantities'];

  $cart_items = WC()->cart->get_cart();

  foreach($update_keys as $index => $key) {
    WC()->cart->set_quantity($key, intval($update_quantities[$index]));
  }

  die();
}
add_action('wp_ajax_update_all_item_quantities', 'k_update_all_item_quantities');
add_action('wp_ajax_nopriv_update_all_item_quantities', 'k_update_all_item_quantities');
// == end AJAX fn's == //



// == begin macros -- reuseable components that can take args and spit out HTML == //
include_once('partials/macros/hero.php');
include_once('partials/macros/product-card.php');
include_once('partials/macros/product-video.php');
include_once('partials/macros/article-card.php');
// == end macros == //



// == begin helpers -- you know, helpers. They help. == //
function k_before_first_section() {
  echo '<div id="k-headermargin"></div>';
}
add_action('k_before_first_section', 'k_before_first_section');

function k_spacer() {
  echo '<div class="k-block k-block--md k-no-padding--bottom"></div>';
}
add_action('k_spacer', 'k_spacer');
// == end helpers == //


// == begin plugin stuff == //
function add_wc_support() {
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'add_wc_support');
// == end plugin stuff == //


/**
 * BEGIN STUFF FROM ORIGINAL THEME'S FUNCTIONS.PHP
 * 
 * I don't know what's going on in here but some of it's necessary for sure
 */


//
// Recommended way to include parent theme styles.
//  (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
//  
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}
//
// Your code goes below
//

add_filter( 'woocommerce_apply_base_tax_for_local_pickup', '__return_false' );



add_filter( 'et_project_posttype_rewrite_args', 'wpc_projects_slug', 10, 2 );
function wpc_projects_slug( $slug ) {
$slug = array( 'slug' => 'lab-result' );
return $slug;
}


add_filter('um_account_page_default_tabs_hook', 'my_custom_tab_in_um', 100 );
function my_custom_tab_in_um( $tabs ) {
	$tabs[800]['veterans']['icon'] = 'um-icon-android-star';
	$tabs[800]['veterans']['title'] = "Apply For Military Discount";
	$tabs[800]['veterans']['custom'] = true;
	return $tabs;
}
	
/* make our new tab hookable */

add_action('um_account_tab__veterans', 'um_account_tab__veterans');
function um_account_tab__veterans( $info ) {
	global $ultimatemember;
	extract( $info );

	$output = $ultimatemember->account->get_tab_output('veterans');
	if ( $output ) { echo $output; }
}

/* Finally we add some content in the tab */

add_filter('um_account_content_hook_veterans', 'um_account_content_hook_veterans');
function um_account_content_hook_veterans( $output ){
	ob_start();
	?>
		
	<div style="text-align: center;" class="um-field">
	<p id="veteran-heading" >To Thank All 
The Men & Women Who've Served Our Country, Koi Offers All Members of The 
United States Military Access To Our Veteran Discount Program</p>

	<a id="veteran-button" href="https://koicbd.com/veteran-application/">Apply Now</a>

	</div>		
		
	<?php
		
	$output .= ob_get_contents();
	ob_end_clean();
	return $output;
}

// Custom Return To Shop URL

function wc_empty_cart_redirect_url() {
	return '/';
}
add_filter( 'woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url' );


// Custom No Shipping Error


add_filter( 'woocommerce_cart_no_shipping_available_html', 'change_msg_no_available_shipping_methods', 10, 1  );
add_filter( 'woocommerce_no_shipping_available_html', 'change_msg_no_available_shipping_methods', 10, 1 );
function change_msg_no_available_shipping_methods( $default_msg ) {
    $custom_msg = "Sorry, but Koi CBD does not ship internationally. If you are located outside of the U.S. try ordering through <a href='http://www.koicbd.co.uk/'>www.koicbd.co.uk</a> or <a href='http://www.cbdcanadakoi.com/'>www.cbdcanadakoi.com</a> if you are in Canada.";
    if( empty( $custom_msg ) ) {
      return $default_msg;
    }
    
    return $custom_msg;
}
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');


// Create and display the custom field in product general setting tab
add_action( 'woocommerce_product_options_general_product_data', 'add_custom_field_general_product_fields' );
function add_custom_field_general_product_fields(){
    global $post;

    echo '<div class="product_custom_field">';

    // Custom Product Checkbox Field
    woocommerce_wp_checkbox( array(
        'id'        => '_disabled_for_coupons',
        'label'     => __('Disabled for coupons', 'woocommerce'),
        'description' => __('Disable this products from coupon discounts', 'woocommerce'),
        'desc_tip'  => 'true',
    ) );

    echo '</div>';;
}

// Save the custom field and update all excluded product Ids in option WP settings
add_action( 'woocommerce_process_product_meta', 'save_custom_field_general_product_fields', 10, 1 );
function save_custom_field_general_product_fields( $post_id ){

    $current_disabled = isset( $_POST['_disabled_for_coupons'] ) ? 'yes' : 'no';

    $disabled_products = get_option( '_products_disabled_for_coupons' );
    if( empty($disabled_products) ) {
        if( $current_disabled == 'yes' )
            $disabled_products = array( $post_id );
    } else {
        if( $current_disabled == 'yes' ) {
            $disabled_products[] = $post_id;
            $disabled_products = array_unique( $disabled_products );
        } else {
            if ( ( $key = array_search( $post_id, $disabled_products ) ) !== false )
                unset( $disabled_products[$key] );
        }
    }

    update_post_meta( $post_id, '_disabled_for_coupons', $current_disabled );
    update_option( '_products_disabled_for_coupons', $disabled_products );
}

// Make coupons invalid at product level
add_filter('woocommerce_coupon_is_valid_for_product', 'set_coupon_validity_for_excluded_products', 12, 4);
function set_coupon_validity_for_excluded_products($valid, $product, $coupon, $values ){
    if( ! count(get_option( '_products_disabled_for_coupons' )) > 0 ) return $valid;

    $disabled_products = get_option( '_products_disabled_for_coupons' );
    if( in_array( $product->get_id(), $disabled_products ) )
        $valid = false;

    return $valid;
}

// Set the product discount amount to zero
add_filter( 'woocommerce_coupon_get_discount_amount', 'zero_discount_for_excluded_products', 12, 5 );
function zero_discount_for_excluded_products($discount, $discounting_amount, $cart_item, $single, $coupon ){
    if( ! count(get_option( '_products_disabled_for_coupons' )) > 0 ) return $discount;

    $disabled_products = get_option( '_products_disabled_for_coupons' );
    if( in_array( $cart_item['product_id'], $disabled_products ) )
        $discount = 0;

    return $discount;
}

if(class_exists('Members')) {
  $members = new Members();
}