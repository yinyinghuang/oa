<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $config->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $config->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Configs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="configs form large-9 medium-8 columns content">
    <?= $this->Form->create($config) ?>
    <fieldset>
        <legend><?= __('Edit Config') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('content');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
