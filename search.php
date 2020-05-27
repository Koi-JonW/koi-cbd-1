<?php

get_header('search');

do_action('k_before_first_section');
?>

<section class="k-block k-block--md k-no-padding--bottom k-no-padding--top">
  <div class="k-inner k-inner--md">
    <p class="k-preheading k-upcase">Search Koi CBD</p>
    <h1 class="k-headline k-headline--md">Search Results</h1>
  </div>
</section>

<section class="k-searchresults k-block k-block--md k-no-padding--top">
  <div class="k-inner k-inner--md">
  <?php
    global $wp_query;
    $posts = $wp_query->posts;
    
    foreach($posts as $key => $_post) {
      $is_product = get_post_type($_post) == 'product';
    
      if ($is_product) {
        $product = wc_get_product($_post->ID);
        $id = $product->get_id();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'large')[0];
        $price = $product->get_price();
        $link_to_product = $product->get_permalink();
        $req_url = 'https://api.yotpo.com/v1/widget/MS3VY5Cc4TFD6zbI2zGhMsb9gvkPpQDKwUcPhaSG/products/' . $id . '/reviews.json?per_page=150';
        $reviews_response = wp_remote_get($req_url);
      if (!is_wp_error($reviews_response)) :
        $to_json = json_decode($reviews_response['body'])->response;
        $reviews = $to_json->reviews;
        $bottomline = $to_json->bottomline;
        $rating = floatval(number_format($bottomline->average_score, 1, '.', ''));

        $decimal_value =  fmod($rating, 1);
        $difference = 1 - $decimal_value;
        $translate_value = $difference * 100;
      ?>
        <div class="k-searchresults--item" data-yotpo-product-id="<?php echo $id; ?>">
          <div class="k-searchresults--item__liner">

            <div class="k-searchresults--item__image">
              <a href="<?php echo $link_to_product; ?>">
                <figure class="k-figure">
                  <div class="k-figure--liner" style="padding-bottom: 100%;">
                    <img src="<?php echo $image; ?>" alt="<?php echo $product->get_title(); ?>" class="k-figure--img">
                  </div>
                </figure>
              </a>
            </div>

            <div class="k-searchresults--item__title">
              <a href="<?php echo $link_to_product; ?>">
                <h3 class="k-headline k-headline--sm"><?php echo $product->get_title(); ?></h3>
              </a>
            </div>

            <div class="k-searchresults--item__reviews">
              <ul>
                <?php if ($rating): ?>
                  <li class="k-productcard--reviewavg k-accent-text"><?php echo $rating ?></li>
                <?php else: ?>
                  <li class="k-productcard--reviewavg k-accent-text">No Reviews Available</li>
                <?php endif; ?>                  
                <?php for ($i = 0; $i < $rating; $i++): ?>
                  <div class="k-goldstar">
                    <div class="k-goldstar--liner">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 49.57 47.14" style="transform: translate3d(-<?php echo $i + 1 > $rating ? $translate_value : 0; ?>%, 0, 0);">
                        <g id="Layer_2" data-name="Layer 2">
                          <g id="Layer_1-2" data-name="Layer 1">
                            <polygon style="fill: #f4b13e; transform: translate3d(<?php echo $i + 1 > $rating ? $translate_value : 0; ?>%, 0, 0);" points="24.78 0 32.44 15.52 49.57 18.01 37.18 30.09 40.1 47.14 24.78 39.09 9.47 47.14 12.39 30.09 0 18.01 17.13 15.52 24.78 0"/>
                          </g>
                        </g>
                      </svg>
                    </div>
                  </div>
                <?php endfor; ?>
              </ul>
            </div>

            <div class="k-searchresults--item__price">
              <p class="k-bigtext"><?php echo $price > 0 ? '$' : ''; ?><?php echo $price > 0 ? $price : ''; ?></p>
            </div>

            <div class="k-searchresults--item__action">
              <a href="<?php echo $link_to_product; ?>" class="k-button k-button--primary">Go</a>
            </div>
          </div>
        </div>
      <?php endif;
      }
    }
  ?>
  </div>
</section>

<?php
get_footer();
?>