<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新增模板'), ['action' => 'add']) ?></li>

    </ul>
</nav>
<div class="smsTemplates index large-10 medium-9 columns content">
    <h3><?= __('短信模板') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= __('名称') ?></th>
                <th scope="col" class="visible-lg visible-md"><?= __('内容') ?></th>
                <th scope="col" class="visible-lg visible-md"><?= __('签名') ?></th>
                <th scope="col" class="visible-lg"><?= $this->Paginator->sort('modified',['更新时间']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($smsTemplates as $smsTemplate): ?>
            <tr>
                <td><?= $this->Number->format($smsTemplate->id) ?></td>
                <td><?= h($smsTemplate->name) ?></td>
                <td class="visible-lg visible-md"><?= h($smsTemplate->content) ?></td>
                <td class="visible-lg visible-md"><?= h($smsTemplate->sign) ?></td>
                <td class="visible-lg"><?= h($smsTemplate->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('SMS'), ['controller' => 'customerCategories','action' => 'sms', 0, $smsTemplate->id]) ?>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $smsTemplate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $smsTemplate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $smsTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smsTemplate->id)]) ?>
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
