<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('编辑流水'), ['action' => 'edit', $finance->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除流水'), ['action' => 'delete', $finance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finance->id)]) ?> </li>
        <li><?= $this->Html->link(__('流水列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增流水'), ['action' => 'add']) ?> </li>
        
    </ul>
</nav>
<div class="finances view large-10 medium-9 columns content">
    <h3><?= h($finance->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('经办人') ?></th>
            <td><?= $finance->has('user') ? $this->Html->link($finance->user->username, ['controller' => 'Users', 'action' => 'view', $finance->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('收款人') ?></th>
            <td><?= h($finance->payee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('明细') ?></th>
            <td><?= h($finance->detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('交易方式') ?></th>
            <td><?= $finance->has('finance_type') ? $this->Html->link($finance->finance_type->name, ['controller' => 'FinanceTypes', 'action' => 'view', $finance->finance_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('凭证') ?></th>
            <td><?= $finance->receipt ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($finance->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('金额') ?></th>
            <td><?= $this->Number->format(abs($finance->amount)) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($finance->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新时间') ?></th>
            <td><?= h($finance->modified) ?></td>
        </tr>
    </table>
</div>
<div class="clearfix"></div>