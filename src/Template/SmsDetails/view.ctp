<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('发送短信'), ['controller' => 'CustomerCategories', 'action' => 'sms']) ?></li>
    </ul>
</nav>
<div class="smsDetails view large-10 medium-9 columns content">
    <h3><?= h($smsDetail->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('发送人') ?></th>
            <td><?= $smsDetail->has('user') ? $this->Html->link($smsDetail->user->username, ['controller' => 'Users', 'action' => 'view', $smsDetail->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('短信内容') ?></th>
            <td><?= h($smsDetail->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($smsDetail->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('成功') ?></th>
            <td><?= $this->Number->format($smsDetail->success) ?>条</td>
        </tr>
        <tr>
            <th scope="row"><?= __('失败') ?></th>
            <td><?= $this->Number->format($smsDetail->fail) ?>条<?php if ($smsDetail->fail > 0): ?><?= $this->Html->link(__('失败重发'), ['controller' => 'CustomerCategories', 'action' => 'resend', $smsDetail->id],['style' => 'padding-left:6px;']) ?><?php endif ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('总共') ?></th>
            <td><?= $this->Number->format($smsDetail->total) ?>条</td>
        </tr>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($smsDetail->created) ?></td>
        </tr>
    </table>
    <?php if (!empty($smsDetail->sms_records)): ?>
    <div class="related">
        <h4><?= __('失败记录') ?></h4>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('客户') ?></th>
                <th scope="col"><?= __('电话') ?></th>
                <th scope="col"><?= __('失败原因') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($smsDetail->sms_records as $smsRecords): ?>
            <tr>
                <td><?= h($smsRecords->id) ?></td>
                <td><?= h($smsRecords->customer['name']) ?></td>
                <td><?= h($smsRecords->customer['mobile']) ?></td>
                <td><?= h($smsRecords->result) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $smsRecords->customer_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $smsRecords->id], ['confirm' => __('确定删除此客户?', $smsRecords->customer_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
</div>
