<?php
  /* Template Name: Million Milligram */

  $root = get_template_directory_uri();
  $fields = get_fields();
  $site_content = get_fields();

  get_header();

  /**
   * This page relies on the include(locate_template()) hack.
   * Any variables declared in this file's scope will be silently
   * passed to any files included with this method, as if the 
   * included file's content was in this file to begin with.
   * 
   * There's cleaner ways of doing this, but this does work and 
   * we're not sure at this point if these homepage components 
   * are even reuseable.
   * 
   * It works nicely, however, since the majority of the site's 
   * content is entered on the ACF "options" page titled
   * "Site Content". Let's all just embrace global vars, okay?
   */
  $hero_fields = array(
    'headline' => $site_content['hero_headline'],
    'body' => $site_content['hero_body'],
    'bgImg' => $site_content['hero_background_image'],
    'actions' => $site_content['hero_actions'],
  );
  include(locate_template('partials/million-milligram-hero.php'));
	echo "<section class='home-sections'>";
  $slider_fields = array(
    'headline' => $site_content['product_slider_headline'],
    'products' => $site_content['product_slider_products'],
    'half_padding_top' => true,
  );
  // include(locate_template('partials/promo-slider.php'));

  $overview_fields = array(
    'headline' => $site_content['product_overview_headline'],
    'supporting_copy' => $site_content['product_overview_supporting_copy'],
    'main_link' => $site_content['product_overview_main_link'],
    'main_image' => $site_content['product_overview_main_image'],
    'tinctures_copy' => $site_content['product_overview_tinctures_supporting_copy'],
    'tinctures_bg_image' => $site_content['product_overview_tinctures_bg_image'],
    'tinctures_corner_image' => $site_content['product_overview_tinctures_corner_image'],
    'topicals_copy' => $site_content['product_overview_topicals_supporting_copy'],
    'topicals_bg_image' => $site_content['product_overview_topicals_bg_image'],
    'topicals_corner_image' => $site_content['product_overview_topicals_corner_image'],
    'pets_copy' => $site_content['product_overview_pets_supporting_copy'],
    'pets_bg_image' => $site_content['product_overview_pets_bg_image'],
    'pets_corner_image' => $site_content['product_overview_pets_corner_image'],
    'edibles_copy' => $site_content['product_overview_edibles_supporting_copy'],
    'edibles_bg_image' => $site_content['product_overview_edibles_bg_image'],
    'edibles_corner_image' => $site_content['product_overview_edibles_corner_image'],
    'vape_copy' => $site_content['product_overview_vape_supporting_copy'],
    'vape_bg_image' => $site_content['product_overview_vape_bg_image'],
    'vape_corner_image' => $site_content['product_overview_vape_corner_image'],
    'merch_copy' => $site_content['product_overview_merch_supporting_copy'],
    'merch_bg_image' => $site_content['product_overview_merch_bg_image'],
    'merch_corner_image' => $site_content['product_overview_merch_corner_image'],
    'product_overview_cbd_bath_beauty_description' => $site_content['product_overview_cbd_bath_beauty_description'],
    'product_overview_cbd_bath_beauty_background_image' => $site_content['product_overview_cbd_bath_beauty_background_image'],
    'product_overview_cbd_bath_beauty_corner_image' => $site_content['product_overview_cbd_bath_beauty_corner_image'],
    'product_overview_cbd_inhalers_description' => $site_content['product_overview_cbd_inhalers_description'],
    'product_overview_cbd_inhalers_background_image' => $site_content['product_overview_cbd_inhalers_background_image'],
    'product_overview_cbd_inhalers_corner_image' => $site_content['product_overview_cbd_inhalers_corner_image'],
  );
  // include(locate_template('partials/home-overview.php'));

  $testimonial_fields = array(
   'testimonials' => $site_content['homepage_testimonials'],
  );
  // include(locate_template('partials/testimonial-slider.php'));

  $cta_fields = array(
    'preheading' => $site_content['cta_banner_preheading'],
    'heading' => $site_content['cta_banner_heading'],
    'link' => $site_content['cta_banner_link'],
    'image' => $site_content['cta_banner_image'],
  );
  // include(locate_template('partials/cta-banner.php'));
  
  // get_template_part('partials/process-preview');
  echo "</section>"; ?>
<section class='home-sections'>

<section id="sign-up-area">
<div class="content-sign-up-area">
	<div class="title-sign-up-section">
		<?php the_field('title_first_section'); ?>
	</div><!--end title-sign-up-section-->
	<div class="content-sign-up-section" style="max-width:530px; margin-left:auto; margin-right:auto; left:0; right:0;">
		<?php the_field('content_first_section'); ?>
	</div><!--end content-sign-up-section-->
</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<section id="boxes-section" style="padding:0px 0px 50px 0px !important; margin-top:-40px;">
	<div class="content-area">
		<?php
		if( have_rows('boxes') ):
		while ( have_rows('boxes') ) : the_row(); ?>
		<div class="box-area" style="text-align:center;">
			<div class="icon-box-area">
				<img src="<?php the_sub_field('icon_box_section'); ?>" alt="box-icon"/>
			</div><!--end icon-box-area-->
			<div class="title-box-area-v2"><?php the_sub_field('title_box_section'); ?></div><!--end title-box-area-v2-->
			<div class="description-box-area"><?php the_sub_field('description_box_section'); ?></div><!--end description-box-area-->
		</div><!--end box-area-->   	
		<?php endwhile; endif; ?>
	</div><!--end k-inner k-inner--md-->
</section><!--end boxes-section-->

<section id="sign-up-area" style="background:url(<?php the_field('background_image_opt'); ?>) no-repeat center; padding:<?php the_field('padding_top_opt'); ?> 0px <?php the_field('padding_bottom_opt'); ?> 0px !important; color:<?php the_field('text_color_opt'); ?>;">
	<div class="content-sign-up-area">
		<?php the_field('content_banner_opt'); ?>
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<section id="sign-up-area">
<div class="content-sign-up-area">
	<div class="title-sign-up-section">
		<?php the_field('title_join_us'); ?>
	</div><!--end title-sign-up-section-->
	<div class="content-sign-up-section">
		<?php the_field('content_join_us'); ?>
		<?php the_field('gleam_demo_code'); ?>
	</div><!--end content-sign-up-section-->
</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->


<section style="max-width:767px; margin:0 auto; text-align:center;">
<div class="content-sign-up-area">
	<div class="title-sign-up-section">
		<?php the_field('title_banner_20'); ?>
	</div><!--end title-sign-up-section-->
	<div class="content-sign-up-section">
		<?php the_field('subtitle_banner_20'); ?>
	</div><!--end content-sign-up-section-->
</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->


<section id="sign-up-area" style="background:url(<?php the_field('background_image_20'); ?>) no-repeat center; background-size:cover; padding:<?php the_field('padding_top_20'); ?> 0px <?php the_field('padding_bottom_20'); ?> 0px !important; color:<?php the_field('text_color_20'); ?>; max-width:1300px; margin:0 auto;">
	<div class="content-sign-up-area" style="text-align:left;">
	<div class="title-sign-up-section" style="color:<?php the_field('text_color_20'); ?>; margin-bottom:10px; font-size:<?php the_field('font_size_20'); ?>; line-height:<?php the_field('line_heright_20'); ?>;">
		<?php the_field('content_banner_20'); ?>
	</div><!--end title-sign-up-section-->
		<a class="k-button k-button--primary" href="<?php the_field('button_url_20'); ?>"><?php the_field('button_title_20'); ?></a>
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<section id="sign-up-area">
	<div class="content-sign-up-area" style="max-width:1200px !important;">
	<div class="title-sign-up-section">
		<?php the_field('title_instagram_feeds'); ?>
	</div><!--end title-sign-up-section-->
	<div class="content-sign-up-section">
		<?php the_field('subtitle_instagram_feeds'); ?>
	</div><!--end content-sign-up-section-->
		<?php echo do_shortcode( '[instagram-feed]' ); ?>
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->
<section id="sign-up-area" style="padding-top:2% !important;">
	<div class="content-sign-up-area" style="max-width:1200px !important;">
	<?php if(get_field('title_reviews')){ ?>
	<div class="title-sign-up-section">
		<?php the_field('title_reviews'); ?>
	</div><!--end title-sign-up-section-->
	<?php } ?>
	<?php if(get_field('subtitle_reviews')){ ?>
	<div class="content-sign-up-section">
		<?php the_field('subtitle_reviews'); ?>
	</div><!--end content-sign-up-section-->
	<?php } ?>
	<?php if(get_field('reviews_code')){ ?>
		<?php the_field('reviews_code'); ?>		
	<?php } ?>
		</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

</section>
<?php
  get_footer();
?>