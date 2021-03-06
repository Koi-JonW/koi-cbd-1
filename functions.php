<?php

require_once( __DIR__ . '/helpers/veterans.php');
require_once( __DIR__ . '/helpers/member.php');
require_once( __DIR__ . '/helpers/breadcrumbs.php');

function redirect_prevent()
{
add_action('redirect_canonical','__return_false');
}
add_action('template_redirect','redirect_prevent',1);

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

// Disable admin bar and assoc. styles:
function disable_admin_bar() {
  return false;
}
add_filter('show_admin_bar', 'disable_admin_bar');

/**
 * We need a custom implementation of the "Submit order --> order details page" user flow.
 * 
 * Tapping into this Woo hook lets us redirect to a custom "thank you" template once the 
 * purchase method has been charged. This should not affect any email & automation workflows.
 */
// function go_to_thank_you($order_id) {
//   WC()->cart->empty_cart(); // otherwise this doesn't happen

//   wp_redirect(site_url() . '/order-received', 301);

//   die();
// }
// add_action('woocommerce_thankyou', 'go_to_thank_you');


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

function k_on_add_to_cart() {
  echo "<script> window.__openCart = true; </script>";
}
/**
 * Disabled flyout cart after add_to_cart due to script being received in the
 * responseText of a network request and creating a parsererror.
 */
// add_action('woocommerce_add_to_cart', 'k_on_add_to_cart');

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
  $num_selected_items = 0;

  foreach ($selected_child_items as $idx => $child_item) {
    $num_selected_items += intval($child_item['quantity']);
  }

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
      if (!$cart_item['variation_id']) {
        continue;
      }
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
include_once('partials/macros/product-review.php');
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

// remove before checkout coupon form
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


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

if(class_exists('Veterans')) {
  $veterans = new Veterans();
}

if(class_exists('Member')) {
  $member = new Member();
}

function admin_styles() {
  wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'admin_styles' );
add_action( 'login_enqueue_scripts', 'admin_styles' );

function check_login() {
  if(!is_user_logged_in()) {
    wp_redirect(home_url() . '/login');
  }
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
function register_custom_menus() {
  register_nav_menus(
    array(
      'categories-menu' => __('Shop Menu'),
      'resources-menu' => __('Resources Menu'),
      'about-menu' => __('About Menu'),
      'footer-company-menu' => __('Footer - Company Menu'),
      'footer-legal-menu' => __('Footer - Legal Menu'),
    )
  );
}
add_action('init', 'register_custom_menus');

add_action( 'woocommerce_single_product_summary', 'do_flavor_dropdown', 20);
function do_flavor_dropdown() {
  wc_get_template('single-product/flavor-dropdown.php');
}

// -- woocommerce_order_status_completed

function yotpo_create_order($order_id){

  $order = new WC_Order($order_id);
  $order_id = $order->get_id();
  $order_ip = $order->get_customer_ip_address();
  $order_user_agent = $order->get_customer_user_agent();
  $order_currency = $order->get_currency();
  $order_date = date_format(date_create($order->get_date_created()), 'Y-m-d H:i:s');

  $order_total = (float)$order->get_total();
  $order_total = number_format($order_total, 2, '-', '-');
  $order_total = str_replace('-', '', $order_total);
  $order_total = (int)str_replace('-', '', $order_total);
  
  $order_user = $order->get_user();
  $order_user_data = get_userdata($order_user->id);
  $order_user_email = $order_user_data->user_email;

  $order_coupon = $order->get_coupons();
  $order_coupon = count($order_coupon) ? end($order_coupon)['code'] : '';

  $order_items = [];

  foreach($order->get_items() as $item){
        
    $item_price = (float)$item['subtotal'];
    $item_price = number_format($item_price, 2, '-', '-');
    $item_price = str_replace('-', '', $item_price);
    $item_price = (int)str_replace('-', '', $item_price);      
  
    $order_items[] = array(
      'id'=>$item['product_id'],
      'name'=>$item['name'],
      'price_cents'=>$item_price,
      'quantity'=>$item['quantity']
    );
  }

  $order_discount_total = (float)$order->get_discount_total();
  $order_discount_total = number_format($order_discount_total, 2, '-', '-');
  $order_discount_total = str_replace('-', '', $order_discount_total);
  $order_discount_total = (int)str_replace('-', '', $order_discount_total);

  $swell_options = get_option('swell_options');
  $swell_url = 'https://app.swellrewards.com/api/v2/orders';
  $swell_data = array(
    "customer_email" => $order_user_email,
    "total_amount_cents" => $order_total,
    "currency_code" => $order_currency,
    "order_id" => $order_id,
    "status" => "paid",
    "created_at" => $order_date,
    "coupon_code" => $order_coupon,
    "ip_address" => $order_ip,
    "user_agent" => $order_user_agent,
    "discount_amount_cents" => $order_discount_total,
    "items" => $order_items
  );

  $ch = curl_init();
  
  curl_setopt($ch, CURLOPT_URL, $swell_url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($swell_data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'content-type: application/json', 
    'x-api-key: ' . $swell_options['api_key'],
    'x-guid: ' . $swell_options['guid']
  ));

  $swell_result = curl_exec($ch);

  // --

  $swell_log  = '-- [' . date('y-m-d H:i:s') . '] yotpo_create_order' . PHP_EOL;
  $swell_log .= "- customer_email: {$order_user_email}" . PHP_EOL;
  $swell_log .= "- total_amount_cents: {$order_total}" . PHP_EOL;
  $swell_log .= "- currency_code: {$order_currency}" . PHP_EOL;
  $swell_log .= "- order_id: {$order_id}" . PHP_EOL;
  $swell_log .= "- status: paid" . PHP_EOL;
  $swell_log .= "- created_at: {$order_date}" . PHP_EOL;
  $swell_log .= "- coupon_code: {$order_coupon}" . PHP_EOL;
  $swell_log .= "- ip_address: {$order_ip}" . PHP_EOL;
  $swell_log .= "- user_agent: {$order_user_agent}" . PHP_EOL;
  $swell_log .= "- discount_amount_cents: {$order_discount_total}" . PHP_EOL;
  $swell_log .= "- result:" . PHP_EOL;
  $swell_log .= $swell_result . PHP_EOL;
  $swell_log .= "--" . PHP_EOL;

  file_put_contents('yotpo-api.log', $swell_log, FILE_APPEND);

}

add_action('woocommerce_order_status_completed', 'yotpo_create_order');

function wc_checkout_form_save_data_on_reload() {
    if(is_wc_endpoint_url( 'order-received' )) { //clear session storage
?>
<script type="text/javascript">
  sessionStorage.removeItem("billing_first_name");
  sessionStorage.removeItem("billing_last_name");
  sessionStorage.removeItem("billing_company");
  sessionStorage.removeItem("billing_phone");
  sessionStorage.removeItem("billing_email");
  sessionStorage.removeItem("order_comments");
  sessionStorage.removeItem("ship-to-different-address");
  sessionStorage.removeItem("shipping_first_name");
  sessionStorage.removeItem("shipping_last_name");
  sessionStorage.removeItem("shipping_company");
</script>
<?php
    }

    if ( ! is_checkout() ) return;
    
?>
<script type="text/javascript">
window.onload = function() {
  jQuery(function($){
    if (sessionStorage.getItem('billing_first_name') == "billing_first_name") {
      return;
    }

    let billing_first_name = sessionStorage.getItem('billing_first_name');
    if (billing_first_name !== null) $('#billing_first_name').val(billing_first_name);

    let billing_last_name = sessionStorage.getItem('billing_last_name');
    if (billing_last_name !== null) $('#billing_last_name').val(billing_last_name);

    let billing_company = sessionStorage.getItem('billing_company');
    if (billing_company !== null) $('#billing_company').val(billing_company);

    let billing_phone = sessionStorage.getItem('billing_phone');
    if (billing_phone !== null) $('#billing_phone').val(billing_phone);

    let billing_email = sessionStorage.getItem('billing_email');
    if (billing_email !== null) $('#billing_email').val(billing_email);

    let order_comments = sessionStorage.getItem('order_comments');
    if (order_comments !== null) $('#order_comments').val(billing_phone);


    let shipping_different_address = sessionStorage.getItem('ship-to-different-address');
    if (shipping_different_address !== null) $('#ship-to-different-address').val(shipping_different_address);

    if(shipping_different_address){

      $('#ship-to-different-address').trigger('click');

      let shipping_first_name = sessionStorage.getItem('shipping_first_name');
      if (shipping_first_name !== null) $('#shipping_first_name').val(shipping_first_name);

      let shipping_last_name = sessionStorage.getItem('shipping_last_name');
      if (shipping_last_name !== null) $('#shipping_last_name').val(shipping_last_name);

      let shipping_company = sessionStorage.getItem('shipping_company');
      if (shipping_company !== null) $('#shipping_company').val(shipping_company);
    }

  });
}

window.onbeforeunload = function() {
  jQuery(function($){
    sessionStorage.setItem("billing_first_name", $('#billing_first_name').val());
    sessionStorage.setItem("billing_last_name", $('#billing_last_name').val());
    sessionStorage.setItem("billing_company", $('#billing_company').val());
    sessionStorage.setItem("billing_phone", $('#billing_phone').val());
    sessionStorage.setItem("order_comments", $('#order_comments').val());

    let shipping_different_address = $("#ship-to-different-address").is(':checked');
    sessionStorage.setItem("ship-to-different-address", shipping_different_address);

    if(shipping_different_address){
      sessionStorage.setItem("shipping_first_name", $('#shipping_first_name').val());
      sessionStorage.setItem("shipping_last_name", $('#shipping_last_name').val());
      sessionStorage.setItem("shipping_company", $('#shipping_company').val());
    }
  });
}
</script>
<?php
}
add_action('wp_footer', 'wc_checkout_form_save_data_on_reload', 50);

// -- Yoast

function get_post_title($post): string {
  if($post){
    $yoast_title = get_post_meta($post->ID, '_yoast_wpseo_title', true);
    if (empty($yoast_title)) {
        $wpseo_titles = get_option('wpseo_titles', []);
        $yoast_title = isset($wpseo_titles['title-' . $post->post_type]) ? $wpseo_titles['title-' . $post->post_type] : get_the_title();
    }
    return wpseo_replace_vars($yoast_title, $post);
  } else {
    return '';
  }
}

function get_post_description($post): string {
  if($post){
    $yoast_description = get_post_meta($post->ID, '_yoast_wpseo_metadesc', true);
    if (empty($yoast_description)) {
        $wpseo_titles = get_option('wpseo_titles', []);
        $yoast_description = isset($wpseo_titles['metadesc-' . $post->post_type]) ? $wpseo_titles['metadesc-' . $post->post_type] : '';
    }
    return wpseo_replace_vars($yoast_description, $post);
  } else {
    return '';
  }
}
add_action( 'woocommerce_after_shipping_rate', 'action_after_shipping_rate', 20, 2 );
function action_after_shipping_rate ( $method, $index ) {
    // Targeting checkout page only:
    if( is_cart() ) return; // Exit on cart page

    if( 'free_shipping:1' === $method->id ) {
        echo __('<div style="font-size:12px; color:#666666;">10-14 Bus. Days (Shipping times may be longer due to carrier volume)</div>');
    }
    if( 'local_pickup:20' === $method->id ) {
        echo __('<div style="font-size:12px; color:#666666;">5-7 Bus. Days (Shipping times may be longer due to carrier volume)</div>');
    }
}


// NEW POSTS TYPES
function create_posttype() {
 
    register_post_type( 'movies',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Movies' ),
                'singular_name' => __( 'Movie' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'movies'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

register_post_type(
    'Movies',
    array(
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array(
            'slug'       => 'my_post_type',
            'with_front' => false,
        ),
        'supports' => array(
            'page-attributes' /* This will show the post parent field */,
            'title',
            'editor',
            'something-else',
        ),
        // Other arguments
    )
);




// Adds password-confirmation to user registration page (/my-account/)
add_filter( 'woocommerce_register_form', 'pixel_registration_password_repeat', 9 );
// Priority 10 will probably work for you, but in my situation, 
// a reCAPTCHA element loads between the password boxes, so I used 9.
function pixel_registration_password_repeat() {
    ?>
    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
        <label for="password_confirm"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="password" class="input-text" name="password_confirm" id="password_confirm">
    </p>
    <?php
}


// Adds password-confirmation to user registration during checkout phase
add_filter( 'woocommerce_checkout_fields', 'pixel_checkout_registration_password_repeat', 10, 1 );
function pixel_checkout_registration_password_repeat( $fields ) {
    if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) {
        $fields['account']['account_password_confirm'] = array(
            'type'        => 'password',
            'label'       => __( '', 'woocommerce' ),
            'required'    => true,
            'placeholder' => esc_attr__( 'Confirm password', 'woocommerce' )
        );
    }
    return $fields;
}


// Form-specific password validation step.
add_filter( 'woocommerce_registration_errors', 'pixel_validate_registration_passwords', 10, 3 );
function pixel_validate_registration_passwords( $errors, $username, $email ) {
    global $woocommerce;
    extract( $_POST );

    if ( isset( $password ) || ! empty( $password ) ) {
        // This code runs for new user registration on the /my-account/ page.
        if ( strcmp( $password, $password_confirm ) !== 0 ) {
            return new WP_error( 'registration-error', __( 'Passwords do not match', 'woocommerce' ) );
        }
    } else if ( isset( $account_password ) || ! empty( $account_password ) ) {
        // This code runs for new user registration during checkout process.
        if ( strcmp( $account_password, $account_password_confirm ) !== 0 ) {
            return new WP_error( 'registration-error', __( 'Passwords do not match', 'woocommerce' ) );
        }
    }

    return $errors;
}