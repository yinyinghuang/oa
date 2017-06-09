<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('交易方式列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="financeTypes form large-10 medium-9 columns content">
    <?= $this->Form->create($financeType) ?>
    <fieldset>
        <legend><?= __('新增交易方式') ?></legend>
        <?php
            echo $this->Form->control('name',['label' => '名称']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary','pull-right']]) ?>
    <?= $this->Form->end() ?>
</div>
