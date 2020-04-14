<aside class="k-cart-sidebar" tabindex="0">
  <div class="k-cart-sidebar__liner">
    <p class="k-upcase k-cart-sidebar__title">Your Cart</p>
    <div class="k-cart-sidebar__content">
      <div id="k-ajaxcart-cartitems"></div>
    </div>
    <div class="k-cart-sidebar__close" tabindex="0" aria-label="close"><h2>+</h2></div>
  </div>

  <div class="k-cart-sidebar__swell">
    <div>You Have <span class="swell-point-balance" style="display: inline-block;">X</span> Points.</div>
	  <select class="swell-redemption-dropdown"></select>
    <a class="swell-redemption-button k-button k-button--primary" href="#">Apply</a>
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

<style>
.k-cart-sidebar__swell {
  position: relative;
  margin-top: -90px;
  padding: 0 1em;
}
.k-cart-sidebar__swell select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
}
.k-cart-sidebar__swell a {
  display: block;
}
@media (min-width: 1199px){
  .k-cart-sidebar__swell {
      padding: 0 3em;
  }
}
@media (min-width: 767px){
  .k-cart-sidebar__swell {
    padding: 0 3em;
  }
}
</style>
<script>
  var $ = jQuery.noConflict();
</script>
<script>

  var onRedemptionSuccess = function(redemption) {
    prepareRedemptionForm();
    var postData = {
      coupon_code: redemption.couponCode, 
      security: '<?php echo(wp_create_nonce("apply-coupon")); ?>'
    };
    $.post('/?wc-ajax=apply_coupon', postData).done(function(data) {
      window.location.href = '/checkout';
    });
  };

  var onRedemptionError = function(err) {
    alert('Oops! It looks like we\'re having trouble finding what you\'re looking for. Please try again later.');
    console.log('-- makeRedemption Error:\n', err);
  }

  $('.swell-redemption-button').on('click', function(e){
    e.preventDefault();
    var redemptionOption = $(this).parent().find('.swell-redemption-dropdown option:selected').val();
    if(redemptionOption){
      swellAPI.makeRedemption({
        redemptionOptionId: redemptionOption
      }, onRedemptionSuccess, onRedemptionError);
    } else {
      alert('Please select a redemption option');
    }
  })

</script>