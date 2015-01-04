<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $secufiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'length' => 11, 'key' => 'primary'),
		'hash' => array('type' => 'text', 'null' => true),
		'content' => array('type' => 'text', 'null' => true),
		'remaining_views' => array('type' => 'integer', 'null' => false, 'default' => '1'),
		'photo' => array('type' => 'text', 'null' => true),
		'photo_dir' => array('type' => 'text', 'null' => true),
		'indexes' => array(
			
		),
		'tableParameters' => array()
	);

}
