<?php
function compile_assets($path)
{
    return env('APP_ENV') == 'production' ? mix($path) : asset($path);
}

function set_active($route, $strict = false)
{
    $path = Request::path();
    return $strict ? ($path === strval($route) ? 'active' : '') : (strpos($path, $route) === 0 ? 'active' : '');
}

