<?php

define('db', APP.'db'.DS.'secufiles');

class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Sqlite',
		'persistent' => false,
		'prefix' => '',
        'database' => db
		//'encoding' => 'utf8',
	);


}
