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

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image','658196'); ?>') no-repeat; background-size:cover; border-radius:10px; width:80%; max-width:1225px; margin:0 auto; margin-top:7%;">
    <div class="banner-row">
        <div class="banner-left">
            <div class="banner-above-titles-v2"><?php the_field('banner_above_title','658196'); ?></div>
            <div class="banner-titles-v2"><?php the_field('banner_title','658196'); ?></div>
            <div class="banner-description-v2"><?php the_field('banner_content','658196'); ?></div>
            <div class="banner-underline"></div>
            <div class="button-text-below"><?php the_field('text_below_line','658196'); ?></div>
            <div class="yotpo-box">
                <input type="text" class="input-text" placeholder="Your friends' emails (separated by commas)">
                <a href="" class="k-button k-button--primary">Send</a>
			<div class="banner-links-sections">
			 You can also share your link with the buttons below.<br/>
			 <a href="#" class="icon-sharev"><?php the_field('share',658196); ?></a>
			 <a href="#" class="icon-tweet"><?php the_field('tweet',658196); ?></a>
			 <a href="#" class="icon-message"><?php the_field('message',658196); ?></a>
			 <a href="#" class="icon-copy-link"><?php the_field('copy_link',658196); ?></a>
			</div><!--end banner-links-sections-->
            </div>
        </div>
        <div class="banner-right">
            <div class="check-rewards-title"><?php the_field('check_rewards_title','658196'); ?></div>
            <div class="check-rewards-subtitle"><?php the_field('check_rewards_subtitle','658196'); ?></div>
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
            <div class="check-rewards-below-table"><?php the_field('text_below_table_i','658196'); ?></div>
            <div class="check-rewards-below-table-2"><?php the_field('text_below_table_ii','658196'); ?></div>
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
$username = $current_user->display_name;
?>
			<span style="padding-bottom:5px;">Hi, <?php echo $username; ?></span>
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
			<span>Hi, <?php echo $username; ?><br/>You Have <span class='swell-point-balance' style='display: inline-block;'>X</span> Points.</span>
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
			<div class="points-range-orange"><?php the_field('points_orange'); ?></div><!--end points-range-orange-->
		<?php
		if( have_rows('points') ): ?>
			<div class="points-area">
			<?php while ( have_rows('points') ) : the_row(); ?>
				<div class="points-box">
     				<div class="discount-txt"><?php the_sub_field('discount'); ?></div>
					<div class="points-txt"><?php the_sub_field('points'); ?></div>
				</div>
			<?php endwhile; ?>
			</div><!--end points-area-->
		<?php endif;?>
		</div><!--end redeem-r-->
	</div><!--end k-inner-->
</section><!--end redeem-->

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image','658196'); ?>') no-repeat; background-size:cover; border-radius:10px; width:80%; max-width:1225px; margin:0 auto; margin-top:7%;">
    <div class="banner-row" style="max-width:94%; margin:0 auto;">
        <div class="banner-left">
            <div class="banner-above-titles-v2"><?php the_field('banner_above_title','658196'); ?></div>
            <div class="banner-titles-v2"><?php the_field('banner_title','658196'); ?></div>
            <div class="banner-description-v2"><?php the_field('banner_content','658196'); ?></div>
            <div class="banner-underline"></div>
            <div class="button-text-below"><?php the_field('text_below_line','658196'); ?></div>
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
        <div class="banner-right">
            <div class="check-rewards-title"><?php the_field('check_rewards_title','658196'); ?></div>
            <div class="check-rewards-subtitle"><?php the_field('check_rewards_subtitle','658196'); ?></div>
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
            <div class="check-rewards-below-table"><?php the_field('text_below_table_i','658196'); ?></div>
            <div class="check-rewards-below-table-2"><?php the_field('text_below_table_ii','658196'); ?></div>
            <div class="yotpo-box">
                <a href="<?php echo esc_url( home_url( '/shop' ) ); ?>" class="k-button k-button--primary">Shop Now</a>
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

	function setSwellActiveCampaigns(campaigns){
		campaigns.forEach(function(campaign){

			$('.swell-campaign-list').append(
				$('<li>').append(
					$('<div>').append(
						$('<i>').addClass('fa ' + campaign.icon),
						$('<p>').text(campaign.rewardText),
						$('<h5>').text(campaign.title)
					).addClass('content-bx').attr({
						'id': 'campaign-' + campaign.id
					})
				).addClass('campaign swell-campaign-link').attr({
					'data-campaign-id': campaign.id,
					'data-display-mode': 'modal',
					'style': 'background: url(' + campaign.backgroundImageUrl  + ') center center no-repeat; background-size: cover;'
				})
			);

		});
	}

	var checkSwellActiveCampaigns = setInterval(function(){
        if (typeof swellAPI == 'object' && swellAPI !== null){
			var swellCampaigns = swellAPI.getActiveCampaigns();
			if (swellCampaigns && swellCampaigns.length){
            	clearInterval(checkSwellActiveCampaigns);
            	setSwellActiveCampaigns(swellCampaigns);
			}
        }
    }, 100);

    // --

    $('#referred-customers-send-btn').on('click', function(e) {

        e.preventDefault();

        var onSuccess = function() {
            step_1.hide();
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

            step_1.show();
            step_2.hide();
            step_3.hide();

        });

    });

</script>
<?php get_footer(lp); ?>
