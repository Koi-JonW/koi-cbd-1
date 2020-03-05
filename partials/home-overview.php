<?php
  $root = get_template_directory_uri();
?>

<section class="k-overview k-block k-block--lg k-no-padding--bottom k-no-padding--top">
  <div class="k-overview--bgimg" data-src="<?php echo $root . '/dist/misc/koi-bg.html #koi-bg' ?>"></div>
  <div class="k-inner k-inner--md k-overview--intro">
    <div class="k-overview--intro__image">
      <figure class="k-figure">
        <img class="k-figure--img" data-src="<?php echo $overview_fields['main_image']['url']; ?>" alt="<?php echo $overview_fields['main_image']['alt']; ?>">
      </figure>
    </div>
    <div class="k-overview--intro__text">
      <div class="k-preheading">
        <span class="k-upcase">Koi CBD Products</span>
      </div>
      <div class="k-heading">
        <h2 class="k-headline k-headline--md">
          <?php echo $overview_fields['headline']; ?>
        </h2>
      </div>
      <div class="k-textbody">
        <p><?php echo $overview_fields['supporting_copy']; ?></p>
      </div>
      <div class="k-action">
        <a
          href="<?php echo $overview_fields['main_link']['url']; ?>"
          class="k-button k-button--primary"
        >
          <?php echo $overview_fields['main_link']['title']; ?> &nbsp; &rarr;
        </a>
      </div>
    </div>    
  </div>
  <div class="k-inner k-inner--md k-overview__card-container">

    <div class="k-overview--item k-overview--item">
      <div class="k-overview--item__card k-overview--item__card--tinctures">
        <a href="<?php echo site_url().'/cbd-tinctures'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['tinctures_bg_image']['url']; ?>" alt="<?php echo $overview_fields['tinctures_bg_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['tinctures_corner_image']['url']; ?>" alt="<?php echo $overview_fields['tinctures_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <h3 class="k-headline k-headline--xs">
          <a href="<?php echo site_url().'/cbd-tinctures'; ?>">CBD Tinctures & Sprays</a>
        </h3>
        <div class="k-rte-content">
          <p><?php echo $overview_fields['tinctures_copy']; ?></p>
          <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-tinctures'; ?>">Shop CBD Tinctures & Sprays &rarr;</a>
        </div>
      </div>
    </div>
    <div class="k-overview--merch k-overview--item">
      <div class="k-overview--item__card k-overview--item__card--merch">
        
        <figure class="k-figure k-figure--rounded ">
          <a href="<?php echo site_url().'/cbd-skincare'; ?>">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['merch_bg_image']['url']; ?>" alt="<?php echo $overview_fields['merch_bg_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['merch_corner_image']['url']; ?>" alt="<?php echo $overview_fields['merch_corner_image']['alt']; ?>" class="k-cornerimg">
          </a>
        </figure>
        
        <div class="k-overview--merch__text">
          <h3 class="k-headline k-headline--xs">
            <a href="<?php echo site_url().'/cbd-skincare'; ?>">CBD Skincare</a>
          </h3>
          <div class="k-rte-content">
            <p><?php echo $overview_fields['merch_copy']; ?></p>
            <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-skincare'; ?>">Shop CBD Skincare &rarr;</a>
          </div>
        </div>
      </div>
    </div>
    <div class="k-overview--topicals k-overview--item">
      <div class="k-overview--item__card">
        <a href="<?php echo site_url().'/cbd-topicals'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['topicals_bg_image']['url']; ?>" alt="<?php echo $overview_fields['topicals_bg_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['topicals_corner_image']['url']; ?>" alt="<?php echo $overview_fields['topicals_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <h3 class="k-headline k-headline--xs">
          <a href="<?php echo site_url().'/cbd-topicals'; ?>">CBD Balms</a>
        </h3>
        <div class="k-rte-content">
          <p><?php echo $overview_fields['topicals_copy']; ?></p>
          <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-topicals'; ?>">Shop CBD Balms &rarr;</a>
        </div>
      </div>
    </div>
    <div class="k-overview--topicals k-overview--item">
      <div class="k-overview--item__card">
        <a href="<?php echo site_url().'/cbd-bath-beauty'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['product_overview_cbd_bath_beauty_background_image']['url']; ?>" alt="<?php echo $overview_fields['product_overview_cbd_bath_beauty_background_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['product_overview_cbd_bath_beauty_corner_image']['url']; ?>" alt="<?php echo $overview_fields['product_overview_cbd_bath_beauty_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <h3 class="k-headline k-headline--xs">
          <a href="<?php echo site_url().'/cbd-bath-beauty'; ?>">CBD Bath & Body</a>
        </h3>
        <div class="k-rte-content">
          <p><?php echo $overview_fields['product_overview_cbd_bath_beauty_description']; ?></p>
          <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-bath-beauty'; ?>">Shop CBD Bath & Body &rarr;</a>
        </div>
      </div>
    </div>
    <div class="k-overview--edibles k-overview--item">
      <div class="k-overview--item__card">
        <a href="<?php echo site_url().'/cbd-gummies'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['edibles_bg_image']['url']; ?>" alt="<?php echo $overview_fields['edibles_bg_image']['url']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['edibles_corner_image']['url']; ?>" alt="<?php echo $overview_fields['edibles_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <div class="k-overview--edibles__text">
          <h3 class="k-headline k-headline--xs">
            <a href="<?php echo site_url().'/cbd-gummies'; ?>">CBD Gummies & Softgels</a>
          </h3>
          <div class="k-rte-content">
            <p><?php echo $overview_fields['edibles_copy']; ?></p>
            <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-gummies'; ?>">Shop CBD Gummies & Softgels &rarr;</a>
          </div>
        </div>
      </div>
    </div>
    <div class="k-overview--pets k-overview--item">
      <div class="k-overview--item__card">
        <a href="<?php echo site_url().'/cbd-for-pets'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['pets_bg_image']['url']; ?>" alt="<?php echo $overview_fields['pets_bg_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['pets_corner_image']['url']; ?>" alt="<?php echo $overview_fields['pets_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <h3 class="k-headline k-headline--xs">
          <a href="<?php echo site_url().'/cbd-for-pets'; ?>">CBD For Pets</a>
        </h3>
        <div class="k-rte-content">
          <p><?php echo $overview_fields['pets_copy']; ?></p>
          <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-for-pets'; ?>">Shop CBD for Pets &rarr;</a>
        </div>
      </div>
    </div>
    <div class="k-overview--vape k-overview--item">
      <div class="k-overview--item__card">        
        <figure class="k-figure k-figure--rounded ">
          <a href="<?php echo site_url().'/cbd-vape-juice'; ?>">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['vape_bg_image']['url']; ?>" alt="<?php echo $overview_fields['vape_bg_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['vape_corner_image']['url']; ?>" alt="<?php echo $overview_fields['vape_corner_image']['alt']; ?>" class="k-cornerimg">
          </a>
        </figure>
        
        <div class="k-overview--vape__text">
          <h3 class="k-headline k-headline--xs">
            <a href="<?php echo site_url().'/cbd-vape-juice'; ?>">CBD Vape Juices and Devices</a>
          </h3>
          <div class="k-rte-content">
            <p><?php echo $overview_fields['vape_copy']; ?></p>
            <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-vape-juice'; ?>">Shop CBD Vape Juices and Devices &rarr;</a>
          </div>
        </div>
      </div>
    </div>
    <div class="k-overview--topicals k-overview--item">
      <div class="k-overview--item__card">
        <a href="<?php echo site_url().'/cbd-inhalers'; ?>">
          <figure class="k-figure k-figure--rounded ">
            <div class="k-figure--liner">
              <img class="k-figure--img" data-src="<?php echo $overview_fields['product_overview_cbd_inhalers_background_image']['url']; ?>" alt="<?php echo $overview_fields['product_overview_cbd_inhalers_background_image']['alt']; ?>" />
            </div>
            <img data-src="<?php echo $overview_fields['product_overview_cbd_inhalers_corner_image']['url']; ?>" alt="<?php echo $overview_fields['product_overview_cbd_inhalers_corner_image']['alt']; ?>" class="k-cornerimg">
          </figure>
        </a>
        <h3 class="k-headline k-headline--xs">
          <a href="<?php echo site_url().'/cbd-inhalers'; ?>">CBD Inhalers</a>
        </h3>
        <div class="k-rte-content">
          <p><?php echo $overview_fields['product_overview_cbd_inhalers_description']; ?></p>
          <a class="k-button k-button--primary" href="<?php echo site_url().'/cbd-inhalers'; ?>">Shop CBD Inhalers &rarr;</a>
        </div>
      </div>
    </div>

  </div>
</section>