<?php
defined('ABSPATH') || exit;
/* Template Name: Template V3 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image'); ?>') no-repeat; background-size:cover;">
    <div class="banner-above-titles-v3"><?php the_field('banner_above_title'); ?></div>
    <div class="banner-titles-v3"><?php the_field('banner_title'); ?></div>
    <div class="banner-description-v3"><?php the_field('banner_content'); ?></div>
    <div class="banner-underline"></div>
    <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
    <div class="yotpo-box">
        <input id="customers-input" type="text" class="input-text" placeholder="Your email">
        <a id="customers-send-btn" href="" class="k-button k-button--primary">Next</a>
    </div>
</section>

<script>
	var $ = jQuery.noConflict();
</script>
<script>

    var customersInput = $("#customers-input");
    var sendEmailBtn = $("#customers-send-btn");

    $(sendEmailBtn).click(function() {
        onSuccess = function() {
            $("#success").show();
        }
        onError = function() {
            $("#error").show();
        }
        swellAPI.identifyReferrer(customersInput.val(), onSuccess, onError);
    });

</script>

<?php get_footer(lp); ?>