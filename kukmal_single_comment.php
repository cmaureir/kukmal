<?php
/**
 * Single Posts Template
 *
 *
 * @file           single.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2012 ThemeID
 * @license        license.txt
 * @version        Release: 1.0
 * @filesource     wp-content/themes/responsive/single.php
 * @link           http://codex.wordpress.org/Theme_Development#Single_Post_.28single.php.29
 * @since          available since Release 1.0
 */

$post = $wp_query->post;
if ( in_category('blog') )
{
	include(TEMPLATEPATH . '/single_blog.php');
}
else {
	include(TEMPLATEPATH . '/kukmal/kukmal_single_nocomment.php');
}
?>
