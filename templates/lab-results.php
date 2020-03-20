<?php

if (!defined('ABSPATH')) {
	exit;
}
/* Template Name: 2019 Lab Results Page */
$root = get_template_directory_uri();

get_header();
?>

<section class="k-hero k-hero--twocol k-hero--labresults">
  <div class="k-hero--bgimg" data-src="<?php echo $root . '/dist/img/lab-results-hero-1-20.jpg'; ?>"></div>
  <div class="k-inner k-inner--md">

    <div class="k-hero__main">
    
      <div class="k-hero__heading">
        <h1 class="k-preheading k-upcase">Lab Results</h1>
        <h2 class="k-headline k-headline--md">From Plant to Finished Product</h2>
      </div>
    
      <div class="k-hero__body k-rte-content">
        <p>All Koi products are lab-tested for purity, consistency, and safety. Plus, we offer full traceability on every batch of our CBD.</p>
      </div>

    </div>
  
  </div>
</section>

<?php new Breadcrumbs([
  [
    'name' => 'Home',
    'url' => home_url()
  ],
  [
    'name' => get_the_title(),
    'url' => get_the_permalink()
  ]
]); ?>

<section class="k-recentresults k-block k-block--md k-no-padding--bottom">
  <div class="k-inner k-inner--sm">
    <div class="k-recentresults__intro">
      <h3 class="k-headline k-headline--md">Recent Lab Results</h3>
      <p class="k-rte-content">
        Knowing exactly what is in your CBD product is important, from the potency to the purity. At Koi, we test our USA-grown hemp extracts before we infuse them into our products, and then test every final batch we make with an accredited, independent lab. All the details are made available, providing transparency and trust.      
      </p>
    </div>
  </div>
  <div class="k-inner k-inner--md">
    <?php
      /**
       * 
       * Since the categories needed for this section don't directly tie up
       * to all categories in the store, they need to be hardcoded. This will
       * mean when category names are changed in the future, a dev will likely
       * need to update these categories manually.
       * 
       */
    ?>
    <div class="k-recentresults__categories">
      <div data-category="tincture" class="k-recentresults__category-button k-button k-button--default">
        <span>Tinctures</span>
      </div>
      <div data-category="gummies" class="k-recentresults__category-button k-button k-button--default">
        <span>Gummies</span>
      </div>
      <div data-category="sprays" class="k-recentresults__category-button k-button k-button--default">
        <span>Sprays</span>
      </div>
      <div data-category="vape" class="k-recentresults__category-button k-button k-button--default">
        <span>Vape Juices</span>
      </div>
      <div data-category="balms" class="k-recentresults__category-button k-button k-button--default">
        <span>Balms</span>
      </div>
      <div data-category="lotion" class="k-recentresults__category-button k-button k-button--default">
        <span>Lotions</span>
      </div>
      <div data-category="petChew" class="k-recentresults__category-button k-button k-button--default">
        <span>Pet Chews</span>
      </div>
      <div data-category="petSpray" class="k-recentresults__category-button k-button k-button--default">
        <span>Pet Spray</span>
      </div>
      <div data-category="hempFlower" class="k-recentresults__category-button k-button k-button--default">
        <span>Hemp Flower</span>
      </div>
      <div data-category="inhalers" class="k-recentresults__category-button k-button k-button--default">
        <span>Inhalers</span>
      </div>
      <div data-category="softgels" class="k-recentresults__category-button k-button k-button--default">
        <span>Softgels</span>
      </div>
      <div data-category="bathBombs" class="k-recentresults__category-button k-button k-button--default">
        <span>Bath Bombs</span>
      </div>
      <div data-category="hempShots" class="k-recentresults__category-button k-button k-button--default">
        <span>Hemp Shots</span>
      </div>
      <div data-category="skincare" class="k-recentresults__category-button k-button k-button--default">
        <span>Skincare</span>
      </div>
    </div>

    <div class="k-recentresults__spacer"></div>

    <div class="k-recentresults__append-target">
      <div class="k-recentresults__tab-append-target"></div>
      <div class="k-recentresults__test-append-target"></div>
    </div>
  </div>
</section>

<section class="k-labresults k-block k-block--sm" style="padding-bottom: 4em !important;">
  <div class="k-inner k-inner--sm">
    <div class="k-labresults__spacer"></div>
  </div>
  <div class="k-inner k-inner--md">

    <div class="k-labresults__searchform">
      <div class="k-labresults__content">
        <h4 class="k-headline k-headline--sm">Search by Batch</h4>
        <p class="k-rte-content">Find the lab results of every Koi product by using its unique batch number. Not sure where to find your product's batch number? Check out <a href="https://koicbd.com/wp-content/uploads/tracking-with-batch-numbers.jpg" target="_blank">this example.</a></p>
      </div>
      <form class="k-form" id="k-resultssearch">
        <div class="k-form__content">
          <input
            type="text"
            name="lab-result-search"
            id="k-resultssearchval"
            placeholder="Enter Batch Number"
          />
          <button type="submit" class="k-button k-button--primary k-upcase">Search</button>
        </div>
      </form>
    </div>

    <div class="k-labresults__main">
      <div id="resultsembedtarget"></div>
    </div>

  </div>
</section>

<?php
get_footer();
?>
