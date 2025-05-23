<?php

$author_field = $this->skylight_utilities->getField("Author");
$maker_field = $this->skylight_utilities->getField("Maker");
$type_field = $this->skylight_utilities->getField("Type");
$bitstream_field = $this->skylight_utilities->getField("Bitstream");
$thumbnail_field = $this->skylight_utilities->getField("Thumbnail");
$filters = array_keys($this->config->item("skylight_filters"));
$link_uri_field = $this->skylight_utilities->getField("Link");
$media_uri = $this->config->item("skylight_media_url_prefix");
$image_uri_field = $this->skylight_utilities->getField('ImageUri');
$permalink_field = $this->skylight_utilities->getField('Permalink');
$acc_no_field = $this->skylight_utilities->getField("Accession Number");

$type = 'Unknown';
$mainImageTest = false;
$numBitstreams = 0;
$bitstreamLinks = array();
$mainImage = false;
$numThumbnails = 0;
$bitstreamLinks = array();
$image_id = "";
$accno = '';
//Insert Schema.org
$schema = $this->config->item("skylight_schema_links");

if(isset($solr[$type_field])) {
    $type = "media-" . strtolower(str_replace(' ','-',$solr[$type_field][0]));
}

if(isset($solr[$bitstream_field]) && $link_bitstream) {

    $bitstream_array = array();

    foreach ($solr[$bitstream_field] as $bitstream_for_array)
    {
        $b_segments = explode("##", $bitstream_for_array);
        $b_seq = $b_segments[4];
        $bitstream_array[$b_seq] = $bitstream_for_array;
    }

    ksort($bitstream_array);

    $videoFile = false;
    $audioFile = false;
    $audioLink = "";
    $videoLink = "";
    $b_seq =  "";

    foreach($bitstream_array as $bitstream) {

        $mp4ok = false;
        $b_segments = explode("##", $bitstream);
        $b_filename = $b_segments[1];
        $b_handle = $b_segments[3];
        $b_seq = $b_segments[4];
        $b_handle_id = preg_replace('/^.*\//', '',$b_handle);

        if ((strpos($b_filename, ".mp3") > 0) or (strpos($b_filename, ".MP3") > 0)) {
            echo '<div itemprop="audio" itemscope itemtype="http://schema.org/AudioObject"></div>';
            $b_uri = './record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
            $audioLink .= '<audio controls>';
            $audioLink .= '<source src="' . $b_uri . '" type="audio/mpeg" />Audio loading...';
            $audioLink .= '</audio>';
            $audioFile = true;

        }

        else if ((strpos($b_filename, ".mp4") > 0) or (strpos($b_filename, ".MP4") > 0))
        {
            $b_uri = $media_uri.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
            // Use MP4 for all browsers other than Chrome
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == false)
            {
                $mp4ok = true;
            }
            //Microsoft Edge is calling itself Chrome, Mozilla and Safari, as well as Edge, so we need to deal with that.
            else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == true)
            {
                $mp4ok = true;
            }

            if ($mp4ok == true)
            { 
                echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                $videoLink .= '<source src="' . $b_uri . '" type="video/mp4" />Video loading...';
                $videoLink .= '</video>';
                $videoLink .= '</div>';
                $videoFile = true;
            }
        }

        else if ((strpos($b_filename, ".webm") > 0) or (strpos($b_filename, ".WEBM") > 0))
	{
            //Microsoft Edge needs to be dealt with. Chrome calls itself Safari too, but that doesn't matter.
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') == false)
            {
                if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true)
                {
                    echo '<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject"></div>';
                    $b_uri = $media_uri . $b_handle_id . '/' . $b_seq . '/' . $b_filename;
                    // if it's chrome, use webm if it exists
                    $videoLink .= '<div class="flowplayer" data-analytics="' . $ga_code . '" title="' . $record_title . ": " . $b_filename . '">';
                    $videoLink .= '<video preload=auto loop width="100%" height="auto" controls preload="true" width="660">';
                    $videoLink .= '<source src="' . $b_uri . '" type="video/webm" />Video loading...';
                    $videoLink .= '</video>';
                    $videoLink .= '</div>';
                    $videoFile = true;
                }
            }
        }
        else if ((strpos($b_filename, ".json") > 0) or (strpos($b_filename, ".JSON") > 0))
        {
            if(isset($solr[$acc_no_field])) {
                $accno =  $solr[$acc_no_field][0];
            }
            $bitstreamLink = $this->skylight_utilities->getBitstreamLink($bitstream);
            $bitstreamUri = $this->skylight_utilities->getBitstreamUri($bitstream);
            $manifest  = base_url().'mimed/record/'.$b_handle_id.'/'.$b_seq.'/'.$b_filename;
            $jsonLink  = '<span class ="json-link-item"><a href="https://librarylabs.ed.ac.uk/iiif/uv/?manifest='.$manifest.'" target="_blank" class="uvlogo" title="View in UV"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a target="_blank" href="https://librarylabs.ed.ac.uk/iiif/mirador/?manifest='.$manifest.'" class="miradorlogo" title="View in Mirador"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="https://images.is.ed.ac.uk/luna/servlet/view/search?search=SUBMIT&q='.$accno.'" class="lunalogo" title="View in LUNA" target="_blank"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href="'.$manifest.'" target="_blank"  class="iiiflogo" title="IIIF manifest"><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
            $jsonLink .= '<span class ="json-link-item"><a href = "https://creativecommons.org/licenses/by/3.0/" class ="ccbylogo" title="All images CC-BY" target="_blank" ><span class="visually-hidden"> (opens in a new tab)</span></a></span>';
        }
        ?>
    <?php
    }
}
?>
<div class="content">

    <h1 class="itemtitle"><?php echo $record_title ?></h1>
    <div itemscope itemtype ="http://schema.org/CreativeWork">

    <div class="tags">
    <?php

    if (isset($solr[$author_field])) {
        foreach($solr[$author_field] as $author) {

            $orig_filter = urlencode($author);

            $lower_orig_filter = strtolower($author);
            $lower_orig_filter = urlencode($lower_orig_filter);

            echo '<a class="maker" href="./search/*:*/Maker:%22'.$lower_orig_filter.'+%7C%7C%7C+'.$orig_filter.'%22" title="'. $author . '">'.$author.'</a>';
        }
    }

    ?>
    </div>


    <?php
    $numThumbnails = 0;
    $imageCounter = 0;
    if (isset($solr[$image_uri_field])) {
        foreach($solr[$image_uri_field] as $linkURI)
        {
            if (strpos($linkURI, 'luna') > 0) {
                $tileSource[$imageCounter] = str_replace('full/full/0/default.jpg', 'info.json', $linkURI);
                $tileSource[$imageCounter] = str_replace('http', 'https', $tileSource[$imageCounter]);

                list($width, $height) = getimagesize($linkURI);
                $portrait = true;
                if ($width > $height) {
                    $portrait = false;
                }

                $imageCounter++;
            }
        }
        echo "<div id='imageCounter' style='display:none;'>$imageCounter</div>";
        echo "<div class ='imageContainer'>";
        $divCounter = 0;
        $freshIn = true;
        while ($divCounter < $imageCounter) {
            if (!$mainImage) {
                $mainImageTest = true;
                ?>
                <div class="full-image">
                    <div id="openseadragon<?php echo $divCounter; ?>" class="image-toggle"<?php if (!$freshIn) {
                        echo ' style="display:none;"';
                    } else {
                        echo ' style="display:block; "';
                    } ?>>
                        <script type="text/javascript">
                            OpenSeadragon({
                                id: "openseadragon<?php echo $divCounter; ?>",
                                prefixUrl: "<?php echo base_url();?>theme/mimed/images/buttons/",

                                visibilityRatio: 1,
                                minZoomLevel: 0,
                                defaultZoomLevel: 0,
                                panHorizontal: true,
                                sequenceMode: true,
                                preserveViewport: false,
                                tileSources: ["<?php echo $tileSource[$divCounter]; ?>"]
                            });
                        </script>
                    </div>
                </div>

                <?php
            }
            $divCounter++;
            $freshIn = false;
        }
        echo "</div>";
        if(isset($solr[$acc_no_field])) {
            $accno =  $solr[$acc_no_field][0];
        }

        $numThumbnails = 0;
        $imageset = false;
        $thumbnailLink = array();
        $countThumbnails = count($solr[$image_uri_field]);
        echo "<!--<br>-->";

        $widthtotal = 0;
        $i = 0;
        foreach ($solr[$image_uri_field] as $imageURI)
        {
            $imageURI = str_replace('http://', 'https://', $imageURI);
            $imagefull[$i] = $imageURI;
            list($fullwidth, $fullheight) = getimagesize($imagefull[$i]);
            //echo 'WIDTH'.$width.'HEIGHT'.$height
            if ($fullwidth > $fullheight) {
                $parms = '/150,/0/';
            } else {
                $parms = '/,150/0/';
            }

            $imagesmall[$i] = str_replace('/full/0/', $parms, $imagefull[$i]);
            echo '<span itemprop="thumbnailUrl" style="display:none;">'. $imagesmall[$i]. '</span>';
            list($width, $height) = getimagesize($imagesmall[$i]);
            $widthtotal = $widthtotal + $width;

            $i++;
        }
        if ($countThumbnails > 1)
        {
            if ($widthtotal > 660)
            {
               echo '<div class="jcarousel-wrapper">
               <div class="jcarousel" data-jcarousel="true">
               <ul  <!--id = "jcar-record"-->>';
            }
            else
            {
                echo ' <div class="thumb-strip">';
            }

            for ($numThumbnails = 0; $numThumbnails<$countThumbnails; $numThumbnails++)
            {
                if ($widthtotal > 660)
                {
                    $thumbnailLink[$numThumbnails] = '<li>';
                }
                else
                {
                    $thumbnailLink[$numThumbnails] = '';
                }
                $thumbnailLink[$numThumbnails] .= '<label class="image-toggler" data-image-id="#openseadragon' . $numThumbnails . '">';
                $thumbnailLink[$numThumbnails] .= '<input type="radio" name="options" id="option' . $numThumbnails . '">';

                $thumbnailLink[$numThumbnails] .= '<img src = "' . $imagesmall[$numThumbnails] . '" class="record-thumb-strip" alt="' . $solr[$title_field][0];



                $manifest = str_replace("iiif/", "iiif/m/", $imagefull[$numThumbnails]);
                $manifest = str_replace("full/full/0/default.jpg", "manifest", $manifest);

                $json = file_get_contents($manifest);

                $jobj = json_decode($json, true);
                //print_r ($jobj);
                $error = json_last_error();
                $jsonMD = $jobj['sequences'][0]['canvases'][0]['metadata'];
                $rights = '';
                $photographer = '';
                $photoline = '';
                foreach ($jsonMD as $jsonMDPair)
                {

                    if ($jsonMDPair['label'] == 'Repro Creator Name')
                    {
                        $photographer = str_replace("<span>", "", $jsonMDPair['value']);
                        $photographer = str_replace("</span>", "", $photographer);
                    }
                    if ($jsonMDPair['label'] == 'Repro Rights Statement')
                    {
                        $rights = str_replace("<span>", "", $jsonMDPair['value']);
                        $rights = str_replace("</span>", "", $rights);
                    }

                }
                if ($photographer !== '')
                {
                    $photoline = ' Photo by '.$photographer;
                }
                $thumbnailLink[$numThumbnails] .= '. '. $photoline.' '.$rights.'"/></label>';

                if ($widthtotal > 660)
                {
                    $thumbnailLink[$numThumbnails] .= '</li>';
                }
                else
                {
                    $thumbnailLink[$numThumbnails] .= '';
                }
                echo $thumbnailLink[$numThumbnails];

                $imageset = true;

            }

         if ($widthtotal > 660)
         {
             echo '</ul>
                </div>
                <a class="jcarousel-control-prev" href="'.$_SERVER['REQUEST_URI'].'/#" data-jcarouselcontrol="true">‹</a>
                <a class="jcarousel-control-next" href="'.$_SERVER['REQUEST_URI'].'/#" data-jcarouselcontrol="true">›</a>';
            }
            echo '</div>';
        }

        else
        {
         echo '<div class="json-link">';
            $imageUri = $solr[$image_uri_field] ;
            $manifest = str_replace("iiif/", "iiif/m/", $imageURI);
            $manifest = str_replace("full/full/0/default.jpg", "manifest", $manifest);

            $json = file_get_contents($manifest);

            $jobj = json_decode($json, true);
            //print_r ($jobj);
            $error = json_last_error();
            $jsonMD = $jobj['sequences'][0]['canvases'][0]['metadata'];
            $rights = '';
            $photographer = '';
            $photoline = '';
            foreach ($jsonMD as $jsonMDPair)
            {

                if ($jsonMDPair['label'] == 'Repro Creator Name')
                {
                    $photographer = str_replace("<span>", "", $jsonMDPair['value']);
                    $photographer = str_replace("</span>", "", $photographer);
                }
                if ($jsonMDPair['label'] == 'Repro Rights Statement')
                {
                    $rights = str_replace("<span>", "", $jsonMDPair['value']);
                    $rights = str_replace("</span>", "", $rights);
                }

            }
            if ($photographer !== '')
            {
                $photoline = ' Photo by '.$photographer;
            }
            echo '<p>'.$photoline.' '.$rights.'</p>';
         echo '</div>';
        }
        ?>


    <?php } ?>

    <div class = "json-link">
        <p>
            <?php if (isset($jsonLink)){echo $jsonLink;} ?>
        </p>
        <p>(Note: Each icon above opens in a new tab.)</p>
    </div>
    <div class="record-content">
    <?php
    if($numBitstreams > 0) { ?>

        <div id="left-metadata">

    <?php } else { ?>

        <div id="full-metadata">

    <?php } ?>

<!--Insert Schema.org-->
    <div class="full-metadata">

        <table>
            <tbody>
            <?php foreach($recorddisplay as $key) {

                $element = $this->skylight_utilities->getField($key);
                if(isset($solr[$element])) {
                   echo $key == "Maker" ? '<tr><td class="first">' : '<tr><td>';

                    echo '<h4>' . $key . '</h4>';
                    foreach($solr[$element] as $index => $metadatavalue) {
                        // if it's a facet search
                        // make it a clickable search link

                        // SR - for Arnold 2020/12/04
                        // replace | with nbsp;

                        $metadatavalue = str_replace('|', '&nbsp;', $metadatavalue);
                        if(in_array($key, $filters)) {

                            $orig_filter = urlencode($metadatavalue);
                            $lower_orig_filter = strtolower($metadatavalue);
                            $lower_orig_filter = urlencode($lower_orig_filter);

                            //Insert Schema
                            if (isset ($schema[$key]))
                            {
                                echo '<span itemprop="'.$schema[$key].'"><a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22" title="'. $metadatavalue . '">' . $metadatavalue . '</a></span>';
                            }
                            else
                            {
                                echo '<a href="./search/*:*/' . $key . ':%22' . $lower_orig_filter . '+%7C%7C%7C+' . $orig_filter . '%22" title="'. $metadatavalue . '">' . $metadatavalue . '</a>';
                            }
                        }
                        else {
                          if (isset ($schema[$key]))
                          {
                              echo '<span itemprop="'.$schema[$key].'">'. $metadatavalue. "</span>";
                          }
                          else
                          {
                              echo $metadatavalue;
                          }

                        }



                        if($index < sizeof($solr[$element]) - 1) {
                            echo '; ';
                        }
                    }
                    echo '</td></tr>';
                }

            } ?>


            </tbody>
        </table>
    </div>

    <?php

        foreach($bitstreamLinks as $bitstreamLink) {

            echo $bitstreamLink;
        }

    ?>

    <div class="clearfix"></div></div>

    <?php

    if(isset($solr[$bitstream_field]) && $link_bitstream) {

        echo '<div class="record_bitstreams">';

        if($audioFile) {
            echo '<h2>Audio</h2>';
            echo $audioLink;
        }

        if($videoFile) {
            echo '<h2>Video</h2>';
            echo $videoLink;
        }

        echo '</div><div class="clearfix"></div>';

    }

    echo '</div>';
echo'</div></div>';
?>

<input type="button" value="Back to Search Results" class="backbtn" onClick="history.go(-1);">
