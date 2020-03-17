<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>

<div class="k-checkout__swell">
    <div class="k-checkout__swell-title">You Have <span class="swell-point-balance" style="display: inline-block;">X</span> Points.</div>
	<select class="swell-redemption-dropdown"></select>
	<a class="swell-redemption-button k-button k-button--dark" href="#">Apply</a>
</div>

<div class="k-checkout__coupon">
	<!-- <p class="form-row form-row-first"> -->
		<label for="coupon_code">Coupon:</label>
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
		<!-- </p> -->
</div>
<div class="k-checkout__coupon-actions">
	<!-- <p class="form-row form-row-last"> -->
		<a type="submit" class="k-button k-button--dark" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></a>
		<!-- </p> -->
</div>

<style>
.k-checkout__swell {
  position: relative;
  width: 100%;
  padding-bottom: 2em;
  margin-bottom: 2em;
  text-align: right;
  border-bottom: 1px solid #ddd;
}
.k-checkout__swell-title {
  text-align: left;
  text-transform: uppercase;
}
.k-checkout__swell select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #dedede !important;
  border-radius: 3px !important;
}
.k-checkout__swell a {
  display: inline-block;
}
</style>