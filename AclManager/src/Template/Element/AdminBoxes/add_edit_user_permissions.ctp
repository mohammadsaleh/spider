<?php
$this->Html->css('tree/jquery.tree-multiselect.min', ['block' => true]);
?>
<div class="panel panel-flat">
    <div class="panel-heading">
        <h4 class="panel-title">Private User Permissions</h4>
    </div>
    <div class="panel-body">
        <?= $this->element('AclManager.acl_permissions')?>
    </div>
</div>