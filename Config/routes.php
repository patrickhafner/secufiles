<?php

Router::connect( '/', [ 'controller' => 'secufiles', 'action' => 'add' ] );
Router::connect( '/v/:hash', [ 'controller' => 'secufiles', 'action' => 'view' ], [ 'pass' => ['hash'] ] );
Router::connect( '/i/:hash', [ 'controller' => 'secufiles', 'action' => 'image' ], [ 'pass' => ['hash'] ] );
Router::connect( '/l', [ 'controller' => 'secufiles', 'action' => 'showList' ] );
Router::connect( '/ajax/:hash', [ 'controller' => 'secufiles', 'action' => 'getRemainingViews' ], [ 'pass' => ['hash'] ] );
Router::connect( '/delete/:hash/:delete_code', [ 'controller' => 'secufiles', 'action' => 'delete' ], [ 'pass' => ['hash', 'delete_code'] ] );


CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
