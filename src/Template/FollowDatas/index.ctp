<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Follow Data'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Accounts'), ['controller' => 'Accounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Account'), ['controller' => 'Accounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="followDatas index large-9 medium-8 columns content">
    <h3><?= __('Follow Datas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('account_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('followed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unfollowed') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($followDatas as $followData): ?>
            <tr>
                <td><?= $this->Number->format($followData->id) ?></td>
                <td><?= $followData->has('account') ? $this->Html->link($followData->account->name, ['controller' => 'Accounts', 'action' => 'view', $followData->account->id]) : '' ?></td>
                <td><?= h($followData->date) ?></td>
                <td><?= $this->Number->format($followData->followed) ?></td>
                <td><?= $this->Number->format($followData->unfollowed) ?></td>
                <td><?= $this->Number->format($followData->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $followData->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $followData->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $followData->id], ['confirm' => __('Are you sure you want to delete # {0}?', $followData->id)]) ?>
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
