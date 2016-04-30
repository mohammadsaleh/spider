<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Plugin'), ['action' => 'edit', $plugin->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Plugin'), ['action' => 'delete', $plugin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $plugin->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Plugins'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Plugin'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="plugins view large-10 medium-9 columns">
    <h2><?= h($plugin->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($plugin->name) ?></p>
            <h6 class="subheader"><?= __('Version') ?></h6>
            <p><?= h($plugin->version) ?></p>
            <h6 class="subheader"><?= __('New Version') ?></h6>
            <p><?= h($plugin->new_version) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($plugin->id) ?></p>
            <h6 class="subheader"><?= __('weight') ?></h6>
            <p><?= $this->Number->format($plugin->weight) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($plugin->status) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Theme') ?></h6>
            <?= $this->Text->autoParagraph(h($plugin->theme)) ?>
        </div>
    </div>
</div>
