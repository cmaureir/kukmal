<script type="text/javascript">

$(document).ready(function()
{
    if(document.getElementById('free').checked)
    {
        $("#rubrikfree").show();
        $("#rubriksell").hide();
        $("#zielgruppe").show();
    }
    else if(document.getElementById('sell').checked)
    {
        $("#rubrikfree").hide();
        $("#rubriksell").show();
        $("#zielgruppe").hide();
    }
});

function toggle(tr_id)
{
    if ( tr_id == 1 )
    {
        $("#rubrikfree").show();
        $("#rubriksell").hide();
        $("#zielgruppe").show();
    }
    else if (tr_id == 2)
    {
        $("#rubrikfree").hide();
        $("#rubriksell").show();
        $("#zielgruppe").hide();
    }
}
</script>


<h2>Suchen</h2>
<table class="kukmaltable">
    <form name="form1" method="post" action="">

    <!-- Type -->
    <tr>
	<td>Type</td>
	<td class="alt">
	    <?php
            if($_POST['type'] == 1)
	    {
            ?>
	        <input id="free" type="radio" name="type" value="1" onClick="toggle(1);" checked/> Kurse und Unterricht
	        <input id="sell" type="radio" name="type" value="2" onClick="toggle(2);" /> Zutaten
	    <?php
	    }
	    else if ($_POST['type'] == 2)
	    {
	    ?>
	        <input id="free" type="radio" name="type" value="1" onClick="toggle(1);" /> Kurse und Unterricht
	        <input id="sell" type="radio" name="type" value="2" onClick="toggle(2);" checked/> Zutaten
	    <?php
            }
	    else
	    {
	    ?>
	        <input id="free" type="radio" name="type" value="1" onClick="toggle(1);" checked/> Kurse und Unterricht
	        <input id="sell" type="radio" name="type" value="2" onClick="toggle(2);" /> Zutaten
            <?php
            }
            ?>
	</td>
    </tr>
    <!-- End of Type -->

    <!-- Rubrik Free -->
    <tr id="rubrikfree">
        <td>Rubrik</td>
        <td>
            <?php
            $options = array(
                'instrumental'       => 'Instrumental und Gesangsunterricht',
                'kurse'              => 'Weitere Kurse aus dem Bereich Musik',
                'tanz'               => 'Tanz',
                'theater'            => 'Theater',
                'malen'              => 'Malen und Zeichnen',
                'handwerk'           => 'Kunsthandwerkskurse',
                'foto'               => 'Fotografie und Film',
                'schreiben'          => 'Schreiben und Erzählen',
                'sprachunterricht'   => 'Sprachunterricht',
                'philosophiekurse'   => 'Philosophiekurse',
                'geschichtsworkshops'=> 'Geschichtsworkshops',
                'kulinarisches'      => 'Kulinarisches');
            ?>
            <select name="rubrik">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['rubrik'] == $key)
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
    <tr id="rubriksell" style="display:none;">
        <td>Rubrik</td>
        <td>
            <?php
            $options = array(
                'korper'  => 'Körpertherapieangebote',
                'raum'    => 'Raumvermietungen',
                'zubehor' => 'Zubehör');
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
    <tr id="zielgruppe">
        <td>Zielgruppe</td>
        <td>
            <?php
            $options = array('%' => 'Alles',
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

    <!-- Kategorie -->
    <tr id="kategorie">
        <td>Kategorie</td>
        <td class="alt">
            <?php
            $options = array('%' => 'Alles',
                    'ort'     => 'Presencial',
                    'online' => 'Überregional/online');
            ?>
            <select name="kategorie">
            <?php
            foreach($options as $key => $value)
            {
                if($_POST['kategorie'] == $key)
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
    <tr>
        <td>PLZ</td>
        <td>
            <input type="number" name="plz" value="<?php
                                                   $value = $_POST['plz'];
                                                   if (isset($value))
                                                       echo $value;
                                                   else
                                                       echo"-1"; ?>"/>
            <br/>
            <p>("-1" bedeutet "alle PLZ")</p>
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
