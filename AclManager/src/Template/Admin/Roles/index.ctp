<?php
$this->extend('/Common/content_index');
$this->element('index_scripts');
$this->assign('content_title', !empty($title) ? $title : __('List Role'));
$this->assign('table_title', 'Table Title');
$this->assign('table_description', 'Table Description');
$this->Html->addCrumb(!empty($title) ? $title : __('List Role'));
?>

<?php $this->append('actions');?>
<?= $this->Html->link('<i class="fa fa-plus positio-left"></i> ' . __('New Role'), ['action' => 'add'], ['class' => 'btn btn-success btn-sm', 'escape' => false]);?>

<?php $this->end();?>

<?php $this->append('table');?>
<table class="table datatable index-datatable">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('description') ?></th>
            <th><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($treeRoles as $id => $treeRole):
        $role = $roles[$id];
    ?>
        <tr>
            <td><?= $role->id ?></td>
            <td><?= h($treeRole) ?></td>
            <td><?= h($role->title) ?></td>
            <td><?= h($role->description) ?></td>
            <td>
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><?= $this->Html->link(__('View'), ['action' => 'view', $role->id], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-edit"></i> ' . __('Edit'), ['action' => 'edit', $role->id], ['escape' => false]) ?></li>
                            <li><?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Delete'), ['action' => 'delete', $role->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?></li>
                        </ul>
                    </li>
                </ul>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->end();?>