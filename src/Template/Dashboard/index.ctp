<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h4>常用模块</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'add'])?>"><i class="fa fa-plus"></i>新建项目</a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h4>最近任务<?php if ($backlogCount): ?><i class="badge badge-danger"><?= $backlogCount?></i><?php endif ?> </h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-lg">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px"><?= __('id') ?></th>
                        <th scope="col" style="width: 70px"><?= __('模块') ?></th>
                        <th scope="col"><?= __('内容') ?></th>
                        <th scope="col" style="width: 70px"><?= __('操作人') ?></th>
                        <th scope="col"  style="width: 120px"><?= __('更新时间') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                    <tr <?php if ($task->state == 0): ?>style="font-weight:600"<?php endif ?>>
                        <td><?= $this->Number->format($task->id) ?></td>
                        <td><?= $taskModelArr[$task->controller] ?></td>
                        <td><?= $this->Html->link(__($task->item), $task->deal['url']) ?> </td>
                        <td><?= $this->Html->link(__($task->operator['username']), ['controller' => 'Users', 'action' => 'view', $task->operator['id']]) ?></td>
                        <td><?= h($task->modified) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hidden-lg">
                <?php foreach ($tasks as $task): ?>
                <div class="row card text-left">
                    <div class="col-xs-12 business_name text-center">編號：</i><?= h($task->id) ?></div>
                    <div class="col-xs-12 business_name"><i class="fa fa-list"></i><?= h($task->item) ?></div>
                    <div class="col-xs-6 business_user"><i class="fa fa-cubes"></i><?= h($taskModelArr[$task->controller]) ?></div>
                    <div class="col-xs-6"><i class="fa fa-user"></i><?= $this->Html->link(__($task->operator['username']), ['controller' => 'Users', 'action' => 'view', $task->operator['id']]) ?></div>                       
                    <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= h($task->modified) ?></div>
                    <div class="col-xs-6">状态：<?= $task->status?></div> 
                    <div class="col-xs-6 action">
                        <?php if ($task->deal): ?>
                            <?= $this->Html->link(__($task->deal['label']), $task->deal['url']) ?>    
                        <?php endif ?>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php if ($countTasks > 5): ?>
               <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'task', 'action' => 'index']) ?>">更多</a> 
            <?php endif ?>
        </div>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">   
    <div class="x_panel">
        <div class="x_title">
            <h4>最新消息</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-lg">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px"><?= __('id') ?></th>
                        <th scope="col" style="width: 70px"><?= __('模块') ?></th>
                        <th scope="col"><?= __('内容') ?></th>
                        <th scope="col" style="width: 70px"><?= __('操作人') ?></th>
                        <th scope="col"  style="width: 120px"><?= __('更新时间') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notices as $notice): ?>
                    <tr>
                        <td><?= $this->Number->format($notice->id) ?></td>
                        <td><?= $noticeModelArr[$notice->controller] ?></td>
                        <td><?= $this->Html->link(__($notice->item), $notice->deal['url']) ?> </td>
                        <td><?= $this->Html->link(__($notice->operator['username']), ['controller' => 'Users', 'action' => 'view', $notice->operator['id']]) ?></td>
                        <td><?= h($notice->created) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hidden-lg">
                <?php foreach ($notices as $notice): ?>
                <div class="row card text-left">
                    <div class="col-xs-12 business_name text-center">編號：</i><?= h($notice->id) ?></div>
                    <div class="col-xs-12 business_name"><i class="fa fa-list"></i><?= h($notice->item) ?></div>
                    <div class="col-xs-6 business_user"><i class="fa fa-cubes"></i><?= h($noticeModelArr[$notice->controller]) ?></div>
                    <div class="col-xs-6"><i class="fa fa-user"></i><?= $this->Html->link(__($notice->operator['username']), ['controller' => 'Users', 'action' => 'view', $notice->operator['id']]) ?></div>                       
                    <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= h($notice->created) ?></div>
                    <div class="col-xs-6 action">
                        <?php if ($notice->deal): ?>
                            <?= $this->Html->link(__($notice->deal['label']), $notice->deal['url']) ?>    
                        <?php endif ?>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <?php if ($countNotices > 5): ?>
               <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'notices', 'action' => 'index']) ?>">更多</a> 
            <?php endif ?>
        </div>
    </div>    
</div>
<div class="clearfix"></div>   

<div class="col-md-6 col-sm-6 col-xs-12">   
    <div class="x_panel">
        <div class="x_title">
            <h4>我的网盘</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-lg">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px"><?= __('id') ?></th>
                        <th scope="col"><?= __('项目名称') ?></th>
                        <th scope="col" style="width: 70px"><?= __('发起人') ?></th>
                        <th scope="col" style="width: 64px"><?= __('状态') ?></th>
                        <th scope="col" style="width: 120px"><?= __('更新时间') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projectSchedules as $schedule): ?>
                    <?php $project = $schedule->project; ?>
                    <tr>
                        <td><?= $this->Number->format($project->id) ?><?php if (isset($projectRespArr[2]) && in_array($project->id, $projectRespArr[2])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </td>
                        <td><?= $this->Html->link(__($project->title), ['controller' => 'Projects', 'action' => 'view', $project->id]) ?></td>
                        <td><?= $project->has('user') ? $this->Html->link($project->user->username, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                        <?php if ($project->state == 2 && date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>
                        <td><span class="label <?= $projectStateArr['style'][$project->state]?>"><?= $projectStateArr['label'][$project->state] ?></span></td>
                        <td><?= h($project->modified) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hidden-lg">
                <?php foreach ($projectSchedules as $schedule): ?>
                <?php $project = $schedule->project; ?>
                <div class="row card text-left">
                    <div class="col-xs-12 business_name text-center">編號：</i><?= h($project->id) ?><?php if (isset($projectRespArr[2]) && in_array($project->id, $projectRespArr[2])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </div>
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
                    <?php if (date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>          
                    <div class="col-xs-6">状态：<span class="label <?= $projectStateArr['style'][$project->state]?>"><?= $projectStateArr['label'][$project->state]?></span></div>
                    <div class="col-xs-6 action">
                        <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $project->id],['class' => 'col-xs-4']) ?>                        
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id),'class' => 'col-xs-4']) ?>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
        <?php if ($countProjects > 5): ?>
           <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>">更多</a> 
        <?php endif ?>
    </div>    
</div>
<div class="col-md-6 col-sm-6 col-xs-12">   
    <div class="x_panel">
        <div class="x_title">
            <h4>参与项目</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-lg">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px"><?= __('id') ?></th>
                        <th scope="col"><?= __('项目名称') ?></th>
                        <th scope="col" style="width: 70px"><?= __('发起人') ?></th>
                        <th scope="col" style="width: 64px"><?= __('状态') ?></th>
                        <th scope="col" style="width: 120px"><?= __('更新时间') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projectSchedules as $schedule): ?>
                    <?php $project = $schedule->project; ?>
                    <tr>
                        <td><?= $this->Number->format($project->id) ?><?php if (isset($projectRespArr[2]) && in_array($project->id, $projectRespArr[2])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </td>
                        <td><?= $this->Html->link(__($project->title), ['controller' => 'Projects', 'action' => 'view', $project->id]) ?></td>
                        <td><?= $project->has('user') ? $this->Html->link($project->user->username, ['controller' => 'Users', 'action' => 'view', $project->user->id]) : '' ?></td>
                        <?php if ($project->state == 2 && date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>
                        <td><span class="label <?= $projectStateArr['style'][$project->state]?>"><?= $projectStateArr['label'][$project->state] ?></span></td>
                        <td><?= h($project->modified) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hidden-lg">
                <?php foreach ($projectSchedules as $schedule): ?>
                <?php $project = $schedule->project; ?>
                <div class="row card text-left">
                    <div class="col-xs-12 business_name text-center">編號：</i><?= h($project->id) ?><?php if (isset($projectRespArr[2]) && in_array($project->id, $projectRespArr[2])): ?><sup style="background: #D33C44;color: #fff;">new</sup><?php endif ?> </div>
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
                    <?php if (date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>          
                    <div class="col-xs-6">状态：<span class="label <?= $projectStateArr['style'][$project->state]?>"><?= $projectStateArr['label'][$project->state]?></span></div>
                    <div class="col-xs-6 action">
                        <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $project->id],['class' => 'col-xs-4']) ?>                        
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id),'class' => 'col-xs-4']) ?>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
        <?php if ($countProjects > 5): ?>
           <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>">更多</a> 
        <?php endif ?>
    </div>    
</div>
<div class="clearfix"></div>
<div class="col-md-6 col-sm-6 col-xs-12">   
    <div class="x_panel">
        <div class="x_title">
            <h4>财务流水 <?php if (count($financeInArr)): ?><i class="badge badge-danger"><?= count($financeInArr)?></i><?php endif ?> </h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" style="width: 40px"><?= __('id') ?></th>
                        <th scope="col"><?= __('经办人') ?></th>
                        <th scope="col" width="62"><?= __('金额') ?></th>
                        <th scope="col"><?= __('收款人') ?></th>
                        <th scope="col" class="visible-lg"><?= $this->Paginator->sort('balance',['余额']) ?></th>
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
                        <td><?php if ($finance->alia): ?>
                            <?= h($finance->user->username) ?>
                        <?php else: ?>  
                            <?= h($finance->payee) ?>
                        <?php endif ?></td>
                        <td class="visible-lg"><?= $this->Number->format($finance->balance) ?></td>
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
            <?php if ($countFinances > 5): ?>
               <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'Finances', 'action' => 'index']) ?>">更多</a> 
            <?php endif ?>
            <a class="btn btn-danger pull-right" href="<?= $this->Url->build(['controller' => 'Finances', 'action' => 'add']) ?>">记账</a>
        </div>
    </div>    
</div>
<div class="clearfix"></div>

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