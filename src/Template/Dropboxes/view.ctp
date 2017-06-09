<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Dropbox'), ['action' => 'edit', $dropbox->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Dropbox'), ['action' => 'delete', $dropbox->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dropbox->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Dropboxes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dropbox'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="dropboxes view large-9 medium-8 columns content">
    <h3><?= h($dropbox->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td><?= $dropbox->has('file') ? $this->Html->link($dropbox->file->id, ['controller' => 'Files', 'action' => 'view', $dropbox->file->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($dropbox->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $dropbox->has('user') ? $this->Html->link($dropbox->user->id, ['controller' => 'Users', 'action' => 'view', $dropbox->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($dropbox->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size') ?></th>
            <td><?= $this->Number->format($dropbox->size) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($dropbox->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($dropbox->modified) ?></td>
        </tr>
    </table>
</div>
