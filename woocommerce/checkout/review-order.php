<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="k-review-order k-block">
	
	<div class="k-review-order--titlerow">
		<p class="k-weight--lg"><?php _e( 'Product', 'woocommerce' ); ?></p>
		<p class="k-weight--lg"><?php _e( 'Total', 'woocommerce' ); ?></p>
	</div>

	<div class="k-review-order--main">
	<?php
		do_action('woocommerce_review_order_before_cart_contents');

			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$running_bundle_total = 0;
				$running_bundle_full_price = 0;

				if (wc_pb_is_bundle_container_cart_item($cart_item)) {
					$bundled_cart_items = wc_pb_get_bundled_cart_items($cart_item);
					$discount_amount = reset(wc_get_product($_product->get_id())->get_bundled_items())->get_discount() / 100;

					foreach($bundled_cart_items as $bundled_cart_item) {
						$bundled_product = wc_get_product($bundled_cart_item['variation_id']);
						$price = floatval($cart_item['data']->get_price());
						$price_with_discount = number_format($price - ($discount_amount * $price), 2);
						$running_bundle_total += $price_with_discount * $bundled_cart_item['quantity'];
						$running_bundle_full_price += $price * $bundled_cart_item['quantity'];
					}
				}

				// Don't list out bundled items, include them as sub-items under their parent product instead.
				if (wc_pb_is_bundled_cart_item($cart_item)) {
					continue;
				}

				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
					?>
					<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
						<div class="product-name">
							<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;'; ?>
							<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times; %s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
							<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
						</div>
						<div class="product-total">
							<p class="k-bigtext">
								<?php if ($_product->get_type() !== 'bundle'): ?>
									<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
								<?php else: ?>
									<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
									<?php // echo '$'.$running_bundle_total; ?>
									<?php // echo '<span class="k-strikethrough">'.$running_bundle_full_price.'</span>'; ?>
								<?php endif; ?>
							</p>
						</div>
						<?php if (wc_pb_is_bundle_container_cart_item($cart_item)) :
							$bundled_cart_items = wc_pb_get_bundled_cart_items($cart_item);
							$discount_amount = reset(wc_get_product($_product->get_id())->get_bundled_items())->get_discount() / 100; ?>
							<div class="product-bundleditems">
								<h4 style="margin-bottom: 0;">Bundled items:</h4>
								<ul>
									<?php
									foreach($bundled_cart_items as $bundled_cart_item) :
										$bundled_product = wc_get_product($bundled_cart_item['variation_id']);
										$price = floatval($cart_item['data']->get_price());
										$price_with_discount = number_format($price - ($discount_amount * $price), 2);
										$running_bundle_total += $price_with_discount * $bundled_cart_item['quantity'];
										$running_bundle_full_price += $price * $bundled_cart_item['quantity'];
										?>
										
										<li>
											<a href="<?php echo $cart_item['data']->get_permalink(); ?>"><?php echo $cart_item['data']->get_name(); ?></a>
											<!--<p><span>Bundled price: </span><?php // echo $price_with_discount . '<sup>' . ($discount_amount * 100) . '% off!</sup>'; ?></p> -->
											<p><span>Quantity: </span><span><?php echo $bundled_cart_item['quantity']; ?></span></p>
										</li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
					<?php
				}
			}
			
			// Coupons
			foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
					<div class="product-name">
						<?php echo wc_cart_totals_coupon_label( $coupon ); ?>
					</div>
					<div class="product-total">
						<p class="k-bigtext">
							<?php echo wc_cart_totals_coupon_html( $coupon ); ?>
						</p>
					</div>
				</div>
			<?php endforeach; 
			
			// Shipping
			if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
			<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
				<div class="product-name">
					Shipping
				</div>
				<div class="product-total">
					<p class="k-bigtext">
						<?php WC()->cart->calculate_totals(); ?>
						<?php wc_cart_totals_shipping_html(); ?>
					</p>
				</div>
			</div>
			<?php endif; 
			
			// Fees
			foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
					<div class="product-name">
						<?php echo esc_html( $fee->name ); ?>
					</div>
					<div class="product-total">
						<p class="k-bigtext">
							<?php wc_cart_totals_fee_html( $fee ); ?>
						</p>
					</div>
				</div>
			<?php endforeach;

			// Taxes
			if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
						<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
							<div class="product-name">
								<?php echo esc_html( $tax->label ); ?>
							</div>
							<div class="product-total">
								<p class="k-bigtext">
									<?php echo wp_kses_post( $tax->formatted_amount ); ?>
								</p>
							</div>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
						<div class="product-name">
							<?php echo esc_html( WC()->countries->tax_or_vat() ); ?>
						</div>
						<div class="product-total">
							<p class="k-bigtext">
								<?php wc_cart_totals_taxes_total_html(); ?>
							</p>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<div class="k-review-order--item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
				<div class="product-name">
					<?php _e( 'Total', 'woocommerce' ); ?>
				</div>
				<div class="product-total">
					<p class="k-bigtext">
						<?php wc_cart_totals_order_total_html(); ?>
					</p>
				</div>
			</div>
			<div class="k-review-order--item k-checkout__coupon-row">
					<?php if (wc_coupons_enabled()) : ?>

						<?php wc_get_template('checkout/form-coupon.php'); ?>

						<?php /* 
						<form class="checkout_coupon woocommerce-form-coupon" method="post">
            	<div class="k-checkout__coupon">
            	  <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
								<input
									type="text"
									name="coupon_code"
									class="input-text"
									id="coupon_code" 
									placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>"
									value=""
								/>
            	</div>

            	<div class="k-checkout__coupon-actions">
            	  <a href="<?php echo site_url(); ?>/checkout/?apply_coupon=''"class="k-button k-button--dark">
            	    <?php esc_attr_e('Apply coupon', 'woocommerce'); ?>
								</a>
							</div>

						</form>

						*/ ?>

          <?php 
          endif;
          ?>				
			</div>

			<?php
			do_action( 'woocommerce_review_order_after_cart_contents' );
			?>
	</div>

	<div class="k-review-order--meta">
		
	</div>
	<?php
	if(get_field('show_in_the_footer','51')){
		echo '<br/>';
		the_field('coupon_alerts','51');
	}
	?>
	<div class="freeprod"></div>
</div>
<!-- <table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
			do_action('woocommerce_review_order_before_cart_contents');

			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

				if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
					?>
					<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
						<td class="product-name">
							<?php echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;'; ?>
							<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times; %s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); ?>
							<?php echo wc_get_formatted_cart_item_data($cart_item); ?>
						</td>
						<td class="product-total">
							<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php _e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table> -->