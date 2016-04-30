<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Activation Keys'), ['controller' => 'ActivationKeys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activation Key'), ['controller' => 'ActivationKeys', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Accounts'), ['controller' => 'UserAccounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Account'), ['controller' => 'UserAccounts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Logins'), ['controller' => 'UserLogins', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Login'), ['controller' => 'UserLogins', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Banks'), ['controller' => 'Banks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bank'), ['controller' => 'Banks', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="users view large-10 medium-9 columns">
    <h2><?= h($user->alias) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Username') ?></h6>
            <p><?= h($user->username) ?></p>
            <h6 class="subheader"><?= __('Password') ?></h6>
            <p><?= h($user->password) ?></p>
            <h6 class="subheader"><?= __('Firstname') ?></h6>
            <p><?= h($user->firstname) ?></p>
            <h6 class="subheader"><?= __('Lastname') ?></h6>
            <p><?= h($user->lastname) ?></p>
            <h6 class="subheader"><?= __('Alias') ?></h6>
            <p><?= h($user->alias) ?></p>
            <h6 class="subheader"><?= __('Mobile') ?></h6>
            <p><?= h($user->mobile) ?></p>
            <h6 class="subheader"><?= __('Birthday') ?></h6>
            <p><?= h($user->birthday) ?></p>
            <h6 class="subheader"><?= __('User') ?></h6>
            <p><?= $user->has('user') ? $this->Html->link($user->user->alias, ['controller' => 'Users', 'action' => 'view', $user->user->id]) : '' ?></p>
            <h6 class="subheader"><?= __('City') ?></h6>
            <p><?= $user->has('city') ? $this->Html->link($user->city->name, ['controller' => 'Cities', 'action' => 'view', $user->city->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Role') ?></h6>
            <p><?= $user->has('role') ? $this->Html->link($user->role->name, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($user->id) ?></p>
            <h6 class="subheader"><?= __('Status') ?></h6>
            <p><?= $this->Number->format($user->status) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($user->created) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Activation Keys') ?></h4>
    <?php if (!empty($user->activation_keys)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Activation Key') ?></th>
            <th><?= __('Created') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->activation_keys as $activationKeys): ?>
        <tr>
            <td><?= h($activationKeys->id) ?></td>
            <td><?= h($activationKeys->user_id) ?></td>
            <td><?= h($activationKeys->activation_key) ?></td>
            <td><?= h($activationKeys->created) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ActivationKeys', 'action' => 'view', $activationKeys->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ActivationKeys', 'action' => 'edit', $activationKeys->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ActivationKeys', 'action' => 'delete', $activationKeys->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activationKeys->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related User Accounts') ?></h4>
    <?php if (!empty($user->user_accounts)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Amount') ?></th>
            <th><?= __('Account Description Id') ?></th>
            <th><?= __('Balance') ?></th>
            <th><?= __('Created') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->user_accounts as $userAccounts): ?>
        <tr>
            <td><?= h($userAccounts->id) ?></td>
            <td><?= h($userAccounts->user_id) ?></td>
            <td><?= h($userAccounts->amount) ?></td>
            <td><?= h($userAccounts->account_description_id) ?></td>
            <td><?= h($userAccounts->balance) ?></td>
            <td><?= h($userAccounts->created) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserAccounts', 'action' => 'view', $userAccounts->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserAccounts', 'action' => 'edit', $userAccounts->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserAccounts', 'action' => 'delete', $userAccounts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccounts->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related User Logins') ?></h4>
    <?php if (!empty($user->user_logins)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('User Id') ?></th>
            <th><?= __('Login Date') ?></th>
            <th><?= __('Logout Date') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->user_logins as $userLogins): ?>
        <tr>
            <td><?= h($userLogins->id) ?></td>
            <td><?= h($userLogins->user_id) ?></td>
            <td><?= h($userLogins->login_date) ?></td>
            <td><?= h($userLogins->logout_date) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'UserLogins', 'action' => 'view', $userLogins->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'UserLogins', 'action' => 'edit', $userLogins->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserLogins', 'action' => 'delete', $userLogins->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userLogins->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related Banks') ?></h4>
    <?php if (!empty($user->banks)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Name') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($user->banks as $banks): ?>
        <tr>
            <td><?= h($banks->id) ?></td>
            <td><?= h($banks->name) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'Banks', 'action' => 'view', $banks->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'Banks', 'action' => 'edit', $banks->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Banks', 'action' => 'delete', $banks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $banks->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
