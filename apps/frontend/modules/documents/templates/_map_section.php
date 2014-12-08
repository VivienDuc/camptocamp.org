<?php

use_helper('JavascriptQueue');

if (!isset($has_geom))
{
    $has_geom = (boolean)($document->get('geom_wkt'));
}

// we display map if route has no gpx track, but geolocalized linked docs (summit, parking, hut)
if (!$has_geom && $document->module == 'routes')
{
    foreach (array('summits', 'parkings', 'huts') as $type)
    {
        if (!isset($document->$type)) continue;
        foreach ($document->$type as $associated_doc)
        {
            if (!empty($associated_doc['pointwkt']))
            {
                $has_geom = true;
                break 2;
            }
        }
    }
}

if (!isset($show_map))
{
    $show_map = false;
}
if ($has_geom || $show_map)
{
    if (!isset($home_section))
    {
        $home_section = false;
    }
    if (!isset($section_title))
    {
        $section_title = 'Interactive map';
    }
    if (!isset($show_tip))
    {
        $show_tip = true;
    }
    
    if ($home_section)
    {
        include_partial('documents/home_section_title',
                        array('module'            => 'maps',
                              'home_section'      => false,
                              'custom_title_text' => __($section_title),
                              'has_title_link'    => false,
                              'custom_section_id' => 'map_container'));
    }
    else
    {
        echo start_section_tag($section_title, 'map_container', 'opened', true, false, false, $show_tip);
    }
    
    if (!empty($help_text))
    {
        echo __($help_text);
    }
    
    use_helper('Map');
    if (!isset($layers_list))
    {
        $layers_list = null;
    }
    if (!isset($height))
    {
        $height = null;
    }
    if (isset($center))
    {
        $center = $sf_data->getRaw('center');
    }
    else
    {
        $center = null;
    }
    echo show_map('map_container', $document, $sf_user->getCulture(), $layers_list, $height, $center, $has_geom, $sf_user->isConnected());
    echo end_section_tag(true);
// fold_init_map.js ~ 390b ?>
<script>
!function(e,t){var n=e.setSectionStatus
e.setSectionStatus=function(i,o,c){if(n(i,o,c)){var a=e.section_open,l=t.getElementById(i+"_section_container")
l.style.display="none",l.title=a
var s=t.getElementById(i+"_toggle")
s.className=s.className.replace("picto_close","picto_open"),s.alt="+",s.title=a,t.getElementById("tip_"+i).innerHTML="["+a+"]"}}}(window.C2C=window.C2C||{},document)
</script>
    <?php
        $cookie_position = array_search('map_container', sfConfig::get('app_personalization_cookie_fold_positions'));
    ?>
    <script>
    C2C.setSectionStatus('map_container', <?php echo $cookie_position ?>, true);
    </script>
    <?php
    $async_map = sfConfig::get('app_async_map', false) && !sfContext::getInstance()->getRequest()->getParameter('debug', false);

    $init = $async_map ? 'C2C.async_map_init();' : '$(window).load(C2C.map_init);';
    $delayed_init = $async_map ? 'C2C.async_map_init' : 'C2C.map_init';

    echo javascript_queue("
      var id = 'map_container';
      if (!C2C.shouldHide($cookie_position, true)) {".
        $init
    ."} else {
        $('#'+id).one('click', " . $delayed_init . ");
      }
      $('#'+id).click(function() {
        C2C.registerFoldStatus(id, $cookie_position, !$('#'+id+'_section_container').is(':visible'));
        $('.x-window.x-resizable-pinned').toggle();
      }); ");

}
