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
                ['action' => 'delete', $account->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Article Datas'), ['controller' => 'ArticleDatas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article Data'), ['controller' => 'ArticleDatas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Follow Datas'), ['controller' => 'FollowDatas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Follow Data'), ['controller' => 'FollowDatas', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="accounts form large-9 medium-8 columns content">
    <?= $this->Form->create($account) ?>
    <fieldset>
        <legend><?= __('Edit Account') ?></legend>
        <?php
            echo $this->Form->control('department_id');
            echo $this->Form->control('name');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
