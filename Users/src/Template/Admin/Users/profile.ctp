<?php
$this->extend('/Common/content_form');
$this->element('form_scripts');
$this->set('form', $this->Form->create($user, ['class' => 'form-horizontal']));
$this->assign('content_title', !empty($title) ? $title : __('My Profile'));
$this->Html->addCrumb(!empty($title) ? $title : __('My Profile'));

?>

<?php $this->append('form');?>
    <div class="panel-heading">
    <h4 class="panel-title"><?= __('My Profile') ?></h4>
</div>
    <div class="panel-body no-padding-bottom">
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('username')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('username', ['class' => 'form-control', 'label' => false, 'disabled' => 'disabled']);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('old password')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('old_password', ['class' => 'form-control', 'type' => 'password', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('new password')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('password', ['class' => 'form-control', 'type' => 'password', 'label' => false]);?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('confirm new password')?></label>
        <div class="col-lg-9">
        <?= $this->Form->input('confirm_password', ['class' => 'form-control', 'type' => 'password', 'label' => false]);?>
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
</div>
<?php $this->end();?>