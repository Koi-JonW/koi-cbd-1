<?php
defined('ABSPATH') || exit;
/* Template Name: Refer a Friend */

$root = get_template_directory_uri();
$site_content = get_fields('option');
get_header();
// --
$current_user = wp_get_current_user();
$user_name = $current_user->display_name;
$user_email = $current_user->user_email;
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
                    <input type="text" id="referred-customers-input" class="input-text" placeholder="Your friends' emails (separated by commas)">
                    <a href="#" id="referred-customers-send-btn" class="k-button k-button--primary">Send</a>
                <div class="banner-links-sections">
                    You can also share your link with the buttons below.<br/>
                    <a href="#" class="icon-sharev"><?php the_field('share',658196); ?></a>
                    <a href="#" class="icon-tweet"><?php the_field('tweet',658196); ?></a>
                    <a href="#" class="icon-message"><?php the_field('message',658196); ?></a>
                    <a href="#" class="icon-copy-link"><?php the_field('copy_link',658196); ?></a>
                </div><!--end banner-links-sections-->
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
                </table>
            </div>
            <div class="banner-underline"></div>
            <div class="check-rewards-below-table"><?php the_field('text_below_table_i'); ?></div>
            <div class="check-rewards-below-table-2"><?php the_field('text_below_table_ii'); ?></div>
            <div class="yotpo-box">
                <a href="<?php echo esc_url(home_url('/shop')); ?>" class="k-button k-button--primary">Shop Now</a>
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
            <a href="#" id="customers-send-btn" class="k-button k-button--primary">Next</a>

        </div><!--end yotpo-box-->
    </div>
    <div class="banner-step-2" style="display: none;">
        <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
        <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
        <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
        <div class="banner-underline"></div>
        <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
        <div class="yotpo-box">
            <input type="text" id="referred-customers-input" class="input-text" placeholder="Your friends' emails (separated by commas)">
            <a href="#" id="referred-customers-send-btn" class="k-button k-button--primary">Send</a>
            <div class="banner-links-sections">
             You can also share your link with the buttons below.<br/>
             <a href="#" class="icon-sharev"><?php the_field('share'); ?></a>
             <a href="#" class="icon-tweet"><?php the_field('tweet'); ?></a>
             <a href="#" class="icon-message"><?php the_field('message'); ?></a>
             <a href="#" class="icon-copy-link"><?php the_field('copy_link'); ?></a>
            </div><!--end banner-links-sections-->

        </div>
    </div>
    <div class="banner-step-3" style="display: none;">
        <div class="banner-titles-v3">Thanks for referring</div>
        <div class="banner-above-titles-v3">Remind your friends to check their emails</div>
        <div class="yotpo-box">
            <a href="#" id="thank-you-back" class="k-button k-button--primary">Refer More Friends</a>
        </div>
    </div>
</section>

<?php } ?>

<script>
    var $ = jQuery.noConflict();
</script>
<script>

    var step_1 = $('.banner-step-1');
    var step_2 = $('.banner-step-2');
    var step_3 = $('.banner-step-3');

    var user_email = '<?php echo($user_email); ?>';

    // --

    $('#customers-send-btn').on('click', function(e) {

        e.preventDefault();

        var onSuccess = function() {
            console.log('Customer identified: ', $('#customers-input').val());
            step_1.hide();
            step_2.show();
            step_3.hide();
            $('#customers-input').val('');
        }

        var onError = function(err) {
            alert('Please enter a valid email address');
            console.log('-- identifyReferrer Error:\n', err);
        }

        try {
            swellAPI.identifyReferrer($('#customers-input').val(), onSuccess, onError);
        } catch(err) {
            console.log('-- identifyReferrer Exception:\n', err);
            onError(err);
        }

    });

    // --

    $('#referred-customers-send-btn').on('click', function(e) {

        e.preventDefault();

        var emails = $('#referred-customers-input').val().toLowerCase().split(',');

        // --

        if($.inArray(user_email.toLowerCase(), emails) !== -1){
            alert('You may not refer your own email address');
            return false;
        }

        // --

        var onSuccess = function() {
            console.log('Email(s) sent to: ', $('#referred-customers-input').val());
            step_1.hide();
            step_2.hide();
            step_3.show();
            $('#referred-customers-input').val('');
        }

        var onError = function(err) {
            alert('Please enter a valid email address');
            console.log('-- sendReferralEmails Error:\n', err);
        }

        try {
            swellAPI.sendReferralEmails(emails, onSuccess, onError);
        } catch(err) {
            console.log('-- sendReferralEmails Exception:\n', err);
            onError(err);
        }

    });

    // --

    $('#thank-you-back').on('click', function(e){

        e.preventDefault();

        step_1.show();
        step_2.hide();
        step_3.hide();

    });

</script>

<?php get_footer(lp); ?>