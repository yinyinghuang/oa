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
                ['action' => 'delete', $projectProgress->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectProgress->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Project Progresses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projectProgresses form large-9 medium-8 columns content">
    <?= $this->Form->create($projectProgress) ?>
    <fieldset>
        <legend><?= __('Edit Project Progress') ?></legend>
        <?php
            echo $this->Form->control('project_schedule_id', ['options' => $projectSchedules]);
            echo $this->Form->control('content');
            echo $this->Form->control('progress');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
