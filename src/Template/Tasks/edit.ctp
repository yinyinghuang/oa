<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $task->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Finance Applies'), ['controller' => 'FinanceApplies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Finance Apply'), ['controller' => 'FinanceApplies', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['controller' => 'ProjectIssueSolutions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['controller' => 'ProjectIssueSolutions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Issues'), ['controller' => 'ProjectIssues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Issue'), ['controller' => 'ProjectIssues', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Progresses'), ['controller' => 'ProjectProgresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Progress'), ['controller' => 'ProjectProgresses', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tasks form large-9 medium-8 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __('Edit Task') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('controller');
            echo $this->Form->control('itemid');
            echo $this->Form->control('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
