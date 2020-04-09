<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

	<?php endif; ?>

	<h2 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'woocommerce' ); ?></h2>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_billing_address( __( 'N/A', 'woocommerce' ) ) ); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
		<?php endif; ?>
	</address>

	<?php if ( $show_shipping ) : ?>

		</div><!-- /.col-1 -->

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
			<h2 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'woocommerce' ); ?></h2>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( __( 'N/A', 'woocommerce' ) ) ); ?>
			</address>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
</div>
</div>

<?php
$current_user = wp_get_current_user();
$username = $current_user->display_name;
?>
<script type="text/javascript">
function close_yp(){
	document.getElementById('banner-thank-you').style.display = "none";
}
</script>

<section id="banner-thank-you" style="display:block; position:relative !important; padding:50px 0px !important; z-index:0;">
	<!-- <div class="close-yellow" onclick="close_yp();">X</div>--><!--end close-yellow-->
    <!--<p>Thanks! <?php echo $username; ?></p>-->
    <div class="banner-row responsive-area-yp">
        <div class="banner-left">
            <img src="<?php the_field('left_image','options'); ?>" alt="" class="img-desktop">
            <!--<img src="<?php the_field('left_image_mobile','options'); ?>" alt="" class="img-mobile">-->
        </div>
        <div class="banner-right">
            <div class="banner-step-2">
                <div class="banner-above-titles-v3"><?php the_field('banner_above_title','options'); ?></div>
                <div class="banner-titles-v3"><?php the_field('banner_title','options'); ?></div>
                <div class="banner-description-v3"><?php the_field('banner_content','options'); ?></div>
                <div class="banner-underline"></div>
                <div class="button-text-below"><?php the_field('text_below_line','options'); ?></div>
                <div class="yotpo-box">
                    <input type="text" id="referred-customers-input" class="input-text" placeholder="Your friends' emails (separated by commas)">
                    <a href="#" id="referred-customers-send-btn" class="k-button k-button--primary">Send</a>
                </div>
            </div>
            <div class="banner-step-3" style="display: none;">
                <div class="banner-titles-v3">Thanks for referring</div>
                <div class="banner-above-titles-v3">Remind your friends to check their emails</div>
                <div class="yotpo-box">
                    <a id="thank-you-back" href="#" class="k-button k-button--primary">Refer More Friends</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	var $ = jQuery.noConflict();
</script>
<script>

    var step_2 = $('.banner-step-2');
    var step_3 = $('.banner-step-3');

    // --

    $('#referred-customers-send-btn').on('click', function(e) {

        e.preventDefault();

        var onSuccess = function() {
            step_2.hide();
            step_3.show();
        }

        var onError = function(err, log=true) {
            alert('Oops! It looks like we\'re having trouble finding what you\'re looking for. Please try again later.');
            if(log){
                console.log('-- sendReferralEmails Error');
                console.log(err);
            }
        }

        var emails = $('#referred-customers-input').val().split(',');

        try {
            swellAPI.sendReferralEmails(emails, onSuccess, onError);
        } catch(err) {
            console.log('-- sendReferralEmails Exception');
            console.log(err);
            onError(err, false);
        }

        });

        // --

        $('#thank-you-back').on('click', function(e){

            step_2.hide();
            step_3.hide();

        });

</script>
<div class="k-inner k-inner--md">
<div class="woocommerce-order">

