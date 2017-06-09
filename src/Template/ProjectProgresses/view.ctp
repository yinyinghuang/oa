<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Project Progress'), ['action' => 'edit', $projectProgress->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Project Progress'), ['action' => 'delete', $projectProgress->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectProgress->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Project Progresses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Progress'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projectProgresses view large-9 medium-8 columns content">
    <h3><?= h($projectProgress->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Project Schedule') ?></th>
            <td><?= $projectProgress->has('project_schedule') ? $this->Html->link($projectProgress->project_schedule->title, ['controller' => 'ProjectSchedules', 'action' => 'view', $projectProgress->project_schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($projectProgress->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Content') ?></th>
            <td><?= $this->Number->format($projectProgress->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Progress') ?></th>
            <td><?= $this->Number->format($projectProgress->progress) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($projectProgress->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($projectProgress->modified) ?></td>
        </tr>
    </table>
</div>
