<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="customerBusinesses view large-12 medium-12 columns content">
    <h3><?= h($customerBusiness->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('客户') ?></th>
            <td><?= $customerBusiness->has('customer') ? $this->Html->link($customerBusiness->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerBusiness->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('业务员') ?></th>
            <td><?= $customerBusiness->has('user') ? $this->Html->link($customerBusiness->user->username, ['controller' => 'Users', 'action' => 'view', $customerBusiness->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('内容') ?></th>
            <td><?= h($customerBusiness->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerBusiness->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('开始时间') ?></th>
            <td><?= h($customerBusiness->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('结束时间') ?></th>
            <td><?= h($customerBusiness->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($customerBusiness->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新时间') ?></th>
            <td><?= h($customerBusiness->modified) ?></td>
        </tr>
    </table>
</div>
<div class="clearfix"></div>