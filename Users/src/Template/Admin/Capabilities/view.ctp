<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Capability'), ['action' => 'edit', $capability->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Capability'), ['action' => 'delete', $capability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $capability->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Capabilities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Capability'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="capabilities view large-10 medium-9 columns">
    <h2><?= h($capability->title) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Title') ?></h6>
            <p><?= h($capability->title) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($capability->id) ?></p>
        </div>
    </div>
    <div class="row texts">
        <div class="columns large-9">
            <h6 class="subheader"><?= __('Description') ?></h6>
            <?= $this->Text->autoParagraph(h($capability->description)) ?>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Roles') ?></h4>
    <?php if (!empty($capability->roles)): ?>
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
        <?php foreach ($capability->roles as $roles): ?>
        <tr>
            <td><?= h($roles->id) ?></td>
            <td><?= h($roles->parent_id) ?></td>
            <td><?= h($roles->name) ?></td>
            <td><?= h($roles->title) ?></td>
            <td><?= h($roles->description) ?></td>
            <td><?= h($roles->lft) ?></td>
            <td><?= h($roles->rght) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Roles', 'action' => 'view', $roles->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Roles', 'action' => 'edit', $roles->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Roles', 'action' => 'delete', $roles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roles->id)]) ?>

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
    <?php if (!empty($capability->users)): ?>
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
        <?php foreach ($capability->users as $users): ?>
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
