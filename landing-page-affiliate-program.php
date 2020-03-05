<?php
defined('ABSPATH') || exit;
/* Template Name: LP Affiliate Program */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<section id="banner-lp" style="background:url('<?php the_field('background_banner'); ?>') no-repeat; background-size:cover;">
	<div class="k-inner k-inner--md">
		<div class="banner-l">
			<div class="banner-small-titles"><?php the_field('small_title_lp'); ?></div><!--end banner-titles-->
			<div class="banner-titles"><?php the_field('big_title_lp'); ?></div><!--end banner-titles-->
		</div><!--end banner-l-->
		<div class="banner-r">
			<div class="banner-description"><?php the_field('description_banner_lp'); ?></div><!--end banner-description-->
		</div><!--end banner-r-->
	</div><!--end k-inner k-inner--md-->
</section><!--end banner-lp-->

<?php new Breadcrumbs([
  [
    'name' => 'Home',
    'url' => home_url()
  ],
  [
    'name' => get_the_title(),
    'url' => get_the_permalink()
  ]
]); ?>

<section id="boxes-section">
	<div class="content-area">
		<?php
		if( have_rows('boxes') ):
		while ( have_rows('boxes') ) : the_row(); ?>
		<div class="box-area">
			<div class="icon-box-area" style="text-align: center;">
				<img src="<?php the_sub_field('icon_box_section'); ?>" alt="box-icon"/>
			</div><!--end icon-box-area-->
			<div class="title-box-area" style="text-align: center;"><?php the_sub_field('title_box_section'); ?></div><!--end title-box-area-->
			<div class="description-box-area" style="text-align: center;"><?php the_sub_field('description_box_section'); ?></div><!--end description-box-area-->
		</div><!--end box-area-->   	
		<?php endwhile; endif; ?>
	</div><!--end k-inner k-inner--md-->
</section><!--end boxes-section-->

<section id="middle-area-section" style="background:url('<?php the_field('banner_background_image'); ?>') no-repeat center; background-size:cover;">
	<div class="middle-area-small"><?php the_field('small_text_banner'); ?></div>
	<div class="middle-area-big"><?php the_field('big_text_banner'); ?></div>
	<a class="middle-area-link" href="<?php the_field('button_url'); ?>" rel="link"><?php the_field('button_text_banner'); ?></a>
</section><!--end banner-section-lp-->

<section id="sign-up-area">
	<div class="content-sign-up-area">
		<div class="title-sign-up-section">
			<?php the_field('title_sign_up_section'); ?>
		</div><!--end title-sign-up-section-->
		<div class="content-sign-up-section">
			<?php the_field('content_sign_up_section'); ?>
		</div><!--end content-sign-up-section-->
		<a href="<?php the_field('button_url_sign_up'); ?>" class="k-button k-button--primary"><?php the_field('button_text_sign_up'); ?></a>
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<?php


get_footer(lp);
?>
