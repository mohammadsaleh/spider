<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Setting'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="settings view large-9 medium-8 columns content">
    <h3><?= h($setting->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Key') ?></th>
            <td><?= h($setting->key) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= h($setting->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($setting->title) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($setting->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Weight') ?></th>
            <td><?= $this->Number->format($setting->weight) ?></td>
        </tr>
        <tr>
            <th><?= __('Editable') ?></th>
            <td><?= $this->Number->format($setting->editable) ?></td>
        </tr>
        <tr>
            <th><?= __('Created By') ?></th>
            <td><?= $this->Number->format($setting->created_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated By') ?></th>
            <td><?= $this->Number->format($setting->updated_by) ?></td>
        </tr>
        <tr>
            <th><?= __('Updated') ?></th>
            <td><?= $this->Number->format($setting->updated) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($setting->created) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Params') ?></h4>
        <?= $this->Text->autoParagraph(h($setting->params)); ?>
    </div>
</div>
