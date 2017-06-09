<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Department'), ['action' => 'edit', $department->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Department'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete # {0}?', $department->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Departments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="departments view large-9 medium-8 columns content">
    <h3><?= h($department->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($department->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Department') ?></th>
            <td><?= $department->has('parent_department') ? $this->Html->link($department->parent_department->name, ['controller' => 'Departments', 'action' => 'view', $department->parent_department->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($department->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($department->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($department->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($department->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related User') ?></h4>
        <?php if (!empty($department->user_department_roles)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User') ?></th>
                <th scope="col"><?= __('Role') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($department->user_department_roles as $userDepartmentRoles): ?>
            <tr>
                <td><?= h($userDepartmentRoles->user_id) ?></td>
                <td><?= h($userDepartmentRoles->user['username']) ?></td>
                <td><?= h($userDepartmentRoles->role['name']) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserDepartmentRoles', 'action' => 'view', $userDepartmentRoles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserDepartmentRoles', 'action' => 'edit', $userDepartmentRoles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserDepartmentRoles', 'action' => 'delete', $userDepartmentRoles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userDepartmentRoles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
