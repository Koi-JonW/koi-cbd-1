<aside class="k-cart-sidebar" tabindex="0">
  <div class="k-cart-sidebar__liner">
    <p class="k-upcase k-cart-sidebar__title">Your Cart</p>
    <div class="k-cart-sidebar__content">
      <div id="k-ajaxcart-cartitems"></div>
    </div>
    <div class="k-cart-sidebar__close" tabindex="0" aria-label="close"><h2>+</h2></div>
  </div>

  <div class="k-cart-sidebar__swell">
	  <select id="swell-redemption-dropdown">
		  <option>Please select an option</option>
	  </select>
    <a id="swell-redemption-button" class="k-button k-button--primary" href="#">Apply</a>
  </div>

  <div class="k-cart-sidebar__actions">
    <div class="k-liner">
      <div class="k-cart-sidebar__summary">
        <h4 class="k-headline k-cart-sidebar__subtotal"><strong>Subtotal:</strong> <span class="k-cart-sidebar--subtotal" aria-label="cart subtotal"></span><sup class="k-cart-sidebar__price-star">*</sup></h4>
        <div class="k-cart-sidebar__price-notice">
          <p class="k-accent-text"><span class="k-cart-sidebar__price-star"><sup>*</sup></span>View total after promotional discounts at checkout.</p>
        </div>
      </div>
    </div>
    <div class="k-liner">
      <a class="k-button k-button--primary" href="<?php echo site_url() . '/cart';?>" aria-label="View Cart">View Cart</a>
      <a class="k-button k-button--dark" href="<?php echo site_url() . '/checkout';?>" aria-label="Checkout">Checkout</a>
    </div>
  </div>
</aside>

<script>
	var $ = jQuery.noConflict();
</script>
<script>
	console.log($);
</script>