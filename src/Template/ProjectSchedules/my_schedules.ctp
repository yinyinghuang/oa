<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('项目列表'), ['controller' => 'Projects','action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projectSchedules index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('参与的项目计划') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">项目名称</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="projectTitle" value="<?= h(isset($projectTitle) ? $projectTitle : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">计划名称</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="scheduleTitle" value="<?= h(isset($scheduleTitle) ? $scheduleTitle : '') ?>" class="form-control">
            </div>
        </div>

        <div class="row form-group">
            <label class="col-md-2 col-xs-12">项目日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" value="<?= h(isset($start_time) ? $start_time : '') ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" value="<?= h(isset($end_time) ? $end_time : '') ?>" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div>
            <label class="col-md-2 col-xs-12">状态</label>
            <div class="col-md-2 col-xs-12">
                <select name="state" class="form-control">
                    <option value="-1">請選擇</option>
                    <?php foreach ($stateArr['label'] as $key => $value): ?>
                        <option value="<?= $key ?>" <?php if (isset($state) && $key == $state): ?>selected<?php endif ?>><?= $value?></option>
                    <?php endforeach ?>
                </select>
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
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index',1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col" width="40"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= __('项目名称') ?></th>
                <th scope="col"><?= __('计划名称') ?></th>
                <th scope="col" width="70"><?= $this->Paginator->sort('state', ['状态']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('start_time', ['开始时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('end_time', ['结束时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('modified', ['更新时间']) ?></th>
                <th scope="col" class="actions" width="60"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projectSchedules as $projectSchedule): ?>
            <tr>
                <td><?= $this->Number->format($projectSchedule->id) ?></td>
                <td><?= $this->Html->link($projectSchedule->project->title, ['controller' => 'Projects', 'action' => 'view', $projectSchedule->project->id]) ?></td>
                <td><?= h($projectSchedule->title) ?></td>
                <?php if ($projectSchedule->state == 2 && date_format($projectSchedule->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedule->state ++; ?>
                <td><span class="label <?= $stateArr['style'][$projectSchedule->state]?>"><?= $stateArr['label'][$projectSchedule->state] ?></span></td>
                <td><?= h($projectSchedule->start_time) ?></td>
                <td><?= h($projectSchedule->end_time) ?></td>
                <td><?= h($projectSchedule->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('更新'), ['action' => 'view', $projectSchedule->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($projectSchedules  as $projectSchedule): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($projectSchedule->id) ?></div>
            <div class="col-xs-12 business_name"><i class="fa fa-product-hunt"></i><?= $this->Html->link($projectSchedule->project->title, ['controller' => 'Projects', 'action' => 'view', $projectSchedule->project->id]) ?></div>
            <div class="col-xs-12 business_name"><i class="fa fa-list"></i><?= h($projectSchedule->title) ?></div>
            <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= $projectSchedule->start_time  . '至' . $projectSchedule->end_time?></div>
            <?php if ($projectSchedule->state == 2 && date_format($projectSchedule->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedule->state ++; ?>
            <div class="col-xs-6">状态：<span class="label <?= $stateArr['style'][$projectSchedule->state]?>"><?= $stateArr['label'][$projectSchedule->state] ?></span></div>
            <div class="col-xs-6 action">
                <?= $this->Html->link(__('更新'), ['action' => 'view', $projectSchedule->id],['class' => 'pull-right']) ?>
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