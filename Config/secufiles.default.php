<?php

/***
 * secufiles config file
 * (c) 2015 by Patrick Hafner
 *
 *
 * please change the values of
 * Security.salt and Security.key
 * for best encryption
 *
 */

Configure::write( 'Security.salt', 'ew356P-t*YPy9-S-(oIUVFVtOdr;*_qdH/nSw' );
Configure::write( 'Security.key', 'QD:8e9,maQ!FtnVMSW,bC,9X`)AE~' ); // generate random string with your favourite tool to encrypt images and text


Configure::write( 'secufiles.config', [
    'Version'             => '1.1',
    'showVersionInFooter' => true,
] );