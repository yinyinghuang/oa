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
                ['action' => 'delete', $financeType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $financeType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('交易方式列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="financeTypes form large-10 medium-9 columns content">
    <?= $this->Form->create($financeType) ?>
    <fieldset>
        <legend><?= __('编辑交易方式') ?></legend>
        <?php
            echo $this->Form->control('name',['label' => '名称']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary','pull-right']]) ?>
    <?= $this->Form->end() ?>
</div>
