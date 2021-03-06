<?php

/**
 * We use an url shortener service
 * TODO hard coded url...
 */
function _marker_url($module, $type = null)
{
    switch ($module)
    {
        case 'summits':
            switch ($type)
            {
                case 2:  $url = 'http://goo.gl/90ei2c'; break 2; // http://www.camptocamp.org/static/images/picto/pass.png
                case 3:  $url = 'http://goo.gl/gl97GZ'; break 2; // http://www.camptocamp.org/static/images/picto/lake.png
                case 4:  $url = 'http://goo.gl/rYvByO'; break 2; // http://www.camptocamp.org/static/images/picto/crag.png
                default: $url = 'http://goo.gl/PXBoo'; break 2; // http://www.camptocamp.org/static/images/modules/summits_mini.png
            }
        case 'huts':
            switch ($type)
            {
                case 3:  $url = 'http://goo.gl/8RmT2T'; break 2; // http://www.camptocamp.org/static/images/picto/camp.png
                case 5:  $url = 'http://goo.gl/mziJTt'; break 2; // http://www.camptocamp.org/static/images/picto/gite.png
                default: $url = 'http://goo.gl/tHrhW'; break 2; // http://www.camptocamp.org/static/images/modules/huts_mini.png
            }
        case 'parkings': $url = 'http://goo.gl/SgAWw'; break; // http://www.camptocamp.org/static/images/modules/parkings_mini.png
        case 'sites':    $url = 'http://goo.gl/FlURV'; break; // http://www.camptocamp.org/static/images/modules/sites_mini.png
        case 'products': $url = 'http://goo.gl/JQ5IU'; break; // http://www.camptocamp.org/static/images/modules/products_mini.png
        case 'images':   $url = 'http://goo.gl/iVugl'; break; // http://www.camptocamp.org/static/images/modules/images_mini.png
        case 'users':    $url = 'http://goo.gl/RDZBR'; break; // http://www.camptocamp.org/static/images/modules/users_mini.png
        default:         $url = ''; break;
    }
    return urlencode($url);
}

/**
 * Encode a geometry obtained vi gisQuery::getEWKT into an encodedpolyline
 * http://code.google.com/apis/maps/documentation/polylinealgorithm.html
 */
function _polyline_encode($geom)
{
    $points = explode(',', $geom);
    foreach ($points as $key => $point)
    {
        $coords = explode(' ', $point);
        $points[$key] = array(floatval($coords[1]), floatval($coords[0]));
    }

    $encoder = new PolylineEncoder();
    return $encoder->encode($points)->rawPoints;
}

/**
 * empirical function to determine which tolerance to apply
 * to simplify for a geometry, given the box2d
 */
function _compute_tolerance($box2d, $track = false)
{
    $bounds = explode(' ', str_replace(',', ' ', $box2d));
    $max = max(abs(intval($bounds[2])-intval($bounds[0])), abs(intval($bounds[3])-intval($bounds[1])));
    if ($track) // gps track
    {
        return intval($max * 0.8 / 100);
    }
    else // area, map
    {
        return intval($max * 1.5 / 100);
    }
}
