<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('发送短信'), ['action' => 'sms', $customerCategory->id]) ?></li>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $customerCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $customerCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('分类列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customerCategories view large-10 medium-9 columns content">
    <h3><?= h($customerCategory->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('名称') ?></th>
            <td><?= h($customerCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('上级分类') ?></th>
            <td><?= $customerCategory->has('parent_customer_category') ? $this->Html->link($customerCategory->parent_customer_category->name, ['controller' => 'CustomerCategories', 'action' => 'view', $customerCategory->parent_customer_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerCategory->id) ?></td>
        </tr>
        <?php foreach ($customerCategory->customer_category_options as $k => $option): ?>
        <tr><td colspan="2" class="text-center"><?= __('字段' . ($k+1))?></td></tr>
        <tr>
            <th scope="row"><?= __('字段名称') ?></th>
            <td><?= $option->name ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('类型') ?></th>
            <td><?= $typeArr[$option->type] ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('内容') ?></th>
            <td><?= $option->value ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('必填') ?></th>
            <td><?= $option->required ? __('是') : __('否') ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('首页可见栏位') ?></th>
            <td><?= $option->font ? __('是') : __('否') ?></td>
        </tr> 
        <tr>
            <th scope="row"><?= __('搜索栏可见') ?></th>
            <td><?= $option->searchable ? __('是') : __('否') ?></td>
        </tr>  

        <?php endforeach ?>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($customerCategory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新时间') ?></th>
            <td><?= h($customerCategory->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('相关客户') ?></h4>
        <?php if (!empty($customerCategory->customers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('姓名') ?></th>
                <th scope="col" class="visible-lg"><?= __('公司') ?></th>
                <th scope="col"><?= __('手机') ?></th>
                <th scope="col"><?= __('电邮') ?></th>
                <th scope="col" class="visible-lg"><?= __('职位') ?></th>
                <th scope="col" class="visible-lg"><?= __('更新时间') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($customerCategory->customers as $customers): ?>
            <tr>
                <td><?= h($customers->id) ?></td>
                <td><?= h($customers->name) ?></td>
                <td class="visible-lg"><?= h($customers->company) ?></td>
                <td><a href="tel:<?= '+' . $customers->country_code . '-' .$customers->mobile ?>"><?= '+' . $customers->country_code . '-' .$customers->mobile ?></a></td>
                <td><?= h($customers->email) ?></td>
                <td class="visible-lg"><?= h($customers->position) ?></td>
                <td class="visible-lg"><?= h($customers->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
