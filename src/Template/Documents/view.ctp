<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Documents'), ['controller' => 'Documents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Document'), ['controller' => 'Documents', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="documents view large-9 medium-8 columns content">
    <h3><?= h($document->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $document->has('user') ? $this->Html->link($document->user->username, ['controller' => 'Users', 'action' => 'view', $document->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Spell') ?></th>
            <td><?= h($document->spell) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Origin Name') ?></th>
            <td><?= h($document->origin_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($document->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ext') ?></th>
            <td><?= h($document->ext) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Document') ?></th>
            <td><?= $document->has('parent_document') ? $this->Html->link($document->parent_document->name, ['controller' => 'Documents', 'action' => 'view', $document->parent_document->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($document->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Size') ?></th>
            <td><?= $this->Number->format($document->size) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ord') ?></th>
            <td><?= $this->Number->format($document->ord) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Level') ?></th>
            <td><?= $this->Number->format($document->level) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($document->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($document->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($document->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($document->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Dir') ?></th>
            <td><?= $document->is_dir ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deleted') ?></th>
            <td><?= $document->deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Documents') ?></h4>
        <?php if (!empty($document->child_documents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Spell') ?></th>
                <th scope="col"><?= __('Origin Name') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Size') ?></th>
                <th scope="col"><?= __('Ext') ?></th>
                <th scope="col"><?= __('Is Dir') ?></th>
                <th scope="col"><?= __('Ord') ?></th>
                <th scope="col"><?= __('Level') ?></th>
                <th scope="col"><?= __('Parent Id') ?></th>
                <th scope="col"><?= __('Lft') ?></th>
                <th scope="col"><?= __('Rght') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($document->child_documents as $childDocuments): ?>
            <tr>
                <td><?= h($childDocuments->id) ?></td>
                <td><?= h($childDocuments->user_id) ?></td>
                <td><?= h($childDocuments->spell) ?></td>
                <td><?= h($childDocuments->origin_name) ?></td>
                <td><?= h($childDocuments->name) ?></td>
                <td><?= h($childDocuments->size) ?></td>
                <td><?= h($childDocuments->ext) ?></td>
                <td><?= h($childDocuments->is_dir) ?></td>
                <td><?= h($childDocuments->ord) ?></td>
                <td><?= h($childDocuments->level) ?></td>
                <td><?= h($childDocuments->parent_id) ?></td>
                <td><?= h($childDocuments->lft) ?></td>
                <td><?= h($childDocuments->rght) ?></td>
                <td><?= h($childDocuments->deleted) ?></td>
                <td><?= h($childDocuments->created) ?></td>
                <td><?= h($childDocuments->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $childDocuments->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Documents', 'action' => 'edit', $childDocuments->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Documents', 'action' => 'delete', $childDocuments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childDocuments->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
