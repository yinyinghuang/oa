<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新增日志'), ['controller' => 'CustomerBusinesses', 'action' => 'add', $customer->id]) ?> </li>
        <li><?= $this->Html->link(__('新增收益'), ['controller' => 'CustomerIncomes', 'action' => 'add', $customer->id]) ?> </li>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $customer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete {0}?', $customer->name)]) ?> </li>
        <li><?= $this->Html->link(__('客户列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增客户'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customers view large-10 medium-9 columns content">
   
    <div class="x_panel">
        <div class="x_title">
         <h3><?= h($customer->name) ?></h3>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('客户分类') ?></th>
                    <td><?= $customer->has('customer_category') ? $this->Html->link($customer->customer_category->name, ['controller' => 'CustomerCategories', 'action' => 'view', $customer->customer_category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('姓名') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('公司') ?></th>
                    <td><?= h($customer->company) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('业务员') ?></th>
                    <td><?= $customer->has('user') ? $this->Html->link($customer->user->username, ['controller' => 'Users', 'action' => 'view', $customer->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('电话') ?></th>
                    <td><a href="tel:<?=  '+' . $customer->country_code . '-' . $customer->mobile?>"><?=  '+' . $customer->country_code . '-' . $customer->mobile?></a></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('电邮') ?></th>
                    <td><?= __($customer->email) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('职位') ?></th>
                    <td><?= __($customer->position) ?></td>
                </tr>
                <?php foreach ($customer->customer_category_values as $value): ?>
                <tr>
                    <th scope="row"><?= __($value->customer_category_option['name'])?></th>
                    <td><?= $value->value ?></td>
                </tr>
                <?php endforeach ?>
                <tr>
                    <th scope="row"><?= __('创建时间') ?></th>
                    <td><?= h($customer->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('更新时间') ?></th>
                    <td><?= h($customer->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php if (!empty($customer->customer_businesses)): ?>
    <div class="related">
        <div class="x_panel">
            <div class="x_title">
                 <h4><?= __('相关日志') ?></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">   
                <table cellpadding="0" cellspacing="0" class="visible-lg">
                    <tr>
                        <th scope="col" width="60"><?= __('Id') ?></th>
                        <th scope="col"><?= __('内容') ?></th>
                        <th scope="col"><?= __('开始时间') ?></th>
                        <th scope="col"><?= __('结束时间') ?></th>
                        <th scope="col"><?= __('业务员') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($customer->customer_businesses as $customerBusinesses): ?>
                    <tr>
                        <td><?= h($customerBusinesses->id) ?></td>
                        <td><?= h($customerBusinesses->content) ?></td>
                        <td><?= h($customerBusinesses->start_time) ?></td>
                        <td><?= h($customerBusinesses->end_time) ?></td>
                        <td><?= h($customerBusinesses->user['username']) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'CustomerBusinesses', 'action' => 'view', $customerBusinesses->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerBusinesses', 'action' => 'edit', $customerBusinesses->id]) ?>
                            <?php if (h($customerBusinesses['end_time']) && !$customerBusinesses['state']): ?>
                            <?= $this->Form->postLink(__('Done'), ['controller' => 'CustomerBusinesses', 'action' => 'done', $customerBusinesses->id], ['confirm' => __('确定已完成此交易')]) ?>    
                            <?php endif ?>
                            
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerBusinesses', 'action' => 'delete', $customerBusinesses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerBusinesses->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="hidden-lg">
                    <?php foreach ($customer->customer_businesses as $customerBusinesses): ?>
                    <div class="row card text-left">
                        <div class="col-xs-12 business_name text-center">編號：</i><?= h($customerBusinesses->id) ?></div>
                        <div class="col-xs-6 business_name"><i class="fa fa-list"></i><?= h($customerBusinesses->content) ?></div>
                        <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($customerBusinesses->user['username']) ?></div>
                        <?php if ($customerBusinesses->end_time || $customerBusinesses->start_time): ?>
                        <div class="col-xs-12"><i class="fa fa-clock-o"></i>活动时间：<?= $customerBusinesses->start_time  . '至' . $customerBusinesses->start_time?></div>   
                        <?php endif ?>
                        <div class="clearfix"></div>
                        <div class="col-xs-6 action">
                            <?= $this->Html->link(__('View'), ['controller' => 'CustomerBusinesses','action' => 'view', $customerBusinesses->id],['class' => 'col-xs-4']) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerBusinesses','action' => 'edit', $customerBusinesses->id],['class' => 'col-xs-4']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerBusinesses','action' => 'delete', $customerBusinesses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerBusinesses->id),'class' => 'col-xs-4']) ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <?php if ($countBusiness > 5): ?>
                    <a href="<?= $this->Url->build(['controller' => 'CustomerBusinesses','action' => 'index', $customer->id])?>" class="btn btn-default pull-right">更多</a>
                <?php endif ?>
                <a href="<?= $this->Url->build(['controller' => 'CustomerBusinesses','action' => 'add', $customer->id])?>" class="btn btn-primary pull-right">新增</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (!empty($customer->customer_incomes)): ?>
    <div class="related">
    <div class="x_panel">
        <div class="x_title">
            <h4><?= __('相关收益') ?></h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">   
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" width="60"><?= $this->Paginator->sort('id') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('user_id',['经办人']) ?></th>
                        <th scope="col"><?= $this->Paginator->sort('amount',['金额']) ?></th>
                        <th scope="col" class="visible-sm"><?= $this->Paginator->sort('detail',['明细']) ?></th>
                        <th scope="col" class="visible-lg"><?= __('交易方式') ?></th>
                        <th scope="col" class="visible-lg"><?= $this->Paginator->sort('modified',['更新时间']) ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customer->customer_incomes as $incomes): ?>
                    <tr>
                        <td><?= $this->Number->format($incomes->id) ?></td>
                        <td><?= $incomes->has('user') ? $this->Html->link($incomes->user->username, ['controller' => 'Users', 'action' => 'view', $incomes->user_id]) : '' ?></td>
                        <td><?= $this->Number->format($incomes->amount) ?></td>
                        <td class="visible-sm"><?= h($incomes->detail) ?></td>
                        <td class="visible-lg"><?= h($incomes->finance_type['name']) ?></td>
                        <td class="visible-lg"><?= h($incomes->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'CustomerIncomes','action' => 'view', $incomes->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerIncomes','action' => 'edit', $incomes->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerIncomes','action' => 'delete', $incomes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incomes->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($countIncome > 5): ?>
                <a href="<?= $this->Url->build(['controller' => 'CustomerIncomes','action' => 'index', $customer->id])?>" class="btn btn-default pull-right">更多</a>
            <?php endif ?>            
            <a href="<?= $this->Url->build(['controller' => 'CustomerIncomes','action' => 'add',$customer->id])?>" class="btn btn-primary pull-right">新增</a>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="clearfix"></div>