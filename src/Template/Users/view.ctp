<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-10 medium-9 columns content">
    <h3><?= h($user->username) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <?php foreach ($user->user_department_roles as $key => $position): ?>
        <tr>
            <th scope="row">部门<?= $key + 1 ?></th>
            <td><?= $position->department['name'] . $position->role['name'] ?></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <th scope="row"><?= __('Telephone') ?></th>
            <td><?= h($user->telephone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gender') ?></th>
            <td><?= $user->gender ? __('女') : __('男'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $user->state ? __('在职') : __('离职'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Customers') ?></h4>
        <?php if (!empty($user->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Customer Category Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Company') ?></th>
                <th scope="col"><?= __('Country Code') ?></th>
                <th scope="col"><?= __('Mobile') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Position') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->customer_category_id) ?></td>
                <td><?= h($customers->name) ?></td>
                <td><?= h($customers->company) ?></td>
                <td><?= h($customers->country_code) ?></td>
                <td><?= h($customers->mobile) ?></td>
                <td><?= h($customers->email) ?></td>
                <td><?= h($customers->position) ?></td>
                <td><?= h($customers->user_id) ?></td>
                <td><?= h($customers->created) ?></td>
                <td><?= h($customers->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Dropboxes') ?></h4>
        <?php if (!empty($user->dropboxes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('File Id') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->dropboxes as $dropboxes): ?>
            <tr>
                <td><?= h($dropboxes->id) ?></td>
                <td><?= h($dropboxes->file_id) ?></td>
                <td><?= h($dropboxes->size) ?></td>
                <td><?= h($dropboxes->type) ?></td>
                <td><?= h($dropboxes->user_id) ?></td>
                <td><?= h($dropboxes->created) ?></td>
                <td><?= h($dropboxes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Dropboxes', 'action' => 'view', $dropboxes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Dropboxes', 'action' => 'edit', $dropboxes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Dropboxes', 'action' => 'delete', $dropboxes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dropboxes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Finances') ?></h4>
        <?php if (!empty($user->finances)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Detail') ?></th>
                <th scope="col"><?= __('Payee') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Receipt') ?></th>
                <th scope="col"><?= __('Customer Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->finances as $finances): ?>
            <tr>
                <td><?= h($finances->id) ?></td>
                <td><?= h($finances->user_id) ?></td>
                <td><?= h($finances->amount) ?></td>
                <td><?= h($finances->detail) ?></td>
                <td><?= h($finances->payee) ?></td>
                <td><?= h($finances->type) ?></td>
                <td><?= h($finances->receipt) ?></td>
                <td><?= h($finances->customer_id) ?></td>
                <td><?= h($finances->created) ?></td>
                <td><?= h($finances->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Finances', 'action' => 'view', $finances->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Finances', 'action' => 'edit', $finances->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Finances', 'action' => 'delete', $finances->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finances->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Issue Solutions') ?></h4>
        <?php if (!empty($user->project_issue_solutions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Issues Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Solution') ?></th>
                <th scope="col"><?= __('Attachment') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->project_issue_solutions as $projectIssueSolutions): ?>
            <tr>
                <td><?= h($projectIssueSolutions->id) ?></td>
                <td><?= h($projectIssueSolutions->task_id) ?></td>
                <td><?= h($projectIssueSolutions->project_issues_id) ?></td>
                <td><?= h($projectIssueSolutions->user_id) ?></td>
                <td><?= h($projectIssueSolutions->solution) ?></td>
                <td><?= h($projectIssueSolutions->attachment) ?></td>
                <td><?= h($projectIssueSolutions->created) ?></td>
                <td><?= h($projectIssueSolutions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectIssueSolutions', 'action' => 'view', $projectIssueSolutions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectIssueSolutions', 'action' => 'edit', $projectIssueSolutions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectIssueSolutions', 'action' => 'delete', $projectIssueSolutions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssueSolutions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Issues') ?></h4>
        <?php if (!empty($user->project_issues)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Schedule Id') ?></th>
                <th scope="col"><?= __('Issue') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Project Issue Solution Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->project_issues as $projectIssues): ?>
            <tr>
                <td><?= h($projectIssues->id) ?></td>
                <td><?= h($projectIssues->task_id) ?></td>
                <td><?= h($projectIssues->project_schedule_id) ?></td>
                <td><?= h($projectIssues->issue) ?></td>
                <td><?= h($projectIssues->user_id) ?></td>
                <td><?= h($projectIssues->state) ?></td>
                <td><?= h($projectIssues->project_issue_solution_id) ?></td>
                <td><?= h($projectIssues->created) ?></td>
                <td><?= h($projectIssues->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectIssues', 'action' => 'view', $projectIssues->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectIssues', 'action' => 'edit', $projectIssues->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectIssues', 'action' => 'delete', $projectIssues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssues->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Schedules') ?></h4>
        <?php if (!empty($user->project_schedules)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Breif') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('End Time') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->project_schedules as $projectSchedules): ?>
            <tr>
                <td><?= h($projectSchedules->id) ?></td>
                <td><?= h($projectSchedules->task_id) ?></td>
                <td><?= h($projectSchedules->project_id) ?></td>
                <td><?= h($projectSchedules->title) ?></td>
                <td><?= h($projectSchedules->breif) ?></td>
                <td><?= h($projectSchedules->user_id) ?></td>
                <td><?= h($projectSchedules->state) ?></td>
                <td><?= h($projectSchedules->start_time) ?></td>
                <td><?= h($projectSchedules->end_time) ?></td>
                <td><?= h($projectSchedules->created) ?></td>
                <td><?= h($projectSchedules->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectSchedules', 'action' => 'view', $projectSchedules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectSchedules', 'action' => 'edit', $projectSchedules->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectSchedules', 'action' => 'delete', $projectSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedules->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($user->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Participants') ?></th>
                <th scope="col"><?= __('Brief') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->task_id) ?></td>
                <td><?= h($projects->title) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->participants) ?></td>
                <td><?= h($projects->brief) ?></td>
                <td><?= h($projects->state) ?></td>
                <td><?= h($projects->start_date) ?></td>
                <td><?= h($projects->end_date) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Tasks') ?></h4>
        <?php if (!empty($user->tasks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Controller') ?></th>
                <th scope="col"><?= __('C Id') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('End Time') ?></th>
                <th scope="col"><?= __('Remind') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->tasks as $tasks): ?>
            <tr>
                <td><?= h($tasks->id) ?></td>
                <td><?= h($tasks->user_id) ?></td>
                <td><?= h($tasks->controller) ?></td>
                <td><?= h($tasks->c_id) ?></td>
                <td><?= h($tasks->start_time) ?></td>
                <td><?= h($tasks->end_time) ?></td>
                <td><?= h($tasks->remind) ?></td>
                <td><?= h($tasks->state) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tasks', 'action' => 'view', $tasks->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tasks', 'action' => 'edit', $tasks->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tasks', 'action' => 'delete', $tasks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tasks->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<div class="clearfix"></div>