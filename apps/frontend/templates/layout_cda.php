<?php
$lang_code = __('meta_language');
$module = $sf_context->getModuleName();
$lang = $sf_user->getCulture();
$action = sfContext::getInstance()->getActionName();
$id = $sf_params->get('id');
$mw_contest_id = sfConfig::get('app_mw_contest_id');

use_helper('MyMinify', 'MetaLink', 'Forum', 'Link');

$static_base_url = sfConfig::get('app_static_url');
$response = sfContext::getInstance()->getResponse();
$response->addJavascript('/static/js/fold.js', 'head_last');
?>
<!doctype html>
<html lang="<?php echo $lang_code ?>">
<head>
    <meta charset="utf-8">
    <?php
        $debug = (bool) sfConfig::get('app_minify_debug');
        $combine = !$debug;
        echo include_http_metas();
        echo include_title();
        // we remove title from metas, because we don't want a <meta name=title>
        $response->getParameterHolder()->remove('title', 'helper/asset/auto/meta');
        echo include_metas();
        minify_include_main_stylesheets($combine, $debug);
        minify_include_custom_stylesheets($combine, $debug);
    ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo $static_base_url . '/' . sfTimestamp::getTimestamp('/static/css/cda.css'); ?>/static/css/cda.css" />
    <!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="<?php echo $static_base_url . '/' . sfTimestamp::getTimestamp('/static/css/ie6.css'); ?>/static/css/ie6.css" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" type="text/css" media="all" href="<?php echo $static_base_url. '/' . sfTimestamp::getTimestamp('/static/css/ie7.css'); ?>/static/css/ie7.css" /><![endif]-->
    <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?php
        minify_include_head_javascripts($combine, $debug);
    ?>
    <link rel="shortcut icon" href="<?php
   echo $static_base_url . '/static/images/portals/cda_favicon.ico';
    ?>" />
</head>
<body>
<div id="holder">
  <div id='top'>
    <div id='topright'>
      <?php
      $items = array();
      foreach (Language::getAll() as $language => $value)
      {
          if ($lang == $language)
          {
              $items[] = '<strong>' . $language . '</strong>';
          }
          else
          {
              $items[] = link_to($language, "@" . $action . "?lang=$language",
                                 array('title' => $value));
          }
      }

      echo implode('&nbsp;|&nbsp;', $items);
      ?>
    </div>
  </div>
  <header id="page_header">
    <map name="map">
      <area shape="rect" coords="579,153,746,170" alt="<?php echo __('Moutainwilderness') ?>" href="http://www.mountainwilderness.fr" target="_blank" />
      <area shape="rect" coords="758,144,828,179" alt="<?php echo __('Camp to Camp') ?>" href="http://www.camptocamp.org" target="_blank" />
    </map>
        <a href="/cda/<?php echo $lang;?>"><?php echo image_tag('/static/images/cda/bandeau.jpg',array('alt'=>__('Changer d\'approche'),'usemap'=>"#map")) ?></a>
    
    <?php
    if ($action != "cda"):
    ?>
    <div id="menu">
      <ul>
        <li><?php echo link_to(__('ecomobility'), '@cdasearch?lang=' . $lang); ?>
        <li><?php echo link_to(__('contest'), '@document_by_id_lang?module=articles&id=' . $mw_contest_id . '&lang=' . $lang); ?>
        <li><?php echo link_to(__('picturial'), '@default?module=images&action=list&owtp=yes'); ?>
        <li><?php echo f_link_to(__('questions?'), 'viewtopic.php?id=42'); ?></li>
        <li><?php echo absolute_link_to(__('map (cda)'), '@map?zoom=7&lat=45.5&lon=7&layerNodes=public_transportations&bgLayer=gmap_physical'); ?></li>
      </ul>
    </div>
    <?php endif; ?>
  </header>
  <div id="container">
      <?php echo $sf_data->getRaw('sf_content') ?>
  </div>
  <?php
  if ($action != "cda"):
  ?>
  <div id="page_footer">
    <div class="column span-24">
      <div id="partenairesbas">
        <ul>
          <li><img alt="FEDER Alpes" title="FEDER Alpes" src="/static/images/cda/FEDER-Alpes_70.jpg"></li>
          <li><img alt="EUROPE" title="EUROPE" src="/static/images/cda/EUROPE_70.jpg"></li>
          <li><img alt="Rhônes Alpes" title="Rhônes Alpes" src="/static/images/cda/rhones-alpes_70.jpg"></li>
          <li><img alt="Conseil Général 06" title="Conseil Général 06" src="/static/images/cda/alpemaritime.jpg"></li>
          <li><img alt="Languedoc Rousillon" title="Languedoc Rousillon" src="/static/images/cda/LanguedoRousillon.jpg"></li>
          <li><img alt="Aquitaine" title="Aquitaine" src="/static/images/cda/Aquitaine.jpg"></li>
          <li><img alt="PACA" title="PACA" src="/static/images/cda/paca_70.jpg"></li>
        </ul>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>
    <div id="fields_tooltip" class="ajax_feedback" style="display: none;" onclick="Element.hide(this); return false;"></div>
    <?php
    minify_include_body_javascripts($combine, $debug);
    minify_include_maps_javascripts($combine);
    include_partial('common/tracker', array('addthis' => sfContext::getInstance()->getResponse()->hasParameter('addthis', 'helper/asset/addthis')));
    // Prompt ie6 users to install Chrome Frame - no adm rights required. chromium.org/developers/how-tos/chrome-frame-getting-started ?>
    <!--[if lt IE 7 ]><script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script><script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script><![endif]-->
</body>
</html>