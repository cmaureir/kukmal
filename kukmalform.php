<script type="text/javascript">

$(document).ready(function() {  
$('#sortierung').change( function() {
    var $t = $(this).find("option:selected").val();
    if($t == "plz")
    {
	$("#plz").show();
    }
    else
    {
	$("#plz").hide();
    }

});
$('#atype').change( function() {

    var $t = $(this).find("option:selected").val();

    if($t == "free")
    {
        $("#rubrikfree").show();
        $("#rubriksell").hide();
        $("#zielgruppe").show();
    }
    else if($t == "sell")
    {
        $("#rubrikfree").hide();
        $("#rubriksell").show();
        $("#zielgruppe").hide();
    }
    else if($t == "therapie" || $t == "raum")
    {
        $("#rubrikfree").hide();
        $("#rubriksell").hide();
        $("#zielgruppe").hide();
    }

});
});


</script>


<h2>Suchen</h2>
<table class="kukmaltable">
    <form name="form1" method="post" action="">

    <!-- Type -->
    <tr>
	<td>Angebotsart</td>
        <td>
            <?php
            $options = array(
                'free'     => 'Kurse und Unterricht',
                'sell'     => 'Zubehör',
                'therapie' => 'Kunst-und Körpertherapien',
                'raum'     => 'Raumvermietungen');
            ?>
            <select name="atype" id="atype">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['atype'] == $key)
                {
                    echo"<option value='".$key."' selected>".$value."</option>\n";
                }
                else
                {
                    echo"<option value='".$key."'>".$value."</option>\n";
                }
            }
            ?>
            </select>
	</td>
    </tr>
    <!-- End of Type -->

    <!-- Rubrik Free -->
    <tr name="rubrikfree" id="rubrikfree" <?php if (isset($_POST['atype']) && $_POST['atype'] != "free") { ?>style="display:none;" <?php } ?>>
        <td>Rubrik</td>
        <td>
            <?php
		// This are the values and names of the Custom Field plugin for Free announcements.
            $options = array(
                'free_musikunterricht'   => 'Instrumental und Gesangsunterricht',
                'free_musik'             => 'Weitere Kurse aus dem Bereich Musik',
                'free_tanz'              => 'Tanzunterricht/Tanzkurse',
                'free_theater'           => 'Theaterworkshops/Theaterkurse',
                'free_malen'             => 'Malen und Zeichnen',
                'free_kunst'             => 'Kunsthandwerkskurse',
                'free_kleinkunst'        => 'Kleinkunst',
                'free_foto'              => 'Kurse Fotografie und Film',
                'free_schreib'           => 'Schreiben und Erzählen',
                'free_sprach'            => 'Sprachunterricht',
                'free_philosophie'       => 'Philosophiekurse',
                'free_geschicht'         => 'Geschichtsworkshops',
                'free_kulinarisches'     => 'Kulinarisches');

            ?>
            <select name="rubrik_free">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['rubrik_free'] == $key)
                {
                    echo"<option value='".$key."' selected>".$value."</option>\n";
                }
                else
                {
                    echo"<option value='".$key."'>".$value."</option>\n";
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <!-- End of Rubrik -->


    <!-- Rubrik Sell -->
    <tr name="rubriksell" id="rubriksell" <?php if (!isset($_POST['atype']) || $_POST['atype'] != "sell") { ?>style="display:none;" <?php } ?>>
        <td>Rubrik</td>
        <td>
            <?php
		// This are the values and names of the Custom Field plugin for Sell announcements.
            $options = array(
		'sell_musik'      => 'Zubehör Musik',
		'sell_tanz'       => 'Zubehör Tanz',
		'sell_theater'    => 'Theaterbedarf',
		'sell_kunst'      => 'Künstlerbedarf',
		'sell_kleinkunst' => 'Zubehör Kleinkunst',
		'sell_foto'       => 'Zubehör für Fotografie und Film',
		'sell_anti'       => 'Buchläden und Antiquariate',
		'sell_kochen'     => 'Zubehör Kochen');
            ?>
            <select name="rubrik_sell">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['rubrik_sell'] == $key)
                {
                    echo"<option value='".$key."' selected>".$value."</option>\n";
                }
                else
                {
                    echo"<option value='".$key."'>".$value."</option>\n";
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <!-- End of Rubrik Sell-->


    <!-- Zielgruppe -->
    <tr name="zielgruppe" id="zielgruppe" <?php if (isset($_POST['atype']) && ($_POST['atype'] == "therapie" || $_POST['atype'] == "raum" || $_POST["atype"] == "sell" )) { ?>style="display:none;" <?php } ?>>
    <td>Zielgruppe</td>
    <td>
    <?php
                $options = array('%'          => 'Kinder und Erwachsene',
                        	 'Kinder'     => 'Kinder',
                        	 'Erwachsene' => 'Erwachsene');
                ?>
    <select name="zielgruppe">
    <?php
                foreach($options as $key => $value)
                {
                    if($_POST['zielgruppe'] == $key)
                    {
                        echo"<option value='".$key."' selected>".$value."</option>\n";
                    }
                    else
                    {
                        echo"<option value='".$key."'>".$value."</option>\n";
                    }
                }
                ?>
    </select>
    </td>
    </tr>
    <!-- End of Zielgruppe -->


    <!-- Sortierung -->
    <tr id="sortierung">
        <td>Sortierung</td>
        <td class="alt">
            <?php
            $options = array(
                    'plz'    => 'Angebote sortiert nach PLZ',
                    'online' => 'Überregionale und Online-Angebote',
                    '%'      => 'Alle Angebote');
            ?>
            <select name="sortierung" id="sortierung">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['sortierung'] == $key)
                {
                    echo"<option value='".$key."' selected>".$value."</option>\n";
                }
                else
                {
                    echo"<option value='".$key."'>".$value."</option>\n";
                }
            }
            ?>
            </select>
        </td>
    </tr>
    <!-- End of Category -->

    <!-- PLZ -->
    <tr name="plz" id="plz" <?php if (isset($_POST['sortierung']) && $_POST['sortierung'] != "plz") { ?>style="display:none;" <?php } ?>>
        <td>PLZ</td>
        <td>
            <input type="number" name="plz" value="<?php
                                                   $value = $_POST['plz'];
                                                   if (isset($value))
                                                       echo $value;
                                                   else
                                                       echo"0"; ?>"/>
            <br/>
            <p>(Sie können hier eine bis fünf Ziffern eingeben und erhalten entsprechend genaue Ergebnisse. (Z.B. "67" für die Region Ludwigshafen; "67227" nur für Frankenthal)</p>
        </td>
    </tr>

    <!-- End of PLZ -->

     <tr>
        <td></td>
        <td>
            <input type="submit" name="Submit" value="Suchen!" class="searchbutton">
        </td>
    </tr>
    </form>
</table>
