<?php
App::uses( 'AppController', 'Controller' );
App::uses( 'Folder', 'Utility' );
App::uses( 'File', 'Utility' );

/**
 * Secufiles Controller
 *
 * @property Secufile $Secufile
 */
class SecufilesController extends AppController {

    protected $path = '';

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->unlockedActions = [ 'add', 'getRemainingViews' ];

        $this->path = APP . '/uploads/';

    }


    public function image( $hash = null ) {


        $file = $this->Secufile->find( 'first', [
            'conditions' => [
                'hash'     => $hash,
                'photo !=' => ''
            ]
        ] );


        if ( $file ) {

            $ext = explode( '.', $file['Secufile']['photo'] );

            $this->response->type( end( $ext ) );

            $path = $this->path . $file['Secufile']['photo_dir'] . '/';
            $encryptedPhoto = new File( $path . $file['Secufile']['photo'] );
            $this->response->body( Security::rijndael( $encryptedPhoto->read(), Configure::read( 'Security.key' ), 'decrypt' ) );

        } else {

            $this->response->type( 'png' );
            $this->response->file( APP . WEBROOT_DIR . '/img/1px.png' );

        }


        return $this->response;

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view( $hash = null ) {

        $file = $this->Secufile->find( 'first', [
            'conditions' => [
                'hash' => $hash
            ]
        ] );


        if ( !$file ) {
            $this->Session->setFlash(
                __( "File already deleted.<br /><br />You will be redirecting after 3 seconds." ),
                'alert',
                [ 'plugin' => 'BoostCake', 'class' => 'alert-danger' ]
            );

            $this->response->header('Refresh: 3; URL=' . Router::fullBaseUrl( '/' ) );
        }


        if ( isset( $file['Secufile']['remaining_views'] ) ) {

            // are there remaining views? then show the record, and decrease the view counter
            if ( intval( $file['Secufile']['remaining_views'] ) >= 1 ) {

                $file['Secufile']['remaining_views']--;
                $this->Secufile->save( $file );

                $file['Secufile']['content'] = Security::rijndael( $file['Secufile']['content'], Configure::read( 'Security.key' ), 'decrypt' );
                $this->set( 'Secufile', $file );
                $this->render();

            } // no more remaining views, delete the record
            else if ( $file['Secufile']['remaining_views'] == 0 ) {

                $file = $this->Secufile->find( 'first', [
                    'conditions' => [
                        'hash' => $hash,
                    ]
                ] );


                if ( $file ) {

                    // delete from db
                    $this->Secufile->delete( $file['Secufile']['id'] );

                    if ( $file['Secufile']['photo'] ) {

                        // delete photo from fs
                        $imgFolder = new Folder( $this->path . $file['Secufile']['id'] );
                        $imgFolder->delete();

                    }
                }

                $this->set( 'Secufile', null );

                $this->Session->setFlash(
                    __( "File already deleted.<br /><br />You will be redirecting after 3 seconds." ),
                    'alert',
                    [ 'plugin' => 'BoostCake', 'class' => 'alert-danger' ]
                );

                $this->response->header('Refresh: 3; URL=' . Router::fullBaseUrl( '/' ) );


            }

        } // end isset remaining_views


    }


    public function add() {


        if ( $this->request->is( 'post' ) ) {

            $this->Secufile->Behaviors->load( 'Upload' );

            if ( ( $this->request->data['Secufile']['photo']['size'] != 0 ) || ( $this->request->data['Secufile']['content'] != '' ) ) {


                if ( !( isset( $this->data['Secufile']['remaining_views'] ) ) ) {
                    $this->data['Secufile']['remaining_views'] = 1;
                }

                $this->Secufile->create();


                if ( $this->Secufile->save( $this->request->data ) ) {


                    $Secufile = $this->Secufile->read( null, $this->Secufile->getLastInsertID() );


                    // encrypt

                    if ( isset( $Secufile['Secufile']['content'] ) && $Secufile['Secufile']['content'] ) {
                        $encryptedText = Security::rijndael( $Secufile['Secufile']['content'], Configure::read( 'Security.key' ), 'encrypt' );
                        $this->Secufile->saveField( 'content', $encryptedText );
                        $this->Secufile->save();
                    }


                    if ( isset( $Secufile['Secufile']['photo'] ) && $Secufile['Secufile']['photo'] ) {
                        $path = $this->path . $Secufile['Secufile']['photo_dir'] . '/';
                        $unencryptedPhoto = new File( $path . $Secufile['Secufile']['photo'] );
                        $encryptedPhoto = Security::rijndael( $unencryptedPhoto->read(), Configure::read( 'Security.key' ), 'encrypt' );

                        $unencryptedPhoto->write( $encryptedPhoto );

                        $unencryptedPhoto->close();
                    }

                    $flashMsg = [
                        'url'         => Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ),
                        'whatsapp'    => "whatsapp://send?text=" . Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ),
                        'delete_code' => $Secufile['Secufile']['delete_code'],
                        'hash'        => $Secufile['Secufile']['hash']
                    ];
                    $this->Session->setFlash( $flashMsg, 'created' );

                    return $this->redirect( [ 'action' => 'add' ] );
                } else {
                    $this->Session->setFlash( __( 'The secufile could not be saved. Please, type in any text or upload an image.' ), 'alert', [ 'plugin' => 'BoostCake', 'class' => 'alert-danger' ] );
                }

            } else {

                $this->Secufile->validates = false;
                $this->Session->setFlash( __( 'The secufile could not be saved. Please, type in any text or upload an image.' ), 'alert', [ 'plugin' => 'BoostCake', 'class' => 'alert-danger' ] );


            }

        }


    }


    public function showList() {


    }


    public function getRemainingViews( $hashes ) {

        if ( !$this->request->is( 'ajax' ) ) Throw new BadRequestException;

        $hashes = explode( ';', $hashes );
        array_pop( $hashes );

        $Secufiles = $this->Secufile->find( 'all', [
            'fields'     => [ 'remaining_views', 'created_at', 'hash', 'photo' ],
            'conditions' => [
                'OR' => [
                    'hash' => $hashes
                ],
            ],
        ] );

        foreach($Secufiles as &$Secufile) {
            if($Secufile['Secufile']['photo']) {
                $Secufile['Secufile']['containsPhoto'] = 1;
            } else {
                $Secufile['Secufile']['containsPhoto'] = 0;
            }
            unset($Secufile['Secufile']['photo']);
        }


        $this->response->type( 'json' );
        $this->response->body( json_encode( $Secufiles ) );

        return $this->response;
    }

    public function delete( $hash, $delete_code ) {
        $file = $this->Secufile->find( 'first', [
            'conditions' => [
                'hash'        => $hash,
                'delete_code' => $delete_code
            ]
        ] );


        $this->Secufile->id = $file['Secufile']['id'];

        if ( $this->Secufile->exists() ) {


            if ( $file['Secufile']['photo'] ) {

                // delete photo from fs
                $imgFolder = new Folder( $this->path . $file['Secufile']['id'] );
                $imgFolder->delete();

            }

            if ( $this->Secufile->delete() ) {
                $this->Session->setFlash( __( 'The Secufile has been deleted.' ), 'alert', [ 'plugin' => 'BoostCake', 'class' => 'alert-success' ] );
            } else {
                $this->Session->setFlash( __( 'The Secufile could not be deleted. Please, try again.' ), 'alert', [ 'plugin' => 'BoostCake', 'class' => 'alert-danger' ] );
            }

            return $this->redirect( [ 'action' => 'showList' ] );
        }
    }

}
