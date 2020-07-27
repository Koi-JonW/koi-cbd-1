<?php
defined('ABSPATH') || exit;
/* Template Name: V2 Lab Results 2020 */

$root = get_template_directory_uri();
$site_content = get_fields('option');

get_header();
?>
<?php
  $taxonomy     = 'product_cat';
  $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 0;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;
$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty
);
?>
<ul>
<?php $all_categories = get_categories( $args );

//print_r($all_categories);
foreach ($all_categories as $cat) {
    //print_r($cat);
    if($cat->category_parent == 0) {
        $category_id = $cat->term_id;

?>     

<li><?php echo $cat->name; ?>

        <?php
        $args2 = array(
          'taxonomy'     => $taxonomy,
          'child_of'     => 0,
          'parent'       => $category_id,
          'orderby'      => $orderby,
          'show_count'   => $show_count,
          'pad_counts'   => $pad_counts,
          'hierarchical' => $hierarchical,
          'title_li'     => $title,
          'hide_empty'   => $empty
        );
        $sub_cats = get_categories( $args2 );
        if($sub_cats) {
			echo '<ul>';
            foreach($sub_cats as $sub_category) {
                echo  '<li>'.$sub_category->name.'</li>';
            }
			echo '</ul>';

        } ?>

</li>

    <?php }     
}
?>
</ul>
<?php get_footer(lp); ?>
