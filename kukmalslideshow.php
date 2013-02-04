<?php

global $wpdb;
global $current_user;

$postdata = get_postdata($id);
$user_id = $postdata['Author_ID'];
$user = new WP_User( $user_id );
$user_role  = $user->roles[0];

$type = "";

if ($user_role == 'freeuser')
	$type = "free";
else if ($user_role == 'selluser')
	$type = "sell";


if ($type != "")
{
	$url1 = get_field($type . '_slideshow_1');
	$url2 = get_field($type . '_slideshow_2');
	$url3 = get_field($type . '_slideshow_3');

	if ( get_field($type . '_slideshow') == 1 )
	{
	?>
	<div id="slideshowsingle">
	<?php
		if ($url1 != "")
		{
		?>
			<div><img width="300px" height="300px" src="<?php echo $url1; ?>"></div>
		<?php
		}
		if ($url2 != "")
		{
		?>
			<div><img width="300px" height="300px" src="<?php echo $url2; ?>"></div>
		<?php
		}
		if ($url3 != "")
		{
		?>
			<div><img width="300px" height="300px" src="<?php echo $url3; ?>"></div>
		<?php
		}
		?>
	</div>
	<?php
	}
	else
	{
		// No slideshow
	}
}

?>
