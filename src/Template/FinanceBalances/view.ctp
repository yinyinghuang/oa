<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Finance Balance'), ['action' => 'edit', $financeBalance->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Finance Balance'), ['action' => 'delete', $financeBalance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeBalance->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Finance Balances'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Finance Balance'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financeBalances view large-9 medium-8 columns content">
    <h3><?= h($financeBalance->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $financeBalance->has('user') ? $this->Html->link($financeBalance->user->username, ['controller' => 'Users', 'action' => 'view', $financeBalance->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($financeBalance->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Balance') ?></th>
            <td><?= $this->Number->format($financeBalance->balance) ?></td>
        </tr>
    </table>
</div>
