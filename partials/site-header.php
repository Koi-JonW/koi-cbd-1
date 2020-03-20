<?php
$root = get_template_directory_uri();
$url = site_url();
?>

<header class="k-header">
  <button class="k-header__skip-to-main k-button k-button--primary">Skip To Main Content</button>
  <div class="k-header__newsletter-signup">
    <div class="k-inner k-inner--xl">
      <form action="POST">
        <fieldset class="k-form--group">
          <label for="k-newsletter-first" class="k-header__newsletter-label">First Name</label>
          <input class="k-input" type="text" name="first name" id="k-newsletter-first" required>
        </fieldset>
        <fieldset class="k-form--group">
          <label for="k-newsletter-last" class="k-header__newsletter-label">Last Name</label>
          <input class="k-input" type="text" name="last name" id="k-newsletter-last" required>
        </fieldset>        
        <fieldset class="k-form--group">
          <label for="k-newsletter-email" class="k-header__newsletter-label">Email</label>
          <input class="k-input" type="text" name="email" id="k-newsletter-email" required>
        </fieldset>
        <button class="k-header__newsletter-submit k-button k-button--primary">Sign Up</button>
      </form>

    </div>
  </div>
  <div class="k-header--top k-promobanner k-header__newsletter-trigger k-header__newsletter-trigger--mobile">
    <div class="k-inner k-inner--xl">
      <div class="k-promobanner--item">
        <span class="k-upcase">Free shipping on all US orders over $35</span>
      </div>
      <div class="k-promobanner--item">
      <?php $newsletter_field = get_field('header_newsletter_copy', 'options'); ?>
        <span class="k-upcase k-header__newsletter-trigger k-header__newsletter-trigger--desktop"><?php echo $newsletter_field; ?></span>
      </div>
    </div>
  </div>
  <div class="k-header--main">
    <nav class="k-header--nav">
      <div class="k-header--nav__content">
        <ul>
          <li class="k-has-dropdown">
            <a class="k-upcase"><span>&#9660;</span> Shop</a>
            <ul class="k-dropdown">
              <div class="k-dropdown--liner">

                <?php wp_nav_menu( array( 'theme_location' => 'categories-menu')) ?>

              </div>
            </ul>
          </li>
          <li>
            <a href="/store-finder" class="k-upcase">STORE FINDER</a>
          </li>
          <li>
            <a href="/blog" class="k-upcase">KOI BLOG</a>
          </li>
<!--          <li class="k-has-dropdown">
            <a class="k-upcase"><span>&#9660;</span> Resources</a>
            <ul class="k-dropdown">
              <div class="k-dropdown--liner">

                <?php // wp_nav_menu( array( 'theme_location' => 'resources-menu')) ?>

              </div>
            </ul>
          </li> -->
          <li>
            <a class="k-upcase" href="<?php echo $url . '/lab-results' ?>">Lab Results</a>
          </li>
        </ul>
        <ul>
          <li><a class="k-upcase" href="https://wholesale.koicbd.com/">Wholesale</a></li>
          <li class="k-has-dropdown">
            <a class="k-upcase"><span>&#9660;</span>About Us</a>
            <ul class="k-dropdown">
              <div class="k-dropdown--liner">

                <?php wp_nav_menu( array( 'theme_location' => 'about-menu')) ?>

              </div>
            </ul>
          </li>
          <li>
            <a class="k-upcase" href="<?php echo $url; ?>/account/">
              <?php if (is_user_logged_in()): ?>
                Account
              <?php else: ?>
                Login
              <?php endif; ?>
            </a>
          </li>

          <li class="k-header--cart">
            <a id="k-carttoggle" tabindex="0" aria-label="cart">
              <i class="icon-bag"></i>
              <span id="k-cartnum" class="">0</span>
            </a>
          </li>

          <li class="k-searchparent" aria-label="search">
            <!-- <a href="<?php echo $url; ?>/search"> -->
              <i id="k-searchicon" class="icon-magnifier k-searchtrigger"></i>
            <!-- </a> -->
          </li>
        </ul>
      </div>
    </nav>
    <div class="k-inner k-inner--xl">
      <div class="k-header--logo">
        <a href="<?php echo site_url(); ?>">
          <img src="<?php echo $root.'/dist/img/koi-logo-main@2x.png'; ?>" alt="Koi CBD Logo">
        </a>
      </div>
      <div class="k-header--navtoggle" id="k-nav-trigger">
        <div class="k-header--navtoggle__line"></div>
        <div class="k-header--navtoggle__line"></div>
        <div class="k-header--navtoggle__line"></div>
      </div>
    </div>
  </div>
</header>