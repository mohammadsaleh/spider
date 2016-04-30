<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Settings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Setting'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="settings view large-10 medium-9 columns">
    <h2><?= h($setting->title) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Key') ?></h6>
            <p><?= h($setting->key) ?></p>
            <h6 class="subheader"><?= __('Value') ?></h6>
            <p><?= h($setting->value) ?></p>
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($setting->title) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($setting->id) ?></p>
            <h6 class="subheader"><?= __('Weight') ?></h6>
            <p><?= $this->Number->format($setting->weight) ?></p>
            <h6 class="subheader"><?= __('Editable') ?></h6>
            <p><?= $this->Number->format($setting->editable) ?></p>
            <h6 class="subheader"><?= __('Created By') ?></h6>
            <p><?= $this->Number->format($setting->created_by) ?></p>
            <h6 class="subheader"><?= __('Updated By') ?></h6>
            <p><?= $this->Number->format($setting->updated_by) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($setting->created) ?></p>
            <h6 class="subheader"><?= __('Updated') ?></h6>
            <p><?= h($setting->updated) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <?= $this->Text->autoParagraph(h($setting->description)) ?>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Params') ?></h6>
            <?= $this->Text->autoParagraph(h($setting->params)) ?>
        </div>
    </div>
</div>
