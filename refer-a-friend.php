<?php
defined('ABSPATH') || exit;
/* Template Name: Refer a Friend */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>

<?php if(is_user_logged_in()){ ?>

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image'); ?>') no-repeat; background-size:cover;">
    <div class="banner-row">
        <div class="banner-left">
            <div class="banner-step-2">
                <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
                <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
                <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
                <div class="banner-underline"></div>
                <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
                <div class="yotpo-box">
                    <input type="text" class="input-text" id="friends-input" placeholder="Your friends' emails (separated by commas)">
                    <a href="#" id="customers-send-btn" class="k-button k-button--primary">Send</a>
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
        <div class="banner-right">
            <div class="check-rewards-title"><?php the_field('check_rewards_title'); ?></div>
            <div class="check-rewards-subtitle"><?php the_field('check_rewards_subtitle'); ?></div>
            <div class="check-rewards-table">
                <table>
                    <tr>
                        <td>EMAIL</td>
                        <td>STATUS</td>
                    <tr>
                    <tr>
                        <td>friend1@gmail.com</td>
                        <td>invited</td>
                    </tr>
                    <tr>
                        <td>friend2@gmail.com</td>
                        <td>invited</td>
                    </tr>
                    <tr>
                        <td>friend3@gmail.com</td>
                        <td>purchased ($15 earned)</td>
                    </tr>
                    <tr>
                        <td>friend4@gmail.com</td>
                        <td>purchased ($15 earned)</td>
                    </tr>
                    <tr>
                        <td>friend1@gmail.com</td>
                        <td>invited</td>
                    </tr>
                    <tr>
                        <td>friend2@gmail.com</td>
                        <td>invited</td>
                    </tr>
                    <tr>
                        <td>friend3@gmail.com</td>
                        <td>purchased ($15 earned)</td>
                    </tr>
                    <tr>
                        <td>friend4@gmail.com</td>
                        <td>purchased ($15 earned)</td>
                    </tr>
                </table>
            </div>
            <div class="banner-underline"></div>
            <div class="check-rewards-below-table"><?php the_field('text_below_table_i'); ?></div>
            <div class="check-rewards-below-table-2"><?php the_field('text_below_table_ii'); ?></div>
            <div class="yotpo-box">
                <a href="" class="k-button k-button--primary">Shop Now</a>
            </div>
        </div>
    </div>
</section>

<?php }else{ ?>

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image_i'); ?>') no-repeat; background-size:cover;">
    <div class="banner-step-1">
        <div class="banner-above-titles-v3"><?php the_field('banner_above_title_i'); ?></div>
        <div class="banner-titles-v3"><?php the_field('banner_title_i'); ?></div>
        <div class="banner-description-v3"><?php the_field('banner_content_i'); ?></div>
        <div class="banner-underline"></div>
        <div class="button-text-below"><?php the_field('text_below_line_i'); ?></div>
        <div class="yotpo-box">
            <input id="customers-input" type="text" class="input-text" placeholder="Your email">
            <a href="#" id="step-2" class="k-button k-button--primary">Next</a>
        </div>
    </div>
    <div class="banner-step-2" style="display: none;">
        <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
        <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
        <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
        <div class="banner-underline"></div>
        <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
        <div class="yotpo-box">
            <input type="text" id="friends-input" class="input-text" placeholder="Your friends' emails (separated by commas)">
            <a id="customers-send-btn" href="#" class="k-button k-button--primary">Send</a>
        </div>
    </div>
    <div class="banner-step-3" style="display: none;">
        <div class="banner-titles-v3">Thanks for referring</div>
        <div class="banner-above-titles-v3">Remind your friends to check their emails</div>
        <div class="yotpo-box">
            <a id="step-1" href="#" class="k-button k-button--primary">Refer More Friends</a>
        </div>
    </div>
</section>

<?php } ?>

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

    $(step2).click(function() {
        if( $(customersInput).val().length !== 0 ){
            $('.banner-step-1').hide();
            $('.banner-step-2').show();
        }
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

    function swellCustomerCore(swellCustomer){
		if($(".check-rewards-table").length){
			swellCustomer.referrals.forEach(function(campaign){
                // --
            });
		}
	}

	var checkSwellCustomer = setInterval(function(){
        if (typeof swellAPI == 'object' && swellAPI !== null){
			var swellCustomer = swellAPI.getCustomerDetails();
			if (swellCustomer && swellCustomer['pointsBalance'] !== 'undefined'){
            	clearInterval(checkSwellCustomer);
            	swellCustomerCore(swellCustomer);
			}
        }
    }, 100);

</script>

<?php get_footer(lp); ?>