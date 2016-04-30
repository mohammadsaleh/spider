<?php
$isTheme = false;
if(in_array('theme', $this->request->params['pass'])){
    $isTheme = true;
}
?>
<div class="page-content">
    <h3 class="page-title">
    <?= __d('plugin_manager','Index Plugins') ?>
    <small></small>
</h3>
    <div class="page-bar">
        <ul class="page-breadcrumb">
    <li>
        <i class="fa fa-home"></i>
        <?= $this->Html->link(__('Home'), ['action' => 'dashboard']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <?= $this->Html->link(__d('plugin_manager', 'Plugins'), ['action' => 'index']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?= __d('plugin_manager', 'List Plugins') ?></span>
    </li>
</ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet blue box">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>Basic Bootstrap 3.0 Responsive Table
                    </div>
                    <div class="actions">
                        <?=
                        $this->Html->link(
                            '<i class="fa fa-plus"></i> '.__d('plugin_manager', 'Add New Plugins'),
                            ['action' => 'add'],
                            ['class' => 'btn btn-circle btn-info', 'escape' => false]
                        );
                        ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?= $this->Paginator->sort('id') ?></th>
                                <?php if($isTheme){?>
                                <th><?= __d('plugin_manager', 'Screen Shot'); ?></th>
                                <?php }?>
                                <th><?= $this->Paginator->sort('name') ?></th>
                                <th><?= $this->Paginator->sort('version') ?></th>
                                <th><?= $this->Paginator->sort('new_version') ?></th>
                                <?php if($isTheme){?>
                                <th><?= $this->Paginator->sort('type') ?></th>
                                <?php }?>
                                <th><?= $this->Paginator->sort('status') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($plugins as $plugin): ?>
                            <tr>
                                <td><?= $this->Number->format($plugin->id) ?></td>
                                <?php if($isTheme){?>
                                <td><?= $this->Html->image($plugin->name . '.screenshot.png', ['width' => '200px']);?></td>
                                <?php }?>
                                <td><?= h($plugin->name) ?></td>
                                <td><?= h($plugin->version) ?></td>
                                <td><?= h($plugin->new_version) ?></td>
                                <?php if($isTheme){?>
                                <td><?= h($plugin->theme) ?></td>
                                <?php }?>
                                <td><?= h($plugin->status) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link('<i class="fa fa-bolt text-info"></i>', ['action' => 'active', $plugin->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash text-danger"></i>',
                                        ['action' => 'delete', $plugin->id],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', $plugin->id),
                                            'escape' => false
                                        ]
                                    );
                                    ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix">
                        <div class="paginator pull-left">
                            <ul class="pagination">
                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('next') . ' >') ?>
                            </ul>
                        </div>
                        <div class="pull-right">
                            <p><?= $this->Paginator->counter() ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>