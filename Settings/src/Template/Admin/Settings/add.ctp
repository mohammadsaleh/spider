<?php
$this->extend('/Common/content_form');
$this->element('form_scripts');
$this->assign('content_title', !empty($title) ? $title : __('Add Setting'));
$this->Html->addCrumb(__('List Settings'), ['action' => 'index']);
$this->Html->addCrumb(!empty($title) ? $title : __('Add Setting'));
$this->set('form', $this->Form->create($setting, ['class' => 'form-horizontal']));
?>


<?php $this->append('form');?>
<div class="panel-heading">
    <h4 class="panel-title"><?= __('Add Setting') ?></h4>
</div>
<div class="panel-body no-padding-bottom">
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('key')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('key', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('value')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('value', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('title')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('title', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('description')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('description', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('params')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('params', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('weight')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('weight', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('editable')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('editable', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('created_by')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('created_by', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('updated_by')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('updated_by', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
</div>
<?php $this->end();?>