<?php
use_helper('Viewer', 'Button', 'Javascript', 'Home');

$culture = $sf_user->getCulture();
$connected = $sf_user->isConnected();
$mobile_version = c2cTools::mobileVersion();

echo init_js_var(true, 'home_nav', $connected);

if (!$mobile_version)
{

    include_partial('documents/welcome', array('sf_cache_key' => 'home_' . $culture,
                                               'default_open' => true));

    if ($connected)
    {
        include_partial('documents/wizard_button', array('sf_cache_key' => $culture));
    }
    include_partial('documents/news', array('items' => $latest_c2c_news, 'culture' => $culture, 'default_open' => true));
    include_partial('documents/prepare', array('sf_cache_key' => $culture, 'default_open' => false));
    include_partial('documents/toolbox', array('sf_cache_key' => $culture, 'default_open' => true));
    include_partial('documents/figures', array('sf_cache_key' => $culture, 'figures' => $figures, 'default_open' => true));
    include_partial('documents/buttons', array('sf_cache_key' => $culture));
}

echo display_content_top('home');
echo start_content_tag('home_article', true);
?>
        <div id="last_images">
            <?php
            include_partial('images/latest', array('items' => $latest_images, 'culture' => $culture, 'default_open' => true));
            ?>
        </div>
        <div id="home_background_content">
            <div id="home_left_content">
                <?php
                if (!$mobile_version)
                {
                    include_partial('common/edit_in_place', array('message' => $sf_data->getRaw('message')));
                }
                include_partial('outings/latest', array('items' => $latest_outings, 'culture' => $culture, 'default_open' => true));
                if (!$mobile_version)
                {
                    include_partial('documents/latest_meta', array('items' => $meta_items, 'culture' => $culture, 'default_open' => false));
                    include_partial('articles/latest', array('items' => $latest_articles, 'culture' => $culture, 'default_open' => true));
                }
                ?>
            </div>
            <div id="home_right_content">
                <?php
                include_partial('documents/latest_mountain_news', array('items' => $latest_mountain_news, 'culture' => $culture, 'default_open' => true));
                include_partial('documents/latest_threads', array('items' => $latest_threads, 'culture' => $culture, 'default_open' => true));
                if ($mobile_version)
                {
                    include_partial('articles/latest', array('items' => $latest_articles, 'culture' => $culture, 'default_open' => true));
                }
                include_partial('documents/latest_docs', array('culture' => $culture, 'default_open' => true));
                ?>
            </div>
        </div>
        <div id="fake_clear"> &nbsp;</div>

<?php
echo end_content_tag();

include_partial('common/content_bottom') ?>
