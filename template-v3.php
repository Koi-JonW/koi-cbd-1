<?php
defined('ABSPATH') || exit;
/* Template Name: Template V3 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<style type="text/css">

#banner-refer-friend{width:100%; padding:6% 0% 6%; font-size: 20px; line-height: 26px; color:#fff;}
#banner-refer-friend .banner-above-titles-v2{font-family: Recoleta Regular,serif; font-size: 26px; line-height: 26px; color:#fff; padding: 10px 0 10px 0; text-align: center;}
#banner-refer-friend .banner-titles-v2{font-family: Recoleta Regular,serif; font-size: 60px; line-height: 60px; color:#fff; padding: 10px 0 20px 0; text-align: center;}
#banner-refer-friend .banner-description-v2{padding:35px 0px; text-align: center; max-width: 390px; margin: 0 auto;}
#banner-refer-friend .banner-underline{ border-bottom: 1px solid #fff; width: 200px; margin: 0 auto; display: block;}
#banner-refer-friend .k-button{padding:20px 75px; text-align: center; margin: 0 auto;}
#banner-refer-friend .button-text-below{padding:30px 0px 10px; font-size: 16px; text-align: center;}
#banner-refer-friend .yotpo-box{ text-align: center; margin: 0 auto; max-width: 400px; width: 100%; padding-bottom: 60px;}
#banner-refer-friend .yotpo-box .k-button{margin-top: 10px; margin-bottom: 10px;}
#banner-refer-friend .yotpo-box .input-text{height: 60px; width: 100%; padding-left: 20px; padding-right: 20px; background-color: rgba(255,255,255,0.8); border: none; margin-bottom: 10px; display: block;}
#banner-refer-friend .yotpo-box .input-text::placeholder{color: #000000; font-size: 16px;}

</style>
<section id="banner-refer-friend" style="background:url('<?php the_field('background_image'); ?>') no-repeat; background-size:cover;">
    <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
    <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
    <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
    <div class="banner-underline"></div>
    <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
    <div class="yotpo-box">
        <input type="text" class="input-text" placeholder="Your email">
        <a href="" class="k-button k-button--primary">Next</a>
    </div>
</section>

<?php get_footer(lp); ?>