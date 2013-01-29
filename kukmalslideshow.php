<?php

$url1 = get_field('free_slideshow_1');
$url2 = get_field('free_slideshow_2');
$url3 = get_field('free_slideshow_3');

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

?>
