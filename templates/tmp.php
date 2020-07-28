<?php
/* Template Name: TMP */

get_header();


function get_subcategories_by_category_id($category_id){

    $args = array(
       'hierarchical' => 1,
       'show_option_none' => '',
       'hide_empty' => 0,
       'parent' => $category_id,
       'taxonomy' => 'product_cat'
    );

    return(get_categories($args));

}

function get_products_by_category_id($category_id){

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'tax_query' => array(
            array(
				'taxonomy' => 'product_cat',
				'field' => 'term_id',
                'terms' => $category_id,
                'operator' => 'IN'
            )
        )
    );
    
	$query = new WP_Query($args);

    return $query->posts;

}

function get_variations_by_product_id($product_id){

    $product = wc_get_product($product_id);

	return $product->get_available_variations();

}

function get_product_type($post_title){

	$title_arr = explode('|', $post_title);

	if(count($title_arr) > 1){
		return trim(end($title_arr));
	} else {
		return '---';
	}

}

?>

<h2>-- get_subcategories_by_category_id:</h2>
<pre><?php // var_dump(get_subcategories_by_category_id(265)); ?></pre>

<h2>-- get_products_by_category_id:</h2>
<pre><?php // var_dump(get_products_by_category_id(5173)); ?></pre>

<h2>-- get_variations_by_product_id:</h2>
<pre><?php // var_dump(get_variations_by_product_id(505482)); ?></pre>

<hr />

<?php $sub_categories = get_subcategories_by_category_id(265); ?>
<?php foreach($sub_categories as $category): ?>
<div class='accordion'>
    <div class='accordion-title'><?php echo($category->name); ?></div>
	<div class='accordion-content'>
        <?php $products = get_products_by_category_id($category->term_id); ?>
	<?php foreach($products as $product): ?>
        <?php $lab_results_variations = get_field('lab_results_variations', $product->ID); ?>
        <div class='accordion'>
            <div class='accordion-title'><?php echo(get_product_type($product->post_title)); ?></div>
            <div class='accordion-content'>
                <?php $variations = get_variations_by_product_id($product->ID); ?>
		<?php foreach($variations as $variation): ?>
                <div class="accordion">
                    <div class="accordion-link"><?php echo($variation['attributes']['attribute_strength']); ?></div>
		    <div class="accordion-details">
			<pre>
			<?php $lab_results = array_filter($lab_results_variations, function($item) use ($variation){
                            return ($item['variant_id'] == strval($variation['variation_id'])) && ($item['visible'] == 'yes');
                        }); ?>
			</pre>
                        <pre><?php var_dump($lab_results); ?></pre>
                    </div>
                <?php endforeach; ?>
            </div>
        <div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<?php
get_footer();
?>
