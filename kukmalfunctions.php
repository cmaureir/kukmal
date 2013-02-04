<?php

function get_cat_slug($cat_id)
{
	$cat_id = (int) $cat_id;
	$category = &get_category($cat_id);
	return $category->slug;
}

function get_offer_categories($categories)
{
	// Removing Free and Sell category
	foreach($categories as $key=>$cat)
	{
		$c = get_cat_slug($cat);
		if ($c == 'free' or $c == 'sell')
			unset($categories[$key]);	
	}

	// Find parent categories
	$musik = False;
	$sprach = False;
	foreach($categories as $key=>$cat)
	{
		$c = get_cat_slug($cat);
		if ($c == 'free_rubrikcat_instrumental')
		{
			$musik = True;
			unset($categories[$key]);	
			break;
		}
		else if ($c == 'free_rubrikcat_sprach')
		{
			$sprach = True;
			unset($categories[$key]);	
			break;
		}
	}

	if(count($categories) != 1)
		echo "An extra category?<br/>";
	
	// Relations between Free and Sell
	$cat = array_values($categories);
	$cat = $cat[0];
	$c = get_cat_slug($cat);

	if ($musik)
	{
		if ($c == 'free_inscat_klavier')
		{
			return array(1,8,9,12);
		}
		else if($c == 'free_inscat_streich')
		{
			return array(1,8,9,13);
		}
		else if($c == 'free_inscat_blas')
		{
			return array(1,8,9,14);
		}
		else if($c == 'free_inscat_zupf')
		{
			return array(1,8,9,15);
		}
		else if($c == 'free_inscat_schlag')
		{
			return array(1,8,9,16);
		}
		else if($c == 'free_inscat_gesand')
		{
			return array(1,8,9);
		}
	}
	else if ($sprach)
	{
		// All the subcategories need the same sell
		// category, so we just return the  value
		return array(1,6);
	}
	else
	{
		// Here we know that the category left
		// is not related to the Instrumental or Sprach
		// so is one of the other Rubrik categories.
		if($c == 'free_rubrikcat_musik')
		{
			return array(1,8,9);
		} 
		else if($c == 'free_rubrikcat_tanz')
		{
			return array(1,2,9);
		} 
		else if($c == 'free_rubrikcat_theater')
		{
			return array(1,3,9);
		} 
		else if($c == 'free_rubrikcat_malen')
		{
			return array(1,4,9);
		} 
		else if($c == 'free_rubrikcat_kunst')
		{
			return array(1,4,9);
		} 
		else if($c == 'free_rubrikcat_kleinkunst')
		{
			return array(1,8,17);
		} 
		else if($c == 'free_rubrikcat_foto')
		{
			return array(1,5,8);
		} 
		else if($c == 'free_rubrikcat_schreib')
		{
			return array(1,6,8);
		} 
		else if($c == 'free_rubrikcat_philosophie')
		{
			return array(1,6,8);
		} 
		else if($c == 'free_rubrikcat_geschicht')
		{
			return array(1,6);
		} 
		else if($c == 'free_rubrikcat_kulinarisches')
		{
			return array(7);
		} 
	}
}

function get_page_from_category($category)
{
	// The titles of the pages (sell) must be hardcoded because is easy to modify it
	// in the future, compared with the pages ids.
	$pages = array(
	1 => "Räume",
	2 => "Zubehör Tanz",
	3 => "Theaterbedarf",
	4 => "Künstlerbedarf",
	5 => "Zubehör für Fotografie und Film",
	6 => "Buchläden und Antiquariate",
	7 => "Zubehör Kochen",
	8 => "Körpertherapien / Kunsttherapien",
	9  => "Musikinstrumente und Noten",
	//10 => "Noten und Bücher (auch Antiquariate)",
	11 => "Musikinstrumente, alle Sparten",
	12 => "Klavierhäuser, Klavierstimmer",
	13 => "Streichinstrumente, Geigenbauer",
	14 => "Blasinstrumente",
	15 => "Zupfinstrumente",
	16 => "Schlaginstrumente",
	17 => "Körpertherapien / Kunsttherapien",
	);


	$url = esc_url( get_permalink( get_page_by_title( $pages[$category] ) ));
	$page = (object)array('url' => $url, 'name' => $pages[$category]);

	return $page;
}

function get_pages_from_categories($categories)
{
	$pages = Array();

	foreach($categories as $cat)
	{
		$page = get_page_from_category($cat);
		array_push($pages, $page);		
	}
	
	return $pages;
}

/* 
 * Sell widget inside a Free announcement
 * 
 * */
function get_offer_widget($id, $categories)
{

	$offer_cat = get_offer_categories($categories);
	$offer_links = get_pages_from_categories($offer_cat);
?>
   <div id="kukmal-widgets" class="grid col-300 fit">
       <div class="kukmal-widget-wrapper">
           <div class="kukmal-widget-title">Finden Sie hier deutschlandweit:</div>
               <ul>
		<?php foreach ($offer_links as $offer)
		      {
			?>
                   	<li><a href='<?php echo $offer->url; ?>' title='<?php echo $offer->name; ?>'><?php echo $offer->name; ?></a></li>
			<?php
		      }
		?>
               </ul>
       </div>
   </div>
<?php
}

/* 
 * Information table displayer in a single post (free)
 * 
 * Status: Pending
 * */
function get_free_table($id)
{
    $rubrik  = get_field('free_rubrik', $id);
    $zielgruppe   = get_field_object('free_zielgruppe', $id);
    $zielgruppe   = $zielgruppe['choices'];
    $zielgruppe   = $zielgruppe[get_field('free_zielgruppe',$id)];
    $rubrik_value = get_field_object('free_rubrik', $id);
    $rubrik_value = $rubrik_value['choices'];
    $rubrik_value = $rubrik_value[$rubrik];

    echo"
        <h3>Information</h3>
        <table>
            <tr>
                <td><b>Rubrik</b></td>
                <td> ".$rubrik_value;

                if($rubrik == 'free_musikunterricht')
                {
                    $detail = get_field_object('free_musikunterricht',$id);
                    $detail = $detail['choices'][get_field('free_musikunterricht')];
                    echo "<br/>($detail)";
                }
                else if ($rubrik == 'free_sprachunterricht')
                {
                    $detail = get_field_object('free_sprachunterricht');
                    $detail = $detail['choices'][get_field('free_sprachunterricht')];
                    echo "<br/>($detail)";
                }

    echo"       </td></tr>
                <tr>
                    <td><b>Zielgruppe</b></td>
                    <td>$zielgruppe</td>
                </tr>";
    $other_values = array('free_institution',
                          'free_veranstaltungsort',
                          'free_plz',
                          'free_ortsname',
                          'free_telefonnummer',
                          'free_email',
                          'free_weblink');

    foreach ($other_values as $val) {
        $field = get_field_object($val,$id);
        $field = $field['label'];
        $value = get_field($val,$id);
        if ($value != "" && $value != "0")
        {
            echo "
            <tr>
              <td><b>$field</b></td>";

            if ( $val == 'weblink' )
            {
                if( substr($value, 0, 7) != 'http://')
                {
                    $value = 'http://'.$value;
                }
                echo"
                <td><a href='$value' rel='nofollow' target='_blank'>$value</a></td>
            </tr>";
            }
            else
            {
                echo"
                <td>$value</td>
            </tr>";
            }
        }
    }
    echo "</table>";
}

/* 
 * Information table displayer in a single post (sell)
 * 
 * Status: Pending
 * */
function get_sell_table($id)
{
    $rubrik  = get_field('sell_rubrik', $id);
    $rubrik_value = get_field_object('sell_rubrik', $id);
    $rubrik_value = $rubrik_value['choices'];
    $rubrik_value = $rubrik_value[$rubrik];

    echo"
        <h3>Information</h3>
        <table>
            <tr>
                <td><b>Rubrik</b></td>
                <td> ".$rubrik_value;

                if($rubrik == 'sell_zubehor')
                {
                    $detail = get_field_object('sell_zubehor',$id);
                    $detail = $detail['choices'][get_field('sell_zubehor')];
                    echo "<br/>, $detail";
                    if (get_field('zubehor') == 'musikinstrumente')
                    {
                        $detail = get_field_object('musikinstrumente');
                        $detail = $detail['choices'][get_field('musikinstrumente')];
                        echo "<br/>($detail)";
                    }
                }

    echo"       </td></tr>";
    $other_values = array('name',
                          'adresse',
                          'plz',
                          'ortsname',
                          'telefonnummer',
                          'email',
                          'weblink');

    foreach ($other_values as $val) {
        $field = get_field_object($val,$id);
        $field = $field['label'];
        $value = get_field($val,$id);
        if ($value != "" && $value != "0")
        {
            echo "
            <tr>
              <td><b>$field</b></td>";

            if ( $val == 'weblink' )
            {
                if( substr($value, 0, 7) != 'http://')
                {
                    $value = 'http://'.$value;
                }
                echo"
                <td><a href='$value' rel='nofollow' target='_blank'>$value</a></td>
            </tr>";
            }
            else
            {
                echo"
                <td>$value</td>
            </tr>";
            }
        }
    }
    echo "</table>";
}

/*
 * Functions to get the category of the options
 * that the user select
 *
 * Status: OK
 */
function get_rubrik_category_slug($rubrik, $user_cat)
{
	$tmp = '';
	if($user_cat == 'free')
	{
	    switch($rubrik)
	    {
	        case 'free_musikunterricht':
		    $tmp  =  'free_rubrikcat_instrumental';
		    break;
		case 'free_musik';
		    $tmp  =  'free_rubrikcat_musik';
		    break;
		case 'free_tanz';
		    $tmp  =  'free_rubrikcat_tanz';
		    break;
		case 'free_theater';
		    $tmp  =  'free_rubrikcat_theater';
		    break;
		case 'free_malen';
		    $tmp  =  'free_rubrikcat_malen';
		    break;
		case 'free_kunsthandwerk';
		    $tmp  =  'free_rubrikcat_kunst';
		    break;
		case 'free_kleinkunst';
		    $tmp  =  'free_rubrikcat_kleinkunst';
		    break;
		case 'free_foto';
		    $tmp  =  'free_rubrikcat_foto';
		    break;
		case 'free_schreiben';
		    $tmp  =  'free_rubrikcat_schreib';
		    break;
		case 'free_sprachunterricht';
		    $tmp  =  'free_rubrikcat_sprach';
		    break;
		case 'free_philosophie';
		    $tmp  =  'free_rubrikcat_philosophie';
		    break;
		case 'free_geschichte';
		    $tmp  =  'free_rubrikcat_geschicht';
		    break;
		case 'free_kulinarisches';
		    $tmp  =  'free_rubrikcat_kulinarisches';
		    break;
	    }

	}	
	else if($user_cat == 'sell')
	{
	    switch($rubrik)
	    {
		case 'sell_zubehoer':
			$tmp = 'sell_rubrikcat_zubehoer';
			break;
		case 'sell_raeume':
			$tmp = 'sell_rubrikcat_raeume';
			break;
		case 'sell_therapie':
			$tmp = 'sell_rubrikcat_therapie';
			break;
	    }
	}

	return $tmp;
}

function get_musik_category($musik)
{
	$tmp = '';
	switch($musik)
	{
		case 'free_klavier':
			$tmp = 'free_inscat_klavier';
			break;
		case 'free_streicher';
			$tmp = 'free_inscat_streich';
			break;
		case 'free_blaeser';
			$tmp = 'free_inscat_blas';
			break;
		case 'free_zupf';
			$tmp = 'free_inscat_zupf';
			break;
		case 'free_schlag';
			$tmp = 'free_inscat_schlag';
			break;
		case 'free_gesang';
			$tmp = 'free_inscat_gesang';
			break;
	}
	return $tmp;
}

function get_sprach_category($sprach)
{
	$tmp = '';
	switch($sprach)
	{
		case 'free_de';
			$tmp = 'free_sprachcat_de';
			break;
		case 'free_en';
			$tmp = 'free_sprachcat_en';
			break;
		case 'free_es';
			$tmp = 'free_sprachcat_es';
			break;
		case 'free_fr';
			$tmp = 'free_sprachcat_fr';
			break;
		case 'free_it';
			$tmp = 'free_sprachcat_it';
			break;
		case 'free_sl';
			$tmp = 'free_sprachcat_sl';
			break;
		case 'free_nr';
			$tmp = 'free_sprachcat_nr';
			break;
		case 'free_andere';
			$tmp = 'free_sprachcat_weitere';
			break;
	}
	return $tmp;
}

function get_zub_category($zub)
{
	$tmp = '';
	switch($zub)
	{
		case 'sell_musik':
			$tmp = 'sell_zubcat_musik';
			break;
		case 'sell_tanz':
			$tmp = 'sell_zubcat_tanz';
			break;
		case 'sell_theater':
			$tmp = 'sell_zubcat_theater';
			break;
		case 'sell_kunst':
			$tmp = 'sell_zubcat_kuenstlerbedarf';
			break;
		case 'sell_kleinkunst':
			$tmp = 'sell_zubcat_kleinkunst';
			break;
		case 'sell_foto':
			$tmp = 'sell_zubcat_foto';
			break;
		case 'sell_buecher':
			$tmp = 'sell_zubcat_antiquariate';
			break;
		case 'sell_kochen':
			$tmp = 'sell_zubcat_kochen';
			break;
	}
	return $tmp;
}
function get_zub_musik_category($musik)
{
	$tmp = '';
	switch($musik)
	{
		case 'sell_noten';
			$tmp = 'sell_musikcat_noten';
			break;
		case 'sell_instrumente';
			$tmp = 'sell_musikcat_instrumente';
			break;
		case 'sell_klavier';
			$tmp = 'sell_musikcat_klavier';
			break;
		case 'sell_streicher';
			$tmp = 'sell_musikcat_streich';
			break;
		case 'sell_blaeser';
			$tmp = 'sell_musikcat_blas';
			break;
		case 'sell_zupf';
			$tmp = 'sell_musikcat_zupf';
			break;
		case 'sell_schlag';
			$tmp = 'sell_musikcat_schlag';
			break;
	}
}

/*
 * Add categories automatically to the post,
 * when the admin publish/update a post 
 * 
 * Status: OK
 */
function add_custom_category( $post_ID )
{

    global $wpdb;
    global $current_user;

    $postdata = get_postdata($id);
    $user_id = $postdata['Author_ID'];
    $user = new WP_User( $user_id );
    $user_role  = $user->roles[0];
    $user_cat = "";


    $cat_tmp = array();

    if ($user_role == 'freeuser')
    {
    	$slug = get_field('free_rubrik',$post_ID);
        $user_cat = "free";
	array_push($cat_tmp, $user_cat);
	if($slug == 'free_musikunterricht')
	{
	    $subslug = get_field('free_musikunterricht',$post_ID);
	    $subslug = get_musik_category($subslug);
            array_push($cat_tmp, $subslug);
	}
	else if($slug == 'free_sprachunterricht')
	{
	    $subslug = get_field('free_sprachunterricht',$post_ID);
	    $subslug = get_sprach_category($subslug);
            array_push($cat_tmp, $subslug);
	}
    }
    else if ($user_role == 'selluser')
    {
    	$slug = get_field('sell_rubrik',$post_ID);
        $user_cat = "sell";
	array_push($cat_tmp, $user_cat);
	if($slug == 'sell_zubehoer')
	{
		$subslug = get_field('sell_zubehoer',$post_ID);
		if($subslug == 'sell_musik')
		{
			$subsubslug = get_field('sell_musik',$post_ID);
	        	$subsubslug = get_zub_musik_category($subsubslug);
			array_push($cat_tmp, $subsubslug);
		}
	        $subslug = get_zub_category($subslug);
                array_push($cat_tmp, $subslug);
	}
    }

    $slug = get_rubrik_category_slug($slug, $user_cat);
    array_push($cat_tmp, $slug);

    if (!empty($cat_tmp))
    {

        // Getting categories
        $category_ids = array();
        foreach ($cat_tmp as $cat) {
		$idObj = get_category_by_slug($cat); 
        	array_push($category_ids, $idObj->term_id);
	}

        $category_ids = array_map('intval', $category_ids);
        $category_ids = array_unique( $category_ids );

        wp_set_object_terms($post_ID, $category_ids, 'category');
    }
}
add_action('publish_post',    'add_custom_category');
add_action('pre_post_update', 'add_custom_category');
//add_action('edit_post',       'add_custom_category');
//add_action('wp_insert_post', 'add_custom_category');
//add_action('save_post',       'add_custom_category');

function add_usertype_category( $post_ID )
{

    global $wpdb;
    global $current_user;

    global $wp_roles;
    
    foreach ( $wp_roles->role_names as $role => $name ) :
    	if ( current_user_can( $role ) )
    		$user_role = $role;
    endforeach;


    $cat_tmp = array();

    if ($user_role == 'freeuser')
    {
        $user_cat = "free";
	array_push($cat_tmp, $user_cat);
    }
    else if ($user_role == 'selluser')
    {
        $user_cat = "sell";
	array_push($cat_tmp, $user_cat);
    }

    //$slug = get_rubrik_category_slug($slug, $user_cat);
    //array_push($cat_tmp, $slug);

    if (!empty($cat_tmp))
    {

        // Getting categories
        $category_ids = array();
        foreach ($cat_tmp as $cat) {
        	$idObj = get_category_by_slug($cat); 
        	array_push($category_ids, $idObj->term_id);
        }

        $category_ids = array_map('intval', $category_ids);
        $category_ids = array_unique( $category_ids );

        wp_set_object_terms($post_ID, $category_ids, 'category');
    }
}
//add_action('save_post',      'add_usertype_category');
add_action('wp_insert_post', 'add_usertype_category');


function add_thumbnail($post_id)
{
	$thumbnail = get_field('free_thumbnail');		
	set_post_thumbnail( $post_id, $thumbnail );
}
add_action('publish_post',    'add_thumbnail');
add_action('edit_post',       'add_thumbnail');
add_action('pre_post_update', 'add_thumbnail');

/*
 * Modifying enter_title_here
 *
 * Status: Define different messages
 */
function change_default_title( $title ){

    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if ($user_role == 'freeuser')
    {
        $screen = get_current_screen();
        if  ( 'post' == $screen->post_type ) {
            $title = 'Z.B "Aquarellkurs in Berlin-Friedenau" oder "Schreiben online lernen"';
        }
    }
    if ($user_role == 'selluser')
    {
        $screen = get_current_screen();
        if  ( 'post' == $screen->post_type ) {
            $title = 'Digitalpianos - generalüberholt - online kaufen" oder "Antiquariat mit Schwerpunkt Philosophie in Heidelberg';
        }
    }

   return $title;
}
add_filter( 'enter_title_here', 'change_default_title' );

/*
 * Modifying Header of new meesage
 *
 * Status: Define the title
 *
 */
function change_default_title_label( $title ){

    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if ($user_role == 'freeuser' || $user_role == 'selluser')
    {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->add_new_item = 'Inserieren';
    }
}
add_action('init', 'change_default_title_label');

/*
 * Adding description below title
 *
 * Status: Message for Sell and Free users
 */
function adding_description()
{
    $message = NULL;

    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    if(strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/post-new.php' ) !== false)
    {
    	if ($user_role == 'freeuser')
    	{
    	    $message = 'Die Überschrift sollte vor allem etwas über Ihr Angebot und den Veranstaltungsort aussagen - für die Suchmaschine!';
    	}
    	else if ($user_role == 'selluser')
    	{
    	    $message = 'Die Überschrift sollte vor allem etwas über Ihr Angebot und Ihren Standort aussagen - für die Suchmaschine.';
    	}

	$note_title = 'Bitte beachten:';
	$note_content = 'Die Vorschau-Funktion und den Button zum "Veröffentlichen" finden Sie hier oben rechts!';

    	if ($message)
    	{
    	    ?><script>
    	        jQuery(function($)
    	        {
    	            $('<div style="margin-bottom:15px; color: black;"></div>').text('<?php echo $note_content; ?>').insertAfter('#wpbody-content .wrap h2:eq(0)');
    	            $('<div style="margin-bottom:15px; color: red;"></div>').text('<?php echo $note_title; ?>').insertAfter('#wpbody-content .wrap h2:eq(0)');
    	            $('<div style="margin-bottom:15px; color:#999;"></div>').text('<?php echo $message; ?>').insertAfter('#wpbody-content .wrap h2:eq(0)');
    	        });
    	    </script><?php
    	}
     }
}
add_action('admin_footer', 'adding_description');

/*
 * List post by a category
 *
 * Status: Pending default image
 *         Alternative to the 404 page in the menu-items
 */
function list_kukmal_posts($category)
{
	get_header();
	?>
	<div id="content-full" class="grid col-940">
	<h1 class="post-title"><?php the_title(); ?></h1>
	<?php the_content(); ?>
	<?php
	$blog_query = new WP_Query("category_name=$category");
	if($blog_query->have_posts()) :
	while ($blog_query->have_posts()) : $blog_query->the_post();
	?>
	<hr class="kukmalhr">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="post-title"><?php the_title(); ?></a></h2>
	                <div class="post-meta">
	                <?php responsive_post_meta_data(); ?>
	                </div><!-- end of .post-meta -->
	                <div class="post-entry">
			<div style="float: left; padding: 5px;">
				<?php
	            		global $post;
	            		$id = $post->ID;
				$url = "http://www.nigeltomm.com/images/green_square_nigel_tomm_m.jpg";
				if(has_post_thumbnail($id)) {
				   $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
				}
				echo"<img src=\"$url\" width=\"100px\" height=\"100px\">";
				?>
			</div>
	                    <?php the_excerpt(__('Read more &#8250;', 'responsive')); ?>
	
	                    <?php if ( get_the_author_meta('description') != '' ) : ?>
	
	                    <div id="author-meta">
	                    <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>
	                        <div class="about-author"><?php _e('About','responsive'); ?> <?php the_author_posts_link(); ?></div>
	                        <p><?php the_author_meta('description') ?></p>
	                    </div><!-- end of #author-meta -->
	
	                    <?php endif; // no description, no author's meta ?>
	
	                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
	                </div><!-- end of .post-entry -->
	            </div>
	
	<?php endwhile; else: ?>

		<?php include('kukmal404.php'); ?>

	<?php endif; ?>
	
	</div>
	
	<?php //get_sidebar(); ?>
	<?php get_footer(); ?>
	<?php
}

/*
 * Adding Login/Logout option to menu
 *
 * Status: OK
 */
function add_login_logout_link($items, $args) {
 
    if($args->theme_location == 'top-menu') {
 
	global $current_user;
        get_currentuserinfo();

        if (is_user_logged_in()) {  
		$items .= '<li><a href="'. wp_logout_url( home_url() ) .'" title="Logout" style="color: #A6A605; font-weight: bold;">Logout</a></li>';
        }
        else {
		$items .= '<li><a href="'. wp_login_url( home_url() ) .'" title="Login" style="color: #A6A605; font-weight: bold;" >Login</a></li>';
        }
 
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'add_login_logout_link', 10, 2 );

/*
 * Function to remove media library from upload tab
 */
//function remove_medialibrary_tab($tabs) {
////	if ( !current_user_can( 'administrator' ) ) {
//		unset($tabs['library']);
//		return $tabs;
////	}
////	else
////	{
////		return $tabs;
////	}
//}
//add_filter('media_upload_tabs','remove_medialibrary_tab');

function mymo_parse_query_useronly( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ||
         strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/media-upload.php' ) !== false ||
         strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/media-new.php' ) !== false ||
         strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/media.php' ) !== false 

	){
        if ( !current_user_can( 'level_5' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
add_filter('parse_query', 'mymo_parse_query_useronly' );


function users_own_attachments( $wp_query_obj ) {

    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( 'upload.php' != $pagenow )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->id );

    return;
}
add_action('pre_get_posts','users_own_attachments');
add_action('admin_head-media-upload-popup', 'users_own_attachmens');

/*
 * Change maximum upload file
 * The displayed message in the media window is still 25M
 */
//function kukmal_max_upload_size() {
//	$u_bytes = wp_convert_hr_to_bytes( '2MB' );
//	$p_bytes = wp_convert_hr_to_bytes( '2MB' );
//	$bytes = apply_filters( 'upload_size_limit', min($u_bytes, $p_bytes), $u_bytes, $p_bytes );
//	return $bytes;
//} 
//apply_filters( 'import_upload_size_limit', kukmal_max_upload_size() );	

function list_kukmal_posts2($category)
{

	$blog_query = new WP_Query("category_name=$category");
	if($blog_query->have_posts()) :
	while ($blog_query->have_posts()) : $blog_query->the_post();
	?>
	<hr class="kukmalhr">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	    		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="post-title"><?php the_title(); ?></a></h2>
	                <div class="post-meta">
	                <?php responsive_post_meta_data(); ?>
	                </div><!-- end of .post-meta -->
	                <div class="post-entry">
			<div style="float: left; padding: 5px;">
				<?php
	            		global $post;
	            		$id = $post->ID;
				$url = "http://www.nigeltomm.com/images/green_square_nigel_tomm_m.jpg";
				if(has_post_thumbnail($id)) {
				   $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
				}
				echo"<img src=\"$url\" width=\"100px\" height=\"100px\">";
				?>
			</div>
	                    <?php the_excerpt(__('Read more &#8250;', 'responsive')); ?>
	
	                    <?php if ( get_the_author_meta('description') != '' ) : ?>
	
	                    <div id="author-meta">
	                    <?php if (function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); }?>
	                        <div class="about-author"><?php _e('About','responsive'); ?> <?php the_author_posts_link(); ?></div>
	                        <p><?php the_author_meta('description') ?></p>
	                    </div><!-- end of #author-meta -->
	
	                    <?php endif; // no description, no author's meta ?>
	
	                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
	                </div><!-- end of .post-entry -->
	            </div>
	
	<?php endwhile; else: ?>

		<?php include('kukmal404.php'); ?>

	<?php endif; ?>
	
	</div>
	<?php
}

function get_category_from_content($attr, $content){
        $attr = shortcode_atts( array(
                'category' => 'no category',
        ), $attr );

	ob_start();
	list_kukmal_posts2($attr['category']);
	$output_string = ob_get_contents();
	ob_end_clean();

	return $output_string;
}

add_shortcode('kukmal','get_category_from_content');

?>
