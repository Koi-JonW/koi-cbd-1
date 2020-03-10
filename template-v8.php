<?php
defined('ABSPATH') || exit;
/* Template Name: Template V8 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();

?>

<section id="banner-thank-you">
    <p>Thanks! X</p>
    <div class="banner-row">
        <div class="banner-left">
            <img src="<?php the_field('left_image'); ?>" alt="" class="img-desktop">
            <img src="<?php the_field('left_image_mobile'); ?>" alt="" class="img-mobile">
        </div>
        <div class="banner-right">
            <div class="banner-step-2">
                <div class="banner-above-titles-v3"><?php the_field('banner_above_title'); ?></div>
                <div class="banner-titles-v3"><?php the_field('banner_title'); ?></div>
                <div class="banner-description-v3"><?php the_field('banner_content'); ?></div>
                <div class="banner-underline"></div>
                <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
                <div class="yotpo-box">
                    <input type="text" class="input-text" id="friends-input" placeholder="Your friends’ emails (separated by commas)">
                    <a href="" id="customers-send-btn" class="k-button k-button--primary">Send</a>
                </div>
            </div>
            <div class="banner-step-3" style="display: none;">
                <div class="banner-titles-v3">Thanks for referring</div>
                <div class="banner-above-titles-v3">Remind your friends to check their emails</div>
                <div class="yotpo-box">
                    <a id="step-1" href="#" class="k-button k-button--primary">Refer More Friends</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
	var $ = jQuery.noConflict();

    var customersInput = $("#customers-input");
    var friendsInput = $("#friends-input");
    var step1 = $("#step-1");
    var step2 = $("#step-2");
    var sendEmailBtn = $("#customers-send-btn");

    $(step1).click(function() {
        $('.banner-step-3').hide();
        $('.banner-step-1').show();
    });

    $(sendEmailBtn).click(function() {
        if($(friendsInput).val().length !== 0){
            onSuccess = function() {
                $("#success").show();
            }
            onError = function() {
                $("#error").show();
            }
            swellAPI.identifyReferrer(customersInput.val(), onSuccess, onError);
            $('.banner-step-2').hide();
            $('.banner-step-3').show();
        }
    });

</script>

<?php get_footer(lp); ?>