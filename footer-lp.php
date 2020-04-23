<?php
$root = get_template_directory_uri();
?>
  </main>

  <?php
  get_template_part('partials/site-footer-lp');
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

  <script type="text/javascript" src="<?php echo $root.'/dist/js/magnetic.bundle.js?v=1.12.4'; ?>"></script>
  <script type="text/javascript">
    (function() {
      var backdrop = document.querySelector('#k-backdrop');
      backdrop.classList.remove('active');
    })();
  </script>

  <?php wp_footer(); ?>

  <!-- Swell Integration :: BEGIN -->
  <script>
    var $ = jQuery.noConflict();
  </script>
  <script>

    var swellCustomerDetails = null;
    var swellActiveCampaigns = null;
    var swellActiveRedemptionOptions = null;
    var swellVipTiers = null;

    // -- Swell secondary functions

    function prepareRedemptionForm(){

      if($('.swell-redemption-dropdown').length){

        console.log('-- prepareRedemptionForm');

        $('.swell-redemption-dropdown').html('');
        $('.swell-redemption-dropdown').append(
          $('<option>').prop('selected', true).prop('disabled', true).text('Choose your rewards')
        )

        swellActiveRedemptionOptions.forEach(function(option){
          if(swellCustomerDetails.pointsBalance >= option.costInPoints){
            $('.swell-redemption-dropdown').append(
              $('<option>').val(option.id).text(option.name + ' = ' + option.costText)
            )
          }
        });

      }

    }

    function setSwellActiveCampaigns(){

      if($('.swell-campaign-list').length){

        console.log('-- setSwellActiveCampaigns');

        swellActiveCampaigns.forEach(function(campaign){

          $('.swell-campaign-list').append(
            $('<li>').append(
              $('<div>').append(
                $('<i>').addClass('fa ' + campaign.icon),
                $('<p>').text(campaign.rewardText),
                $('<h5>').text(campaign.title)
              ).addClass('content-bx').attr({
                'id': 'campaign-' + campaign.id
              })
            ).addClass('campaign swell-campaign-link').attr({
              'data-campaign-id': campaign.id,
              'data-display-mode': 'modal',
              'id': 'item_' + campaign.id,
              'style': 'background: url(' + campaign.backgroundImageUrl  + ') center center no-repeat; background-size: cover;'
            })
          );

        });

      }
    }

    function setSwellRewards(){

      if($('[class^="table-vips-cell"]').length){

        console.log('-- setSwellRewards');

        swellVipTiers.forEach(function(tier){

          var multiplier = (parseFloat(tier.pointsMultiplier) % 1) ? (parseFloat(tier.pointsMultiplier) + 'x') : (parseInt(tier.pointsMultiplier) + 'x');
          var bonus = parseFloat(tier.pointsMultiplier) + ' Points';

          $('.table-vips-cell-' + tier.name.toLocaleLowerCase() + '.table-vips-cell-title').html(tier.description.replace('\n', '<br />'));
          $('.table-vips-cell-' + tier.name.toLocaleLowerCase() + '.table-vips-cell-benefits strong').text(tier.name);
          $('.table-vips-cell-' + tier.name.toLocaleLowerCase() + '.table-vips-cell-multiplier').text(multiplier);
          // $('.table-vips-cell-' + tier.name.toLocaleLowerCase() + '.table-vips-cell-bonus').text(bonus);

        });

        if(swellCustomerDetails.vipTier){
          var currentTier = swellCustomerDetails.vipTier.name.toLocaleLowerCase();
        } else {
          var currentTier = 'bronze';
        }

        $('.table-vips-cell-' + currentTier + '.table-vips-cell-title').addClass('bg-orange');
        $('.table-vips-cell-' + currentTier + '.table-vips-cell-benefits').addClass('bg-orange');
        $('.table-vips-cell-' + currentTier + '.table-vips-cell-multiplier').addClass('bg-orange');
        $('.table-vips-cell-' + currentTier + '.table-vips-cell-bonus').addClass('bg-orange');
        $('.table-vips-cell-' + currentTier + '.table-vips-cell-offer').addClass('bg-orange');
        $('.table-vips-cell-' + currentTier + '.table-vips-cell-coupons').addClass('bg-orange');

      }

    }

    function setSwellCustomerReferrals(){

      if($('.check-rewards-table').length){

        console.log('-- setSwellCustomerReferrals');

        swellCustomerDetails.referrals.forEach(function(referral){
      
          $('.check-rewards-table tbody').append(
            $('<tr>').append(
              $('<td>').text(referral.email),
              $('<td>').text(referral.completedAt ? 'Purchased ($15 Earned)' : 'Invited')
            )
          );

        });

      }

    }

    function setSwellCustomerShare(){
      if($('.swell-referral-link-copy').length){

        $('.swell-referral-link-copy').on('click', function(e){
          e.preventDefault();
          navigator.clipboard.writeText(swellCustomerDetails.referralLink);
          alert('Referral link copied: ' + swellCustomerDetails.referralLink);
        });

      }
    }

    // -- Swell main functions

    function swellCustom(){

      console.log('-- swellCustom :: footer-lp');

      prepareRedemptionForm();
      // setSwellActiveCampaigns();
      setSwellRewards();
      setSwellCustomerReferrals();
      setSwellCustomerShare();

    };

  </script>
  <script>
    $(document).on("swell:initialized", function(){

      console.log('-- swell:initialized');

      swellActiveCampaigns = swellAPI.getActiveCampaigns();
      console.log('-- swellActiveCampaigns:\n', swellActiveCampaigns);

      swellActiveRedemptionOptions = swellAPI.getActiveRedemptionOptions();
      console.log('-- swellActiveRedemptionOptions:\n', swellActiveRedemptionOptions);

      swellVipTiers = swellAPI.getVipTiers();
      console.log('-- swellVipTiers:\n', swellVipTiers);

    });
  </script>
  <script>
    $(document).on("swell:setup", function(){

      console.log('-- swell:setup');

      swellCustomerDetails = swellAPI.getCustomerDetails();
      console.log('-- swellCustomerDetails:\n', swellCustomerDetails);

      swellCustom();

    });
  </script>
  <script>
    $(document).on('click', '.write-question-review-button.write-review-button', function(){

      $('.write-review-wrapper.write-form br').remove();

      if(!$('.write-review-wrapper.write-form .custom-description').length){
        $('.write-review-wrapper.write-form h2').parent().append(
          $('<div>').addClass('custom-description').html('Thank you for writing a review! To be sure to see your review published, please refrain from mentioning any medical benefits or specific conditions, as per the FDA we are not allowed to publish reviews with these references. You can of course refer to the quality of our products and a general increase in wellness.<br/><br/>We moderate all reviews, so you may not see your review appear right away.')
        );
      }

      if(!$('.write-review-wrapper.write-form .form-input-close').length){
        $('.form-element.submit-button').append(
          $('<span>').addClass('form-input-close').text('Close').on('click', function(e){
            e.preventDefault();
            $('.write-review-wrapper.write-form').removeClass('visible');
          })
        );
      }

    });
  </script>
  <!-- Swell Integration :: END -->

</body>
</html>
