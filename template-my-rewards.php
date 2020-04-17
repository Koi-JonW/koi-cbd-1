<?php
defined('ABSPATH') || exit;
/* Template Name: My Rewards */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<?php // include(locate_template('temporal-styles-css.php')); ?>
<?php if ( is_user_logged_in() ) { ?>
<?php
$show_popup = $_GET['show'];
if($show_popup){ ?>
<div id="popup-yellow">
    <div class="popup-yellow-area" style="background: <?php the_field('yellow_popup_background_color'); ?> url(<?php the_field('yellow_popup_image'); ?>) no-repeat left top;">
<section id="banner-refer-friend" style="background:url('<?php the_field('background_image'); ?>') no-repeat; background-size:cover; border-radius:10px; width:80%; max-width:1225px; margin:0 auto; margin-top:7%;">
    <div class="banner-row">
        <div class="banner-left">
            <div class="banner-step-2">
                <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
                <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
                <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
                <div class="banner-underline"></div>
                <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
                <div class="yotpo-box">
                    <input type="text" class="input-text" placeholder="Your friends' emails (separated by commas)">
                    <a href="" class="k-button k-button--primary">Send</a>
                    <div class="banner-links-sections">
                        You can also share your link with the buttons below.<br/>
                        <!--
                        <a class="swell-share-referral-facebook icon-sharev" href="javascript:void(0)">Facebook</a>
                        -->
                        <a class="swell-share-referral-twitter icon-tweet" href="javascript:void(0)">Twitter</a>
                        <!--
                        <a class="swell-share-referral-messenger icon-message" href="javascript:void(0)">Messenger</a>
                        -->
                        <a class="swell-referral-link-copy icon-copy-link" href="javascript:void(0)">Copy Link</a>
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
                <a href="" class="k-button k-button--primary">Shop Now</a>
            </div>
        </div>
    </div>
</section>

        
    </div><!--end popup-yellow-area-->
</div><!--end popup-yellow-->
<?php } ?>
<section id="how-it-works" class="my-paddings-v2" style="background-color:#F2F2F2;">
    <div class="k-inner k-inner--md flex-features">
        <?php if(get_field('title_section_hiw')){ ?>
        <div class="template-title" style="text-align:<?php the_field('title_section_hiw_align'); ?>"><?php the_field('title_section_hiw'); ?></div><!--end template-title-->
        <?php } ?>
    <div class="area-35-p white-borders">
        <div class="btns-area">
<?php
$current_user = wp_get_current_user();
$user_name = $current_user->display_name;
$user_email = $current_user->user_email;
?>
            <span style="padding-bottom:5px;">Hi, <?php echo $user_name; ?></span>
<strong>MANAGE ACCOUNT</strong><br/>
<a href="<?php echo esc_url( home_url( '/account' ) ); ?>" style="color:#000;">Dashboard</a><br/>
<strong>My Rewards</strong><br/>
<a href="<?php echo esc_url( home_url( '/account/orders' ) ); ?>" style="color:#000;">Orders</a><br/>
<a href="<?php echo esc_url( home_url( '/account/subscriptions' ) ); ?>" style="color:#000;">Subscriptions</a><br/>
<a href="<?php echo esc_url( home_url( '/account/wc-smart-coupons' ) ); ?>" style="color:#000;">Coupons</a><br/>
<a href="<?php echo esc_url( home_url( '/account/edit-address' ) ); ?>" style="color:#000;">Addresses</a><br/>
<a href="<?php echo esc_url( home_url( '/account/edit-account' ) ); ?>" style="color:#000;">Account details</a><br/>
<strong><a href="<?php echo wp_logout_url(); ?>">Logout</a></strong><br/>
        </div>
    </div><!--end area-35-p-->
    <div class="area-65-p">
        <div class="btns-area" style="max-width:90% !important;">
            <span>Hi, <?php echo $user_name; ?><br/>You Have <span class='swell-point-balance' style='display: inline-block;'>X</span> Points.</span>
            <?php the_field('yellow_button_hiw'); ?><br/><?php the_field('white_button_hiw'); ?>
        </div><!--end btns-area-->
    </div><!--end area-65-p-->
    </div><!--end k-inner-->
</section><!--end how-it-works-->

<section id="vips-earn" class="my-paddings">
    <div class="k-inner k-inner--md">
        <div class="template-title" style="text-align:<?php the_field('title_section_vip_align'); ?>"><?php the_field('title_section_vip'); ?></div><!--end template-title-->
        <ul class="bullet-selector">
        <li class="bull-g opta activex"></li>
        <li class="bull-g optb"></li>
        <li class="bull-g optc"></li>
        </ul>
        <div style="width:100%; clear:both;"></div>
        <div class="flex-features" style="margin-top:50px;">
            <?php the_field('table_code'); ?>
        </div><!--end flex-features-->
    </div><!--end k-inner-->
</section><!--end vips-earn-->

<section id="redeem" class="my-paddings">
    <div class="k-inner k-inner--md flex-features">
        <div class="redeem-l">
            <img src="<?php the_field('image_redeem'); ?>" alt="redeem"/>
        </div><!--end redeem-l-->
        <div class="redeem-r">
            <div class="template-title"><?php the_field('title_section_redeem'); ?></div><!--end template-title-->
            <div class="content_section_redeem"><?php the_field('content_section_redeem'); ?></div><!--end content_section_redeem-->
        
        <?php
        if( have_rows('points') ): ?>
            <div class="points-area">
            <?php if(get_field('points_orange')){ ?><div class='points-range-orange'><?php the_field('points_orange'); ?></div><!--end points-range-orange--><?php } ?>
            <?php while ( have_rows('points') ) : the_row(); ?>
                <div class="points-box">
                    <div class='points-txt'><?php the_sub_field('discount'); ?></div>
                    <div class='discount-txt'><?php the_sub_field('points'); ?></div>
                </div>
            <?php endwhile; ?>
            </div><!--end points-area-->
        <?php endif;?>
        </div><!--end redeem-r-->
    </div><!--end k-inner-->
</section><!--end redeem-->

<div id="section-refer-friend">&nbsp;</div>
<section id="banner-refer-friend" style="background:url('<?php the_field('banner_background_refer'); ?>') no-repeat; background-size:cover; border-radius:10px; width:80%; max-width:1225px; margin:0 auto; margin-top:7%;">
    <div class="banner-row max-width-banner-refer" style="max-width:94%; margin:0 auto;">
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
                        <!--
                        <a class="swell-share-referral-facebook icon-sharev" href="javascript:void(0)">Facebook</a>
                        -->
                        <a class="swell-share-referral-twitter icon-tweet" href="javascript:void(0)">Twitter</a>
                        <!--
                        <a class="swell-share-referral-messenger icon-message" href="javascript:void(0)">Messenger</a>
                        -->
                        <a class="swell-referral-link-copy icon-copy-link" href="javascript:void(0)">Copy Link</a>
                    </div>
                </div>
            </div>
            <div class="banner-step-3" style="display: none;">
                <div class="banner-titles-v3">Thanks for referring</div>
                <div class="banner-above-titles-v3">Remind your friends to check their emails</div>
                <div class="yotpo-box">
                    <a href="#" id="thank-you-back" class="k-button k-button--primary">Refer More Friends</a>
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
<?php }else{ 
    header("Location: /login");
    die();
} ?>
<script>
    var $ = jQuery.noConflict();
</script>
<script>
    $(document).on('click','.opta',function(){
        $('.opt_a').addClass("showmy");
        $('.opt_b').removeClass("showmy");
        $('.opt_c').removeClass("showmy");
        $('.opta').addClass("activex");
        $('.optb').removeClass("activex");
        $('.optc').removeClass("activex");
    });
    $(document).on('click','.optb',function(){
        $('.opt_b').addClass("showmy");
        $('.opt_a').removeClass("showmy");
        $('.opt_c').removeClass("showmy");
        $('.optb').addClass("activex");
        $('.opta').removeClass("activex");
        $('.optc').removeClass("activex");
    });
    $(document).on('click','.optc',function(){
        $('.opt_c').addClass("showmy");
        $('.opt_a').removeClass("showmy");
        $('.opt_b').removeClass("showmy");
        $('.optc').addClass("activex");
        $('.opta').removeClass("activex");
        $('.optb').removeClass("activex");
    });
</script>
<script>

    var step_2 = $('.banner-step-2');
    var step_3 = $('.banner-step-3');

    var user_email = '<?php echo($user_email); ?>';

    // --

    $('#referred-customers-send-btn').on('click', function(e) {

        e.preventDefault();

        var emails = $('#referred-customers-input').val().toLowerCase().split(',');

        // --

        if($.inArray(user_email.toLowerCase(), emails) !== -1){
            alert('Please enter a different email address.\nThis may not be a valid email address, or this person may already be signed up for Koi CBD Rewards.');
            return false;
        }

        // --

        var onSuccess = function() {
            console.log('Email(s) sent to: ', $('#referred-customers-input').val());
            step_2.hide();
            step_3.show();
            $('#referred-customers-input').val('');
        }

        var onError = function(err) {
            alert('Please enter a different email address.\nThis may not be a valid email address, or this person may already be signed up for Koi CBD Rewards.');
            console.log('-- sendReferralEmails Error:\n', err);
        }

        var emails = $('#referred-customers-input').val().split(',');

        try {
            swellAPI.sendReferralEmails(emails, onSuccess, onError);
        } catch(err) {
            onError(err);
        }

        // --

        $('#thank-you-back').on('click', function(e){

            e.preventDefault();

            step_2.show();
            step_3.hide();

        });

    });

</script>
<section id="sign-up-area" style="padding-top:7% !important;">
	<div class="content-sign-up-area">
		<div class="title-sign-up-section" style="text-align:center;">
			<?php the_field('title_qa_section'); ?>
		</div><!--end title-sign-up-section-->
		<div class="content-sign-up-section">
		<?php
		$id_a = "1";
		if( have_rows('questions_and_answers') ):
		while ( have_rows('questions_and_answers') ) : the_row(); 
		$id = $id_a++;
		?>
		<script>
		function qa<?php echo $id; ?>(){
		document.getElementById("answer_<?php echo $id; ?>").style.display = "block";
		document.getElementById("close_<?php echo $id; ?>").style.display = "none";
		document.getElementById("open_<?php echo $id; ?>").style.display = "block";
		}
		function qaclose<?php echo $id; ?>(){
		document.getElementById("answer_<?php echo $id; ?>").style.display = "none";
		document.getElementById("close_<?php echo $id; ?>").style.display = "block";
		document.getElementById("open_<?php echo $id; ?>").style.display = "none";
		}
		</script>
		
		<div class="content-box-qa">
			<div class="box-qa">
				<div class="title-qa">
				<?php echo get_sub_field('question'); ?>
				</div><!--end title-qa-->
				<div id="close_<?php echo $id; ?>" class="simbol-qa-pos" onclick="qa<?php echo $id; ?>();" style="display:block;">+</div>
				<div id="open_<?php echo $id; ?>" class="simbol-qa-neg" onclick="qaclose<?php echo $id; ?>();" style="display:none;">-</div>
			</div>
			<div id="answer_<?php echo $id; ?>" class="box-content-qa" style="display:none;"><?php echo get_sub_field('answer'); ?></div>
		</div><!--end content-box-qa-->
		<?php endwhile; endif; ?>
		</div><!--end content-sign-up-section-->
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<?php get_footer(lp); ?>
