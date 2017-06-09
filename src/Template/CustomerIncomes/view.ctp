<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $customerIncome->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $customerIncome->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerIncome->id)]) ?> </li>
        <li><?= $this->Html->link(__('收益列表'), ['action' => 'index', $customerIncome->customer_id]) ?> </li>
        <li><?= $this->Html->link(__('新增'), ['action' => 'add',$customerIncome->customer_id]) ?> </li>
        
    </ul>
</nav>
<div class="customerIncomes view large-10 medium-9 columns content">
    <h3><?= h($customerIncome->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('客户') ?></th>
            <td><?= $customerIncome->has('customer') ? $this->Html->link($customerIncome->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerIncome->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('明细') ?></th>
            <td><?= h($customerIncome->detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('交易方式') ?></th>
            <td><?= h($customerIncome->finance_type['name']) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('凭证') ?></th>
            <td><?= $customerIncome->receipt ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('业务员') ?></th>
            <td><?= $customerIncome->has('user') ? $this->Html->link($customerIncome->user->username, ['controller' => 'Users', 'action' => 'view', $customerIncome->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerIncome->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('金额') ?></th>
            <td><?= $this->Number->format($customerIncome->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($customerIncome->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新时间') ?></th>
            <td><?= h($customerIncome->modified) ?></td>
        </tr>
    </table>
</div>
<div class="clearfix"></div>