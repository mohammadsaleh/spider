<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Role'), ['action' => 'edit', $role->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Capabilities'), ['controller' => 'Capabilities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Capability'), ['controller' => 'Capabilities', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="roles view large-10 medium-9 columns">
    <h2><?= h($role->name) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Parent Role') ?></h6>
            <p><?= $role->has('parent_role') ? $this->Html->link($role->parent_role->name, ['controller' => 'Roles', 'action' => 'view', $role->parent_role->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name') ?></h6>
            <p><?= h($role->name) ?></p>
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($role->title) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($role->id) ?></p>
            <h6 class="subheader"><?= __('Lft') ?></h6>
            <p><?= $this->Number->format($role->lft) ?></p>
            <h6 class="subheader"><?= __('Rght') ?></h6>
            <p><?= $this->Number->format($role->rght) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <?= $this->Text->autoParagraph(h($role->description)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Roles') ?></h4>
    <?php if (!empty($role->child_roles)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Parent Id') ?></th>
            <th><?= __('Name') ?></th>
            <th><?= __('Title') ?></th>
            <th><?= __('Description') ?></th>
            <th><?= __('Lft') ?></th>
            <th><?= __('Rght') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($role->child_roles as $childRoles): ?>
        <tr>
            <td><?= h($childRoles->id) ?></td>
            <td><?= h($childRoles->parent_id) ?></td>
            <td><?= h($childRoles->name) ?></td>
            <td><?= h($childRoles->title) ?></td>
            <td><?= h($childRoles->description) ?></td>
            <td><?= h($childRoles->lft) ?></td>
            <td><?= h($childRoles->rght) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $childRoles->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $childRoles->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $childRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childRoles->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Users') ?></h4>
    <?php if (!empty($role->users)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Username') ?></th>
            <th><?= __('Password') ?></th>
            <th><?= __('Firstname') ?></th>
            <th><?= __('Lastname') ?></th>
            <th><?= __('Alias') ?></th>
            <th><?= __('Mobile') ?></th>
            <th><?= __('Birthday') ?></th>
            <th><?= __('Presenter Id') ?></th>
            <th><?= __('City Id') ?></th>
            <th><?= __('Role Id') ?></th>
            <th><?= __('Status') ?></th>
            <th><?= __('Created') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($role->users as $users): ?>
        <tr>
            <td><?= h($users->id) ?></td>
            <td><?= h($users->username) ?></td>
            <td><?= h($users->password) ?></td>
            <td><?= h($users->firstname) ?></td>
            <td><?= h($users->lastname) ?></td>
            <td><?= h($users->alias) ?></td>
            <td><?= h($users->mobile) ?></td>
            <td><?= h($users->birthday) ?></td>
            <td><?= h($users->presenter_id) ?></td>
            <td><?= h($users->city_id) ?></td>
            <td><?= h($users->role_id) ?></td>
            <td><?= h($users->status) ?></td>
            <td><?= h($users->created) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Capabilities') ?></h4>
    <?php if (!empty($role->capabilities)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Title') ?></th>
            <th><?= __('Description') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($role->capabilities as $capabilities): ?>
        <tr>
            <td><?= h($capabilities->id) ?></td>
            <td><?= h($capabilities->title) ?></td>
            <td><?= h($capabilities->description) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Capabilities', 'action' => 'view', $capabilities->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Capabilities', 'action' => 'edit', $capabilities->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Capabilities', 'action' => 'delete', $capabilities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $capabilities->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
