<?php
defined('ABSPATH') || exit;
/* Template Name: V2 Lab Results 2020 */


function get_root_categories(){

    $args = array(
       'hierarchical' => 1,
       'show_option_none' => '',
       'hide_empty' => 0,
       'parent' => 0,
       'taxonomy' => 'product_cat'
    );

    return(get_categories($args));

}

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

    wp_reset_query();

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

function prepare_view($category_ids){

    $result = [];

    foreach($category_ids as $category_id){

        $category = get_term_by('id', $category_id, 'product_cat');

        $arr_category = [
            'title' => $category->name,
            'content' => []
        ];

        $sub_categories = get_subcategories_by_category_id($category->term_id);

        if($sub_categories){

            $arr_category['has_subcategories'] = true;

            foreach($sub_categories as $sub_category){

                $arr_sub_category = [
                    'title' => $sub_category->name,
                    'content' => []
                ];

                $products = get_products_by_category_id($sub_category->term_id);

                foreach($products as $product){

                    $arr_product = [
                        'title' => get_product_type($product->post_title),
                        'content' => []
                    ];

                    $product_wc = wc_get_product($product->ID);
                    $product_repeater_lab_results = get_field('lab_results_variations', $product->ID);

                    if($product_wc->is_type('variable')){

                        $arr_product['has_variations'] = true;

                        $product_variations = $product_wc->get_available_variations();

                        foreach($product_variations as $variation){

                            $product_lab_results = array_filter($product_repeater_lab_results, function($item) use ($variation){ return (($item['variant_id'] == strval($variation['variation_id'])) && ($item['visible'] == 'yes')); });
                            $product_lab_results = $product_lab_results ? end($product_lab_results) : [];

                            if($product_lab_results){

                                $arr_product_coa_urls = [];

                                foreach($product_lab_results['coa_url_batch_variations'] as $item){
                                    $arr_product_coa_urls[] = $item['file_url_var'];
                                }

                                $arr_results = [
                                    'title' => $product_lab_results['strength_variations'],
                                    'results' => [
                                        'variant_id' => $product_lab_results['variant_id'],
                                        'title' => $product->post_title,
                                        'strength' => $product_lab_results['strength_variations'],
                                        'size' => $product_lab_results['size_variations'],
                                        'batch' => $product_lab_results['number_batch_variations'],
                                        'coa_urls' => $arr_product_coa_urls
                                    ]
                                ];

                                $arr_product['content'][] = $arr_results;

                            }

                        }

                    } else {

                        $arr_product['has_variations'] = false;

                        $product_lab_results = array_filter($product_repeater_lab_results, function($item){ return ($item['visible'] == 'yes' && $item['variant_id'] != ''); });
                        $product_lab_results = $product_lab_results ? end($product_lab_results) : [];

                        if($product_lab_results){

                            $arr_product_coa_urls = [];

                            foreach($product_lab_results['coa_url_batch_variations'] as $item){
                                $arr_product_coa_urls[] = $item['file_url_var'];
                            }

                            $arr_results = [
                                'title' => $product_lab_results['strength_variations'],
                                'results' => [
                                    'variant_id' => $product_lab_results['variant_id'],
                                    'title' => $product->post_title,
                                    'strength' => $product_lab_results['strength_variations'],
                                    'size' => $product_lab_results['size_variations'],
                                    'batch' => $product_lab_results['number_batch_variations'],
                                    'coa_urls' => $arr_product_coa_urls
                                ]
                            ];

                            $arr_product['content'][] = $arr_results;

                        }

                    }

                    // --

                    if($arr_product['content']){
                        $arr_sub_category['content'][] = $arr_product;
                    }

                }

                // --

                if($arr_sub_category['content']){
                    $arr_category['content'][] = $arr_sub_category;
                }

            }

        } else {

            $arr_category['has_subcategories'] = false;

            $products = get_products_by_category_id($category->term_id);

            foreach($products as $product){

                $arr_product = [
                    'title' => get_product_type($product->post_title),
                    'content' => []
                ];

                $product_wc = wc_get_product($product->ID);
                $product_repeater_lab_results = get_field('lab_results_variations', $product->ID);

                if($product_wc->is_type('variable')){

                    $arr_product['has_variations'] = true;

                    $product_variations = $product_wc->get_available_variations();

                    foreach($product_variations as $variation){

                        $product_lab_results = array_filter($product_repeater_lab_results, function($item) use ($variation){ return (($item['variant_id'] == strval($variation['variation_id'])) && ($item['visible'] == 'yes')); });
                        $product_lab_results = $product_lab_results ? end($product_lab_results) : [];

                        if($product_lab_results){

                            $arr_product_coa_urls = [];

                            foreach($product_lab_results['coa_url_batch_variations'] as $item){
                                $arr_product_coa_urls[] = $item['file_url_var'];
                            }

                            $arr_results = [
                                'title' => $product_lab_results['strength_variations'],
                                'results' => [
                                    'variant_id' => $product_lab_results['variant_id'],
                                    'title' => $product->post_title,
                                    'strength' => $product_lab_results['strength_variations'],
                                    'size' => $product_lab_results['size_variations'],
                                    'batch' => $product_lab_results['number_batch_variations'],
                                    'coa_urls' => $arr_product_coa_urls
                                ]
                            ];

                            $arr_product['content'][] = $arr_results;

                        }

                    }

                } else {

                    $arr_product['has_variations'] = false;

		    $product_lab_results = array_filter($product_repeater_lab_results, function($item){ return ($item['visible'] == 'yes' && $item['variant_id'] != ''); });
                    $product_lab_results = $product_lab_results ? end($product_lab_results) : [];

                    if($product_lab_results){

                        $arr_product_coa_urls = [];

			foreach($product_lab_results['coa_url_batch_variations'] as $item){
                            $arr_product_coa_urls[] = $item['file_url_var'];
                        }

                        $arr_results = [
                            'title' => $product_lab_results['strength_variations'],
                            'results' => [
                                'variant_id' => $product_lab_results['variant_id'],
                                'title' => $product->post_title,
                                'strength' => $product_lab_results['strength_variations'],
                                'size' => $product_lab_results['size_variations'],
                                'batch' => $product_lab_results['number_batch_variations'],
                                'coa_urls' => $arr_product_coa_urls
                            ]
                        ];

                        $arr_product['content'][] = $arr_results;

                    }

                }

                // --

                if($arr_product['content']){
                    $arr_category['content'][] = $arr_product;
                }

            }

        }

        // --

        if($arr_category['content']){
            $result[] = $arr_category;
        }

    }

    return $result;

}

?>
<?php get_header(); ?>
<section class="k-hero k-hero--twocol k-hero--labresults k-hero--loaded">
  <div class="k-hero--bgimg lazyload--progress lazyload--complete" data-src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/themes/KOI-2019/dist/img/lab-results-hero-1-20.jpg" style="background-image: url(https://koicbdstaging.wpengine.com/wp-content/themes/KOI-2019/dist/img/lab-results-hero-1-20.jpg)"></div>
  <div class="k-inner k-inner--md">

    <div class="k-hero__main">
    
      <div class="k-hero__heading">
        <h1 class="k-preheading k-upcase">Lab Results</h1>
        <h2 class="k-headline k-headline--md">From Plant to Finished Product</h2>
      </div>
    
      <div class="k-hero__body k-rte-content">
        <p>All Koi products are lab-tested for purity, consistency, and safety. Plus, we offer full traceability on every batch of our CBD.</p>
      </div>

    </div>
  
  </div>
</section>
<nav class="breadcrumbs">
	<div class="k-inner k-inner--md">
		<ul class="breadcrumbs-links">
			<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
			<li>Lab Results</li>
		</ul>
	</div>
</nav><!--end breadcrumbs-->
<section class="k-recentresults k-block k-block--md k-no-padding--bottom">
	<div class="k-inner k-inner--sm">
		<div class="k-recentresults__intro">
			<h3 class="k-headline k-headline--md">Recent Lab Results</h3>
			<p class="k-rte-content">
			Knowing exactly what is in your CBD product is important, from the potency to the purity. At Koi, we test our USA-grown hemp extracts before we infuse them into our products, and then test every final batch we make with an accredited, independent lab. All the details are made available, providing transparency and trust.      
			</p>
		</div><!--end k-recentresults__intro-->
	</div><!--end k-inner k-inner--sm-->
</section>

<!-- LAB-RESULTS:BEGIN  -->

<?php $root_categories = get_root_categories(); ?>
<?php $category_ids = array_map(function($item){ return $item->term_id; }, $root_categories); ?>
<?php $lab_results_view = prepare_view($category_ids); ?>
<div class="category-wrapper">
<?php foreach($lab_results_view as $category): ?>
    <div class="category-block">
	<div class="category-title">
            <?php echo($category['title']); ?>
            <span class="arr">&#9660;</span>
        </div>
        <div class="category-content">
        <?php if($category['has_subcategories']): ?>
        <?php foreach($category['content'] as $sub_category): ?>
            <div class='accordion'>
                <div class='accordion-title'>
                    <?php echo($sub_category['title']); ?>
                    <span class="arr" style="font-size:13px;">&#9660;</span>
                </div>
                <div class='accordion-content'>
                    <?php foreach($sub_category['content'] as $product): ?>
                    <div class='accordion'>
                        <div class='accordion-title'>
                            <?php echo($product['title']); ?>
                            <span class="arr" style="font-size:13px;">&#9660;</span>
                        </div>
			<div class='accordion-content'>
                        <?php if($product['has_variations']): ?>
                        <?php foreach($product['content'] as $variation): ?>
                            <div class='accordion'>
                                <div id="<?php echo($variation['results']['variant_id']); ?>" class="accordion-link">
                                    <?php echo($variation['title']); ?>
                                    <span class="arr" style="font-size:25px; margin-top:-10px;">&#9656;</span>
                                </div>
                                <div class="accordion-popup">
                                    <div class="popup-content">
                                        <div class="close-pp">X</div>
                                        <div class="popup-area-a">
                                            <h3 class="k-headline k-headline--sm k-promoslider--titlerow__item"><?php echo($product['title']); ?></h3>
                                        </div>
                                        <div class="popup-area-b">Variant: <?php echo($variation['results']['strength']); ?><br>Size: <?php echo($variation['results']['size']); ?><br>Batch #: <?php echo($variation['results']['batch']); ?></div>
                                        <div class="popup-area-b">
                                        <?php foreach($variation['results']['coa_urls'] as $url): ?>
                                            <a class="red-btn-coa" target="_blank" href="<?php echo($url); ?>" rel="noopener noreferrer">View this produc's Certificate of Analysis (COA)</a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
			    </div>
                        <?php endforeach; ?>
                        <?php else: ?>
			<?php foreach($product['content'] as $item): ?>
                            <div class="accordion">
                                <div id="<?php echo($item['results']['variant_id']); ?>" class="accordion-link">
                                    <?php echo($item['title']); ?>
                                    <span class="arr" style="font-size:25px; margin-top:-10px;">&#9656;</span>
                                </div>
                                <div class="accordion-popup">
                                    <div class="popup-content">
                                        <div class="close-pp">X</div>
                                        <div class="popup-area-a">
                                            <h3 class="k-headline k-headline--sm k-promoslider--titlerow__item"><?php echo($product['title']); ?></h3>
                                        </div>
                                        <div class="popup-area-b">Variant: <?php echo($item['results']['strength']); ?><br>Size: <?php echo($item['results']['size']); ?><br>Batch #: <?php echo($item['results']['batch']); ?></div>
                                        <div class="popup-area-b">
                                        <?php foreach($item['results']['coa_urls'] as $url): ?>
                                            <a class="red-btn-coa" target="_blank" href="<?php echo($url); ?>" rel="noopener noreferrer">View this produc's Certificate of Analysis (COA)</a>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
	  		    </div>
                        <?php endforeach; ?>
			<?php endif; ?>
                        </div>
		    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
        <?php foreach($category['content'] as $product): ?>
            <div class='accordion'>
                <div class='accordion-title'>
                    <?php echo($product['title']); ?>
                    <span class="arr" style="font-size:13px;">&#9660;</span>
                </div>
                <div class='accordion-content'>
                <?php if($product['has_variations']): ?>
                <?php foreach($product['content'] as $variation): ?>
                    <div class='accordion'>
                        <div id="<?php echo($variation['results']['variant_id']); ?>" class="accordion-link">
                            <?php echo($variation['title']); ?>
                            <span class="arr" style="font-size:25px; margin-top:-10px;">&#9656;</span>
                        </div>
                        <div class="accordion-popup">
                            <div class="popup-content">
                                <div class="close-pp">X</div>
                                <div class="popup-area-a">
                                    <h3 class="k-headline k-headline--sm k-promoslider--titlerow__item"><?php echo($product['title']); ?></h3>
                                </div>
                                <div class="popup-area-b">Variant: <?php echo($variation['results']['strength']); ?><br>Size: <?php echo($variation['results']['size']); ?><br>Batch #: <?php echo($variation['results']['batch']); ?></div>
                                <div class="popup-area-b">
                                <?php foreach($variation['results']['coa_urls'] as $url): ?>
                                    <a class="red-btn-coa" target="_blank" href="<?php echo($url); ?>" rel="noopener noreferrer">View this produc's Certificate of Analysis (COA)</a>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
		    </div>
                <?php endforeach; ?>
                <?php else: ?>
		<?php foreach($product['content'] as $item): ?>
                    <div class="accordion">
                        <div id="<?php echo($item['results']['variant_id']); ?>" class="accordion-link">
                            <?php echo($item['title']); ?>
                            <span class="arr" style="font-size:25px; margin-top:-10px;">&#9656;</span>
                        </div>
                        <div class="accordion-popup">
                            <div class="popup-content">
                                <div class="close-pp">X</div>
                                <div class="popup-area-a">
                                    <h3 class="k-headline k-headline--sm k-promoslider--titlerow__item"><?php echo($product['title']); ?></h3>
                                </div>
				<div class="popup-area-b">Variant: <?php echo($item['results']['strength']); ?><br>Size: <?php echo($item['results']['size']); ?><br>Batch #: <?php echo($item['results']['batch']); ?></div>
				<div class="popup-area-b">
				<?php foreach($item['results']['coa_urls'] as $url): ?>
				    <a class="red-btn-coa" target="_blank" href="<?php echo($url); ?>" rel="noopener noreferrer">View this produc's Certificate of Analysis (COA)</a>
                                <?php endforeach; ?>
				</div>
			    </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
	<?php endforeach; ?>
        <?php endif; ?>
	</div>
    </div>
<?php endforeach; ?>
</div>

<!-- LAB-RESULTS:END -->

<!-- LAB-SEARCH: BEGIN -->

<section class="k-labresults k-block k-block--sm k-no-padding--bottom" style="padding-bottom: 4em !important;">
  <div class="k-inner k-inner--sm">
    <div class="k-labresults__spacer"></div>
  </div>
  <div class="k-inner k-inner--md">

    <div id="resultsembedtarget" class="k-labresults__searchform">
      <div class="k-labresults__content">
        <h4 class="k-headline k-headline--sm">Search by Batch</h4>
        <p class="k-rte-content">Find the lab results of every Koi product by using its unique batch number. Not sure where to find your product's batch number? Check out <a href="https://koicbdstaging.wpengine.com/wp-content/uploads/tracking-with-batch-numbers.jpg" target="_blank" rel="noopener noreferrer">this example.</a></p>
      </div>
      <form class="k-form" id="k-resultssearch-" method="post" action="#resultsembedtarget">
        <div class="form-content-lr">
		<div class="form-content-lr-inputext">
            <input type="text" name="lab-result-search" id="k-resultssearchval" placeholder="Enter Batch Number">
		</div><!--end form-content-lr-inputext-->
		<div class="form-content-lr-inputsubmit">
            <input type="submit" class="k-button k-button--primary k-upcase" value="Search">
		</div><!--end form-content-lr-inputsubmit -->
        </div>
      </form>
    </div>

<div class="k-labresults__main" style="padding-top:0px !important;">
<div>
<?php
$show_batch = $_POST['lab-result-search'];
	   $args = array(
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
					if($show_batch == get_sub_field('number_batch_variations')){
		?>
<div class="popup-content" style="margin-top:0px !important;">
	<div class="popup-area-a"><h3 class="k-headline k-headline--sm k-promoslider--titlerow__item"><?php echo get_the_title(); ?></h3></div>
		<div class="popup-area-b">
			Variant: <?php echo get_sub_field('strength_variations'); ?><br/>
			Size: <?php echo get_sub_field('size_variations'); ?><br/>
			Batch #: <?php echo get_sub_field('number_batch_variations'); ?>
		</div><!--end popup-area-b-->
		<div class="popup-area-b">
		<?php
				if( have_rows('coa_url_batch_variations') ):
					while( have_rows('coa_url_batch_variations') ) : the_row();
							$sub_url = get_sub_field('file_url_var');
						echo '<a class="red-btn-coa" target="_blank" href="'.$sub_url.'">View this produc\'s Certificate of Analysis (COA)</a>';

					endwhile;
				endif;
		?>
		</div><!--end popup-area-b-->
</div><!--end popup-content-->
					<?php }
				endwhile;
			endif;
		?>
<?php endwhile; ?>
</div><!--end resultsembedtarget-->
</div><!--end k-labresults__main-->

  </div><!--end k-inner-->
</section><!--end k-labresults-->

<!-- LAB-SEARCH: END -->

<style>
.form-content-lr{width:100%; display:flex; flex-wrap:wrap; max-width:767px;}
.form-content-lr-inputext{width:75%; border-left:1px solid #ccc; border-top:1px solid #ccc; border-bottom:1px solid #ccc; border-radius:5px; padding:4px 0px 0px 0px !important; margin-right:-10px;}
.form-content-lr-inputext input{width:100% !important; max-width:100% !important;  height:50px;}
.form-content-lr-inputsubmit{width:25%;}
.form-content-lr-inputsubmit input{padding:20px 0px !important; font-size:17px;}
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

.accordion-popup {
    position: fixed;
    background-color: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
    top: 0px;
    left: 0px;
    z-index: 99999;
    display: none;
}

.accordion-popup .red-btn-coa {
    margin-bottom: 5px;
}

.accordion-popup .red-btn-coa:last-child {
    margin-bottom: 0;
}

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
    $('.accordion-link').on('click', function(){
        $(this).parent().find('>.accordion-popup').fadeIn();
    });
    $('.accordion-popup .close-pp').on('click', function(){
        $(this).parents('.accordion-popup').fadeOut();
    });
});
</script>
