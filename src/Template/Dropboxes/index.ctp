<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Dropbox'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dropboxes index large-9 medium-8 columns content">
    <h3><?= __('Dropboxes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('size') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dropboxes as $dropbox): ?>
            <tr>
                <td><?= $this->Number->format($dropbox->id) ?></td>
                <td><?= $dropbox->has('file') ? $this->Html->link($dropbox->file->id, ['controller' => 'Files', 'action' => 'view', $dropbox->file->id]) : '' ?></td>
                <td><?= $this->Number->format($dropbox->size) ?></td>
                <td><?= h($dropbox->type) ?></td>
                <td><?= $dropbox->has('user') ? $this->Html->link($dropbox->user->id, ['controller' => 'Users', 'action' => 'view', $dropbox->user->id]) : '' ?></td>
                <td><?= h($dropbox->created) ?></td>
                <td><?= h($dropbox->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $dropbox->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dropbox->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dropbox->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dropbox->id)]) ?>
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
