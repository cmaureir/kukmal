<?php
/*
Template Name: Inserieren
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Redirect if logged-in

if ( is_user_logged_in() ) {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if ($user_role == 'freeuser' || $user_role == 'selluser' )
    {
	// Hard-coded! please update if it's necessary
	header("Location: http://beta.kukmal.org/wp-admin/post-new.php");
    }

}
// Display page content
else {

?>
<?php get_header(); ?>

        <div id="content-full" class="grid col-940">

<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php echo responsive_breadcrumb_lists(); ?>
        <?php endif; ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="post-title"><?php the_title(); ?></h1>

                <div class="post-entry">
                    <?php the_content(__('Read more &#8250;', 'responsive')); ?>

<a href="http://beta.kukmal.org/wp-login.php?action=login" class="green button">Login</a>
<a href="http://beta.kukmal.org/wp-login.php?action=register" class="green button">Register</a>
<a href="http://beta.kukmal.org/#" class="green button">Account Upgrade</a>

                    <?php if ( get_the_author_meta('description') != '' ) : ?>

                    <div id="author-meta">
                    <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>
                        <div class="about-author"><?php _e('About','responsive'); ?> <?php the_author_posts_link(); ?></div>
                        <p><?php the_author_meta('description') ?></p>
                    </div><!-- end of #author-meta -->

                    <?php endif; // no description, no author's meta ?>

                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->


            <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>
            </div><!-- end of #post-<?php the_ID(); ?> -->

        <?php endwhile; ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
        <h6><?php _e( 'You can return', 'responsive' ); ?> <a href="<?php echo home_url(); ?>/" title="<?php esc_attr_e( 'Home', 'responsive' ); ?>"><?php _e( '&larr; Home', 'responsive' ); ?></a> <?php _e( 'or search for the page you were looking for', 'responsive' ); ?></h6>
        <?php get_search_form(); ?>

<?php endif; ?>

        </div><!-- end of #content -->

<?php get_footer(); ?>

<?php } ?>
