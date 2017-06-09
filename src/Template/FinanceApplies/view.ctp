<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Finance Apply'), ['action' => 'edit', $financeApply->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Finance Apply'), ['action' => 'delete', $financeApply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeApply->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Finance Applies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Finance Apply'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financeApplies view large-9 medium-8 columns content">
    <h3><?= h($financeApply->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $financeApply->has('user') ? $this->Html->link($financeApply->user->username, ['controller' => 'Users', 'action' => 'view', $financeApply->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($financeApply->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Task Id') ?></th>
            <td><?= $this->Number->format($financeApply->task_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approver') ?></th>
            <td><?= $this->Number->format($financeApply->approver) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($financeApply->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($financeApply->created) ?></td>
        </tr>
    </table>
</div>
