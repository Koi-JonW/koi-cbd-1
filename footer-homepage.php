<?php
$root = get_template_directory_uri();
?>
  </main>

  <?php
  get_template_part('partials/site-footer');
  ?>

  <div id="k-backdrop" class="active"></div>

  <div class="k-modal k-modal--search">
    <div class="k-inner k-inner--sm">
      <div class="k-modal--content">
        <form class="k-form k-form--search">
          <input name="k-search-input" id="k-search-input" type="text" />
          <label for="k-search-input">Search...</label>
          <button type="submit">&rarr;</button>
        </form>
      </div>
      <div class="k-modal--close k-searchtrigger">
        <div class="k-modal--close__liner">
          <span class="k-headline k-headline--sm">+</span>
        </div>
      </div>
    </div>
  </div>

  <div class="k-modal k-modal--review">
    <div class="k-modal--content">
      <div class="k-modal__close">X</div>

      <h3 class="k-headline k-headline--sm">Write a Review</h3>
      <p class="k-review__producttitle"><span></span></p>

      <div class="k-modal__successmsg">
        <p>Review submitted. Thank you!</p>
      </div>

      <form
        class="k-form k-form--review"
        data-product-sku=""
        data-product-title=""
      >
        <div class="k-form__liner">
          <div class="k-form__group">
            <input class="k-input" type="email" name="email" id="k-review-email" required/>
            <label for="k-reviewemail">Email Address</label>
          </div>
          <div class="k-form__group">
            <input type="text" class="k-input" name="displayname" id="k-review-displayname" required/>
            <label for="k-review-displayname">Display Name</label>
          </div>
          <div class="k-form__group">
            <input type="text" name="reviewtitle" id="k-review-title" class="k-input" required/>
            <label for="k-review-title">Review Title</label>
          </div>

          <div class="k-form__group k-review__rating">
            <p>Star Rating</p>
            <div class="k-review__ratingitem">
              <input type="radio" name="reviewrating" id="k-review-5star" value="5" />
              <label for="k-review-5star"> <?php get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star'); ?></label>
            </div>
            <div class="k-review__ratingitem">
              <input type="radio" name="reviewrating" id="k-review-4star" value="4" />
              <label for="k-review-4star"><?php get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star');get_template_part('partials/svg/gold-star'); ?></label>
            </div>
            <div class="k-review__ratingitem">
              <input type="radio" name="reviewrating" id="k-review-3star" value="3" />
              <label for="k-review-3star"><?php get_template_part('partials/svg/gold-star'); get_template_part('partials/svg/gold-star'); get_template_part('partials/svg/gold-star'); ?></label>
            </div>
            <div class="k-review__ratingitem">
              <input type="radio" name="reviewrating" id="k-review-2star" value="2" />
              <label for="k-review-2star"><?php get_template_part('partials/svg/gold-star'); get_template_part('partials/svg/gold-star'); ?></label>
            </div>
            <div class="k-review__ratingitem">
              <input type="radio" name="reviewrating" id="k-review-1star" value="1" />
              <label for="k-review-1star"><?php get_template_part('partials/svg/gold-star'); ?></label>
            </div>
          </div>

          <div class="k-form__group k-form__group--textarea">
            <label for="k-review-content">Review Content</label>
            <textarea
              name="reviewcontent"
              id="k-review-content"
              cols="30"
              rows="10"
              placeholder="I love this product!"
            ></textarea>
          </div>

          <div class="k-form__actions">
            <button type="submit" class="k-button k-button--primary">Submit Review</button>
          </div>

        </div>
      </form>
    </div>
  </div>

  <?php
    if (is_page_template('templates/cart.php') == false) {
      get_template_part('partials/cart-sidebar');
    }
    global $wp;
  ?>
  
  <!-- Start of LiveChat (www.livechatinc.com) code -->
  <script type="text/javascript">
  window.__lc = window.__lc || {};
  window.__lc.license = 9499945;
  (function() {
    var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
    lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
  })();
  </script>
  <!-- End of LiveChat code -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.2.1/tilt.jquery.min.js"></script>
  <script type="text/javascript" src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
  <script type="text/javascript" src="https://cdn.plyr.io/3.5.6/plyr.polyfilled.js"></script>

  <?php wp_footer(); ?>

  <script type="text/javascript" src="<?php echo $root.'/dist/js/magnetic.bundle.js?v=1.12.4'; ?>"></script>
  <script type="text/javascript">
    (function() {
      var backdrop = document.querySelector('#k-backdrop');
      backdrop.classList.remove('active');
    })();
  </script>


  <!-- Swell Integration :: BEGIN -->
  <script>
    var $ = jQuery.noConflict();
  </script>
        <!-- Swell Integration :: END -->

</body>
</html>
