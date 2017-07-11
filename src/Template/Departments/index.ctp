<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="departments index large-9 medium-8 columns content">
    <h3><?= __('Departments') ?></h3>
    <?php if ($crumbs !== null): ?>
        <div class="crumbs">
            <a href="<?= $this->Url->build(['action' => 'index',$uplevel['parent_id']])?>" class="btn btn-success pull-right">返回上级</a>
            <?php foreach ($crumbs as $key => $value): ?>
                <i class="fa fa-angle-double-right"></i><span><?= $value->name ?></span>
            <?php endforeach ?>
        </div>
    <?php endif ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= __('编号') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= __('子部门') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $department): ?>
            <tr>
                <td><?= h($department->id) ?></td>
                <td><?= h($department->name) ?></td>
                <td><?php if ($department->childCount !== 0): ?>
                    <a href="<?= $this->Url->build(['action' => 'index',$department->id]) ?>"><?= $department->childCount ?></a>
                <?php else :?>0<?php endif ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $department->id]) ?>
                    <?= $this->Html->link(__('Add'), ['action' => 'add', $department->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $department->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete {0}?', $department->name)]) ?>
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
