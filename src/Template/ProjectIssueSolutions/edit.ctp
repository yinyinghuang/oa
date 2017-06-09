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
                ['action' => 'delete', $projectIssueSolution->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssueSolution->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tasks'), ['controller' => 'Tasks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Task'), ['controller' => 'Tasks', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Project Issues'), ['controller' => 'ProjectIssues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Issue'), ['controller' => 'ProjectIssues', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectIssueSolutions form large-9 medium-8 columns content">
    <?= $this->Form->create($projectIssueSolution) ?>
    <fieldset>
        <legend><?= __('Edit Project Issue Solution') ?></legend>
        <?php
            echo $this->Form->control('task_id', ['options' => $tasks]);
            echo $this->Form->control('project_issues_id');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('solution');
            echo $this->Form->control('attachment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
