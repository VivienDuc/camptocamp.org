<?php 
use_helper('Pagination', 'MyImage', 'Lightbox', 'Javascript', 'Link', 'Viewer', 'General');

// add lightbox ressources
addLbMinimalRessources();

$id = $sf_params->get('id');
$lang = $sf_params->get('lang');

echo display_title(__('images list'), $sf_params->get('module'), false);

echo '<div id="nav_space">&nbsp;</div>';
include_partial('nav4list');
//include_partial('documents/nav_news');

echo display_content_top('list_content');
echo start_content_tag('images_content');

echo javascript_tag('lightbox_msgs = Array("' . __('View image details') . '","' . __('View original image') . '");');

echo '<p class="list_header">' . __('images presentation');

$items = $pager->getResults('array', ESC_RAW);

if (count($items) == 0):
    echo '<br /><br />' . __('there is no %1% to show', array('%1%' => __('images'))) . '</p>';
else:
    echo '</p>';
    $pager_navigation = pager_navigation($pager);
    echo $pager_navigation;
    echo '<div class="clearer"></div>';
    $items = Language::parseListItems($items, 'Image');
    $static_base_url = sfConfig::get('app_static_url');
?>
<?php foreach ($items as $item): ?>
    <div class="thumb_data">
    <div class="thumb_data_img">
    <?php
    $i18n_item = $item['ImageI18n'][0];
    $title = $i18n_item['name'];
    $filename = $item['filename'];
    $image_type = $item['image_type'];
    $thumb_url = image_url($filename, 'small');
    $image_route = '@document_by_id_lang_slug?module=images&id=' . $item['id'] . '&lang=' . $i18n_item['culture'] . '&slug=' . make_slug($i18n_item['name']);
    echo link_to(image_tag($thumb_url, array('class' => 'img', 'alt' => $title)),
                 absolute_link(image_url($filename, 'big', true), true),
                 array('title' => $title,
                       'rel' => 'lightbox[document_images]',
                       'class' => 'view_big',
                       'id' => 'lightbox_' . $item['id'] . '_' . $image_type));
    ?>
    <div class="image_license <?php echo 'license_'.$image_type ?>" style="display:none;"></div>
    </div>
    <?php
    echo $title . '<br />';
    echo link_to(__('Details'), $image_route);
    if (!empty($item['nb_comments']))
    {
        echo ' - ' .
             picto_tag('action_comment', __('nb_comments'),
                       array('style' => 'margin-bottom:-4px')) .
             ' (' . link_to($item['nb_comments'], '@document_comment?module=images&id=' . $item['id'] . '&lang=' . $i18n_item['culture']) . ')';
    }
    ?>
    </div>
<?php endforeach ?>
<div style="clear:both"><?php echo $pager_navigation; ?></div>
<?php
echo javascript_tag("
Event.observe(window, 'load', function(){
$$('.thumb_data_img').each(function(obj){
obj.observe('mouseover', function(e){obj.down('.image_license').show();});
obj.observe('mouseout', function(e){obj.down('.image_license').hide();});
});});");

endif;

echo end_content_tag();

include_partial('common/content_bottom') ?>
