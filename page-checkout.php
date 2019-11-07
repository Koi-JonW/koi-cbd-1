<?php
/* Template Name: 2019 Checkout Page */

if (!defined('ABSPATH')) {
	exit;
}

get_header();

$checkout = WC()->checkout();

do_action('k_before_first_section');
?>

<section class="k-checkout k-block k-block--md k-no-padding--top" style="padding-top: 1em !important;">
	<div class="k-inner k-inner--md">
		<h1 class="k-headline k-headline--md">Checkout</h1>
		<?php
			do_action('woocommerce_before_checkout_form', $checkout);
			
			// If checkout registration is disabled and not logged in, the user cannot checkout.
			if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
				echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
				return;
			}
			// do_action('woocommerce_before_checkout_form', $checkout);
		?>
		<form
			name="checkout"
			method="post"
			class="k-form checkout woocommerce-checkout"
			action="<?php echo esc_url(wc_get_checkout_url()); ?>"
			enctype="multipart/form-data"
		>

		<?php if ($checkout->get_checkout_fields()) : ?>

			<?php do_action('woocommerce_checkout_before_customer_details'); ?>

			<div class="k-form--columns" id="customer_details">
				<div class="k-form--columns__col">
					<?php do_action('woocommerce_checkout_billing'); ?>
				</div>

				<div class="k-form--columns__col">
					<?php do_action('woocommerce_checkout_shipping'); ?>
				</div>
			</div>

			<?php do_action('woocommerce_checkout_after_customer_details'); ?>

		<?php endif; ?>

		<?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

		<?php do_action('woocommerce_checkout_before_order_review'); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
			<?php do_action('woocommerce_checkout_order_review'); ?>
		</div>

		<?php
			do_action('woocommerce_checkout_after_order_review'); 
			do_action('woocommerce_after_checkout_form', $checkout);
		?>
		</form>
	</div>
</section>
<?php
get_footer();
?>
