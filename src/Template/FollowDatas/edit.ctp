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
                ['action' => 'delete', $followData->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $followData->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Follow Datas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="followDatas form large-9 medium-8 columns content">
    <?= $this->Form->create($followData) ?>
    <fieldset>
        <legend><?= __('Edit Follow Data') ?></legend>
        <?php
            echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
            echo $this->Form->control('date');
            echo $this->Form->control('followed');
            echo $this->Form->control('unfollowed');
            echo $this->Form->control('total');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
