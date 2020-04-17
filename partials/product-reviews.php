<section 
  class="k-productreviews k-block k-block--md"
  id="product-reviews"
  data-product-sku="<?php echo $product->get_sku(); ?>"
  data-product-title="<?php echo the_title(); ?>"  
>

  <div class="k-inner k-inner--md">

    <div class="k-productreviews--title">
      <?php if (get_field('product_reviews_headline')) : ?>
      <h2 class="k-headline k-headline--sm"><?php the_field('product_reviews_headline'); ?></h2>
      <?php else : ?>
      <h2 class="k-headline k-headline--sm"><?php echo $product->get_name(); ?> Reviews</h2>
      <?php endif; ?>
    </div>

    <div class="k-productreviews--main k-productreviews__render-target" data-product-id="<?php echo $product_id; ?>">
      <?php wc_yotpo_show_widget(); ?>
    </div>
  </div>
</section>
