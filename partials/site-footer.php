<?php
  $root = get_template_directory_uri();
  $url = site_url();

  if (!is_page($page = 'cbd-101')){
    get_template_part('partials/cta-takeover');
  }
?>

<footer class="k-footer" role="contentinfo">
  <div class="k-footer--bgimg" data-src="<?php echo $root.'/dist/img/koi-footer-bg.jpg'; ?>"></div>
  <div class="k-footer--top k-block k-block--md">

    <div class="k-inner k-inner--md">

      <div class="k-footer--item k-footer--logo">
        <figure class="k-figure">
          <div class="k-figure--liner">
            <img src="<?php echo $root . '/dist/img/koi-logo-main@2x.png'; ?>" alt="Koi CBD Logo" class="k-figure--img" />
          </div>
        </figure>
        <div class="k-footer--social k-rte-content">
          <div class="social-icons">
            <div class="social-icons-row">
              <a href="https://www.facebook.com/KOICBD" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/facebook'); ?>
              </a>
              <a href="https://twitter.com/koicbdlife/" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/twitter'); ?>
              </a>
              <a href="https://www.instagram.com/koicbdlife/" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/instagram'); ?>
              </a>
            </div>
            <div class="social-icons-row">
              <a href="https://www.youtube.com/channel/UCe8IzqpmK6p-kpeHndvXGuQ/" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/youtube'); ?>
              </a>
              <a href="https://www.pinterest.com/koicbdlife/" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/pinterest'); ?>
              </a>
              <a href="https://www.linkedin.com/company/koi-cbd" target="_blank" rel="noopener, noreferrer">
                <?php get_template_part('partials/svg/linkedin'); ?>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="k-footer--item k-footer--links k-rte-content">
        <div class="k-footer--links__item">
          <!-- <h4 class="k-upcase k-weight--lg">Shop CBD</h4>-->

          <?php // wp_nav_menu( array( 'theme_location' => 'categories-menu' ) ); ?>
		  <h4 class="k-upcase k-weight--lg">Company</h4>

          <?php wp_nav_menu( array( 'theme_location' => 'footer-company-menu' ) ); ?>
          
        </div>
        <div class="k-footer--links__item">
          <h4 class="k-upcase k-weight--lg">Legal</h4>

          <?php wp_nav_menu( array( 'theme_location' => 'footer-legal-menu') ); ?>

        </div>
        <div class="k-footer--links__item">
          <!-- <h4 class="k-upcase k-weight--lg">Legal</h4>

          <?php // wp_nav_menu( array( 'theme_location' => 'footer-legal-menu') ); ?> -->

        </div>
        </ul>
      </div>
      <div class="k-footer--item k-footer--badges">
        <figure class="k-figure">
          <div class="k-figure--liner">
            <img data-src="<?php echo $root.'/dist/img/us-hemp-roundtable-logo.png'; ?>" alt="Hemp Industries Association">
          </div>
        </figure>
        <figure class="k-figure">
          <div class="k-figure--liner">
            <img data-src="<?php echo $root.'/dist/img/hemp-industries-association-logo.png'; ?>" alt="Hemp Roundtable">
          </div>
        </figure>
        <figure class="k-figure">
          <div class="k-figure--liner">
            <img data-src="<?php echo $root.'/dist/img/california-hemp-council-logo.png'; ?>" alt="California Hemp Council">
          </div>
        </figure>
      </div>
    </div>
  </div>

  <div class="k-footer--bottom">
    <div class="k-inner k-inner--md">
      <div class="k-footer--copy">
        <p>&copy; Koi CBD <?php echo date("Y"); ?>, All Rights Reserved</p>
      </div>
      <div class="k-footer--disclaimer">
        <p>* These statements have not been evaluated by the Food and Drug Administration. This product is not intended to diagnose, treat, cure or prevent any disease.</p>
      </div>
    </div>
  </div>
</footer>
