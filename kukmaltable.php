<?php
$post_categories = wp_get_post_categories( $post->ID );
foreach ($post_categories as $cat) {
    $cat =  get_category($cat);
    $cat = $cat->name;
    if ($cat == 'Free') // Free category!
    {
	?>
	<br/>
    	<div class="informationtable"><?php get_free_table($post->ID);   ?> </div>
	<?php
    }
    else if ($cat == 'Sell') // Sell category!
    {
    	?>
    	<div class="informationtable"><?php get_sell_table($post->ID);    ?> </div>
	<?php
    }
}
?>
