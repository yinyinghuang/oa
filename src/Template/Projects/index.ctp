<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新建项目'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="projects index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('项目列表') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">项目名称</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="title" value="<?= h(isset($title) ? $title : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">负责人</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="username" value="<?= h(isset($username) ? $username : '') ?>" class="form-control">
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
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index',$state,1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0" class="visible-lg">
        <thead>
            <tr>
                <th scope="col" width="40"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= __('项目名称') ?></th>
                <th scope="col" width="80"><?= $this->Paginator->sort('user_id', ['负责人']) ?></th>
                <th scope="col" width="70"><?= $this->Paginator->sort('state', ['状态']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('start_date', ['开始时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('end_date', ['结束时间']) ?></th>
                <th scope="col" width="120"><?= $this->Paginator->sort('modified', [' 更新时间']) ?></th>
                <th scope="col" class="actions" width="120"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= $this->Number->format($project->id) ?><?php if (isset($projectRespArr[$state]) && in_array($project->id, $projectRespArr[$state])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </td>
                <td><?= h($project->title) ?></td>
                <td><?= $project->has('user') ? $this->Html->link($project->user->username, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                <?php if ($project->state == 2 && date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>
                <td><span class="label <?= $stateArr['style'][$project->state]?>"><?= $stateArr['label'][$project->state] ?></span></td>
                <td><?= h($project->start_time) ?></td>
                <td><?= h($project->end_time) ?></td>
                <td><?= h($project->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $project->id]) ?>
                    <?php if ($project->state <= 1): ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id]) ?>    
                    <?php endif ?>                    
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="hidden-lg">
        <?php foreach ($projects as $project): ?>
        <div class="row card text-left">
            <div class="col-xs-12 business_name text-center">編號：</i><?= h($project->id) ?><?php if (isset($projectRespArr[$state]) && in_array($project->id, $projectRespArr[$state])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </div>
            <div class="col-xs-6 business_name"><i class="fa fa-product-hunt"></i><?= h($project->title) ?></div>
            <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($project->user['username']) ?></div>            
            <div class="col-xs-12"><i class="fa fa-users"></i>参与人：<?= $project->participants?></div>
            <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= $project->start_time  . '至' . $project->end_time?></div>
            <?php if ($project->state == 2): ?>
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $project->progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $project->progress ?>%">
                            <span style="display: inline-block;width: 100px;text-align:left;<?php if ($project->progress == 0): ?>color:#333<?php endif ?>"><?= $project->progress ?>%完成</span>
                        </div>
                    </div>
                </div>
            </div>  
            <?php endif ?>  
            <?php if ($project->state == 2 && date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>          
            <div class="col-xs-6">状态：<span class="label <?= $stateArr['style'][$project->state]?>"><?= $stateArr['label'][$project->state]?></span></div>
            <div class="col-xs-6 action">
                <?= $this->Html->link(__('View'), ['action' => 'view', $project->id],['class' => 'col-xs-4']) ?>
                <?php if ($project->state <= 1): ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $project->id],['class' => 'col-xs-4']) ?>    
                <?php endif ?>
                
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id),'class' => 'col-xs-4']) ?>
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