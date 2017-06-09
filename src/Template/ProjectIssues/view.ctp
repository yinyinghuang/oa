<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project Issue'), ['action' => 'edit', $projectIssue->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project Issue'), ['action' => 'delete', $projectIssue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssue->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Project Issues'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['controller' => 'ProjectIssueSolutions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['controller' => 'ProjectIssueSolutions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectIssues view large-9 medium-8 columns content">
    <h3><?= h($projectIssue->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Task') ?></th>
            <td><?= $projectIssue->has('task') ? $this->Html->link($projectIssue->task->id, ['controller' => 'Tasks', 'action' => 'view', $projectIssue->task->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Project Schedule') ?></th>
            <td><?= $projectIssue->has('project_schedule') ? $this->Html->link($projectIssue->project_schedule->title, ['controller' => 'ProjectSchedules', 'action' => 'view', $projectIssue->project_schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Issue') ?></th>
            <td><?= h($projectIssue->issue) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $projectIssue->has('user') ? $this->Html->link($projectIssue->user->id, ['controller' => 'Users', 'action' => 'view', $projectIssue->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Project Issue Solution') ?></th>
            <td><?= $projectIssue->has('project_issue_solution') ? $this->Html->link($projectIssue->project_issue_solution->id, ['controller' => 'ProjectIssueSolutions', 'action' => 'view', $projectIssue->project_issue_solution->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectIssue->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $this->Number->format($projectIssue->state) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($projectIssue->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($projectIssue->modified) ?></td>
        </tr>
    </table>
</div>
