<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新增分类'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerCategories index large-10 medium-9 columns content">
    <h3><?= __('客户分类') ?></h3>
    <?php if ($crumbs !== null): ?>
        <div class="crumbs">
            <a href="<?= $this->Url->build(['action' => 'index',$uplevel['parent_id']])?>" class="btn btn-success pull-right">返回上级</a>
            <ol class="breadcrumb">                
                <?php foreach ($crumbs as $key => $value): ?>
                    <li><span><?= $value->name ?></span></li>
                <?php endforeach ?>                
            </ol>
            
        </div>
    <?php endif ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name',['名称']) ?></th>
                <th scope="col"><?= __('子分类') ?></th>
                <th scope="col" class="hidden-xs"><?= $this->Paginator->sort('created',['创建时间']) ?></th>
                <th scope="col" class="hidden-xs"><?= $this->Paginator->sort('modified',['更新时间']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerCategories as $customerCategory): ?>
            <tr>
                <td><?= h($customerCategory->name) ?></td>
                <td><?php if ($customerCategory->childCount !== 0): ?>
                    <a href="<?= $this->Url->build(['action' => 'index',$customerCategory->id]) ?>"><?= $customerCategory->childCount ?></a>
                <?php else :?>0<?php endif ?></td>
                <td class="hidden-xs"><?= h($customerCategory->created) ?></td>
                <td class="hidden-xs"><?= h($customerCategory->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customerCategory->id]) ?>
                    <?= $this->Html->link(__('Add'), ['action' => 'add', $customerCategory->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customerCategory->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerCategory->id], ['confirm' => __('Are you sure you want to delete {0}?', $customerCategory->name)]) ?>
                    <?= $this->Html->link(__('SMS'), ['action' => 'sms', $customerCategory->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
