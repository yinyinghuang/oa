<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Account'), ['action' => 'edit', $account->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Account'), ['action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Accounts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Account'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Article Datas'), ['controller' => 'ArticleDatas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article Data'), ['controller' => 'ArticleDatas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Follow Datas'), ['controller' => 'FollowDatas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Follow Data'), ['controller' => 'FollowDatas', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="accounts view large-9 medium-8 columns content">
    <h3><?= h($account->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($account->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($account->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($account->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Department Id') ?></th>
            <td><?= $this->Number->format($account->department_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Article Datas') ?></h4>
        <?php if (!empty($account->article_datas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Account Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Level') ?></th>
                <th scope="col"><?= __('Hits') ?></th>
                <th scope="col"><?= __('Sharing Times') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($account->article_datas as $articleDatas): ?>
            <tr>
                <td><?= h($articleDatas->id) ?></td>
                <td><?= h($articleDatas->account_id) ?></td>
                <td><?= h($articleDatas->date) ?></td>
                <td><?= h($articleDatas->title) ?></td>
                <td><?= h($articleDatas->level) ?></td>
                <td><?= h($articleDatas->hits) ?></td>
                <td><?= h($articleDatas->sharing_times) ?></td>
                <td><?= h($articleDatas->user_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ArticleDatas', 'action' => 'view', $articleDatas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ArticleDatas', 'action' => 'edit', $articleDatas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ArticleDatas', 'action' => 'delete', $articleDatas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $articleDatas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Follow Datas') ?></h4>
        <?php if (!empty($account->follow_datas)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Account Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Followed') ?></th>
                <th scope="col"><?= __('Unfollowed') ?></th>
                <th scope="col"><?= __('Total') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($account->follow_datas as $followDatas): ?>
            <tr>
                <td><?= h($followDatas->id) ?></td>
                <td><?= h($followDatas->account_id) ?></td>
                <td><?= h($followDatas->date) ?></td>
                <td><?= h($followDatas->followed) ?></td>
                <td><?= h($followDatas->unfollowed) ?></td>
                <td><?= h($followDatas->total) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FollowDatas', 'action' => 'view', $followDatas->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FollowDatas', 'action' => 'edit', $followDatas->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FollowDatas', 'action' => 'delete', $followDatas->id], ['confirm' => __('Are you sure you want to delete # {0}?', $followDatas->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
