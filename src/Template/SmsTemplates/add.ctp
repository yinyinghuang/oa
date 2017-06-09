<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('模板列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="smsTemplates form large-10 medium-9 columns content">
    <?= $this->Form->create($smsTemplate) ?>
    <fieldset>
        <legend><?= __('新增模板') ?></legend>
        <?php
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => 0,'id' => 'num']);
            echo $this->Form->control('templateid',['label' => '短信模板编号']);
            echo $this->Form->control('name',['label' => '名称']);
            echo $this->Form->control('content',['type' => 'textarea','label' => '内容']);
            echo $this->Form->control('sign',['maxlength' => 8,'label' => '签名','type' => 'text']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('提交'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>