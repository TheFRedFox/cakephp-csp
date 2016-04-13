<?php
use Cake\Routing\Router;

Router::plugin(
    'Csp',
    ['path' => '/csp'],
    function ($routes) {
        $routes->fallbacks('DashedRoute');
    }
);
