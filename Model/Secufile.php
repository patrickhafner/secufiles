<?php
App::uses( 'AppModel', 'Model' );

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

    public $actsAs = [
        'Upload.Upload' => [
            'photo' => [
                'path'       => '{ROOT}{DS}uploads{DS}',
                'pathMethod' => 'randomCombined',
                /*'thumbnailSizes' => array(
                    'mid' => '1024x768'
                ),*/
                'fields'     => [
                    'dir' => 'photo_dir'
                ]
            ]
        ]
    ];

    public $validates = [
        'photo' => [
            'extension'       => [
                'rule'    => [
                    'extension', [
                        'jpg',
                        'jpeg',
                        'bmp',
                        'gif',
                        'png',
                        'jpg'
                    ]
                ],
                'message' => 'File extension is not supported',
                'on'      => 'create'
            ],
            'mime'            => [
                'rule' => [ 'mime', [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/bmp',
                    'image/x-ms-bmp',
                    'image/gif',
                    'image/png'
                ] ],
                'on'   => 'create'
            ],
            'size'            => [
                'rule' => [ 'size', 6097152 ],
                'on'   => 'create'
            ],
            'views_remaining' => [
                'rule' => 'numeric',
                'on'   => 'create'
            ]
        ],


    ];


    public function beforeSave( $options = [ ] ) {
        if ( !isset( $this->data['Secufile']['hash'] ) ) {
            $this->data['Secufile']['hash'] = $this->rand_string( 12 );
        }
        if ( !isset( $this->data['Secufile']['delete_code'] ) ) {
            $this->data['Secufile']['delete_code'] = $this->rand_string( 20 );
        }
        if ( !isset( $this->data['Secufile']['created_at'] ) ) {
            $this->data['Secufile']['created_at'] = date( 'Y-m-d H:i:s' );
        }

        return true;

    }


}
