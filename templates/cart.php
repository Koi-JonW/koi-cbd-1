<?php
  /* Template Name: 2019 Cart Page */
defined( 'ABSPATH' ) || exit;

get_header();

global $ultimatemember;
  
$cart = WC()->cart;
$cart_acf = get_fields();
$items_in_cart = $cart->get_cart();
$url = site_url();

/**
 * Veterans get a 25% discount automatically applied in the form of a special coupon.
 * 
 * Only users with the "veteran" role are eligible for the coupon, so we chack for that
 * as well.
 */

$user_is_veteran = in_array('veteran', get_userdata(get_current_user_id())->roles);
/**
 * Important! Also need to check if user was previously qualified as vet via Ultimate Member.
 * I believe it can be a check for get_user_metadata() or something like that.
 */
$user_veteran_status = get_fields('user_' . get_current_user_id())['veteran_status'];
$is_approved_veteran = $user_is_veteran && $user_veteran_status == 'Veteran Approved';
$veteran_coupon_already_applied = in_array('veteran coupon', $cart->get_applied_coupons());
$should_apply_coupon = $is_approved_veteran && !$veteran_coupon_already_applied;

/**
 * If the veteran coupon is not applied, and the user is an approved veteran
 */
if ($should_apply_coupon) {
  $cart->apply_coupon('veteran coupon');
}

/**
 * If a non-veteran tries to use the veteran coupon, or if a valid veteran decides to remove the coupon for some reason
 */
$valid_veteran_remove_coupon = $_GET['remove_coupon'] == 'veteran coupon';
if (!$user_is_veteran && $veteran_coupon_already_applied || $valid_veteran_remove_coupon) {
	$cart->remove_coupon('veteran coupon');
}

do_action('k_before_first_section');

if (sizeof($items_in_cart) == 0) { ?>
  <section class="k-cart k-cart__noitems k-block k-block--md k-no-padding--bottom">
    <div class="k-inner k-inner--md" style="text-align: center;">
      <h2>Your cart is empty!</h2>
      <a class="k-button k-button--primary" href="<?php echo $url; ?>">Start shopping &rarr;</a>
    </div>
  </section>
<?php
}
?>

<section class="k-cart__notices k-bg-dark">
  <div class="k-inner k-inner--xl">
    <?php do_action('woocommerce_before_cart'); ?>
  </div>
</section>

<section class="k-cart k-block k-block--md k-no-padding--top">
  <div class="k-inner k-inner--xl">
    <div class="k-cart__headline">
      <h1>Your Cart</h1>
    </div>
    <div class="k-cart--main">

      <div class="k-cart--titlerow">
        <div class="k-cart--titleitem">
          <p class="k-upcase"><?php esc_html_e('Product', 'woocommerce'); ?></p>
        </div>
        <div class="k-cart--titleitem">
          <p class="k-upcase"><?php esc_html_e('Quantity', 'woocommerce'); ?></p>
        </div>
        <div class="k-cart--titleitem">
          <p class="k-upcase"><?php esc_html_e('Price', 'woocommerce'); ?></p>
        </div>
      </div>

      <form action="<?php echo esc_url(wc_get_cart_url()); ?>" class="k-cart--form woocommerce-cart-form" method="POST">
        <div class="k-cart--form__liner">
        <?php
          foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            $is_product_bundle = wc_pb_is_bundle_container_cart_item($cart_item); // check if this item contains sub-items
            $is_bundled_item = wc_pb_is_bundled_cart_item($cart_item); // check if this is a sub-item of a bundle, in which case it should not be treated like an individual item

            if ($is_bundled_item) {
              continue; // don't render anything for this item; it does not belong on its own
            }

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
              $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key); ?>

              <div class="k-cart--item woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                <div class="k-cart--item__liner">

                  <div class="k-cart--item__thumbnail">
                    <a href="<?php echo $product_permalink; ?>">
                      <img src="<?php echo get_the_post_thumbnail_url($product_id); ?>" alt="<?php echo $_product->get_name(); ?>" />
                    </a>
                  </div>

                  <div class="k-cart--item__title product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                    <a href="<?php echo $product_permalink; ?>">
                      <h3 class="k-headline k-headline--mini"><?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)); ?></h3>
                    </a>
                    <?php
                    if ($is_product_bundle) {
                      $bundled_cart_items = wc_pb_get_bundled_cart_items($cart_item);
                      $discount_amount = reset(wc_get_product($product_id)->get_bundled_items())->get_discount() / 100;
                    ?>

                      <ul>
                      <?php
                      foreach($bundled_cart_items as $key => $bundled_cart_item) {
                        $bundled_product = wc_get_product($bundled_cart_item['variation_id']);
                        $price = floatval($bundled_product->get_price());
                        $price_with_discount = number_format($price - ($discount_amount * $price), 2);
                      ?>
                        <li class="k-cart--item__bundleditem">
                          <a href="<?php echo $bundled_product->get_permalink(); ?>"><?php echo $bundled_product->get_name(); ?></a>
                          <span class="k-cart--item__bundleditem__price"><?php echo $price_with_discount . '<sup>' . ($discount_amount * 100) . '% off!</sup>'; ?></span>
                        </li>
                      <?php
                      }
                      ?>
                      </ul>
                    <?php
                    }

                    // WC Remove Item link
                    echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                      '<a href="%s" class="remove k-upcase k-accent-text" aria-label="%s" data-product_id="%s" data-product_sku="%s">Remove</a>',
                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                      __( 'Remove this item', 'woocommerce' ),
                      esc_attr( $product_id ),
                      esc_attr( $_product->get_sku() )
                    ), $cart_item_key );

                    // backorder notification
                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                      echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="k-cart--backordernotice backorder_notification">'.esc_html__('Available on backorder', 'woocommerce').'</p>', $product_id));
                    }
                    ?>
                  </div>

                  <div class="k-cart--item__quantity">
                  <?php
                  if ($_product->is_sold_individually()) {
                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                  } else { ?>
                    <div class="k-cart--quantity">
                      <!-- <button type="button" class="k-reduce" data-cart-item-key="<?php echo $cart_item_key; ?>">-</button> -->
                      <input
                        id="<?php echo 'cart[' . $cart_item_key . '][qty]'; ?>"
                        type="number"
                        name="<?php echo 'cart[' . $cart_item_key . '][qty]'; ?>"
                        value="<?php echo $cart_item['quantity'] ?>"
                        min="0"
                        />
                      <!-- <button type="button" class="k-increase" data-cart-item-key="<?php echo $cart_item_key; ?>">+</button> -->
                    </div>
                  <?php
                  }
                  ?>
                  </div>

                  <div class="k-cart--item__price">
                    <?php
                    if ($_product->get_type() != 'bundle') { ?>
                      <p class="k-bigtext"><?php echo $cart->get_product_subtotal($_product, $cart_item['quantity']); ?></p>
                    <?php
                    }
                    ?>
                  </div>

                </div>
              </div>
        <?php
            }
          }
        ?>

          <div class="k-cart--actions">
            <span id="k-cart-remove-all" class="k-upcase k-fakelink"><span>X &nbsp;</span> Empty Cart</span>
          </div>

          <div class="k-cart--item k-cart--meta">
          <?php if (wc_coupons_enabled()) : ?>

            <div class="k-cart--meta__coupon">
              <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
              <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
            </div>

            <div class="k-cart--meta__actions">
              <button type="submit" class="k-button k-button--dark" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>">
                <?php esc_attr_e('Apply coupon', 'woocommerce'); ?>
              </button>
              <!-- <button type="submit" class="k-button k-button--default" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                <?php esc_html_e('Update cart', 'woocommerce'); ?>
              </button> -->
            </div>

          <?php 
          endif;
          ?>
          </div>

        </div>
      </form>
    </div>

    <div class="k-cart--sidebar">
      <div class="k-cart--sidebar__liner">
        <?php
        $discount_amount = NULL;

        foreach ($cart->get_coupons() as $code => $coupon) :
          if ($code === 'veteran coupon') : ?>
          <div class="k-veteran-coupon">
            <div class="k-veteran-coupon__liner">
              <div class="k-veteran-coupon__title">
                <p>Koi Veteran Discount (&mdash;25%)</p>
              </div>
              <div class="k-veteran-coupon__amount">
                <p><?php echo wc_cart_totals_coupon_html($coupon); ?></p>
              </div>
            </div>
          </div>
          <?php else : ?>
          <div class="k-coupon">
            <div class="k-coupon__title">
              <?php echo wc_cart_totals_coupon_label($coupon); ?>
            </div>
            <div class="k-coupon__discount">
              <p><?php echo wc_cart_totals_coupon_html($coupon); ?></p>
            </div>
          </div>
          <?php
          endif;
          // we can safely do this post-loop because only one coupon can be used at a time.
          // That makes the loop useless, but I'm just going to leave it since that may change eventually.
          $discount_amount = $coupon->get_amount();

        endforeach; ?>
        <div class="k-cart__subtotal">
          <p class="k-upcase">Subtotal</p>
          <?php
            $discount_amount
              ? $_subtotal = number_format($cart->get_subtotal() - ($cart->get_subtotal() * ($discount_amount / 100)), 2) 
              : $_subtotal = $cart->get_subtotal();
          ?>
          <p class="k-bigtext">$<?php echo $_subtotal; ?></p>
        </div>

        <div class="k-cart__continue">
          <a href="<?php echo site_url().'/checkout'; ?>" class="k-button k-button--primary">Checkout</a>
          <a href="<?php echo site_url(); ?>" class="k-button k-button--dark">Keep Shopping</a>
        </div>
        
        <div class="k-cart__meta">
          <p class="k-upcase">Secure Checkout Guaranteed</p>
          <p>View Koi CBD <a target="_blank" rel="noopener, noreferrer" href="<?php echo $url . '/shipping-policy'; ?>">Shipping & Return Policies</a> before purchasing.</p>
        </div>

      </div>
    </div>

  </div>
</section>

<?php
  $slider_fields = array(
    'headline' => 'You Might Also Like',
    'products' => $cart_acf['recommended_products'],
  );

  get_footer();
?>