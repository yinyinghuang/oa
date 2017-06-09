<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dropbox->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dropbox->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Dropboxes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="dropboxes form large-9 medium-8 columns content">
    <?= $this->Form->create($dropbox) ?>
    <fieldset>
        <legend><?= __('Edit Dropbox') ?></legend>
        <?php
            echo $this->Form->control('file_id', ['options' => $files]);
            echo $this->Form->control('size');
            echo $this->Form->control('type');
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
