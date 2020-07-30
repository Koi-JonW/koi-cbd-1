<?php
defined('ABSPATH') || exit;
/* Template Name: V2 Lab Results 2020 */


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

function get_product_type($post_title){

    $title_arr = explode('|', $post_title);

    if(count($title_arr) > 1){
        return trim(end($title_arr));
    } else {
        return '---';
    }

}

?>
<?php get_header(); ?>
<?php $category_ids = [265,5157,266,256,259,264]; ?>

<div class="category-wrapper">
<?php foreach($category_ids as $category_id): ?>
<?php $category = get_term_by('id', $category_id, 'product_cat');  ?>
<div class="category-block">
    <div class="category-title"><?php echo($category->name); ?> <span class="arr">&#9660;</span></div>
    <div class="category-content">
        <?php $sub_categories = get_subcategories_by_category_id($category->term_id); ?>
        <?php foreach($sub_categories as $sub_category): ?>
        <div class='accordion'>
            <div class='accordion-title'><?php echo($sub_category->name); ?> <span class="arr" style="font-size:13px;">&#9660;</span></div>
            <div class='accordion-content'>
                <?php $products = get_products_by_category_id($sub_category->term_id); ?>
		<?php foreach($products as $product): ?>
		<?php $product_wc = wc_get_product($product->ID); ?>
                <?php $lab_results_variations = get_field('lab_results_variations', $product->ID); ?>
                <div class='accordion'>
                    <div class='accordion-title'><?php echo(get_product_type($product->post_title)); ?><span class="arr" style="font-size:13px;">&#9660;</span></div>
                    <div class='accordion-content'>
                    <?php if($product_wc->is_type('variable')): ?>
                        <?php $variations = $product_wc->get_available_variations(); ?>
                        <?php foreach($variations as $variation): ?>
                        <?php $lab_results = array_filter($lab_results_variations, function($item) use ($variation){
                            return (($item['variant_id'] == strval($variation['variation_id'])) && ($item['visible'] == 'yes'));
                        }); ?>
                        <?php $lab_results = count($lab_results) ? end($lab_results) : []; if($lab_results): ?>
			<div class="accordion">
                            <div id="<?php echo($variation['variation_id']); ?>" class="accordion-link"><?php echo($variation['attributes']['attribute_strength']); ?>  <span class="arr" style="font-size:25px; margin-top:-10px;">&#9656;</span></div>
                            <div class="accordion-details">
                                <?php $lab_results = array_filter($lab_results_variations, function($item) use ($variation){
                                    return (($item['variant_id'] == strval($variation['variation_id'])) && ($item['visible'] == 'yes'));
				}); ?>
				<?php $lab_results = count($lab_results) ? end($lab_results) : []; ?>
                                <div id="<?php echo($lab_results['variant_id']); ?>"><?php echo($lab_results['variant_id']); ?></div>
                            </div>
			</div>
                        <?php endif; ?>
                        <?php endforeach; ?>
		    <?php else: ?>
		    <?php // -- ?>
                    <?php endif; ?>
		    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
</div>
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
	while( have_rows('lab_results_variations') ) : the_row();
		echo '<div class="divv '.get_sub_field('variant_id').'" style="display:none; position:fixed; background-color: rgba(0,0,0,0.5); width:100%; height:100%; top:0px; left:0px; z-index:99999;">';
		echo '<div class="popup-content">';
		echo '<div class="close-pp">X</div>';
		echo '<div class="popup-area-a"><h3 class="k-headline k-headline--sm k-promoslider--titlerow__item">'.get_the_title().'</h3></div>';
		echo '<div class="popup-area-b">Variant: '.get_sub_field('strength_variations').'<br/>';
		echo 'Size: '.get_sub_field('size_variations').'<br/>';
		echo 'Batch #: '.get_sub_field('number_batch_variations').'</div>';
		echo '<div class="popup-area-b">';
		if( have_rows('coa_url_batch_variations') ):
			while( have_rows('coa_url_batch_variations') ) : the_row();
        			$sub_url = get_sub_field('file_url_var');
				echo '<a class="red-btn-coa" target="_blank" href="'.$sub_url.'">View this produc\'s Certificate of Analysis (COA)</a>';

			endwhile;
		endif;
		echo '</div>';
		echo '</div></div>';		
	endwhile;
endif;
?>

<?php endwhile; ?>

<script>
<?php while ( $products->have_posts() ): ?>
        <?php ($products->the_post()); ?>
<?php
if( have_rows('lab_results_variations') ):
	while( have_rows('lab_results_variations') ) : the_row(); ?>
	<?php if(get_sub_field('variant_id')){ ?>
		jQuery("#<?php echo get_sub_field('variant_id'); ?>").click(function(){
		jQuery(".divv").fadeOut();
		jQuery(".<?php echo get_sub_field('variant_id'); ?>").fadeToggle();
		});
	<?php } ?>
<?php	endwhile;
endif;
?>
<?php endwhile; ?>

jQuery(".close-pp").click(function(){
jQuery(".divv").fadeOut();
});

</script>

<style>
.popup-content{width:100%; max-width:1000px; border:10px solid #ffffff; background-color:#F7F7F7; display:flex; flex-wrap:wrap; align-content: center; align-items: center; margin:0 auto; position:relative; margin-top:10%;}
.popup-area-a{width:30%; margin:2%;}
.popup-area-b{width:29%; margin:2%;}
.popup-area-a h3{margin:0px; padding:0px;}
.popup-area-b .red-btn-coa{color:#fff; background-color:#FE0002; display:block; box-sizing:border-box; padding:25px; text-align:center; border-radius:5px;}
.popup-area-b .red-btn-coa:hover{box-shadow:0px 10px 10px #ccc;}
.close-pp{width:40px; height:40px; background-color:#000; color:#fff; position:absolute; right:-20px; top:-20px; border-radius:50px; font-family:"Recoleta Regular", serif; font-size:25px; line-height:40px; text-align:center; cursor:pointer;}

.arr{float:right; margin-right:25px;}
.category-wrapper {
    	padding: 20px;
	display:flex;
	flex-wrap:wrap;
}
.category-block {
    display: inline-block;
    width: 24%;
    margin:5px 0.5%;
}
.category-title {
    text-align: center;
    padding:25px 0px;
    margin: 10px;
    border:1px solid #DADADA;
    background-color:#fff;
    border-radius: 5px;
    cursor: pointer;
}
.category-title:hover{
    border:1px solid #F4B13E;
    background-color:#F4B13E;
    color:#fff;
}
.category-content {
    display: none;
    
}
.accordion {
    padding: 0 10px 0px 10px;
}
.accordion .accordion {
    padding: 0 0px 0px 0;
}
.accordion-title {
    padding: 10px 10px 10px 20px;
    background: #F7F7F7;
    border-radius: 0px;
    cursor: pointer;
}
.accordion .accordion .accordion-title {
	background: #EAEAEA;
	border-bottom:1px solid #A3A3A3;
}
.accordion-content {
    display: none;
    padding: 0px 0;
}
.accordion-link {
    padding: 10px 10px 10px 30px;
    background: #CFCFCF;
    border-radius: 0px;
    cursor: pointer;
    border-bottom:1px solid #A3A3A3;
    box-sizing:border-box;
}
.accordion-details {}

@media only screen and (max-width:1100px){

.popup-content{width:90%; max-width:1000px; display:flex; flex-wrap:wrap; align-content: center; align-items: center; margin-top:20%;}
.popup-area-a{width:30%; margin:2%;}
.popup-area-b{width:29%; margin:2%;}
.close-pp{width:40px; height:40px; background-color:#000; color:#fff; position:absolute; right:-20px; top:-20px; border-radius:50px; font-size:25px; line-height:40px; text-align:center; cursor:pointer;}

.category-wrapper {
    	padding: 20px;
	display:flex;
	flex-wrap:wrap;
}
.category-block {
    display: inline-block;
    width: 32.33%;
    margin:5px 0.5%;
}
.category-title {
    text-align: center;
    padding:25px 0px;
    margin: 10px;
    border:1px solid #DADADA;
    background-color:#fff;
    border-radius: 5px;
    cursor: pointer;
    font-size:14px;
}

.accordion-title {
    padding: 10px 10px 10px 20px;
    background: #F7F7F7;
    border-radius: 0px;
    cursor: pointer;
    font-size:12px;
}
.accordion-link {
    font-size:12px;
}

}

@media only screen and (max-width:767px){
.popup-content{width:90%; max-width:1000px; display:flex; flex-wrap:wrap; align-content: center; align-items: center; margin-top:50%;}
.popup-area-a{width:96%; margin:2%;}
.popup-area-b{width:96%; margin:2%;}
.popup-area-b .red-btn-coa{padding:15px 25px;}
.close-pp{width:30px; height:30px; right:-20px; top:-20px; font-size:20px; line-height:30px;}

.popup-area-a h3{margin-bottom:0px !important;}
}

@media only screen and (max-width:850px){
.category-block {
    display: inline-block;
    width: 48%;
    margin:5px 1%;
}
}

@media only screen and (max-width:560px){
.category-block {
    display: inline-block;
    width: 98%;
    margin:5px 1%;
}
}
</style>

<?php get_footer(lp); ?>


<script>


$(document).ready(function(){
   $('.category-title').on('click', function(){
        $(this).parent().find('.accordion-details').fadeOut();
        $(this).parent().find('>.category-content').fadeToggle();
   });
   $('.accordion-title').on('click', function(){
        $(this).parent().find('.accordion-details').fadeOut();
        $(this).parent().find('>.accordion-content').fadeToggle();
   });
   // $('.accordion-link').on('click', function(){
      //  $(this).parent().find('>.accordion-details').fadeIn();
   // });
});
</script>