<?php
$Roles = \Cake\ORM\TableRegistry::get('AclManager.Roles');
$roles = $Roles->find()->combine('id', 'name')->toArray();
$user['roles'] = \Cake\Utility\Hash::extract($user, 'roles.{n}.id');
?>
<div class="panel-body no-padding-bottom">
    <div class="form-group">
        <label class="control-label col-lg-3"><?= __('roles')?></label>
        <div class="col-lg-9">
        <?= $this->Form->select('roles', $roles, ['multiple' => true, 'class' => 'form-control select-menu2-color', 'label' => false]);?>
        </div>
    </div>
</div>
<?php
$this->Html->script('forms/select2.min', ['block' => true]);
$this->append('script');
?>
<script>
    $('.select-menu2-color').select2({
        containerCssClass: 'bg-indigo-400',
        dropdownCssClass: 'bg-indigo-400'
    });
</script>
<?php
$this->end();