<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Project Issues'), ['action' => 'index']) ?></li>
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
<div class="projectIssues form large-9 medium-8 columns content">
    <?= $this->Form->create($projectIssue) ?>
    <fieldset>
        <legend><?= __('Add Project Issue') ?></legend>
        <?php
            echo $this->Form->control('task_id', ['options' => $tasks]);
            echo $this->Form->control('project_schedule_id', ['options' => $projectSchedules]);
            echo $this->Form->control('issue');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('state');
            echo $this->Form->control('project_issue_solution_id', ['options' => $projectIssueSolutions]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
