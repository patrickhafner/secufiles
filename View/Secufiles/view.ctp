<div class="secufiles view">
    <?php if($secufile):
        #debug($secufile);
        if($secufile['Secufile']['photo']): ?>

        <div class="well img-frame">
            <?php echo $this->Html->image(['action' => 'image', 'hash' => $secufile['Secufile']['hash'] ], ['escape' => false])?>
        </div>

    <?php endif; ?>

    <?php if($secufile['Secufile']['content']): ?>
        <div class="well">
            <?php echo h($secufile['Secufile']['content']); ?>
        </div>
    <?php endif; ?>

    <ul class="nav naxbar-xs navbar-nav">
        <li><a href="whatsapp://send?text=<?php echo Router::url( [ 'action' => 'view', 'hash' => $secufile['Secufile']['hash'] ], true ); ?>"><?= $this->Html->image('wa-symbol.png', ['class' => 'icon-small']); ?></a></li>
        <li class="nav-input-field"><input type='text' class="form-control" value='<?php echo Router::url( [ 'action' => 'view', 'hash' => $secufile['Secufile']['hash'] ], true ); ?>'></input></li>
        <li class="pull-right"><small><?php echo "<strong>".__('Remaining Views')."</strong>"; ?> <?php echo $secufile['Secufile']['remaining_views']; ?></small></li>
    </ul>


    <?php endif; ?>
</div>