<?php
use_helper('Forum','Button', 'ModalBox', 'General');

$c2c_news_forum = PunbbTopics::getC2cNewsForumId($lang);
$sublevel_ie7 = '<!--[if gte IE 7]><!-->';
$sublevel_start = '<!--<![endif]--> <!--[if lte IE 6]><table><tr><td><![endif]-->';
$sublevel_end = '<!--[if lte IE 6]></td></tr></table></a><![endif]-->';
?>

<script type="text/javascript"><!--
    hide_select = function() {}
    show_select = function() {}
//--></script>
<!--[if lt IE 7]>
<script type="text/javascript" src="/static/js/menus.js?<?php echo sfSVN::getHeadRevision('menus.js') ?>"></script>
<script>
Event.observe(window,'load',startList);var selectList=document.getElementsByTagName('select');hide_select=function()
{if(selectList)
{var len=selectList.length;if(len>0)
{for(i=0;i<len;i++)
{selectList[i].style.display='none';}}}}
show_select=function()
{if(selectList)
{var len=selectList.length;if(len>0)
{for(i=0;i<len;i++)
{selectList[i].style.display='';}}}}
</script>
<![endif]-->

    <div id="menu_content">
        <ul onmouseover="hide_select();" onmouseout="show_select();">
            <li>
                <?php echo link_to(__('Home') . $sublevel_ie7, '@homepage') ?><?php echo $sublevel_start ?>
                <ul>
                    <li><?php echo link_to(__('Kesako?'), getMetaArticleRoute('know_more', false), array('class' => 'img_action_informations')) ?></li>
                    <li><?php echo picto_tag('action_help')
                                 . link_to(__('Customize'), getMetaArticleRoute('customize', false), array('class' => 'ie7m')) ?></li>
                    <li><?php echo link_to(__('FAQ short'), getMetaArticleRoute('faq', false), array('class' => 'img_action_help')) ?></li>
                    <li class="lilast"><?php
                        echo picto_tag('action_help')
                           . link_to(__('Global help'), getMetaArticleRoute('help', false), array('class'=>'ie7m')) ?></li>
                </ul><?php echo $sublevel_end ?>
            </li>
            <li>
                <?php echo link_to(__('Guidebook') . $sublevel_ie7, getMetaArticleRoute('home_guide')); ?><?php echo $sublevel_start ?>
                <ul>
	                <li>
                        <?php echo picto_tag('picto_maps')
                                 . link_to(__('Map tool'), '@map') ?>
                    </li>
                    <li>
                        <?php echo link_to(__('outings') . $sublevel_ie7, '@default_index?module=outings', array('class' => 'img_module_outings')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li><?php echo link_to(__('cond short'), 'outings/conditions', array('class' => 'img_action_list')) ?></li>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=outings', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo m_link_to(__('Add'), 'outings/wizard',
                                                                    array('class' => 'img_action_create',
                                                                          'title'=> __('Create new outing with some help')),
                                                                    array('width' => 600)) ?></li>
                            <?php endif ?>
                        </ul> <?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo link_to(__('routes') . $sublevel_ie7, '@default_index?module=routes',  array('class' => 'img_module_routes')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li class="lilast"><?php echo link_to(__('Search'), '@filter?module=routes', array('class' => 'img_action_search')) ?></li>
                            <li><?php echo m_link_to(__('cotometre'), '@tool?action=cotometre',
                                                     array('class' => 'img_action_tools',
                                                           'title'=> __('cotometre long')),
                                                     array('width' => 600)) ?></li>
                        </ul><?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo picto_tag('picto_summits')
                                 . link_to(__('summits') . $sublevel_ie7, '@default_index?module=summits', array('class'=>'ie7m')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=summits', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=summits&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul><?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo picto_tag('picto_sites')
                                 . link_to(__('sites') . $sublevel_ie7, '@default_index?module=sites', array('class'=>'ie7m')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=sites', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=sites&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul><?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo link_to(__('parkings') . $sublevel_ie7, '@default_index?module=parkings', array('class' => 'img_module_parkings')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li><?php echo link_to(__('Search'), '@filter?module=parkings', array('class' => 'img_action_search')) ?></li>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php
                                echo picto_tag('picto_portals')
                                ?><a href="http://<?php echo sfConfig::get('app_changerdapproche_host') ?>/" class="ie7m"><?php echo __('changerdapproche') ?></a></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=parkings&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul> <?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo picto_tag('picto_huts')
                                 . link_to(__('huts') . $sublevel_ie7, '@default_index?module=huts', array('class'=>'ie7m')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=huts', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=huts&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul> <?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo picto_tag('picto_products')
                                 . link_to(__('products') . $sublevel_ie7, '@default_index?module=products', array('class'=>'ie7m')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=products', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=products&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul><?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo link_to(__('areas') . $sublevel_ie7, '@default_index?module=areas', array('class' => 'img_module_areas')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li class="lilast"><?php echo link_to(__('Search'), '@filter?module=areas', array('class' => 'img_action_search')) ?></li>
                        </ul><?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo link_to(__('maps') . $sublevel_ie7, '@default_index?module=maps', array('class' => 'img_module_maps')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li class="lilast"><?php echo link_to(__('Search'), '@filter?module=maps', array('class' => 'img_action_search')) ?></li>
                        </ul> <?php echo $sublevel_end ?>
                    </li>
                    <li>
                        <?php echo link_to(__('books') . $sublevel_ie7, '@default_index?module=books', array('class' => 'img_module_books')) ?>
                        <?php echo $sublevel_start ?>
                        <ul>
                            <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=books', array('class' => 'img_action_search')) ?></li>
                            <?php if ($is_connected): ?>
                            <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=books&id=&lang=', array('class' => 'img_action_create')) ?></li>
                            <?php endif ?>
                        </ul> <?php echo $sublevel_end ?>
                    </li>
                    <li class="lilast"><?php echo link_to(__('Help'), getMetaArticleRoute('help_guide', false), array('class' => 'img_action_help')) ?></li>
                </ul><?php echo $sublevel_end ?>
            </li>
            <li>
                <?php echo f_link_to(__('Forum') . $sublevel_ie7, '?lang='. $lang); ?><?php echo $sublevel_start ?>
                <ul>
                    <?php foreach (Language::getAll() as $key => $value): ?>
                    <li><?php echo f_link_to(__($value), '?lang=' . $key,  array('class' => 'img_action_comment')) ?></li>
                    <?php endforeach ?>
                    <li><?php echo f_link_to(__('Search'), 'search.php',  array('class' => 'img_action_search')) ?></li>
                    <?php if ($is_connected): ?>
                        <li><?php echo f_link_to(__('User profile'), 'profile.php?section=personality',  array('class' => 'img_action_edit')) ?></li>
                    <?php endif ?>
                    <li><?php echo link_to(__('Help'), getMetaArticleRoute('help_forum', false), array('class' => 'img_action_help')) ?></li>
                    <li class="lilast"><?php echo link_to(__('Charte'), getMetaArticleRoute('charte_forum', false), array('class' => 'img_action_help')) ?></li>
                </ul><?php echo $sublevel_end ?>
            </li>
            <li>
                <?php echo link_to(__('Articles') . $sublevel_ie7, '@default_index?module=articles'); ?><?php echo $sublevel_start ?>
                <ul>
                    <li><?php echo link_to(__('Summary'), getMetaArticleRoute('home_articles', false), array('class' => 'img_action_list')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('mountain environment'), 'articles/list?ccat=1', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('gear and technique'), 'articles/list?ccat=2', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('topoguide supplements'), 'articles/list?ccat=4', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('soft mobility'), 'articles/list?ccat=7', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('expeditions'), 'articles/list?ccat=8', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('stories'), 'articles/list?ccat=3', array('class'=>'ie7m')) ?></li>
                    <li><?php echo picto_tag('picto_articles')
                                 . link_to(__('site info'), 'articles/list?ccat=5', array('class'=>'ie7m')) ?></li>
                    <li<?php if (!$is_connected): ?> class="lilast"<?php endif ?>><?php echo link_to(__('Search'), '@filter?module=articles', array('class' => 'img_action_search')) ?></li>
                    <?php if ($is_connected): ?>
                    <li class="lilast"><?php echo link_to(__('Add'), '@document_edit?module=articles&id=&lang=', array('class' => 'img_action_create')) ?></li>
                    <?php endif ?>
                </ul><?php echo $sublevel_end ?>
            </li>
            <li>
                <?php echo link_to(__('Gallery') . $sublevel_ie7, '@default_index?module=images'); ?><?php echo $sublevel_start ?>
                <ul>
                    <li class="lilast"><?php echo link_to(__('Search'), '@filter?module=images', array('class' => 'img_action_search')) ?></li>
                </ul><?php echo $sublevel_end ?>
            </li>
            <li>
                <?php echo link_to(__('Association'), getMetaArticleRoute('association')); ?>
                <ul>
                    <li><?php echo link_to(__('Summary'), 'articles/list?ccat=6', array('class' => 'img_action_list')) ?></li>
                    <?php if ($c2c_news_forum): ?>
                    <li><?php echo picto_tag('action_comment')
                                 . f_link_to(__('c2corg news'), 'viewforum.php?id=' . $c2c_news_forum, array('class'=>'ie7m')) ?></li>
                    <?php endif ?>
                    <li class="lilast"><?php echo link_to(__('Shop'), getMetaArticleRoute('shop'), array('class' => 'img_action_list')) ?></li>
                </ul>
            </li>
            <li id="menulast">
                <?php echo link_to(ucfirst(__('users')) . $sublevel_ie7, '@default_index?module=users') ?><?php echo $sublevel_start ?>
                <ul>
                    <li><?php echo link_to(__('Search'), '@filter?module=users', array('class' => 'img_action_search')) ?></li>
                    <li><?php echo picto_tag('action_cc')
                                 . link_to(__('User image management'), 'users/manageimages', array('class'=>'ie7m')) ?></li>
                    <li class="lilast"><?php
                        echo picto_tag('action_contact')
                           . link_to(__('Mailing lists link'), 'users/mailinglists', array('class'=>'ie7m')) ?></li>
                </ul><?php echo $sublevel_end ?>
            </li>
        </ul>
        <br class="clearer" />
    </div>