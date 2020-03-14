<?php
defined('ABSPATH') || exit;
/* Template Name: Thank You */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();

?>
<?php
$current_user = wp_get_current_user();
$username = $current_user->display_name;
?>
<section id="banner-thank-you">
    <p>Thanks! <?php echo $username; ?></p>
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

<?php get_footer(lp); ?>