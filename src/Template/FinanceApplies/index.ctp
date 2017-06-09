<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Finance Apply'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="financeApplies index large-9 medium-8 columns content">
    <h3><?= __('Finance Applies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('task_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('approver') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($financeApplies as $financeApply): ?>
            <tr>
                <td><?= $this->Number->format($financeApply->id) ?></td>
                <td><?= $this->Number->format($financeApply->task_id) ?></td>
                <td><?= $financeApply->has('user') ? $this->Html->link($financeApply->user->username, ['controller' => 'Users', 'action' => 'view', $financeApply->user->id]) : '' ?></td>
                <td><?= $this->Number->format($financeApply->approver) ?></td>
                <td><?= $this->Number->format($financeApply->amount) ?></td>
                <td><?= h($financeApply->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $financeApply->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $financeApply->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $financeApply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeApply->id)]) ?>
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
