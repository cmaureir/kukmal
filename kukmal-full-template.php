<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * KuKmal Full Content Template
 *
 * Template Name:  KuKmal Page Full
 */
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
        	            <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
        	        </div><!-- end of .post-entry -->
        	        
        	    <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div> 
        	    </div><!-- end of #post-<?php the_ID(); ?> -->
        	    
        	<?php endwhile; ?> 
        
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>

	    <?php else : ?>


		<?php include('kukmal404.php'); ?>
<?php endif; ?>  
      
        </div><!-- end of #content-full -->

<?php get_footer(); ?>
