<?php

get_header();
do_action('k_before_first_section');

?>
<section class="k-search k-block k-block--md">
  <div class="k-inner k-inner--md">
    <?php get_search_form(); ?>
  </div>
</section>
<div style="display:none">
<?php 
var_dump(get_title());
var_dump(get_search_query());
?>
</div>
<?php
get_footer();
?>

