<?php

$textBlock = '';
$textBlock .= '"File was created.<br /><br />';
$textBlock .= '<ul class="nav"><li>';
$textBlock .= '<a href="'.$message['whatsapp'].'">'.$this->Html->image('wa-symbol.png', ['class' => 'icon-small'], ['escape' => false]).'</a></li>';
$textBlock .= sprintf('<li class="nav-input-field"><input type="text" class="form-control" value="%s"></input></li>', $message['url']);
$textBlock .= '</ul>';


?>

<div class="alert alert-success">
    <a class="close" data-dismiss="alert" href="#">×</a>
    <?= $textBlock; ?>
</div>