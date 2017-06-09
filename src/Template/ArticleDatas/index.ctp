<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Article Data'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articleDatas index large-9 medium-8 columns content">
    <h3><?= __('Article Datas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('account_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('level') ?></th>
                <th scope="col"><?= $this->Paginator->sort('hits') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sharing_times') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articleDatas as $articleData): ?>
            <tr>
                <td><?= $this->Number->format($articleData->id) ?></td>
                <td><?= $articleData->has('account') ? $this->Html->link($articleData->account->name, ['controller' => 'Accounts', 'action' => 'view', $articleData->account->id]) : '' ?></td>
                <td><?= h($articleData->date) ?></td>
                <td><?= h($articleData->title) ?></td>
                <td><?= h($articleData->level) ?></td>
                <td><?= $this->Number->format($articleData->hits) ?></td>
                <td><?= $this->Number->format($articleData->sharing_times) ?></td>
                <td><?= $articleData->has('user') ? $this->Html->link($articleData->user->id, ['controller' => 'Users', 'action' => 'view', $articleData->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $articleData->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $articleData->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $articleData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleData->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
