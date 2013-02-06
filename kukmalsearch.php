<?php
/*
Template Name: KuKmal Search
*/
get_header();
?>

<?php
// Search engine

function get_posts_ids($type, $rubrik, $zielgruppe, $plz)
{
    global $wpdb;
    // Queries to the DB and saving the results of each one

    if($zielgruppe == 'kinder')
    {
        $no_ziel = 'free_erwachsene';
    }
    else if ($zielgruppe == 'erwachsene')
    {
        $no_ziel = 'free_kinder';
    }

    // Rubrik query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='".$type."_rubrik' and
                      $wpdb->postmeta.meta_value like '".$rubrik."');";
    $result_rubrik = $wpdb->get_results($query);

    // Zielgruppe query
    if ($type == "free" && $zielgruppe != "%")
    {
    	$query = "select distinct $wpdb->postmeta.post_id
    	          from $wpdb->postmeta
    	          where ( $wpdb->postmeta.meta_key='".$type."_zielgruppe' and
    	                  $wpdb->postmeta.meta_value like '".$type . "_" .$zielgruppe."' and
    	                  $wpdb->postmeta.meta_value not like '".$no_ziel."');";
    	$result_ziel = $wpdb->get_results($query); 
    }
    else if ($zielgruppe == "%")
    {
    	$query = "select distinct $wpdb->postmeta.post_id
    	          from $wpdb->postmeta
    	          where ( $wpdb->postmeta.meta_key='".$type."_zielgruppe' and
    	                  $wpdb->postmeta.meta_value like '".$zielgruppe."');";
    	$result_ziel = $wpdb->get_results($query); 
    }
    else
    {
	$result_ziel = array();
    }

    // PLZ query
    $query = "select distinct $wpdb->postmeta.post_id
              from $wpdb->postmeta
              where ( $wpdb->postmeta.meta_key='".$type."_plz' and
                      $wpdb->postmeta.meta_value like '".$plz."');";
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

function display_results_sell($rows)
{

    global $post;
    $id = $post->ID;
    echo '<h2>Ergebnisse:</h2>';
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

        $rubrik_value = get_field('sell_rubrik', $id);
        $rubrik = get_field_object('sell_rubrik', $id);
        $rubrik = $rubrik['choices'][$rubrik_value];
        $plz = get_field('sell_plz');
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

function display_results_free($rows)
{

    global $post;
    echo '<h2>Ergebnisse:</h2>';

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
	$url = "";
	if(has_post_thumbnail($id)) {
	   $url = wp_get_attachment_url( get_post_thumbnail_id($id));
	   if ( $url != "")
             echo"<img style=\"float:left; padding: 0px 15px 0px 0px; width: 100px; height:100px;\" src=\"$url\">";
				}
        ?>

        <div class="kukmalpostmeta">
            <span class="kukmalauthor">Posted by <?php the_author(); ?> </span>
            <span class="kukmalclock"> Posted on <?php the_time('M-j-Y'); ?></span>
        </div>
        <?php
        global $post;
        $id = $post->ID;

        $zielgruppe = get_field_object('free_zielgruppe', $id);
        $zielgruppe = $zielgruppe['choices'][get_field($type.'free_zielgruppe',$id)];

        $rubrik_value = get_field('free_rubrik', $id);
        $rubrik = get_field_object('free_rubrik', $id);
        $rubrik = $rubrik['choices'][$rubrik_value];
        if($rubrik_value == 'free_musikunterricht')
        {
            $value = get_field_object('free_musikunterricht',$id);
            $value = $value['choices'][get_field('free_musikunterricht',$id)];
            if($value != "")
            {
                $rubrik .= " (".$value.")";
            }
        }
        else if ($rubrik == 'free_sprachunterricht')
        {
            $value = get_field_object('free_sprachunterricht',$id);
            $value = $value['choices'][get_field('free_sprachunterricht',$id)];
            if($value != "")
            {
                $rubrik .= " (".$value.")";
            }
        }
        $institution = get_field('free_institution');
        $plz = get_field('free_plz');
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

function order_rows_by_plz($rows,$type)
{
    $tmp = array();
    
    foreach($rows as $row)
    {
	$tmp[$row->ID] = get_field($type."_plz",$row->ID);
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

function order_rows_random($rows,$type)
{
    shuffle($rows);
    return $rows; 
}

function kukmal_search($data)
{
    global $wpdb;
    // Getting the parameters of the form
    $type = $data["type"];
    $rubrik = $data["rubrik".$type];
    $zielgruppe = strtolower($data["zielgruppe"]);
    $plz    = $data["sortierung"]; // plz value

    $ids = get_posts_ids($type, $rubrik, $zielgruppe, $plz);


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
            if ($plz != "-1" and $plz != "%")
            {
            	$rows = order_rows_by_plz($rows, $type);
            }
            else if ($plz == "-1")
            {
            	$rows = order_rows_random($rows, $type);
            }
            if ($type == "free")
            	display_results_free($rows);
            else if ($type == "sell")
            	display_results_sell($rows);
        }
    }
    else
    {
        echo "<h2>keine Suchergebnisse gefunden</h2>";
    }
}

?>

<div class="eleven columns ">
<div id="content" >

<?php

function get_search_data()
{
    $type       = $_POST["atype"];
    $rubrikfree = $_POST["rubrik_free"];
    $rubriksell = $_POST["rubrik_sell"];
    $zielgruppe = $_POST["zielgruppe"];
    $sortierung = $_POST["sortierung"];
    $plz        = $_POST["plz"];

    $data = array();

    if(isset($type) &&  $type != "")
    {
	$a_type = array("type" => $type,);
    }
    if(isset($rubrikfree) &&  $rubrikfree != "")
    {
	$a_rubrikfree = array("rubrikfree" => $rubrikfree);
    }
    if(isset($rubriksell) &&  $rubriksell != "")
    {
	$a_rubriksell = array("rubriksell" => $rubriksell);
    }
    if(isset($zielgruppe) &&  $zielgruppe != "")
    {
	$a_zielgruppe = array("zielgruppe" => $zielgruppe);
    }
    if(isset($sortierung) &&  $sortierung != "")
    {
        if ($sortierung == "%")
        {
            $tmp = "%";
        }
        else if ($sortierung == "plz")
        {
            // the PLZ code
	    if($plz > 0)
	        $tmp = $plz . "%";
	    else
		$tmp = "%";
        }
        else if ($sortierung == "online")
        {
            // -1 means überregional/online
            $tmp = "-1";
        }
	$a_sortierung = array("sortierung" => $tmp);
    }

    $data = array_merge($data, $a_type, $a_rubrikfree, $a_rubriksell, $a_zielgruppe, $a_sortierung);
    return $data;

}
include('kukmalform.php');

$form_status = true;

if(isset($_POST["atype"]))
{
	$data = get_search_data();
	//echo "<pre>";
	//print_r($data);
	//echo "</pre>";
	kukmal_search($data);
}


echo "</div></div>";
//get_sidebar();
get_footer();

?>
