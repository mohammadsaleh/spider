<div class="page-content">
    <h3 class="page-title">
    <?= __d('settings','Index Settings') ?>
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
        <?= $this->Html->link(__d('settings', 'Settings'), ['action' => 'index']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?= __d('settings', 'List Settings') ?></span>
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
                            '<i class="fa fa-plus"></i> '.__d('settings', 'Add New Settings'),
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
                                <th><?= $this->Paginator->sort('key') ?></th>
                                <th><?= $this->Paginator->sort('value') ?></th>
                                <th><?= $this->Paginator->sort('title') ?></th>
                                <th><?= $this->Paginator->sort('weight') ?></th>
                                <th><?= $this->Paginator->sort('editable') ?></th>
                                <th><?= $this->Paginator->sort('created_by') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($settings as $setting): ?>
                            <tr>
                                <td><?= $this->Number->format($setting->id) ?></td>
                                <td><?= h($setting->key) ?></td>
                                <td><?= h($setting->value) ?></td>
                                <td><?= h($setting->title) ?></td>
                                <td><?= $this->Number->format($setting->weight) ?></td>
                                <td><?= $this->Number->format($setting->editable) ?></td>
                                <td><?= $this->Number->format($setting->created_by) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link('<i class="fa fa-eye text-info"></i>', ['action' => 'view', $setting->id], ['escape' => false]) ?>
                                    <?= $this->Html->link('<i class="fa fa-pencil text-info"></i>', ['action' => 'edit', $setting->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash text-danger"></i>',
                                        ['action' => 'delete', $setting->id],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', $setting->id),
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