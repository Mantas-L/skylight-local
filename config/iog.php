<?php

$config['skylight_appname'] = 'iog';
$config['skylight_url_prefix'] = 'iog';

// set the base url and ga code
if (strpos($_SERVER['HTTP_HOST'], "localhost") !== false) {
    $config['base_url'] = '';
    $config['skylight_ga_code'] = 'G-8VP4HF0K5M';
    $config['skylight_container_id'] = 'ca96f537-4877-4ddb-8d17-63b65433b9d3';
}
else {
    $config['base_url'] = '';
    $config['skylight_ga_code'] = 'UA-25737241-18';
    $config['skylight_container_id'] = 'ca96f537-4877-4ddb-8d17-63b65433b9d3';
}

$config['skylight_theme'] = 'iog';

$config['skylight_fullname'] = 'Scottish Government Yearbooks';

$config['skylight_adminemail'] = 'lddt@mlist.is.ed.ac.uk';

$config['skylight_oaipmhcollection'] = 'hdl_10683_22746';

$config['skylight_oaipmhallowed'] = true;


//$config['skylight_container_id'] = '16';
$config['skylight_container_field'] = 'location.coll';
$config['skylight_sitemap_type'] = 'external';

$config['skylight_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.contributor.author.en',
    'Subject' => 'dc.subject.en',
    'Type' => 'dc.type.en',
    'Abstract' => 'dc.description.abstract.en',
    'Date' => 'dc.date.issued',
    'Accession Date' => 'dc.date.accessioned_dt',
    'Number of Pages' => 'dc.coverage.spatial',
    'Citation' => 'dc.identifier.citation.en',
    'ISBN' => 'dc.identifier.isbn',
    'Page Numbers' => 'dc.format.extent',
    'Publisher' => 'dc.publisher.en',
    'Series' => 'dc.relation.ispartofseries.en',
);

// HM 14/09/2020
// Date filtering broken in Skylight upgrade so disabling
//$config['skylight_date_filters'] = array('Date' => 'dateIssued.year_sort');
$config['skylight_date_filters'] = array();
$config['skylight_filters'] = array('Author' => 'author_filter', 'Subject' => 'subject_filter');
$config['skylight_filter_delimiter'] = ':';

$config['skylight_meta_fields'] = array('Title' => 'dc.title.en',
    'Author' => 'dc.creator',
    'Abstract' => 'dc.description.abstract',
    'Subject' => 'dc.subject',
    'Date' => 'dc.date.issued',
    'Type' => 'dc.type');

$config['skylight_recorddisplay'] = array('Title','Series','Author','Subject','Citation','Date','Page Numbers','Number of Pages','Publisher','ISBN','Type','Abstract');

$config['skylight_searchresult_display'] = array('Title','Series','Author','Subject','Type','Abstract');

$config['skylight_search_fields'] = array('Keywords' => 'text',
    'Subject' => 'dc.subject',
    'Type' => 'dc.type',
    'Author' => 'dc.creator',
    'Series' => 'dc.relation.ispartofseries'
);

$config['skylight_sort_fields'] = array('Author' => 'dc.contributor.author_sort ',
    'Title' => 'dc.title_sort',
    'Date' => 'dc.date.issued_dt'
);

$config['skylight_related_fields'] = array('Title' => 'dc.title.en', 'Subject' => 'dc.subject.en', 'Author' => 'dc.contributor.author.en');

$config['skylight_feed_fields'] = array('Title' => 'Title',
    'Author' => 'Author',
    'Subject' => 'Subject',
    'Description' => 'Abstract',
    'Date' => 'Date');

$config['skylight_results_per_page'] = 10;
$config['skylight_share_buttons'] = false;

$config['skylight_homepage_recentitems'] = false;

// Set to the number of minutes to cache pages for. Set to false for no caching.
// This overrides the setting in skylight.php so is commented by Demo
$config['skylight_cache'] = false;

// Digital object management
$config['skylight_bitstream_field'] = 'dc.format.original.en';
$config['skylight_thumbnail_field'] = 'dc.format.thumbnail';
$config['skylight_display_thumbnail'] = false;
$config['skylight_link_bitstream'] = true;


// Display common image formats in "light box" gallery?
$config['skylight_lightbox'] = true;
$config['skylight_lightbox_mimes'] = array('image/jpeg', 'image/gif', 'image/png');

// Language and locale settings
$config['skylight_language_default'] = 'en';
$config['skylight_language_options'] = array('en', 'ko', 'jp');


?>