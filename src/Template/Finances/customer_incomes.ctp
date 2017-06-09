<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if (isset($customer_id) && $customer_id != 0): ?>
        <li><?= $this->Html->link(__($customer->name), ['controller' => 'Customers', 'action' => 'view', $customer_id]) ?></li>  
        <li><?= $this->Html->link(__('New Customer Income'), ['action' => 'add',  $customer->id]) ?></li>  
        <?php endif ?>
    </ul>
</nav>
<div class="customerIncomes index large-9 medium-8 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('Customer Incomes') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <?php if (isset($customer_id) && $customer_id != 0): ?>
            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
        <?php else: ?>
            <div class="row form-group">
                <label class="col-md-2 col-xs-4">客户</label>
                <div class="col-md-3 col-xs-8">
                    <input type="text" name="name" value="<?= h(isset($name) ? $name : '') ?>" class="form-control">
                </div>
            </div>            
        <?php endif ?>
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
                    <input type="text" name="max" value="<?= isset($max) ? $max : '' ?>" class="form-control">
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
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'customerIncomes',$customer_id,1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <?php if ($customer_id == 0): ?><th scope="col"><?= __('客户') ?></th><?php endif ?>
                <th scope="col" class="visible-sm"><?= $this->Paginator->sort('detail') ?></th>
                <th scope="col" class="visible-lg"><?= __('交易方式') ?></th>
                <th scope="col" class="visible-lg"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($finances as $finance): ?>
            <tr>
                <td><?= $this->Number->format($finance->id) ?></td>
                <td><?= $finance->has('user') ? $this->Html->link($finance->user->username, ['controller' => 'Users', 'action' => 'view', $finance->user_id]) : '' ?></td>
                <td><?= $this->Number->format($finance->amount) ?></td>
                <?php if ($customer_id == 0): ?><td><?= $finance->customer['name'] ?></td><?php endif ?>
                <td class="visible-sm"><?= h($finance->detail) ?></td>
                <td class="visible-lg"><?= h($finance->finance_type['name']) ?></td>
                <td class="visible-lg"><?= h($finance->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $finance->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $finance->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $finance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finance->id)]) ?>
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
