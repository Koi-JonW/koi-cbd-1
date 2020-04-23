<?php
  $root = get_template_directory_uri();
?>
<section class="k-hero k-hero--default k-hero--center k-hero--on-dark" >
  <div class="hero-media">
    <div class="hero-media-img-top" id="scroll_banner">
      <img
          src="<?php echo $hero_fields['bgImg']['url']; ?>"
          alt="<?php echo $hero_fields['headline']; ?>" style="width:100%;" />
    </div>
    <?php if (get_field('hero_background_video')): ?>
      <div class="hero-media-video">
        <video data-src="<?php the_field('hero_background_video'); ?>" muted playsinline></video>
      </div>
    <?php endif; ?>
  </div>
  <div class="k-inner k-inner--md" style="padding:5em 0 5em 0;">
    <div class="k-hero--text">
      <h2 class="k-headline k-headline--lg"><?php echo $hero_fields['headline']; ?></h2>
      <div class="k-hero--bigtext">
        <h1 class="k-headline--fake"><?php echo $hero_fields['body']; ?></h1>
      </div>
    </div>
    <div class="k-hero--action">
    <?php
      foreach($hero_fields['actions'] as $action_obj) { ?>
        <a
          href="<?php echo $action_obj['link']['url']; ?>"
          class="k-button k-button--<?php echo $action_obj['style']; ?>"
        >
          <?php echo $action_obj['link']['title']; ?> &nbsp; &rarr;
        </a>
    <?php
      }
    ?>
    </div>
  </div>
</section>

<script>
$(window).scroll(function() {
    if ($(this).scrollTop() > 20){  
        $('#scroll_banner').addClass("sticky_banner");

    }
    else{
        $('#scroll_banner').removeClass("sticky_banner");	
    }
});


</script>