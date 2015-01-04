<?php

Router::connect( '/', [ 'controller' => 'secufiles', 'action' => 'add' ] );
Router::connect( '/v/:hash', [ 'controller' => 'secufiles', 'action' => 'view' ], [ 'pass' => ['hash'] ] );
Router::connect( '/i/:hash', [ 'controller' => 'secufiles', 'action' => 'image' ], [ 'pass' => ['hash'] ] );
Router::connect( '/list', [ 'controller' => 'secufiles', 'action' => 'index' ] );

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
