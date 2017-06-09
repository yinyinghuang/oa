<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Article Datas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articleDatas form large-9 medium-8 columns content">
    <?= $this->Form->create($articleData) ?>
    <fieldset>
        <legend><?= __('Add Article Data') ?></legend>
        <?php
            echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => true]);
            echo $this->Form->control('date');
            echo $this->Form->control('title');
            echo $this->Form->control('level');
            echo $this->Form->control('hits');
            echo $this->Form->control('sharing_times');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
