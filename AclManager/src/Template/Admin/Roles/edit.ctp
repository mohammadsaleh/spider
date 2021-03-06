<?php
$this->extend('/Common/content_form');
$this->element('form_scripts');
$this->assign('content_title', !empty($title) ? $title : __('Edit Role'));
$this->Breadcrumbs->add(__('List Roles'), ['action' => 'index']);
$this->Breadcrumbs->add(!empty($title) ? $title : __('Edit Role'));
$this->set('form', $this->Form->create($role, ['class' => 'form-horizontal']));
?>

<?php $this->append('actions')?>
<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $role->id], [
        'confirm' => __('Are you sure you want to delete # {0}?', $role->id),
        'class' => 'btn btn-danger btn-sm'
    ]). ' ';
?>
<?php $this->end()?>

<?php $this->append('form');?>
<div class="panel-heading">
    <h4 class="panel-title"><?= __('Edit Role') ?></h4>
</div>
<div class="panel-body no-padding-bottom">
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('parent_id')?></label>
        <div class="col-lg-9">
        <?= $this->Form->select('parent_id', $parentRoles, ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('name')?></label>
        <div class="col-lg-9">
        <?= $this->Form->control('name', ['class' => 'form-control', 'label' => false]);?>
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
</div>
<?php $this->end();?>