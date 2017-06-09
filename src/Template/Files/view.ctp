<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit File'), ['action' => 'edit', $file->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete File'), ['action' => 'delete', $file->id], ['confirm' => __('Are you sure you want to delete # {0}?', $file->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Files'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New File'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Files'), ['controller' => 'Files', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent File'), ['controller' => 'Files', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Dropboxes'), ['controller' => 'Dropboxes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Dropbox'), ['controller' => 'Dropboxes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="files view large-9 medium-8 columns content">
    <h3><?= h($file->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Path') ?></th>
            <td><?= h($file->path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Auth') ?></th>
            <td><?= h($file->auth) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent File') ?></th>
            <td><?= $file->has('parent_file') ? $this->Html->link($file->parent_file->id, ['controller' => 'Files', 'action' => 'view', $file->parent_file->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($file->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($file->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($file->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($file->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($file->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Dropboxes') ?></h4>
        <?php if (!empty($file->dropboxes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('File Id') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($file->dropboxes as $dropboxes): ?>
            <tr>
                <td><?= h($dropboxes->id) ?></td>
                <td><?= h($dropboxes->file_id) ?></td>
                <td><?= h($dropboxes->size) ?></td>
                <td><?= h($dropboxes->type) ?></td>
                <td><?= h($dropboxes->user_id) ?></td>
                <td><?= h($dropboxes->created) ?></td>
                <td><?= h($dropboxes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Dropboxes', 'action' => 'view', $dropboxes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Dropboxes', 'action' => 'edit', $dropboxes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Dropboxes', 'action' => 'delete', $dropboxes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dropboxes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Files') ?></h4>
        <?php if (!empty($file->child_files)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Path') ?></th>
                <th scope="col"><?= __('Auth') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($file->child_files as $childFiles): ?>
            <tr>
                <td><?= h($childFiles->id) ?></td>
                <td><?= h($childFiles->path) ?></td>
                <td><?= h($childFiles->auth) ?></td>
                <td><?= h($childFiles->parent_id) ?></td>
                <td><?= h($childFiles->lft) ?></td>
                <td><?= h($childFiles->rght) ?></td>
                <td><?= h($childFiles->created) ?></td>
                <td><?= h($childFiles->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Files', 'action' => 'view', $childFiles->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Files', 'action' => 'edit', $childFiles->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Files', 'action' => 'delete', $childFiles->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childFiles->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
