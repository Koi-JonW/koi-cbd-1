<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$checkout = WC()->checkout();
$cart = WC()->cart;
$user_id = get_current_user_id();
$user_data = get_userdata($user_id);

/**
 * Veterans get a 25% discount automatically applied in the form of a special coupon.
 */
function is_valid_veteran() {
	global $user_id;
	global $user_data;
	global $cart;

	// Accounts with 'veteran' role created before the new system launched get grandfathered in
	$launch_date = 1578441600; 
	$registered_before_new_system = strtotime($user_data->user_registered) < $launch_date;
	$is_legacy_veteran = in_array('veteran', $user_data->roles) && $registered_before_new_system;

	// Now check for our current setup:
	$is_valid_veteran = get_fields('user_' . $user_id)['veteran_status'] == 'Veteran Approved';

	return $is_legacy_veteran || $is_valid_veteran;
}

$veteran_coupon_already_applied = in_array('veteran coupon', $cart->get_applied_coupons());
$do_apply = is_valid_veteran() && !$veteran_coupon_already_applied;

/**
 * If the veteran coupon is not applied,
 * and the user is an approved veteran:
 */
if ($do_apply && !$veteran_coupon_already_applied) {
  $cart->apply_coupon('veteran coupon');
}
/**
 * If a non-veteran tries to use the veteran coupon, 
 * or if a valid veteran decides to remove the coupon:
 */
$valid_veteran_remove_coupon = $_GET['remove_coupon'] == 'veteran coupon';
if (!$user_is_veteran_role && $valid_veteran_remove_coupon) {
	$cart->remove_coupon('veteran coupon');
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<?php if ( is_user_logged_in() ) { ?>
<section class="k-checkout k-block k-block--md k-no-padding--top k-no-padding--bottom">
	<div class="k-inner k-inner--sm">
		<form name="checkout" method="post" class="k-form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

			<?php if ( $checkout->get_checkout_fields() ) : ?>
				
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				
					<div class="k-checkout__forms" id="customer_details">
						<div class="k-liner">
							<div class="k-checkout__billing">
								<div class="k-checkout__title">
									<div class="k-liner">
										<h3><?php esc_html_e('Billing details', 'woocommerce'); ?></h3>
									</div>
								</div>								
								<?php do_action( 'woocommerce_checkout_billing' ); ?>
							</div>
							<div class="k-checkout__shipping">
								<div class="k-checkout__title">
									<div class="k-liner">
										<h3><?php esc_html_e('Shipping details', 'woocommerce'); ?></h3>
										<div class="k-toggle-shipping">
											<input id="ship-to-different-address" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" type="checkbox" name="ship_to_different_address" value="1" /> 
											<label for="ship-to-different-address" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
												<?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?>
											</label>
										</div>
									</div>
								</div>
								<div class="k-checkout__fields">
									<div class="k-checkout__shipping-drawer" style="display: none;">
										<?php do_action('woocommerce_checkout_shipping'); ?>
									</div>
									<div class="woocommerce-additional-fields">
										<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
	
										<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>
										
											<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
											
												<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>
											
											<?php endif; ?>
											
											<div class="woocommerce-additional-fields__field-wrapper">
												<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
													<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
												<?php endforeach; ?>
											</div>
												
										<?php endif; ?>
												
										<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
									</div>
								</div>
							</div>
						</div>
		
				</div>
		
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
		
			<?php endif; ?>
			
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
		
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
		
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		
		</form>
		
		<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

	</div>
</section>
<?php
} else {
   include('register-checkout.php');
}
?>
