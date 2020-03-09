<?php
defined('ABSPATH') || exit;
/* Template Name: Template V4 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>

<section id="banner-refer-friend" style="background:url('<?php the_field('background_image'); ?>') no-repeat; background-size:cover;">
    <div class="banner-row">
        <div class="banner-left">
            <div class="banner-above-titles-v2"><?php the_field('banner_above_title'); ?></div>
            <div class="banner-titles-v2"><?php the_field('banner_title'); ?></div>
            <div class="banner-description-v2"><?php the_field('banner_content'); ?></div>
            <div class="banner-underline"></div>
            <div class="button-text-below"><?php the_field('text_below_line'); ?></div>
            <div class="yotpo-box">
                <input type="text" class="input-text" placeholder="Your friends' emails (separated by commas)">
                <a href="" class="k-button k-button--primary">Send</a>
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
            <div class="check-rewards-below-table"><?php the_field('text_below_table_i'); ?></div>
            <div class="check-rewards-below-table-2"><?php the_field('text_below_table_ii'); ?></div>
            <div class="yotpo-box">
                <a href="" class="k-button k-button--primary">Shop Now</a>
            </div>
        </div>
    </div>
</section>

<script>
	var $ = jQuery.noConflict();
</script>

<?php get_footer(lp); ?>