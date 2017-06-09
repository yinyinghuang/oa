<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project Issue Solution'), ['action' => 'edit', $projectIssueSolution->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project Issue Solution'), ['action' => 'delete', $projectIssueSolution->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssueSolution->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Issues'), ['controller' => 'ProjectIssues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue'), ['controller' => 'ProjectIssues', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectIssueSolutions view large-9 medium-8 columns content">
    <h3><?= h($projectIssueSolution->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Task') ?></th>
            <td><?= $projectIssueSolution->has('task') ? $this->Html->link($projectIssueSolution->task->id, ['controller' => 'Tasks', 'action' => 'view', $projectIssueSolution->task->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $projectIssueSolution->has('user') ? $this->Html->link($projectIssueSolution->user->id, ['controller' => 'Users', 'action' => 'view', $projectIssueSolution->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Solution') ?></th>
            <td><?= h($projectIssueSolution->solution) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Attachment') ?></th>
            <td><?= h($projectIssueSolution->attachment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectIssueSolution->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Project Issues Id') ?></th>
            <td><?= $this->Number->format($projectIssueSolution->project_issues_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($projectIssueSolution->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($projectIssueSolution->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Project Issues') ?></h4>
        <?php if (!empty($projectIssueSolution->project_issues)): ?>
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
            <?php foreach ($projectIssueSolution->project_issues as $projectIssues): ?>
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
</div>
