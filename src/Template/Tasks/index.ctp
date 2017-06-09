<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tasks index large-10 medium-9 columns content">
    <h3><?= __('Tasks') ?></h3>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col" style="width: 10%"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('controller',['模块']) ?></th>
                <th scope="col"><?= __('内容') ?></th>
                <th scope="col"><?= __('操作人') ?></th>
                <th scope="col"><?= __('状态') ?></th>
                <th scope="col"><?= __('更新时间') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr <?php if ($task->state == 0): ?>style="font-weight:600"<?php endif ?>>
                <td><?= $this->Number->format($task->id) ?></td>
                <td><?= $modelArr[$task->controller] ?></td>
                <td><?= __($task->item) ?></td>
                <td><?= $this->Html->link(__($task->operator['username']), ['controller' => 'Users', 'action' => 'view', $task->operator['id']]) ?></td>
                <td><?= __($task->status) ?></td>
                <td><?= h($task->modified) ?></td>
                <td class="actions">
                    <?php if ($task->deal): ?>
                    <?= $this->Html->link(__($task->deal['label']), $task->deal['url']) ?>    
                    <?php endif ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($tasks as $task): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($task->id) ?></div>
            <div class="col-xs-12 business_name"><i class="fa fa-list"></i><?= h($task->item) ?></div>
            <div class="col-xs-6 business_user"><i class="fa fa-cubes"></i><?= h($modelArr[$task->controller]) ?></div>
            <div class="col-xs-6"><i class="fa fa-user"></i><?= $this->Html->link(__($task->operator['username']), ['controller' => 'Users', 'action' => 'view', $task->operator['id']]) ?></div>                       
            <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= h($task->modified) ?></div>
            <div class="col-xs-6">状态：<?= $task->status?></div> 
            <div class="col-xs-6 action">
                <?php if ($task->deal): ?>
                    <?= $this->Html->link(__($task->deal['label']), $task->deal['url']) ?>    
                <?php endif ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
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
