<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Privilege'), ['action' => 'edit', $privilege->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Privilege'), ['action' => 'delete', $privilege->id], ['confirm' => __('Are you sure you want to delete # {0}?', $privilege->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Privileges'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Privilege'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="privileges view large-9 medium-8 columns content">
    <h3><?= h($privilege->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($privilege->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Who') ?></th>
            <td><?= $this->Number->format($privilege->who) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $this->Number->format($privilege->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('What') ?></th>
            <td><?= $this->Number->format($privilege->what) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('How') ?></th>
            <td><?= $this->Number->format($privilege->how) ?></td>
        </tr>
    </table>
</div>
