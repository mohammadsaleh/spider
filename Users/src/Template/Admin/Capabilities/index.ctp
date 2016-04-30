<div class="page-content">
    <h3 class="page-title">
    <?= __d('users','Index Capabilities') ?>
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
        <?= $this->Html->link(__d('users', 'Capabilities'), ['action' => 'index']);?>
        <i class="fa fa-angle-right"></i>
    </li>
    <li>
        <span><?= __d('users', 'List Capabilities') ?></span>
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
                            '<i class="fa fa-plus"></i> '.__d('users', 'Add New Capabilities'),
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
                                <th><?= $this->Paginator->sort('title') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($capabilities as $capability): ?>
                            <tr>
                                <td><?= $this->Number->format($capability->id) ?></td>
                                <td><?= h($capability->title) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link('<i class="fa fa-eye text-info"></i>', ['action' => 'view', $capability->id], ['escape' => false]) ?>
                                    <?= $this->Html->link('<i class="fa fa-pencil text-info"></i>', ['action' => 'edit', $capability->id], ['escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fa fa-trash text-danger"></i>',
                                        ['action' => 'delete', $capability->id],
                                        [
                                            'confirm' => __('Are you sure you want to delete # {0}?', $capability->id),
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