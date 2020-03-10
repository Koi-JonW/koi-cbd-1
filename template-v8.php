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
            <img src="<?php the_field('left_image'); ?>" alt="">
        </div>
        <div class="banner-right">
            <div class="banner-above-titles-v3"><?php the_field('banner_above_title'); ?></div>
            <div class="banner-titles-v3"><?php the_field('banner_title'); ?></div>
            <div class="banner-description-v3"><?php the_field('banner_content'); ?></div>
            <div class="banner-underline"></div>
            <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
            <div class="yotpo-box">
                <input type="text" class="input-text" placeholder="Your friends’ emails (separated by commas)">
                <a href="" class="k-button k-button--primary">Send</a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(lp); ?>