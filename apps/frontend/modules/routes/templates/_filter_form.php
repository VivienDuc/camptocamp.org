<?php
use_helper('FilterForm');

$is_connected = $sf_user->isConnected();

echo around_selector('parnd');
$ranges_raw = $sf_data->getRaw('ranges');
$selected_areas_raw = $sf_data->getRaw('selected_areas');
include_partial('areas/areas_selector', array('ranges' => $ranges_raw, 'selected_areas' => $selected_areas_raw, 'use_personalization' => true));
?>
<br />
<?php
include_partial('summits/summits_short_filter');
$activities_raw = $sf_data->getRaw('activities');
include_partial('routes_filter', array('autofocus' => true, 'activities' => $activities_raw));
include_partial('huts/huts_short_filter');
include_partial('parkings/parkings_filter');
?>
<br />
<?php
echo __('filter language') . __('&nbsp;:') . ' ' . lang_selector('rcult');
if ($is_connected)
{
    echo __('Search in my routes') . ' ' . field_value_selector('myroutes', 'mod_routes_myroutes_list', array('filled_options' => false));
}
?>
<br />
<?php
include_partial('documents/filter_sort');
