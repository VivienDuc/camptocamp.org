<?php
use_helper('Home', 'Language', 'Sections', 'Viewer', 'General', 'Field', 'AutoComplete'); 

$culture = $sf_user->getCulture();
$is_connected = $sf_user->isConnected();
$is_moderator = $sf_user->hasCredential(sfConfig::get('app_credentials_moderator'));
$id = $sf_params->get('id');
$is_not_archive = !$document->isArchive();
$is_not_merged = !$document->get('redirects_to');
$show_link_to_delete = ($is_not_archive && $is_not_merged && $is_moderator);
$show_link_tool = ($is_not_archive && $is_not_merged && $is_moderator);
$has_map = $document->getRaw('has_map');
$has_map = !empty($has_map);

$design_files = $document->get('design_file');
$design_files = explode(',', $design_files);
if (count($design_files))
{
    $app_static_url = sfConfig::get('app_static_url');
    foreach ($design_files as $file)
    {
        $file = trim($file);
        if (!empty($file))
        {
            use_stylesheet($app_static_url . '/static/css/' . $file . '.css', 'custom');
        }
    }
}

display_page_header('portals', $document, $id, $metadata, $current_version);

// lang-independent content starts here

echo start_section_tag('portal', 'intro');
echo field_text_data_if_set($document, 'abstract', null, array('needs_translation' => $needs_translation, 'show_images' => false));

if ($is_not_archive)
{
    include_partial('portals/inside_search_form', array('document' => $document));
}
echo end_section_tag();

if ($has_map)
{
    include_partial('documents/map_section', array('document' => $document,
                                                   'layers_list' => $map_filter['objects'],
                                                   'center' => $map_filter['center'],
                                                   'height' => $map_filter['height'],
                                                   'show_map' => true,
                                                   'has_geom' => $has_geom));
}

// lang-dependent content
echo start_section_tag('Description', 'description');
include_partial('documents/i18n_section', array('document' => $document, 'languages' => $sf_data->getRaw('languages'),
                                                'needs_translation' => $needs_translation, 'images' => $associated_images));
echo end_section_tag();



if ($has_images):
?>
        <div id="last_images">
            <?php
    $image_url_params = $sf_data->getRaw('image_url_params');
    $image_url_params = implode('&', $image_url_params);
    $custom_title_link = 'images/list';
    $custom_rss_link = 'images/rss';
    if (!empty($image_url_params))
    {
        $custom_title_link .= '?' . $image_url_params;
        $custom_rss_link .= '?' . $image_url_params;
    }
    include_partial('images/latest',
                    array('items' => $latest_images,
                          'culture' => $culture,
                          'default_open' => true,
                          'custom_title_link' => $custom_title_link,
                          'custom_rss_link' => $custom_rss_link));
            ?>
        </div>
<?php
endif;

?>
        <div id="home_background_content">
            <div id="home_left_content">
                <?php
if ($has_outings)
{
    $outing_url_params = $sf_data->getRaw('outing_url_params');
    $outing_url_params = implode('&', $outing_url_params) . '&orderby=date&order=desc';
    $custom_title_link = 'outings/list?' . $outing_url_params;
    $custom_rss_link = 'outings/rss?' . $outing_url_params;
    include_partial('outings/latest',
                    array('items' => $latest_outings,
                          'culture' => $culture,
                          'default_open' => true,
                          'custom_title_link' => $custom_title_link,
                          'custom_rss_link' => $custom_rss_link));
}
if ($has_articles)
{
    $article_url_params = $sf_data->getRaw('article_url_params');
    $article_url_params = implode('&', $article_url_params);
    $custom_title_link = 'articles/list';
    $custom_rss_link = 'articles/rss';
    if (!empty($article_url_params))
    {
        $custom_title_link .= '?' . $article_url_params;
        $custom_rss_link .= '?' . $article_url_params;
    }
    include_partial('articles/latest',
                    array('items' => $latest_articles,
                          'culture' => $culture,
                          'default_open' => true,
                          'custom_title_link' => $custom_title_link,
                          'custom_rss_link' => $custom_rss_link));
}
                ?>
            </div>
            <div id="home_right_content">
                <?php
if ($has_videos)
{
    include_partial('portals/latest_videos', array('items' => $latest_videos, 'culture' => $culture, 'default_open' => true));
}
if ($has_news)
{
    include_partial('documents/latest_mountain_news', array('items' => $latest_mountain_news, 'culture' => $culture, 'default_open' => true));
}
if ($has_topics)
{
    include_partial('documents/latest_threads', array('items' => $latest_threads, 'culture' => $culture, 'default_open' => true));
}
                ?>
            </div>
        </div>

<?php




echo start_section_tag('Information', 'data');
if ($is_not_archive && $is_not_merged)
{
    $document->associated_areas = $associated_areas;
}
include_partial('data', array('document' => $document));

if ($is_not_archive)
{
    echo '<div class="all_associations">';
    
    include_partial('areas/association',
                    array('associated_docs' => $associated_areas,
                          'module' => 'areas',
                          'weather' => true,
                          'avalanche_bulletin' => true));
    
    if ($is_not_merged)
    {
        if ($show_link_tool)
        {
            $modules_list = array('areas');
            
            echo c2c_form_add_multi_module('portals', $id, $modules_list, 4, 'multi_1', true);
        }
    }
    
    echo '</div>';
}
echo end_section_tag();

if ($is_not_archive && $is_not_merged)
{
    include_partial('documents/images', array('images' => $associated_images,
                                              'document_id' => $id,
                                              'dissociation' => 'moderator',
                                              'is_protected' => $document->get('is_protected')));
}

include_partial('documents/license', array('license' => 'by-sa'));

echo end_content_tag();

include_partial('common/content_bottom');
?>