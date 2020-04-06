<?php
/* Template Name: 2019 Product Listing Page */

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

$page_fields = get_fields();
$product_category = $page_fields['product_type']->name;
$product_category_slug = $page_fields['product_type']->slug;

get_header();

do_action('k_before_first_section');

$hero_fields = array(
  'preheading' => 'Koi CBD',
  'headline' => $product_category,
  'body' => $page_fields['hero_supporting_copy'],
  'background_image' => $page_fields['hero_background_image']['url'],
);

echo k_hero($hero_fields);

new Breadcrumbs([
  [
    'name' => 'Home',
    'url' => home_url()
  ],
  [
    'name' => 'Shop All',
    'url' => home_url() . '/cbd-products'
  ],
  [
    'name' => $product_category,
    'url' => home_url() . '/' . $page_fields['product_type']->slug
  ]
]);

$list_flavored_only = $_GET['flavored'] == true;
$unflavored_products = array(205502, 30207);
?>

  <section class="k-productlisting k-block k-block--md k-no-padding--bottom">
    <div class="k-inner k-inner--md">

      <?php
      $args = array(
        'limit' => -1,
        'status' => 'publish',
        'visibility' => 'visible',
        'post_type' => 'product',
        'category' => array($product_category_slug),
	   'orderby' => 'menu_order',
      );

      $products = wc_get_products($args);

      foreach ($products as $idx => $product) {
        $id = $product->get_id();
        $name = $product->get_name();
        $bottomline_url = 'https://api.yotpo.com/v1/widget/MS3VY5Cc4TFD6zbI2zGhMsb9gvkPpQDKwUcPhaSG/products/' . $id . '/bottomline';
        $bottomline_response = wp_remote_get($bottomline_url);
        $rating = 0;
        
        if (!is_wp_error($bottomline_response)) :
          $to_json = json_decode($bottomline_response['body'])->response;
          /**
           * Turn the Float rating into a usable Int, since usort will cast it to int anyway.
           */
          $product->total_reviews = $to_json->bottomline->total_review;
          $product->visible_rating = $to_json->bottomline->average_score * 1000;
          $product->sort_rating = $product->visible_rating;
          /**
           * 
           * This is where manipulations to the sorting can occur.
           * 
           * Since the product review rating is considered the primary sorting method for tinctures & sprays,
           * it's used as the baseline for products. 
           * 
           * However, we'll make sweeping changes to specific product types by manipulating the sort rating
           * that was based on the review rating.
           * 
           * Since reviews go up to 5 (and we're multiplying by 1000), the range of the sort rating
           * is 0 - 5000 at this point.
           * 
           * RANGES
           * Spray Variety Packs: 0 - 5,000
           * Singular Sprays: 5,001 - 10,001
           * Tincture Variety Packs: 10,002 - 15,002
           * Singular Tinctures: 15,003 - 20,003
           * 
           */
          if (strpos($name, 'Spray') !== false) {
            $product->sort_rating = ($product->sort_rating + 5001);
          } else if (strpos($name, 'Variety Pack') !== false && strpos($name, 'Tincture') !== false) {
            $product->sort_rating = ($product->sort_rating + 10002);
          } else if (strpos($name, 'Tincture') !== false) {
            $product->sort_rating = ($product->sort_rating + 15003);
          }

        endif;
      }

      /**
       * Sort by value of key
       * https://stackoverflow.com/questions/2852621/strcmp-equivelant-for-integers-intcmp-in-php
      */
      function sortByRating ($a, $b) {
        return $b->sort_rating - $a->sort_rating;
      }

      /**
       * Sort array of objects by value of key
       * https://stackoverflow.com/questions/4282413/sort-array-of-objects-by-object-fields
       */
      // usort($products, "sortByRating");
	 usort($products);

      foreach ($products as $idx => $product) {
        $product_is_hidden = $product->get_status() === 'draft' || $product->get_catalog_visibility() === 'hidden';
        if ($product_is_hidden) : continue; endif;

        $name = $product->get_name();
        $id = $product->get_id();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'large')[0];
        $link = get_the_permalink($id);
        /**
         * Return the rating into the float value, since it was turned to a usable Int for usort.
         */
        $product->visible_rating = $product->visible_rating / 1000;

        /**
         * If the user was recommended a flavored item from the Product Rec Tool,
         * don't show un-flavored items here.
         * 
         * Since Koi only has one un-flavored type of each product, the Product
         * Rec Tool just sends them straight to that item, so we don't have to 
         * worry about handling the opposite condition here.
         */
        if ($list_flavored_only && in_array($id, $unflavored_products)) : continue; endif;

        $card_fields = array(
          'product_image_url' => $image,
          'product_title' => $name,
          'product_link' => $link,
          'product_review_link' => $link + '/#product-reviews',
          'product_id' => $id,
          'product_rating' => $product->visible_rating,
          'product_total_reviews' => $product->total_reviews,
          'is_archive' => true,

        );

        echo k_product_card($card_fields);
      }
      ?>

    </div>
  </section>

<?php
// $product_video_fields = array(
//   'preheadline' => 'Feel calm, feel relief, feel balanced',
//   'headline' => 'With all-natural Koi CBD Tinctures, happy, healthy days are a few drops away.',
//   'video_headline' => 'Experience the rejuvenating of Koi CBD Tinctures',
//   'body_copy' => '
//     <p>Repudiandae fuga non nemo facere nihil, libero nesciunt quae, beatae officia distinctio aliquam hic? Optio repudiandae iusto eveniet, sed, deserunt, maxime voluptatibus earum recusandae repellat natus magnam vitae culpa. Amet officiis doloremque error.</p>
//     <p>Quod aliquam beatae sed repellendus nihil sint aliquid voluptates. Repudiandae fuga non nemo facere nihil, libero nesciunt quae, beatae officia distinctio aliquam hic? Optio repudiandae iusto eveniet.</p>
//     <a href="#0" class="k-button k-button--dark">Learn More &rarr;</a>
//   '
// );

// echo k_product_video($product_video_fields);

$featured_articles = $page_fields['featured_articles'];
include(locate_template('partials/blog-promo.php'));
include(locate_template('partials/components/randoms/line.php'));

get_footer();
?>