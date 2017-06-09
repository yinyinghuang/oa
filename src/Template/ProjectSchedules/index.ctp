<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__($project->title), ['controller' => 'Projects', 'action' => 'view', $project->id]) ?></li>
        <li><?= $this->Html->link(__('新增计划'), ['action' => 'add', $project->id]) ?></li>
    </ul>
</nav>
<div class="projectSchedules index large-10 medium-9 columns content">
    <h3><?= __($project->title . ' 项目计划') ?></h3>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col" width="40"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= __('计划名称') ?></th>
                <th scope="col" width="80"><?= $this->Paginator->sort('user_id', ['负责人']) ?></th>
                <th scope="col" width="70"><?= $this->Paginator->sort('state', ['状态']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('start_time', ['开始时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('end_time', ['结束时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('modified', ['更新时间']) ?></th>
                <th scope="col" class="actions" width="120"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectSchedules as $projectSchedule): ?>
            <tr>
                <td><?= $this->Number->format($projectSchedule->id) ?></td>
                <td><?= h($projectSchedule->title) ?></td>
                <td><?= $projectSchedule->has('user') ? $this->Html->link($projectSchedule->user->username, ['controller' => 'Users', 'action' => 'view', $projectSchedule->user->id]) : '' ?></td>
                <?php if ($projectSchedule->state == 2 && date_format($projectSchedule->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedule->state ++; ?>
                <td><span class="label <?= $stateArr['style'][$projectSchedule->state]?>"><?= $stateArr['label'][$projectSchedule->state] ?></span></td>
                <td><?= h($projectSchedule->start_time) ?></td>
                <td><?= h($projectSchedule->end_time) ?></td>
                <td><?= h($projectSchedule->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $projectSchedule->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectSchedule->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedule->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($projectSchedules  as $projectSchedule): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($projectSchedule->id) ?></div>
            <div class="col-xs-6 business_name"><i class="fa fa-list"></i><?= h($projectSchedule->title) ?></div>
            <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($projectSchedule->user['username']) ?></div>
            <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= $projectSchedule->start_time  . '至' . $projectSchedule->end_time?></div>
            <?php if ($projectSchedule->state == 2 && date_format($projectSchedule->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedule->state ++; ?>
            <div class="col-xs-6">状态：<span class="label <?= $stateArr['style'][$projectSchedule->state]?>"><?= $stateArr['label'][$projectSchedule->state] ?></span></div>
            <div class="col-xs-6 action">
                <?= $this->Html->link(__('View'), ['action' => 'view', $projectSchedule->id],['class' => 'col-xs-4']) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $projectSchedule->id],['class' => 'col-xs-4']) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $projectSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedule->id),'class' => 'col-xs-4']) ?>
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
