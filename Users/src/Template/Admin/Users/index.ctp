<?php
$this->extend('/Common/content_index');
$this->element('index_scripts');
$this->assign('content_title', !empty($title) ? $title : __('List User'));
$this->assign('table_title', 'Table Title');
$this->assign('table_description', 'Table Description');
$this->Html->addCrumb(!empty($title) ? $title : __('List User'));
?>

<?php $this->append('actions');?>
<?= $this->Html->link('<i class="fa fa-plus positio-left"></i> ' . __('New User'), ['action' => 'add'], ['class' => 'btn btn-success btn-sm', 'escape' => false]);?>
<?php $this->end();?>

<?php $this->append('table');?>
<table class="table datatable index-datatable">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('username') ?></th>
            <th><?= $this->Paginator->sort('firstname') ?></th>
            <th><?= $this->Paginator->sort('lastname') ?></th>
            <th><?= $this->Paginator->sort('mobile') ?></th>
            <th><?= $this->Paginator->sort('avatar') ?></th>
            <th><?= $this->Paginator->sort('status') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $row = 1;
    foreach ($users as $user):
    ?>
        <tr>
            <td><?= $user->id ?></td>
            <td><?= h($user->username) ?></td>
            <td><?= h($user->firstname) ?></td>
            <td><?= h($user->lastname) ?></td>
            <td><?= h($user->mobile) ?></td>
            <td><?= !empty($user->avatar) ? $this->Html->image($user->avatar, ['style' => 'width:100px']) : '' ?></td>
            <td><?= $this->Spider->status($user->status) ?></td>
            <td><?= \Spider\Lib\Date\Persian::date('Y-m-d H:i:s', $user->created) ?></td>
            <td>
                <ul class="icons-list">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bars"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><?= $this->Html->link(__('View'), ['action' => 'view', $user->id], ['escape' => false]) ?></li>
                            <li><?= $this->Html->link('<i class="fa fa-edit"></i> ' . __('Edit'), ['action' => 'edit', $user->id], ['escape' => false]) ?></li>
                            <li><?= $this->Form->postLink('<i class="fa fa-trash"></i> ' . __('Delete'), ['action' => 'delete', $user->id], ['escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?></li>
                        </ul>
                    </li>
                </ul>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->end();?>