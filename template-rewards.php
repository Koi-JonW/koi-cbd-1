<?php
defined('ABSPATH') || exit;
/* Template Name: Rewards */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<?php //  include(locate_template('temporal-styles-css.php')); ?>
<section id='banner-lp-v2' style='background: url(<?php echo(get_field("background_image")); ?>) no-repeat; background-size: cover;'>
    <div class='k-inner k-inner--md desk'>
        <div class='banner-l'>
            <div class='banner-titles-v2'><?php the_field('banner_title'); ?></div><!--end banner-titles-->
        </div><!--end banner-l-->
        <div class='banner-r'>
            <div class='banner-description-v2'><?php the_field('banner_content'); ?></div><!--end banner-description-->
            <?php if ( is_user_logged_in() ) {
            } else { ?>
            <a href='<?php echo esc_url( home_url( '/' ) ); ?>account?reg=1' class='k-button k-button--primary'>Join Now</a>
            <div class='button-text-below'>Already have an account? <a href='<?php echo esc_url( home_url( '/' ) ); ?>account/#0'>Log In</a></div>
            <?php } ?>

        </div><!--end banner-r-->
    </div><!--end k-inner k-inner--md-->
</section><!--end banner-lp-->

<div class='k-inner k-inner--md resp'>
            <div class='banner-titles-v2'><?php the_field('banner_title'); ?></div><!--end banner-titles-->
            <div class='banner-description-v2'><?php the_field('banner_content'); ?></div><!--end banner-description-->
            <?php if ( is_user_logged_in() ) {
            } else { ?>
            <a href='<?php echo esc_url( home_url( '/' ) ); ?>account?reg=1' class='k-button k-button--primary'>Join Now</a><a href='<?php echo esc_url( home_url( '/' ) ); ?>account' class='k-button k-button--primary white-btn'>Log In</a>
            <?php } ?>
</div><!--end k-inner-->

<section id='how-it-works' class='my-paddings'>
    <div class='k-inner k-inner--md flex-features'>
        <?php if(get_field('title_section_hiw')){ ?>
            <div class='template-title desk' style='text-align:<?php the_field('title_section_hiw_align'); ?>'><?php the_field('title_section_hiw'); ?></div><!--end template-title-->
        <?php } ?>
<?php if ( is_user_logged_in() ) { ?>
    <div class='area-50-p'>
        <img src='<?php the_field('how_it_works_image_lu'); ?>' alt='<?php the_field('title_section_hiw'); ?>' class='img-tmp-100'/>
        <?php if(get_field('title_section_hiw')){ ?>
        <div class='template-title resp' style='text-align:<?php the_field('title_section_hiw_align'); ?>'><?php the_field('title_section_hiw'); ?></div><!--end template-title-->
        <?php } ?>
    </div><!--end area-50-p-->
    <div class='area-50-p'>
        <div class='btns-area'>
            <span>Hi, <span class='swell-user' style='display: inline-block;'><?php $current_user = wp_get_current_user(); echo($current_user->user_firstname ? $current_user->user_firstname : $current_user->user_login);?></span><br/>You Have <span class='swell-point-balance' style='display: inline-block;'>X</span> Points.</span>
            <?php the_field('yellow_button_hiw'); ?><br/><?php the_field('white_button_hiw'); ?><br/><?php the_field('track_referals_button'); ?>
        </div><!--end btns-area-->
    </div><!--end area-50-p-->
<?php } else { ?>
    <div class='area-50-p'>
                <img src='<?php the_field('how_it_works_image'); ?>' alt='<?php the_field('title_section_hiw'); ?>' class='img-tmp-100'/>        
                <div class='template-title resp' style='text-align:<?php the_field('title_section_hiw_align'); ?>'><?php the_field('title_section_hiw'); ?></div><!--end template-title-->
    </div><!--end area-50-p-->
    <div class='area-50-p'>
        <?php
        if( have_rows('steps') ): ?>
            <ul class='steps-area'>
            <?php while ( have_rows('steps') ) : the_row(); ?>
                <li>
                    <div class='tt-li'><?php the_sub_field('title'); ?></div><!--end tt-li-->
                    <div class='dd-li'><?php the_sub_field('description'); ?></div><!--end dd-li-->
                </li>
            <?php endwhile; ?>
            </ul><!--end steps-area-->
        <?php endif;?>
    </div><!--end area-50-p-->
<?php } ?>
    </div><!--end k-inner-->
</section><!--end how-it-works-->


<section class='swell-campaign-list-container'>
    <h4 class='swell-campaign-list-title' style='text-align:<?php the_field('title_section_ways_align'); ?>; padding:0px !important;'><?php the_field('title_section_ways'); ?></h4>
    <?php if(get_field('temp_img')){ ?><img src='<?php the_field('temp_img'); ?>' alt='temp' style='width:100%; max-width:1215px; display:block; margin:0 auto;'/><?php } ?>
        <div class='k-inner k-inner--md flex-features'>
            <ul class='swell-campaign-list'>
            </ul>
        </div><!--end k-inner-->
    <?php the_field('html_embedded'); ?>
</section>

<section id='banner-refer' class='brefer-v'>
    <div class='k-inner k-inner--md' style='background: url(<?php echo(get_field('banner_background_refer')); ?>) no-repeat; background-size: cover; border-radius: 10px;'>
    <div class='small_title_banner'><?php the_field('small_title_banner'); ?></div>
    <div class='big_title_banner'><?php the_field('big_title_banner'); ?></div>
    <div class='banner_description'><?php the_field('banner_description'); ?></div>
    <?php the_field('button_refer_friend'); ?>
    </div><!--end k-inner k-inner--md-->
</section><!--end banner-refer-->

<section id='vips-earn'>
    <div class='k-inner k-inner--md'>
        <div class='template-title' style='text-align:<?php the_field('title_section_vip_align'); ?>'><?php the_field('title_section_vip'); ?></div><!--end template-title-->
        <ul class='bullet-selector'>
        <li class='bull-g opta activex'></li>
        <li class='bull-g optb'></li>
        <li class='bull-g optc'></li>
        </ul>
        <div style='width:100%; clear:both;'></div>
        <div class='flex-features'>
            <?php the_field('table_code'); ?>
        </div><!--end flex-features-->
    </div><!--end k-inner-->
</section><!--end vips-earn-->

<section id='redeem' class='my-paddings'>
    <div class='k-inner k-inner--md flex-features'>
        <div class='redeem-l'>
            <img src='<?php the_field('image_redeem'); ?>' alt='redeem'/>
        </div><!--end redeem-l-->
        <div class='redeem-r'>
            <div class='template-title'><?php the_field('title_section_redeem'); ?></div><!--end template-title-->
            <div class='content_section_redeem'><?php the_field('content_section_redeem'); ?></div><!--end content_section_redeem-->
        <?php
        if( have_rows('points') ): ?>
            <div class='points-area'>
            <?php if(get_field('points_orange')){ ?><div class='points-range-orange'><?php the_field('points_orange'); ?></div><!--end points-range-orange--><?php } ?>
            <?php while ( have_rows('points') ) : the_row(); ?>
                <div class='points-box'>
                    <div class='points-txt'><?php the_sub_field('discount'); ?></div>
                    <div class='discount-txt'><?php the_sub_field('points'); ?></div>
                </div>
            <?php endwhile; ?>
            </div><!--end points-area-->
        <?php endif;?>
        </div><!--end redeem-r-->
    </div><!--end k-inner-->
</section><!--end redeem-->
<style>
    .table-vips-cell-benefits {
        text-transform: capitalize;
    }
</style>
<script>
    var $ = jQuery.noConflict();
</script>
<script>
    $(document).on('click','.opta',function(){
        $('.opt_a').addClass('showmy');
        $('.opt_b').removeClass('showmy');
        $('.opt_c').removeClass('showmy');
        $('.opta').addClass('activex');
        $('.optb').removeClass('activex');
        $('.optc').removeClass('activex');
    });
    $(document).on('click','.optb',function(){
        $('.opt_b').addClass('showmy');
        $('.opt_a').removeClass('showmy');
        $('.opt_c').removeClass('showmy');
        $('.optb').addClass('activex');
        $('.opta').removeClass('activex');
        $('.optc').removeClass('activex');
    });
    $(document).on('click','.optc',function(){
        $('.opt_c').addClass('showmy');
        $('.opt_a').removeClass('showmy');
        $('.opt_b').removeClass('showmy');
        $('.optc').addClass('activex');
        $('.opta').removeClass('activex');
        $('.optb').removeClass('activex');
    });
</script>
<script>
    function swellCore(swellCampaigns){
        if($('.swell-campaign-list').length){
            swellCampaigns.forEach(function(campaign){
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
    }

    var checkSellApi = setInterval(function(){
        if (typeof swellAPI == 'object' && swellAPI !== null){
            var swellCampaigns = swellAPI.getActiveCampaigns();
            if (swellCampaigns && swellCampaigns.length){
                clearInterval(checkSellApi);
                swellCore(swellCampaigns);
            }
        }
    }, 100);
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
