<?php
/**
 * Flavor Dropdown for Tinctures and Sprays
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$cat_name = get_the_terms($product->get_id(), 'product_cat');
$product_category = reset($cat_name)->slug;
$product_is_bundle = get_class($product) === 'WC_Product_Bundle';
// if ($product_is_bundle === false && (reset($product->get_category_ids()) == 265 || reset($product->get_category_ids()) == 256)) : // CBD Oil/Tincture

  $other_tinctures = wc_get_products(array(
    'limit' => -1,
    'visibility' => 'visible',
    'post_type' => 'product',
    'product_cat' => $product_category,
    'exclude' => array( $product->id )
  ));
?>
<?php if(get_field('show_flavor_dropdown')){ ?>
<div class="k-productform--item k-productform__flavorselect">
  <p>FLAVOR</p>
  <div class="k-productform__flavorselect__main k-productform__select-container">
    <select>
      <?php // have the current one be the "current selected" option" ?>
      <option selected>&#10003; <?php echo $product->get_name(); ?></option>
      <?php
      foreach($other_tinctures as $idx => $tincture) :
        $is_visible = $tincture->get_status() !== 'draft';
        $is_not_bundle = $tincture->get_type() !== 'bundle';
        $is_not_weird_one = $tincture->get_id() !== 30239; // the 60ML variant is not be included in this list
        $show_tincture = $is_visible && $is_not_bundle && $is_not_weird_one;
        
        if (strpos($product->name, 'Tincture') and strpos($tincture->name, 'Spray')) {
          $show_tincture = false;
        } else if (strpos($product->name, 'Spray') and strpos($tincture->name, 'Tincture')) {
          $show_tincture = false;
        }
        if ($show_tincture) : ?>
		<?php if(get_field('show_flavor_dropdown', $tincture->get_id())){ ?>
          <option value="<?php echo $tincture->get_permalink(); ?>" label="<?php echo $tincture->get_name(); ?>" id="<?php echo get_field('show_flavor_dropdown', $tincture->get_id()); ?>">
			<?php echo $tincture->get_name(); ?>
		</option>
		<?php } ?>
        <?php 
        endif;
      endforeach; ?>
      </select>
  </div>
</div>
<?php 
}else{
// echo '<br/>';
}
 ?>
<?php // endif; ?>