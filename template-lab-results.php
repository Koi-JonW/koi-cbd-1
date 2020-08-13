<?php
defined('ABSPATH') || exit;
/* Template Name: Lab Results 2020 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<div id="tinctures_shots">Tinctures & Shots</div>
<div id="tinctures_tinctures">Tinctures & Shots</div>


<?php $args = array(
        'post_type'   => 'product',
        'post_status' => 'publish',
        'orderby'     => 'date',
        'order'       => 'DESC',
        'posts_per_page' => -1
    ); $products = new WP_Query( $args ); $wp_products = array(); 
?>
<?php while ( $products->have_posts() ): ?>
        <?php ($products->the_post()); ?>
<?php 
if( have_rows('lab_results_variations') ):
	while ( have_rows('lab_results_variations') ) : the_row();
	if(get_sub_field('visible') == "yes"){ ?>
	<div class="divv <?php echo get_field('category_principal').get_field('subcategory_principal'); ?>" style="display:none;">
	<?php
	echo get_the_title().'<br/>';
	echo get_sub_field('parent_id').'<br/>';
	echo get_sub_field('sku').'<br/>';
	echo get_sub_field('number_batch_variations').'<br/>';
	echo get_sub_field('strength_variations').'<br/>';
	echo get_sub_field('size_variations').'<br/>';
	echo get_sub_field('date_variations').'<br/>';
	echo get_sub_field('variant_title').'<br/>';
	echo get_sub_field('searchable').'<br/>';
	echo get_sub_field('custom_1').'<br/>';
	echo get_sub_field('custom_2').'<br/>';
	echo get_sub_field('custom_3').'<br/>';
	if( have_rows('coa_url_batch_variations') ):
		while ( have_rows('coa_url_batch_variations') ) : the_row();
			echo get_sub_field('file_url_var');
		endwhile;
	endif;
	global $post, $product;
    	$categ = $product->get_categories();
    	echo $categ; 
?>

<?php
		echo '</div>';		
}
	endwhile;
endif;
?>

<?php endwhile; ?>
<?php 
if($_GET['show']){


if( have_rows('lab_results_variations') ):
    while ( have_rows('lab_results_variations') ) : the_row();
        the_sub_field('number_batch_variations'); ?>

<!-- relationship start -->

<?php 

$posts = get_sub_field('variant_id');

if( $posts ): ?>
    <ul>
    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <li>
<?php print_r($post); ?>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <span>Custom field from $post: <?php the_sub_field('author'); ?></span>

<?php echo $sku = get_post_meta( $item['variation_id'], '_sku', true ); ?>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>

<!-- relationship end -->



<?php    endwhile;
endif;



} // end get
?>
<script>
jQuery("#tinctures_shots").click(function(){
  jQuery(".divv").hide();
  jQuery(".tinctures_shotsshots").show();
});
</script>

<?php get_footer(lp); ?>
