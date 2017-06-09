<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $financeType->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $financeType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeType->id)]) ?> </li>
        <li><?= $this->Html->link(__('交易方式列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="financeTypes view large-10 medium-9 columns content">
    <h3><?= h($financeType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('名称') ?></th>
            <td><?= h($financeType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($financeType->id) ?></td>
        </tr>
    </table>
</div>
