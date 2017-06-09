<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Article Data'), ['action' => 'edit', $articleData->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Article Data'), ['action' => 'delete', $articleData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleData->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Article Datas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article Data'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="articleDatas view large-9 medium-8 columns content">
    <h3><?= h($articleData->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Account') ?></th>
            <td><?= $articleData->has('account') ? $this->Html->link($articleData->account->name, ['controller' => 'Accounts', 'action' => 'view', $articleData->account->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($articleData->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $articleData->has('user') ? $this->Html->link($articleData->user->id, ['controller' => 'Users', 'action' => 'view', $articleData->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($articleData->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hits') ?></th>
            <td><?= $this->Number->format($articleData->hits) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sharing Times') ?></th>
            <td><?= $this->Number->format($articleData->sharing_times) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($articleData->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Level') ?></th>
            <td><?= $articleData->level ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
