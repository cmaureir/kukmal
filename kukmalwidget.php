<?php
$post_categories = wp_get_post_categories( $post->ID );
foreach ($post_categories as $cat) {
    $cat =  get_category($cat);
    $cat = $cat->name;
    if ($cat == 'Free') // Free category!
    {
	?>
    	<div class="offerwidget"><?php get_offer_widget($post->ID, $post_categories);?></div>
	<?php
    }
}
?>
