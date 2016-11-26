 <?= $this->Html->link(
    '<i class="fa fa-refresh"></i> ' . __d('acl_manager', 'Sync ACO\'s'),
    ['plugin' => 'AclManager', 'controller' => 'Permissions', 'action' => 'sync'],
    ['escape' => false, 'class' => 'btn btn-success btn-sm']
)
?>