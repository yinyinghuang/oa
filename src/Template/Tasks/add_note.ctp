<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('任务列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="tasks form large-10 medium-9 columns content">
    <?= $this->Form->create($task) ?>
    <fieldset>
        <legend><?= __('待办任务') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('controller');
            echo $this->Form->control('itemid');
            echo $this->Form->control('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('提交'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
