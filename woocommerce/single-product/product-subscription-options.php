<?php
/**
 * Product Subscription Options Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/product-subscription-options.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="select-area" style="text-align:left; font-size:initial !important;">
<div class="wcsatt-options-wrapper <?php echo esc_attr( implode( ' ', $wrapper_classes ) ); ?>" data-sign_up_text="<?php echo esc_attr( $sign_up_text ); ?>" <?php echo $hide_wrapper ? 'style="display:none;"' : ''; ?>>
	<div class="wcsatt-options-product-prompt <?php echo esc_attr( implode( ' ', $prompt_classes ) ); ?>" data-prompt_type="<?php echo esc_attr( $prompt_type ); ?>"><?php echo $prompt; ?></div>
	<div class="wcsatt-options-product-wrapper" <?php echo 'grouped' === $layout ? 'style="display:none;"' : '' ?>>
<?php

		if ( $display_dropdown ) {

			if ( $dropdown_label ) {
				?><span class="wcsatt-options-product-dropdown-label"> Frequency options: <?php // echo $dropdown_label; ?></span><?php
			}

			?><select class="wcsatt-options-product-dropdown" name="convert_to_sub_dropdown<?php echo absint( $product_id ); ?>"><?php
				foreach ( $options as $option ) {

					if ( ! $option[ 'value' ] ) {
						continue;
					}

					?>
<?php $sub = $option[ 'dropdown' ]; ?>
<option value="<?php echo esc_attr( $option[ 'value' ] ); ?>" data-title="SUBSCRIBE & SAVE <?php echo substr($sub,-8,-5); ?>" ><?php echo $option[ 'dropdown' ]; ?></option><?php
				}
			?></select><?php
		}

		?><ul class="wcsatt-options-product wcsatt-options-product--<?php echo $display_dropdown ? 'hidden' : ''; ?>"><?php
			foreach ( $options as $option ) {
				?><li class="<?php echo esc_attr( $option[ 'class' ] ); ?>">
					<label>
						<input type="radio" name="convert_to_sub_<?php echo absint( $product_id ); ?>" data-custom_data="<?php echo esc_attr( json_encode( $option[ 'data' ] ) ); ?>" value="<?php echo esc_attr( $option[ 'value' ] ); ?>" <?php checked( $option[ 'selected' ], true, true ); ?> />
						<span class="<?php echo esc_attr( $option[ 'class' ] ) . '-details'; ?>"><?php echo $option[ 'description' ]; ?></span>
						<?php echo ''; ?>
					</label>
				</li><?php
			}
		?></ul>
	</div>
</div>
</div><!--end select-area -->
<script type="text/javascript">
var $ = jQuery.noConflict();
</script>
<script>
$('.wcsatt-options-product-dropdown').on('change', function(){
$('#valuediscount').text(
$(this).find(':selected').attr('data-title')
);
});
$(".wcsatt-options-prompt-label-one-time").click(function(){
$(".one-time-option input").prop("checked", true);
});
</script>
