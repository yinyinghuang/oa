<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新增流水'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="finances index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('流水') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">收款人</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="payee" value="<?= h(isset($payee) ? $payee : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">类型</label>
            <div class="col-md-3 col-xs-8">
                <label><input type="radio" name="alia" value="1" <?php if (isset($alia) && $alia == 1): ?>checked<?php endif ?> >收入</label>
                <label><input type="radio" name="alia" value="0" <?php if (isset($alia) && $alia == 0): ?>checked<?php endif ?> >支出</label>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">经办人</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="username" value="<?= h(isset($username) ? $username : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">交易方式</label>
            <div class="col-md-3 col-xs-8">
                <select name="type" class="form-control">
                    <option value="-1">請選擇</option>
                    <?php foreach ($financeTypes as $key => $value): ?>
                        <option value="<?= $key ?>" <?php if (isset($type) && $key == $type): ?>selected<?php endif ?>><?= $value?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-12">金额范围</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="min" value="<?= h(isset($min) ? $min : '') ?>" class="form-control">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="max" value="<?= h(isset($max) ? $max : '') ?>" class="form-control">
                </div>
            </div> 
            <label class="col-md-1 col-xs-4">凭证</label>   
            <div class="col-md-2 col-xs-8"><input type="checkbox" name="receipt" value="1" <?php if (isset($receipt) && $receipt == 1): ?>checked<?php endif ?>>有</div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-12">更新日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_modified" value="<?= h(isset($start_modified) ? $start_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_modified" value="<?= h(isset($end_modified) ? $end_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div>    
        </div>
        <div class="row form-group">
            
            <div class="col-md-2">
                <button class="btn btn-primary">搜索</button>
            </div>
            <div class="col-md-2">
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index']) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width="60"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id',['经办人']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount',['金额']) ?></th>
                <th scope="col" class="visible-lg"><?= __('明细') ?></th>
                <th scope="col"><?= __('收款人') ?></th>
                <th scope="col" class="visible-lg"><?= $this->Paginator->sort('balance',['余额']) ?></th>
                <th scope="col" class="visible-lg"><?= $this->Paginator->sort('modified',['更新时间']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($finances as $finance): ?>
            <tr <?php if ($finance->alia): ?>style="background:rgba(26, 187, 156, 0.3);"<?php endif ?>>
                <td><?= $this->Number->format($finance->id) ?><?php if (in_array($finance->id, $financeInArr)): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </td>
                <td>
                <?php if ($finance->alia): ?>
                    <?=  $this->Html->link($finance->payee, ['controller' => 'Users', 'action' => 'view', $finance->payee_id]) ?>
                <?php else: ?>
                    <?= $finance->has('user') ? $this->Html->link($finance->user->username, ['controller' => 'Users', 'action' => 'view', $finance->user->id]) : '' ?>
                <?php endif ?>
                </td>
                <td><?= $this->Number->format(abs($finance->amount)) ?></td>
                <td class="visible-lg"><?= h($finance->detail) ?></td>
                <td><?php if ($finance->alia): ?>
                    <?= h($finance->user->username) ?>
                <?php else: ?>  
                    <?= h($finance->payee) ?>
                <?php endif ?></td>
                <td class="visible-lg"><?= $this->Number->format($finance->balance) ?></td>
                <td class="visible-lg"><?= h($finance->modified) ?></td>
                <td class="actions">
                    <?php if (!$finance->alia): ?>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $finance->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $finance->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $finance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finance->id)]) ?>                        
                    <?php endif ?>

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
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
     $(document).ready(function() {
        $('.datetimepicker').daterangepicker({
            "calender_style": "picker_3",
            "singleDatePicker": true,
            "format" : "YYYY-MM-DD",
          }, function(start, end, label) {
        });
    })
</script>
<?= $this->end() ?>