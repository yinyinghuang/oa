<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Follow Data'), ['action' => 'edit', $followData->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Follow Data'), ['action' => 'delete', $followData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $followData->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Follow Datas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Follow Data'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="followDatas view large-9 medium-8 columns content">
    <h3><?= h($followData->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Account') ?></th>
            <td><?= $followData->has('account') ? $this->Html->link($followData->account->name, ['controller' => 'Accounts', 'action' => 'view', $followData->account->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($followData->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Followed') ?></th>
            <td><?= $this->Number->format($followData->followed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unfollowed') ?></th>
            <td><?= $this->Number->format($followData->unfollowed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($followData->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($followData->date) ?></td>
        </tr>
    </table>
</div>
