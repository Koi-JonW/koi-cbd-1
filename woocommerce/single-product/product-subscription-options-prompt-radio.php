<?php
/**
 * Product Subscription Options Radio Prompt Template.
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/product-subscription-options-prompt-radio.php'.
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
<style type="text/css">
.closed #no_option{
background-color:#000;
}
.closed #yes_option{
background-color:none;
}
.open #yes_option{
background-color:#000;
}
.open #no_option{
background-color:none;
}
</style>

<div class="select_options_area">
<ul class="select_option wcsatt-options-prompt-radios">
	<li class="wcsatt-options-prompt-radio" id="yes_option">
		<label class="wcsatt-options-prompt-label wcsatt-options-prompt-label-subscription">
			<input class="wcsatt-options-prompt-action-input" type="radio" name="subscribe-to-action-input" value="yes" />
			<span class="wcsatt-options-prompt-action" style="text-transform:initial !important;">Yes<?php // echo $subscription_cta; ?></span>
		</label>
	</li>
	<li class="wcsatt-options-prompt-radio" id="no_option">
		<label class="wcsatt-options-prompt-label wcsatt-options-prompt-label-one-time">
			<input class="wcsatt-options-prompt-action-input" type="radio" name="subscribe-to-action-input" value="no" />
			<span class="wcsatt-options-prompt-action" style="text-transform:initial !important;">No<?php // echo $one_time_cta; ?></span>
		</label>
	</li>
</ul>
</div>
<script type="text/javascript">
function changediscount(discount){
var discount;
	document.getElementById("valuediscount").innerHTML = discount;
}
</script>
<div id="valuediscount" class="select_options_text">
SUBSCRIBE & SAVE 10%
</div>
<div class="clear"></div>
