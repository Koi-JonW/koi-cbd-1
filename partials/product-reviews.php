<section 
  class="k-productreviews k-block k-block--md"
  id="product-reviews"
  data-product-sku="<?php echo $product->get_sku(); ?>"
  style="padding: 30px 10% 50px 10%; background: #fafafa; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;"
>
  
  <div class="k-reviews">

    <div class="k-reviews--title" style="text-align: center;">
      <?php if (get_field('product_reviews_headline')) : ?>
      <h2 class="k-review--headline"><?php the_field('product_reviews_headline'); ?></h2>
      <?php else : ?>
      <h2 class="k-review--headline"><?php echo $product->get_name(); ?> Reviews</h2>
      <?php endif; ?>
    </div>

    <div class="yotpo yotpo-reviews-carousel"
      data-background-color="transparent"
      data-mode="top_rated"
      data-type="per_product"
      data-count="9"
      data-show-bottomline="1"
      data-autoplay-enabled="1"
      data-autoplay-speed="3000"
      data-show-navigation="1"
      data-product-id="<?php global $product; echo $product->get_id(); ?>">&nbsp;</div>
    </div>

  </div>

  <div class="k-inner k-inner--md" style="display:none;">

    <div class="k-productreviews--title">
      <?php if (get_field('product_reviews_headline')) : ?>
      <h2 class="k-headline k-headline--sm"><?php the_field('product_reviews_headline'); ?></h2>
      <?php else : ?>
      <h2 class="k-headline k-headline--sm"><?php echo $product->get_name(); ?> Reviews</h2>
      <?php endif; ?>
    </div>

    <div class="k-productreviews--main k-productreviews__render-target" data-product-id="<?php echo $product_id; ?>">
    <?php
    $num_per_page = 10;
    $req_url = 'https://api.yotpo.com/v1/widget/MS3VY5Cc4TFD6zbI2zGhMsb9gvkPpQDKwUcPhaSG/products/' . $product_id . '/reviews.json?per_page=150';
    $reviews_response = wp_remote_get($req_url);

    if (!is_wp_error($reviews_response)) :
      $to_json = json_decode($reviews_response['body'])->response;
      $first_page_reviews = $to_json->reviews;
      $pagination_meta = $to_json->pagination;
      $total_reviews = $pagination_meta->total;
      $no_reviews = true;

      if (count($first_page_reviews) === 0) {
        echo '<article class="k-review"><div class="k-review--liner"><p>None yet! Be the first to <a href="#0" class="k-createreview">leave a review.</a></p></div></article>';
      } else {
        $no_reviews = false;
      }

      foreach($first_page_reviews as $index=>$review) :
        if ($index % 10 == 0) {
          if ($index != 0) {
            echo '</div>';
          }
          echo '<div class="k-review-container">';
          echo k_product_review($review, $index);
        } else if ($index == count($first_page_reviews) - 1){
          echo '</div>';
        } else {
          echo k_product_review($review, $index);          
        }
      endforeach; ?>

    <?php else : ?>
      <p>None yet! Be the first to <a href="#0" class="k-createreview">leave a review.</a></p>
    <?php
    endif; ?>
    </div>
    <div class="k-productreviews__controls">
      <div class="k-productreviews__create"><span class="k-upcase k-createreview <?php echo $no_reviews == true ? 'inactive' : 'active'; ?>">Write A Review</span></div>
      <div><span class="k-productreviews__prev k-upcase <?php echo $no_reviews == true ? 'inactive' : 'active'; ?>">Previous</span></div>
      <div><span class="k-productreviews__next k-upcase <?php echo $no_reviews == true ? 'inactive' : 'active'; ?>">Next</span></div>
    </div>
  </div>
</section>