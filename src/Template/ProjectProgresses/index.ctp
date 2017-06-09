<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Project Progress'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectProgresses index large-9 medium-8 columns content">
    <h3><?= __('Project Progresses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('project_schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content') ?></th>
                <th scope="col"><?= $this->Paginator->sort('progress') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectProgresses as $projectProgress): ?>
            <tr>
                <td><?= $this->Number->format($projectProgress->id) ?></td>
                <td><?= $projectProgress->has('project_schedule') ? $this->Html->link($projectProgress->project_schedule->title, ['controller' => 'ProjectSchedules', 'action' => 'view', $projectProgress->project_schedule->id]) : '' ?></td>
                <td><?= $this->Number->format($projectProgress->content) ?></td>
                <td><?= $this->Number->format($projectProgress->progress) ?></td>
                <td><?= h($projectProgress->created) ?></td>
                <td><?= h($projectProgress->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projectProgress->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectProgress->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectProgress->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectProgress->id)]) ?>
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
