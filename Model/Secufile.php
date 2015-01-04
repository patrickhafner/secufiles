<?php
App::uses('AppModel', 'Model');
/**
 * Secufile Model
 *
 */
class Secufile extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'hash';

    public $actsAs = array(
        'Upload.Upload' => array(
            'photo' => [
                'path' => '{ROOT}{DS}webroot{DS}files{DS}',
                'pathMethod' => 'randomCombined',
                /*'thumbnailSizes' => array(
                    'mid' => '1024x768'
                ),*/
                'fields' => array(
                    'dir' => 'photo_dir'
                )
            ]
        )
    );

    public $validates = [
        'photo' => [
            'extension' => array(
                'rule' => array(
                    'extension', array(
                        'jpg',
                        'jpeg',
                        'bmp',
                        'gif',
                        'png',
                        'jpg'
                    )
                ),
                'message' => 'File extension is not supported',
                'on' => 'create'
            ),
            'mime' => array(
                'rule' => array('mime', array(
                    'image/jpeg',
                    'image/pjpeg',
                    'image/bmp',
                    'image/x-ms-bmp',
                    'image/gif',
                    'image/png'
                )),
                'on' => 'create'
            ),
            'size' => array(
                'rule' => array('size', 6097152),
                'on' => 'create'
            )
        ],


    ];



    public function beforeSave($options = array()) {
        if(!isset($this->data['Secufile']['hash'])) {
            $this->data['Secufile']['hash'] = $this->rand_string(12);
        }

        if(!(isset($this->data['Secufile']['remaining_views']))){
            $this->data['Secufile']['remaining_views'] = 1;
        }



        return true;

    }


}
