<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Issues'), ['controller' => 'ProjectIssues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Issue'), ['controller' => 'ProjectIssues', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectIssueSolutions index large-9 medium-8 columns content">
    <h3><?= __('Project Issue Solutions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('task_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_issues_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('solution') ?></th>
                <th scope="col"><?= $this->Paginator->sort('attachment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectIssueSolutions as $projectIssueSolution): ?>
            <tr>
                <td><?= $this->Number->format($projectIssueSolution->id) ?></td>
                <td><?= $projectIssueSolution->has('task') ? $this->Html->link($projectIssueSolution->task->id, ['controller' => 'Tasks', 'action' => 'view', $projectIssueSolution->task->id]) : '' ?></td>
                <td><?= $this->Number->format($projectIssueSolution->project_issues_id) ?></td>
                <td><?= $projectIssueSolution->has('user') ? $this->Html->link($projectIssueSolution->user->id, ['controller' => 'Users', 'action' => 'view', $projectIssueSolution->user->id]) : '' ?></td>
                <td><?= h($projectIssueSolution->solution) ?></td>
                <td><?= h($projectIssueSolution->attachment) ?></td>
                <td><?= h($projectIssueSolution->created) ?></td>
                <td><?= h($projectIssueSolution->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projectIssueSolution->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectIssueSolution->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectIssueSolution->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssueSolution->id)]) ?>
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
