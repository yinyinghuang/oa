<?php
/**
  * @var \App\View\AppView $this
  */
?>
    
<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
             <h3><?= h($project->title) ?></h3>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('项目名称') ?></th>
                    <td><?= h($project->title) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('负责人') ?></th>
                    <td><?= $project->has('user') ? $this->Html->link($project->user->username, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('参与人') ?></th>
                    <td><?= h($project->participants) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('内容') ?></th>
                    <td><?= h($project->brief) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($project->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('状态') ?></th>
                    <td><span class="label <?= $stateArr['style'][$project->state]?>"><?= $stateArr['label'][$project->state]?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('开始时间') ?></th>
                    <td><?= h($project->start_time) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('结束时间') ?></th>
                    <td><?= h($project->end_time) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('创建时间') ?></th>
                    <td><?= h($project->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('更新时间') ?></th>
                    <td><?= h($project->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
    <?php if (!empty($project->project_schedules)): ?>
    <div class="related">
        <div class="x_panel">
            <div class="x_title">
                 <h4><?= __('项目计划') ?></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <div>
                    <?php foreach ($project->project_schedules  as $projectSchedules): ?>
                    <div class="row card text-left">
                        <div class="col-xs-12 business_name text-center">編號：</i><?= h($projectSchedules->id) ?></div>
                        <div class="col-xs-6 business_name"><i class="fa fa-list"></i><?= h($projectSchedules->title) ?></div>
                        <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($projectSchedules->user['username']) ?></div>
                        <div class="col-xs-12">工作内容：</i><?= $projectSchedules->brief ?></div>
                        <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= $projectSchedules->start_time  . '至' . $projectSchedules->end_time?></div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="clearfix"></div>
<form action="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'check', $project->id])?>" method="post" class="form-horizontal col-md-6 col-sm-6 col-xs-12">
<input type="hidden" name="state" id="state">
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" style="color: #222">操作原因</label>
        <div class="col-md-6 col-sm-6 col-xs-12"><textarea name="reason" id="" cols="30" rows="2"></textarea></div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3 col-sm-offset-3">
        <button class="btn btn-success" id="checked">审核通过</button>
        <button class="btn btn-danger" id="rejected">审核不通过</button>
    </div>
</form>

<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
  $(function(){
    $('#checked').on('click', function(){
        $('#state').val(2);
    });
    $('#rejected').on('click', function(){
        $('#state').val(0);
    });
  });
</script> 
<?= $this->end() ?>