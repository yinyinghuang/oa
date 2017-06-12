<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($project->state <= 1): ?>
        <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $project->id]) ?> </li>
        <?php elseif($project->state == 2): ?>
        <li><?= $this->Html->link(__('挂起'), ['action' => 'hangup', $project->id]) ?> </li>
        <?php elseif($project->state == 5): ?>
        <li><?= $this->Form->postLink(__('继续'), ['action' => 'continued', $project->id], ['confirm' => __('确定要重启该项目?')]) ?> </li>
        <?php endif ?>        
        <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $project->id], ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]) ?> </li>
        <li><?= $this->Html->link(__('项目列表'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('新增项目'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="projects view large-10 medium-9 columns content">
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
                    <th scope="row"><?= __('审核人') ?></th>
                    <td><?= h($project->auditorInput) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('内容') ?></th>
                    <td><?= $project->brief ?></td>
                </tr>
                <?php if ($project->attachment): ?>
                <tr>
                    <th scope="row"><?= __('附件') ?></th>
                    <td><?= $project->attachment ?></td>
                </tr>    
                <?php endif ?>                
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($project->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('状态') ?></th>
                     <?php if ($project->state == 2 && date_format($project->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $project->state ++; ?>
                    <td><span class="label <?= $stateArr['style'][$project->state]?>"><?= $stateArr['label'][$project->state] ?></span></td>
                </tr>
                <?php if ($project->state == 0): ?>
                <tr>
                    <th scope="row"><?= __('操作原因') ?></th>
                    <td><?= $project->reason ?></td>
                </tr>   
                <?php endif ?>
                <?php if ($project->state >= 2): ?>
                <tr>
                    <th scope="row"><?= __('进度') ?></th>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $project->progress ?>" 
                                aria-valuemin="0" aria-valuemax="100" style="width: <?= $project->progress ?>%;">
                                <span style="display: inline-block;width: 100px;text-align:left;<?php if ($project->progress == 0): ?>color:#333<?php endif ?>"><?= $project->progress ?>%完成</span>
                            </div>
                        </div>
                    </td>
                </tr>    
                <?php endif ?>
                <?php if ($project->whitelistArr != ''): ?>
                <tr>
                    <th scope="row"><?= __('可见') ?></th>
                    <td>
                        <table>
                        <?php foreach ($project->whitelistArr as $list): ?>
                            <tr><td><?= $list['username'] ?></td>
                                <td width="50"><?= $this->Form->postLink(__('删除'), ['action' => 'deleteWhitelist', $project->id, $list['id']], ['confirm' => __('确定要删除可见人 {0}?', $list['username'])]) ?></td>
                            </tr>
                        <?php endforeach ?> 
                            <tr><td colspan="2"><?= $this->Html->link(__('新增'), ['action' => 'whitelist', $project->id]) ?></td></tr>
                        </table>
                    </td>
                </tr>   
                <?php endif ?> 
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
                <table cellpadding="0" cellspacing="0" class="visible-md visible-lg">
                    <tr>
                        <th scope="col" style="width: 8%"><?= __('Id') ?></th>
                        <th scope="col"><?= __('计划名称') ?></th>
                        <th scope="col"><?= __('负责人') ?></th>
                        <th scope="col"><?= __('状态') ?></th>
                        <th scope="col"><?= __('进度') ?></th>
                        <th scope="col"><?= __('开始时间') ?></th>
                        <th scope="col"><?= __('结束时间') ?></th>
                        <th scope="col"><?= __('更新时间') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($project->project_schedules as $projectSchedules): ?>
                    <tr>
                        <td><?= h($projectSchedules->id) ?></td>
                        <td><?= h($projectSchedules->title) ?></td>
                        <td><?= h($projectSchedules->user['username']) ?></td>
                        <?php if ($projectSchedules->state == 2 && date_format($projectSchedules->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedules->state ++; ?>
                        <td><span class="label <?= $stateArr['style'][$projectSchedules->state]?>"><?= $stateArr['label'][$projectSchedules->state] ?></span></td>
                        <td><?= h($projectSchedules->progress . '%') ?></td>
                        <td><?= h($projectSchedules->start_time) ?></td>
                        <td><?= h($projectSchedules->end_time) ?></td>
                        <td><?= h($projectSchedules->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'ProjectSchedules', 'action' => 'view', $projectSchedules->id]) ?>
                            <?php if ($project->state == 1): ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectSchedules', 'action' => 'edit', $projectSchedules->id]) ?>                            
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectSchedules', 'action' => 'delete', $projectSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedules->id)]) ?>   
                            <?php endif ?> 
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <div class="hidden-md hidden-lg">
                    <?php foreach ($project->project_schedules  as $projectSchedules): ?>
                    <div class="row card text-left">
                        <div class="col-xs-12 business_name text-center">編號：</i><?= h($projectSchedules->id) ?></div>
                        <div class="col-xs-6 business_name"><i class="fa fa-list"></i><?= h($projectSchedules->title) ?></div>
                        <div class="col-xs-6 business_user"><i class="fa fa-user"></i><?= h($projectSchedules->user['username']) ?></div>
                        <div class="col-xs-12"><i class="fa fa-clock-o"></i><?= $projectSchedules->start_time  . '至' . $projectSchedules->end_time?></div>
                        <div class="col-xs-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $projectSchedules->progress ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $projectSchedules->progress ?>%">
                                    <span style="display: inline-block;width: 100px;text-align:left;<?php if ($projectSchedules->progress == 0): ?>color:#333<?php endif ?>"><?= $projectSchedules->progress ?>%完成</span>
                                </div>
                            </div>
                        </div>
                         <?php if ($projectSchedules->state == 2 && date_format($projectSchedules->end_time, 'Y-m-d H:i') < date('Y-m-d H:i')) $projectSchedules->state ++; ?>
                        <div class="col-xs-6">状态：<span class="label <?= $stateArr['style'][$projectSchedules->state]?>"><?= $stateArr['label'][$projectSchedules->state] ?></span></div>
                        <div class="col-xs-6 action">
                            <?= $this->Html->link(__('View'), ['controller' => 'ProjectSchedules', 'action' => 'view', $projectSchedules->id],['class' => 'col-xs-4']) ?>
                            <?php if ($project->state == 1): ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectSchedules', 'action' => 'edit', $projectSchedules->id],['class' => 'col-xs-4']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectSchedules', 'action' => 'delete', $projectSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedules->id),'class' => 'col-xs-4']) ?>
                                
                            <?php endif ?>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
                <a href="<?= $this->Url->build(['controller' => 'ProjectSchedules', 'action' => 'index', $project->id])?>" class="btn btn-default pull-right">更多</a>
                
                    
                <?php if ($project->state == 1): ?>
                <a href="<?= $this->Url->build(['controller' => 'ProjectSchedules', 'action' => 'add', $project->id])?>" class="btn btn-primary pull-right">新增</a>                   
                <?php endif ?>               
                
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<div class="clearfix"></div>