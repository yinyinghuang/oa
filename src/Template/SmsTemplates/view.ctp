<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('发送短信'), ['controller' => 'customerCategories','action' => 'sms', 0, $smsTemplate->id]) ?></li>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $smsTemplate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $smsTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smsTemplate->id)]) ?> </li>
        <li><?= $this->Html->link(__('模板列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="smsTemplates view large-10 medium-9 columns content">
    <h3><?= h($smsTemplate->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('短信模板编号') ?></th>
            <td><?= h($smsTemplate->templateid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('模板名称') ?></th>
            <td><?= h($smsTemplate->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('内容') ?></th>
            <td><?= h($smsTemplate->content) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('变量') ?></th>
            <td><?= h($smsTemplate->variables) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('签名') ?></th>
            <td><?= h($smsTemplate->sign) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($smsTemplate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('创建时间') ?></th>
            <td><?= h($smsTemplate->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('更新时间') ?></th>
            <td><?= h($smsTemplate->modified) ?></td>
        </tr>
    </table>
</div>
