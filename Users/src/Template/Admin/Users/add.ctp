<?php
$this->extend('/Common/content_form');

$this->assign('content_title', !empty($title) ? $title : __('Add User'));
$this->Html->addCrumb(__('List Users'), ['action' => 'index']);
$this->Html->addCrumb(!empty($title) ? $title : __('Add User'));
$this->set('form', $this->Form->create($user, ['class' => 'form-horizontal']));
?>

<?php $this->append('form');?>
<div class="panel-heading">
    <h4 class="panel-title"><?= __('Add User') ?></h4>
</div>
<div class="panel-body no-padding-bottom">
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('username')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('username', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('password')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('firstname')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('firstname', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('lastname')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('lastname', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('alias')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('alias', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('mobile')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('mobile', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('birthday')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('birthday', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('avatar')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('avatar', ['class' => 'form-control', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('status')?></label>
        <div class="col-lg-9">
        <?php
        $statuses = [
            ['text' => __d('users', 'Deleted'),     'value' => -1,  'class' => 'control-danger'],
            ['text' => __d('users', 'DeActive'),    'value' => 0,   'class' => 'control-info'],
            ['text' => __d('users', 'Active'),      'value' => 1,   'class' => 'control-success'],
        ];
        ?>
        <?= $this->Form->radio('status', $statuses, ['label' => ['class' => 'radio-inline radio-left']]);?>
        </div>
    </div>
</div>
<?php $this->end();?>
