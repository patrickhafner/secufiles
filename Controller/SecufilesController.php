<?php
App::uses( 'AppController', 'Controller' );
App::uses( 'Folder', 'Utility' );
App::uses( 'File', 'Utility' );
App::uses( 'HtmlHelper', 'View/Helper');

/**
 * Secufiles Controller
 *
 * @property Secufile $Secufile
 * @property PaginatorComponent $Paginator
 */
class SecufilesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = [ 'Paginator' ];

    public function beforeFilter() {
        parent::beforeFilter();

        $this->Security->unlockedActions = [ 'add' ];

    }


    public function image( $hash = null ) {
        $file = $this->Secufile->find( 'first', [
            'conditions' => [
                'hash'               => $hash,
                'remaining_views >=' => 0
            ]
        ] );




        if($file) {
            $ext = explode( '.', $file['Secufile']['photo'] );

            $extension = end( $ext );
        } else {
            $extension = 'png';
        }


        switch ( $extension ) {
            case 'jpg':
            case 'jpeg':
                $ct = 'image/jpeg';
                break;
            case 'gif':
                $ct = 'image/gif';
                break;
            default:
                $ct = 'image/png';
                break;
        }

        header( 'Content-type: ' . $ct );

        if($file) {

            $this->autoRender = false;

            $path = APP . WEBROOT_DIR . '/files/' . $file['Secufile']['photo_dir'] . '/';

            $handle = fopen( $path . $file['Secufile']['photo'], 'r' );
            $encryptedPhoto = fread( $handle, filesize( $path . $file['Secufile']['photo'] ) );

            echo Security::rijndael( $encryptedPhoto, Configure::read( 'Security.key' ), 'decrypt' );
        } else {
            $Html = new HtmlHelper(new View());
            echo file_get_contents(APP.WEBROOT_DIR.'/img/1px.png');
            unset($Html);
        }


        exit;


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
                'hash'               => $hash,
                'remaining_views >=' => 1
            ]
        ] );

        #debug((isset($file['Secufile']) && $file['Secufile']['remaining_views'] < 1));

        if ( isset( $file['Secufile']['remaining_views'] ) && intval( $file['Secufile']['remaining_views'] ) >= 1 ) {
            $file['Secufile']['remaining_views']--;

            $this->Secufile->save( $file );

            $file['Secufile']['content'] = Security::rijndael( $file['Secufile']['content'], Configure::read( 'Security.key' ), 'decrypt' );

            $this->set( 'secufile', $file );




        } else {


            $this->Session->setFlash( __( "File already deleted.<br /><br />You will be redirecting after 3 seconds." ), 'alert', [ 'plugin' => 'BoostCake','class'  => 'alert-danger' ] );

            $file = $this->Secufile->find( 'first', [
                'conditions' => [
                    'hash'               => $hash,
                ]
            ] );

            if($file) {
                $this->Secufile->delete($file['Secufile']['id']);

                if($file['Secufile']['photo']) {
                    $imgFolder = new Folder(APP . WEBROOT_DIR . '/files/'.$file['Secufile']['id']);
                    $imgFolder->delete();
                }
            }


            $this->set( 'secufile', null );

            $url = Router::fullBaseUrl( '/' );
            header( 'Refresh: 3; URL=' . $url );
        }



    }

    /**
     * add method
     *
     * @return void
     */


    /*public function index() {
        $secufiles = $this->Session->read( 'files' );

        debug( $secufiles );
        if ( $this->Session->read( 'created' ) == true ) {
            $this->Session->write( 'created', true );

            debug( $secufiles );

            $this->set( 'secufiles', $secufiles );
        }

    }*/

    public function add() {


        if ( $this->request->is( 'post' ) ) {

            $this->Secufile->Behaviors->attach( 'Upload' );


            if ( ( $this->request->data['Secufile']['photo']['size'] != 0 ) || ( $this->request->data['Secufile']['content'] != '' ) ) {

                $this->Secufile->create();


                if ( $this->Secufile->save( $this->request->data ) ) {


                    $Secufile = $this->Secufile->read( null, $this->Secufile->getLastInsertID() );


                    // encrypt

                    if ( isset( $Secufile['Secufile']['content'] ) ) {
                        $encryptedText = Security::rijndael( $Secufile['Secufile']['content'], Configure::read( 'Security.key' ), 'encrypt' );
                        $this->Secufile->saveField( 'content', $encryptedText );
                        $this->Secufile->save();
                    }


                    if ( isset( $Secufile['Secufile']['photo'] ) ) {
                        $path = APP . WEBROOT_DIR . '/files/' . $Secufile['Secufile']['photo_dir'] . '/';
                        $unencryptedPhoto = new File( $path . $Secufile['Secufile']['photo'] );
                        $encryptedPhoto = Security::rijndael( $unencryptedPhoto->read(), Configure::read( 'Security.key' ), 'encrypt' );

                        $unencryptedPhoto->write( $encryptedPhoto );

                        $unencryptedPhoto->close();
                    }

                    $this->Session->write( 'created', true );
                    if ( !CakeSession::read( 'files' ) ) {
                        CakeSession::write( 'files', [ ] );
                    } else {
                        CakeSession::write( 'files', array_merge( $this->Session->read( 'files' ), [ $Secufile['Secufile']['hash'] ] ) );
                    }

                    $flashMsg = [
                        'url' => Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ),
                        'whatsapp' => "whatsapp://send?text=".Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ),
                    ];
                    $this->Session->setFlash( $flashMsg, 'created');

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

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    /*public function delete( $id = null ) {
        $this->Secufile->id = $id;
        if ( !$this->Secufile->exists() ) {
            throw new NotFoundException( __( 'Invalid secufile' ) );
        }
        $this->request->allowMethod( 'post', 'delete' );
        if ( $this->Secufile->delete() ) {
            $this->Session->setFlash( __( 'The secufile has been deleted.' ) );
        } else {
            $this->Session->setFlash( __( 'The secufile could not be deleted. Please, try again.' ) );
        }

        return $this->redirect( [ 'action' => 'index' ] );
    }*/
}
