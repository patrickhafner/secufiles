<div class="secufiles view">
    <?php if ( $Secufile ):
        if ( $Secufile['Secufile']['photo'] ): ?>

            <div class="well img-frame">
                <?php echo $this->Html->image( [ 'action' => 'image', 'hash' => $Secufile['Secufile']['hash'] ], [ 'escape' => false ] ) ?>
            </div>

        <?php endif; ?>

        <?php if ( $Secufile['Secufile']['content'] ): ?>
        <div class="well">
            <?php echo h( $Secufile['Secufile']['content'] ); ?>
        </div>
    <?php endif; ?>

        <ul class="nav naxbar-xs navbar-nav">
            <li><a class="btn btn-default btn-success"
                   href="whatsapp://send?text=<?php echo Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ); ?>"><?= $this->Html->image( 'wa-symbol.png', [ 'class' => 'icon-small' ], [ 'escape' => false ] ); ?>
                    Share it in WhatsApp</a></li>
            <?= sprintf( '<li class="nav-input-field"><input type="text" class="form-control" value="%s"></input></li>', Router::url( [ 'action' => 'view', 'hash' => $Secufile['Secufile']['hash'] ], true ) ); ?>
            <li class="pull-right">
                <small><?php echo "<strong>" . __( 'Remaining Views' ) . "</strong>"; ?>
                    : <?php echo $Secufile['Secufile']['remaining_views']; ?></small>
            </li>
        </ul>


    <?php endif; ?>
</div>