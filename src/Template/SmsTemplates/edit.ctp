<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('删除'),
                ['action' => 'delete', $smsTemplate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $smsTemplate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('模板列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="smsTemplates form large-10 medium-9 columns content">
    <?= $this->Form->create($smsTemplate) ?>
    <fieldset>
        <legend><?= __('编辑模板') ?></legend>
        <?php
            $variables = explode(',', $smsTemplate->variables);
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => count($variables),'id' => 'num']);
            echo $this->Form->control('templateid',['label' => '短信模板编号']);
            echo $this->Form->control('name',['label' => '名称']);
            echo $this->Form->control('content',['type' => 'textarea','label' => '内容']);
            echo $this->Form->control('sign',['label' => '签名']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('提交'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>