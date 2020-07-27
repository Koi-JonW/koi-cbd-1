<?php
defined('ABSPATH') || exit;
/* Template Name: Lab Results 2020 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>

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
if(get_sub_field('visible') == "yes"){
	the_title().'<br/>';
	the_sub_field('parent_id').'<br/>';
	the_sub_field('sku').'<br/>';
	the_sub_field('number_batch_variations').'<br/>';
	the_sub_field('strength_variations').'<br/>';
	the_sub_field('size_variations').'<br/>';
	the_sub_field('date_variations').'<br/>';
	the_sub_field('variant_title').'<br/>';
	the_sub_field('searchable').'<br/>';
	the_sub_field('custom_1').'<br/>';
	the_sub_field('custom_2').'<br/>';
	the_sub_field('custom_3').'<br/>';
		if( have_rows('coa_url_batch_variations') ):
			while ( have_rows('coa_url_batch_variations') ) : the_row();
				the_sub_field('file_url_var');
			endwhile;
		endif;
		echo '<br/>';
		global $post, $product;
    		$categ = $product->get_categories();
    		echo $categ; 


foreach((get_the_category()) as $category) {
$postcat= $category->cat_ID;
$category_name =$category->cat_name;
echo $category_name;
}

?>
..................................
<?php
$featured_posts = get_sub_field('category');
if( $featured_posts ): ?>
    <ul>
    <?php foreach( $featured_posts as $featured_post ): 
        $permalink = get_permalink( $featured_post->ID );
        $title = get_the_title( $featured_post->ID );
        $custom_field = get_field( 'field_name', $featured_post->ID );
        ?>
        <li>
            <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
            <span>A custom field from this post: <?php echo esc_html( $custom_field ); ?></span>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
			
	echo '<br/><br/>';
}
	endwhile;
endif;
?>

<?php endwhile; ?>
*************************
   
------------------------------------------------------1111
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
++++++++++++++++++++++++
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
22222222222222222222222222222222222222222
<?php get_footer(lp); ?>
