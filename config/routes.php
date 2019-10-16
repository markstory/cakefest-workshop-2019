<?php
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/api', ['prefix' => 'Api'], function (RouteBuilder $builder) {
    $builder->setExtensions(['json']);

    $builder->resources('Tickets', function (RouteBuilder $builder) {
        $builder->resources('Emails', [
            'connectOptions' => ['pass' => ['ticket_id', 'id']]
        ]);
    });
});

$routes->scope('/', function (RouteBuilder $builder) {
    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    $builder->applyMiddleware('csrf');
    $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    $builder->fallbacks();
});
