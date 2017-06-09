<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('首页'), ['controller' => 'Dashboard']) ?></li>
    </ul>
</nav>
<div class="notices index large-10 medium-9 columns content">
    <h3><?= __('消息') ?></h3>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col" style="width: 40px"><?= __('id') ?></th>
                <th scope="col" style="width: 70px"><?= __('模块') ?></th>
                <th scope="col"><?= __('内容') ?></th>
                <th scope="col" style="width: 70px"><?= __('操作人') ?></th>
                <th scope="col"  style="width: 120px"><?= __('更新时间') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($notices as $notice): ?>
            <tr  <?php if ($notice->state == 0): ?>style="font-weight:600"<?php endif ?>>
                <td><?= $this->Number->format($notice->id) ?></td>
                <td><?= $noticeModelArr[$notice->controller] ?></td>
                <td><?= $this->Html->link(__($notice->item), $notice->deal['url']) ?> </td>
                <td><?= $this->Html->link(__($notice->operator['username']), ['controller' => 'Users', 'action' => 'view', $notice->operator['id']]) ?></td>
                <td><?= h($notice->created) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($notices as $notice): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($notice->id) ?>  <?php if ($notice->state == 0): ?>style="font-weight:600"<?php endif ?></div>
            <div class="col-xs-12 business_name"><i class="fa fa-list"></i><?= h($notice->item) ?></div>
            <div class="col-xs-6 business_user"><i class="fa fa-cubes"></i><?= h($noticeModelArr[$notice->controller]) ?></div>
            <div class="col-xs-6"><i class="fa fa-user"></i><?= $this->Html->link(__($notice->operator['username']), ['controller' => 'Users', 'action' => 'view', $notice->operator['id']]) ?></div>                       
            <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= h($notice->created) ?></div>
            <div class="col-xs-6 action">
                <?php if ($notice->deal): ?>
                    <?= $this->Html->link(__($notice->deal['label']), $notice->deal['url']) ?>    
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
