<?php
/*
Template Name: KuKmal Search
*/
get_header();
?>

<?php
// Search engine

function get_posts_ids($rubrik, $zielgruppe, $plz, $kategorie)
{
    global $wpdb;
    // Queries to the DB and saving the results of each one

    // Rubrik query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='rubrik' and
                      $wpdb->postmeta.meta_value like '".$rubrik."');";
    $result_rubrik = $wpdb->get_results($query);

    // Zielgruppe query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='zielgruppe' and
                      $wpdb->postmeta.meta_value like '".$zielgruppe."' and
                      $wpdb->postmeta.meta_value not like '".$no_ziel."');";
    $result_ziel = $wpdb->get_results($query);

    // PLZ query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='plz' and
                      $wpdb->postmeta.meta_value like '".$plz."') ";
    if($kategorie == "ort")
    {
	$query = $query."and meta_value not like -1";
    }
    else if ($kategorie == "online")
    {
	$query = $query."and meta_value like -1";
    }
    $query = $query.";";
    print_r($query);

    $result_plz = $wpdb->get_results($query);


    // Adding all the ids to the same array
    // Using 'intersect' to get a unique id's list
    $ids = array();
    $tmp = array();

    foreach ($result_rubrik as $row)
    {
        array_push($ids,$row->post_id);
    }
    foreach ($result_ziel as $row)
    {
        array_push($tmp,$row->post_id);
    }
    $ids = array_intersect($ids, $tmp);
    unset($tmp);
    $tmp = array();
    foreach ($result_plz as $row)
    {
        array_push($tmp,$row->post_id);
    }
    $ids = array_intersect($ids, $tmp);
    // Removing repeated ids
    $ids = array_unique($ids);

    return $ids;
}

function get_posts_ids_sell($rubrik, $plz)
{
    global $wpdb;
    // Queries to the DB and saving the results of each one

    // Rubrik query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='rubrik' and
                      $wpdb->postmeta.meta_value like '".$rubrik."');";
    $result_rubrik = $wpdb->get_results($query);

    // PLZ query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='plz' and
                      $wpdb->postmeta.meta_value like '".$plz."')
              order by $wpdb->postmeta.meta_value asc;";
    $result_plz = $wpdb->get_results($query);


    // Adding all the ids to the same array
    // Using 'intersect' to get a unique id's list
    $ids = array();
    $tmp = array();

    foreach ($result_rubrik as $row)
    {
        array_push($ids,$row->post_id);
    }
    foreach ($result_plz as $row)
    {
        array_push($tmp,$row->post_id);
    }
    $ids = array_intersect($ids, $tmp);
    // Removing repeated ids
    $ids = array_unique($ids);

    return $ids;
}

function display_results_sell($rows)
{

    global $post;
    $id = $post->ID;
    echo '<h2>Resultados:</h2>';
    foreach ($rows as $post)
    {

        echo '<hr class="kukmalhr"/>';
        setup_postdata( $post );
?>
        <h3>
            <a href="<?php the_permalink() ?>"
               rel="bookmark"
               title="Link to <?php the_title(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php
    	global $post;
    	$id = $post->ID;
        $url = "http://www.nigeltomm.com/images/green_square_nigel_tomm_m.jpg";
        if(has_post_thumbnail($id)) {
           $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
        }
        echo"<img style=\"float:left; padding: 0px 15px 0px 0px; width: 100px; height:100px;\" src=\"$url\">";
        ?>

        <div class="kukmalpostmeta">
            <span class="kukmalauthor">Posted by <?php the_author(); ?> </span>
            <span class="kukmalclock"> Posted on <?php the_time('M-j-Y'); ?></span>
        </div>
        <?php
        global $post;
        $id = $post->ID;

        $rubrik_value = get_field('rubrik', $id);
        $rubrik = get_field_object('rubrik', $id);
        $rubrik = $rubrik['choices'][$rubrik_value];
        $plz = get_field('plz');
        ?>
        <div class="kukmalsingleinfo">
            <span class="kukmalinfo">Rubrik:</span>
            <span class="kukmalfields"><?php echo $rubrik; ?> </span><br/>
            <span class="kukmalinfo">PLZ:</span>
            <span class="kukmalfields"><?php echo $plz; ?></span>
        </div>
        <div class="kukmalcontent">
        <?php
            $content = get_the_content();
            $content = substr($content, 0, 400);
            $content .= '...<a href="'. get_permalink().'">Read more</a>';
            echo $content;
        ?>
        <div class="clear"></div>
        <?php wp_link_pages(array('before' => '<p><strong>Pages: </strong> ',
                                  'after' => '</p>',
                                  'next_or_number' => 'number')); ?>
        </div>
<?php
    }
}

function display_results($rows)
{

    global $post;
    $id = $post->ID;
    echo '<h2>Resultados:</h2>';
    foreach ($rows as $post)
    {

        echo '<hr class="kukmalhr"/>';
        setup_postdata( $post );
?>
        <h3>
            <a href="<?php the_permalink() ?>"
               rel="bookmark"
               title="Link to <?php the_title(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php
    	global $post;
    	$id = $post->ID;
        $url = "http://www.nigeltomm.com/images/green_square_nigel_tomm_m.jpg";
        if(has_post_thumbnail($id)) {
           $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
        }
        echo"<img style=\"float:left; padding: 0px 15px 0px 0px; width: 100px; height:100px;\" src=\"$url\">";
        ?>

        <div class="kukmalpostmeta">
            <span class="kukmalauthor">Posted by <?php the_author(); ?> </span>
            <span class="kukmalclock"> Posted on <?php the_time('M-j-Y'); ?></span>
        </div>
        <?php
        global $post;
        $id = $post->ID;

        $zielgruppe = get_field_object('zielgruppe', $id);
        $zielgruppe = $zielgruppe['choices'][get_field('zielgruppe',$id)];

        $rubrik_value = get_field('rubrik', $id);
        $rubrik = get_field_object('rubrik', $id);
        $rubrik = $rubrik['choices'][$rubrik_value];
        if($rubrik_value == 'instrumental')
        {
            $value = get_field_object('instrumental',$id);
            $value = $value['choices'][get_field('instrumental',$id)];
            if($value != "")
            {
                $rubrik .= " (".$value.")";
            }
        }
        else if ($rubrik == 'sprachunterricht')
        {
            $value = get_field_object('sprachunterricht',$id);
            $value = $value['choices'][get_field('sprachunterricht',$id)];
            if($value != "")
            {
                $rubrik .= " (".$value.")";
            }
        }
        $institution = get_field('institution');
        $plz = get_field('plz');
        ?>
        <div class="kukmalsingleinfo">
            <span class="kukmalinfo">Rubrik:</span>
            <span class="kukmalfields"><?php echo $rubrik; ?> </span><br/>
            <span class="kukmalinfo">Zielgruppe:</span>
            <span class="kukmalfields"><?php echo $zielgruppe; ?></span><br/>
            <span class="kukmalinfo">Institution oder Name:</span>
            <span class="kukmalfields"><?php echo $institution; ?></span><br/>
            <span class="kukmalinfo">PLZ:</span>
            <span class="kukmalfields"><?php echo $plz; ?></span>
        </div>
        <div class="kukmalcontent">
        <?php
            $content = get_the_content();
            $content = substr($content, 0, 400);
            $content .= '...<a href="'. get_permalink().'">Read more</a>';
            echo $content;
        ?>
        <div class="clear"></div>
        <?php wp_link_pages(array('before' => '<p><strong>Pages: </strong> ',
                                  'after' => '</p>',
                                  'next_or_number' => 'number')); ?>
        </div>
<?php
    }
}

function order_rows_by_plz($rows)
{
    $tmp = array();
    
    foreach($rows as $row)
    {
	$tmp[$row->ID] = get_field("plz",$row->ID);
    }	
    asort($tmp); 
   
    $new_rows = array();
    foreach($tmp as $key => $value)
    {
        foreach($rows as $i => $post)
        {
	    if ($post->ID == $key)
            {
               array_push($new_rows, $post);
               unset($rows[$i]);
            }
        }
    }
    return $new_rows;

}


function kukmal_search($items, $data, $type)
{
    global $wpdb;
    if ($type == 1)
    {
        // Getting the parameters of the form
        $rubrik     = $data[0];
        $zielgruppe = $data[1];
        $plz        = $data[2]."%";
        $kategorie  = $data[3];


        // Saving the opposite zielgruppe for the filter
        $no_ziel = "";
        if(strtolower($zielgruppe) == 'kinder')
        {
            $no_ziel = 'erwachsene';
        }
        else if (strtolower($zielgruppe) == 'erwachsene')
        {
            $no_ziel = 'kinder';
        }
        $zielgruppe = '%';

        // Fixing the PLZ for the non-physical courses
        if($plz == '-1%')
        {
            $plz = '%';
        }

        $ids = get_posts_ids($rubrik, $zielgruppe, $plz, $kategorie);

        if ( count($ids) != "0")
        {
            $query = "select * from $wpdb->posts where post_status='publish' and (";

            foreach ($ids as $id) {
                $query = $query."ID = '".$id."' or ";
            }
            $query = substr_replace($query ,"",-3);
            $query = $query.");";

            $rows = $wpdb->get_results($query);
            // Check if the results are not 'non-published' post
            if (empty($rows))
            {
                echo "<h2>keine Suchergebnisse gefunden</h2>";
            }
            else
            {
                $rows = order_rows_by_plz($rows);
                display_results($rows);
            }
        }
        else
        {
            echo "<h2>keine Suchergebnisse gefunden</h2>";
        }
    }
    else if ($type == 2)
    {
        // Getting the parameters of the form
        $rubrik     = $data[0];
        $plz        = $data[1]."%";

        // Fixing the PLZ for the non-physical courses
        if($plz == '-1%')
        {
            $plz = '%';
        }

        $ids = get_posts_ids_sell($rubrik, $plz);

        if ( count($ids) != "0")
        {
            $query = "select * from $wpdb->posts where post_status='publish' and (";

            foreach ($ids as $id) {
                $query = $query."ID = '".$id."' or ";
            }
            $query = substr_replace($query ,"",-3);
            $query = $query.");";

            $rows = $wpdb->get_results($query);
            // Check if the results are not 'non-published' post
            if (empty($rows))
            {
                echo "<h2>keine Suchergebnisse gefunden</h2>";
            }
            else
            {
                $rows = order_rows_by_plz($rows);
                display_results_sell($rows);
            }
        }
        else
        {
            echo "<h2>keine Suchergebnisse gefunden</h2>";
        }

    }
}

?>

<div class="eleven columns ">
<div id="content" >

<?php

include('kukmalform.php');

$form_status = true;
$data = array();

// Type of the query
$type = $_POST["type"];

if(isset($type))
{
    if($type == 1)
    {
        $items = array('rubrik',
                       'zielgruppe',
                       'plz',
			'kategorie');
    }
    else if($type == 2)
    {
        $items = array('rubrik_sell',
                       'plz');
    }

    foreach ($items as $item)
    {
        if (isset($_POST[$item]))
        {
            $value = $_POST[$item];
            if(!isset($value) || $value == '')
            {
                $form_status = false;
            }
            else
            {
                array_push($data, $value);
            }
        }
        else
        {
            $form_status = false;
        }
    }

    if($form_status)
    {
        kukmal_search($items, $data, $type);
    }
}


echo "</div></div>";
//get_sidebar();
get_footer();

?>
