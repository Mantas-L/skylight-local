<div class="container-fluid">
    <div id="sch_banner">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a href="https://www.stcecilias.ed.ac.uk/about/" title="About St Cecilia's Hall"><img class="img-responsive sch-logo" alt="St_Cecilias_Hall_logo" src="<?php echo base_url(); ?>theme/stcecilia/images/Instrument-Collection-logo.gif"></a>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="galleries" class="grid"<?php /* Prevent script from loading on homepage */ if($this->config->item('skylight_appname') != str_replace('/', '', $_SERVER['REQUEST_URI'])) { ?> data-masonry='{ "itemSelector": ".grid-item index-grid", "percentPosition": true, "columnWidth": .grid-sizer}'<?php } ?>>
            <div class="grid-sizer"></div>
            <a href="./search/%22Keyboard+grouping%22" title="Click to view all Keyboard instruments" alt="Click to view all Keyboard instruments"><div id="gallerykb" class="grid-item index-grid" ><div class="gallery-title"><h4>Keyboards</h4></div>
            <div class="mob-title"><h4>Keyboards</h4></div></div></a>
            <a href="./search/%22Western+percussion+grouping%22" title="Click to view all Western Percussion instruments" alt="Click to view all Western Percussion instruments"><div id="gallerywespe" class="grid-item index-grid"><div class="gallery-title"><h4>Western Percussion</h4></div>
            <div class="mob-title"><h4>Western Percussion</h4></div></div></a>
            <a href="./search/%22Ethnographic+percussion+grouping%22" title="Click to view all Non-western Percussion instruments" alt="Click to view all Non-western Percussion instruments"><div id="galleryethpe" class="grid-item index-grid"><div class="gallery-title"><h4>Non-western Percussion</h4></div>
            <div class="mob-title"><h4>Non-western Percussion</h4></div></div></a>
            <a href="./search/%22Ethnographic+brasswind+grouping%22" title="Click to view all Non-western Brasswind instruments" alt="Click to view all Non-western Brasswind instruments"><div id="galleryethbw" class="grid-item index-grid"><div class="gallery-title"><h4>Non-western Brasswind</h4></div>
            <div class="mob-title"><h4>Non-western Brasswind</h4></div></div></a>
            <a href="./search/%22Western+string+grouping%22" title="Click to view all Western Strings instruments" alt="Click to view all Western Strings instruments"><div id="gallerywesst" class="grid-item index-grid"><div class="gallery-title"><h4>Western Strings</h4></div>
            <div class="mob-title"><h4>Western Strings</h4></div></div></a>
            <a href="./search/%22Ethnographic+string+grouping%22" title="Click to view all Non-western Strings instruments" alt="Click to view all Non-western Strings instruments"><div id="galleryethst" class="grid-item index-grid"><div class="gallery-title" ><h4>Non-western Strings</h4></div>
            <div class="mob-title" ><h4>Non-western Strings</h4></div></div></a>
            <a href="./search/%22Western+woodwind+grouping%22" title="Click to view all Western Woodwind instruments" alt="Click to view all Western Woodwind instruments"><div id="gallerywesww" class="grid-item index-grid"><div class="gallery-title"><h4>Western Woodwind</h4></div>
            <div class="mob-title"><h4>Western Woodwind</h4></div></div></a>
            <a href="./search/%22Western+brasswind+grouping%22" title="Click to view all Western Brasswind instruments" alt="Click to view all Western Brasswind instruments"><div id="gallerywesbw" class="grid-item index-grid"><div class="gallery-title"><h4>Western Brasswind</h4></div>
            <div class="mob-title"><h4>Western Brasswind</h4></div></div></a>
            <a href="./search/%22Ethnographic+woodwind+grouping%22" title="Click to view all Non-western Woodwind instruments" alt="Click to view all Non-western Woodwind instruments"><div id="galleryethww" class="grid-item index-grid"><div class="gallery-title"><h4>Non-western Woodwind</h4></div>
            <div class="mob-title"><h4>Non-western Woodwind</h4></div></div></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="spacer"></div>
    <div class="clearfix"></div>
</div>
