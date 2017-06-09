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
                ['action' => 'delete', $financeApply->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $financeApply->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Finance Applies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="financeApplies form large-9 medium-8 columns content">
    <?= $this->Form->create($financeApply) ?>
    <fieldset>
        <legend><?= __('Edit Finance Apply') ?></legend>
        <?php
            echo $this->Form->control('task_id');
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('approver');
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
