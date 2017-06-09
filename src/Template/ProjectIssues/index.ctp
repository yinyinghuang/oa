<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project Issue'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['controller' => 'ProjectIssueSolutions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['controller' => 'ProjectIssueSolutions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectIssues index large-9 medium-8 columns content">
    <h3><?= __('Project Issues') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('task_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('issue') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_issue_solution_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectIssues as $projectIssue): ?>
            <tr>
                <td><?= $this->Number->format($projectIssue->id) ?></td>
                <td><?= $projectIssue->has('task') ? $this->Html->link($projectIssue->task->id, ['controller' => 'Tasks', 'action' => 'view', $projectIssue->task->id]) : '' ?></td>
                <td><?= $projectIssue->has('project_schedule') ? $this->Html->link($projectIssue->project_schedule->title, ['controller' => 'ProjectSchedules', 'action' => 'view', $projectIssue->project_schedule->id]) : '' ?></td>
                <td><?= h($projectIssue->issue) ?></td>
                <td><?= $projectIssue->has('user') ? $this->Html->link($projectIssue->user->id, ['controller' => 'Users', 'action' => 'view', $projectIssue->user->id]) : '' ?></td>
                <td><?= $this->Number->format($projectIssue->state) ?></td>
                <td><?= $projectIssue->has('project_issue_solution') ? $this->Html->link($projectIssue->project_issue_solution->id, ['controller' => 'ProjectIssueSolutions', 'action' => 'view', $projectIssue->project_issue_solution->id]) : '' ?></td>
                <td><?= h($projectIssue->created) ?></td>
                <td><?= h($projectIssue->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projectIssue->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectIssue->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectIssue->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssue->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
