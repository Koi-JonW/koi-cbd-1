<?php
defined('ABSPATH') || exit;
/* Template Name: LP Subscribe & Save */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<section id="banner-lp" style="background:url('<?php the_field('background_banner'); ?>') no-repeat; background-size:cover; padding:15% 0% 5% 0%;">
	<div class="k-inner k-inner--md">
		<div class="banner-l" style="width:100%; text-align:center;">
			<!-- <div class="banner-small-titles"><?php // the_field('small_title_lp'); ?></div>--><!--end banner-titles-->
			<div class="banner-titles"><?php the_field('big_title_lp'); ?></div><!--end banner-titles-->
		</div><!--end banner-l-->
		<div class="banner-r" style="width:100%; margin:0px 0px 0px 0px !important; text-align:center;">
			<div class="banner-description" style="margin-bottom:0px;"><?php the_field('description_banner_lp'); ?></div><!--end banner-description-->
		</div><!--end banner-r-->
<div class="k-hero--action" style="text-align:center; width:100%; margin-top:40px;">
            <a href="/cbd-gummies/" class="k-button k-button--primary">
          Shop Softgels &nbsp; &#8594;
        </a>
        </div>
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

<?php if(get_field('big_text_banner')){ ?>
<section id="middle-area-section" style="background:url('<?php the_field('banner_background_image'); ?>') no-repeat center; background-size:cover;">
	<div class="middle-area-small"><?php the_field('small_text_banner'); ?></div>
	<div class="middle-area-big"><?php the_field('big_text_banner'); ?></div>
	<a class="middle-area-link" href="<?php the_field('button_url'); ?>" rel="link"><?php the_field('button_text_banner'); ?></a>
</section><!--end banner-section-lp-->
<?php } ?>

<section id="sign-up-area" style="padding-top:2% !important;">
	<div class="content-sign-up-area">
		<h3 class="title-sign-up-section" style="text-align:center; margin:0px;">
			<?php the_field('title_qa_section'); ?>
		</h3><!--end title-sign-up-section-->
		<div class="content-sign-up-section" style="display:flex; flex-wrap:wrap;">
		<?php
		if( have_rows('boxes_general_section') ):
		while ( have_rows('boxes_general_section') ) : the_row(); ?>
		<div class="new-boxes-27">
			<div class="new-boxes-27-title"><?php the_sub_field('title_boxes'); ?></div>
		<?php the_sub_field('description_boxes'); ?>
		</div><!--end new-boxes-27-->
		<?php endwhile; endif; ?>
		</div>
	</div>
</section><!--end boxes-section-->

<section id="sign-up-area" style="padding-top:2% !important;">
	<div class="content-sign-up-area">
		<div class="title-sign-up-section" style="text-align:center;">
			<?php the_field('text_boxes_area'); ?>
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
				</div>
				<div id="close_<?php echo $id; ?>" class="simbol-qa-pos" onclick="qa<?php echo $id; ?>();" style="display:block;">+</div>
				<div id="open_<?php echo $id; ?>" class="simbol-qa-neg" onclick="qaclose<?php echo $id; ?>();" style="display:none;">-</div>
			</div>
			<div id="answer_<?php echo $id; ?>" class="box-content-qa" style="display:none;"><?php echo get_sub_field('answer'); ?></div>
		</div><!--end content-box-qa-->
		<?php endwhile; endif; ?>
		</div><!--end content-sign-up-section-->
	</div><!--end content-sign-up-area-->
</section><!--end sign-up-area-->

<?php
  echo "<section id='landing-page-sections'>";
  // $testimonial_fields = array(
  //  'testimonials' => $site_content['homepage_testimonials'],
  // );
  // include(locate_template('partials/testimonial-slider.php'));
  $slider_fields = array(
    'headline' => $site_content['product_slider_headline'],
    'products' => $site_content['product_slider_products'],
    'half_padding_top' => true,
  );
  include(locate_template('partials/promo-slider.php'));

    echo "</section>";

?>
<?php
get_footer(lp);
?>
