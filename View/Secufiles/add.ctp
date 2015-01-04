<div class="secufiles form">
    <?php echo $this->Form->create( 'Secufile', [ 'type'  => 'file', 'inputDefaults' => [
        'div'       => 'form-group',
        'wrapInput' => false,
        'class'     => 'form-control'
    ],
                                                  'class' => 'well' ] ); ?>

    <?php
    echo $this->Form->input( 'Secufile.content', [ 'label' => false, 'placeholder' => __( 'Type in your text here…' ) ] ); ?>


    <div class="form-inline">
        <?php echo $this->Form->input( 'Secufile.photo', [ 'type' => 'file', 'class' => 'form-group btn btn-primary btn-sm btn-block', 'accept' => 'image/*', 'capture' => 'camera', 'title' => __( 'Upload image' ), 'label' => false ] ); ?>
        <?php echo $this->Form->input( 'Secufile.photo_dir', [ 'type' => 'hidden' ] ); ?>


    </div>

    <hr/>

    <?php echo $this->Form->submit( __( 'Create secret file' ), [ 'class' => 'btn-default, btn btn-success btn-lg btn-block' ] );
    $this->Form->end();
    ?>
</div>