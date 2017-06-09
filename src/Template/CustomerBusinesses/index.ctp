<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__($customer->name), ['controller' => 'Customers', 'action' => 'view', $customer->id]) ?></li>
        <li><?= $this->Html->link(__('新增日志'), ['action' => 'add', $customer->id]) ?></li>
    </ul>
</nav>
<div class="customerBusinesses index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('客户日志') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <input type="hidden" name="customer_id" value="<?= $customer->id?>">
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">内容</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="content" value="<?= h(isset($content) ? $content : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">业务员</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="username" value="<?= h(isset($username) ? $username : '') ?>" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-12">活动日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" value="<?= h(isset($start_time) ? $start_time : '') ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" value="<?= h(isset($end_time) ? $end_time : '') ?>" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div>           
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
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index',$customer->id,1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id', ['业务员']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('content', ['内容']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('start_time', ['开始时间']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('end_time', ['结束时间']) ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerBusinesses as $customerBusiness): ?>
            <tr>
                <td><?= $this->Number->format($customerBusiness->id) ?></td>
                <td><?= $customerBusiness->has('user') ? $this->Html->link($customerBusiness->user->username, ['controller' => 'Users', 'action' => 'view', $customerBusiness->user->id]) : '' ?></td>
                <td><?= h($customerBusiness->content) ?></td>
                <td><?= h($customerBusiness->start_time) ?></td>
                <td><?= h($customerBusiness->end_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customerBusiness->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customerBusiness->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerBusiness->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerBusiness->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($customerBusinesses as $customerBusiness): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($customerBusiness->id) ?></div>
            <div class="col-xs-6 business_name"><i class="fa fa-list"></i><?= h($customerBusiness->content) ?></div>
            <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($customerBusiness->user['username']) ?></div>
            <?php if ($customerBusiness->end_time || $customerBusiness->start_time): ?>
            <div class="col-xs-12"><i class="fa fa-clock-o"></i>活动时间：<?= $customerBusiness->start_time  . '至' . $customerBusiness->end_time?></div>   
            <?php endif ?>
            <div class="col-xs-6 action">
                <?= $this->Html->link(__('View'), ['controller' => 'CustomerBusinesses','action' => 'view', $customerBusiness->id],['class' => 'col-xs-4']) ?>
                <?= $this->Html->link(__('Edit'), ['controller' => 'CustomerBusinesses','action' => 'edit', $customerBusiness->id],['class' => 'col-xs-4']) ?>
                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CustomerBusinesses','action' => 'delete', $customerBusiness->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerBusiness->id),'class' => 'col-xs-4']) ?>
            </div>
        </div>
        <?php endforeach ?>
    </div>
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