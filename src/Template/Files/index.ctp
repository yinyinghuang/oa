<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New File'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Dropboxes'), ['controller' => 'Dropboxes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Dropbox'), ['controller' => 'Dropboxes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="files index large-9 medium-8 columns content">
    <h3><?= __('Files') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('path') ?></th>
                <th scope="col"><?= $this->Paginator->sort('auth') ?></th>
                <th scope="col"><?= $this->Paginator->sort('parent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): ?>
            <tr>
                <td><?= $this->Number->format($file->id) ?></td>
                <td><?= h($file->path) ?></td>
                <td><?= h($file->auth) ?></td>
                <td><?= $file->has('parent_file') ? $this->Html->link($file->parent_file->id, ['controller' => 'Files', 'action' => 'view', $file->parent_file->id]) : '' ?></td>
                <td><?= h($file->created) ?></td>
                <td><?= h($file->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $file->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $file->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) ?>
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
