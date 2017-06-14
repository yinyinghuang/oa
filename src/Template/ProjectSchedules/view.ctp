<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($projectSchedule->project['state'] == 0): ?>
            <li><?= $this->Html->link(__('编辑'), ['action' => 'edit', $projectSchedule->id]) ?> </li>
            <li><?= $this->Html->link(__('新增计划'), ['action' => 'add', $projectSchedule->project_id]) ?> </li>
            <li><?= $this->Form->postLink(__('删除'), ['action' => 'delete', $projectSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedule->id)]) ?> </li>
        <?php elseif($projectSchedule->project['state'] == 2 && $projectSchedule->state == 2): ?>
            <li><?= $this->Html->link(__('添加进度'), ['controller' => 'ProjectProgresses', 'action' => 'add', $projectSchedule->id]) ?> </li>
        <?php endif ?>
    </ul>
</nav>
<div class="projectSchedules view large-10 medium-9 columns content">
    <div class="x_panel">
        <div class="x_title">
            <h3><?= h($projectSchedule->title) ?></h3>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="vertical-table">
                <tr>
                    <th scope="row"><?= __('项目名称') ?></th>
                    <td><?= $projectSchedule->has('project') ? $this->Html->link($projectSchedule->project->title, ['controller' => 'Projects', 'action' => 'view', $projectSchedule->project->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('计划名称') ?></th>
                    <td><?= h($projectSchedule->title) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('内容') ?></th>
                    <td><?= $projectSchedule->brief ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('负责人') ?></th>
                    <td><?= $projectSchedule->has('user') ? $this->Html->link($projectSchedule->user->username, ['controller' => 'Users', 'action' => 'view', $projectSchedule->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($projectSchedule->id) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('状态') ?></th>
                    <td><span class="label <?= $stateArr['style'][$projectSchedule->state]?>"><?= $stateArr['label'][$projectSchedule->state]?></td>
                </tr>
                <?php if ($projectSchedule->state >= 2): ?>
                <tr>
                    <th scope="row"><?= __('进度') ?></th>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $projectSchedule->progress ?>" 
                                aria-valuemin="0" aria-valuemax="100" style="width: <?= $projectSchedule->progress ?>%; <?php if ($projectSchedule->progress == 0): ?>color:#333<?php endif ?>">
                                <span style="display: inline-block;width: 100px;text-align:left;<?php if ($projectSchedule->progress == 0): ?>color:#333<?php endif ?>"><?= $projectSchedule->progress ?>%完成</span>
                            </div>
                        </div>
                    </td>
                </tr>    
                <?php endif ?>                
                <tr>
                    <th scope="row"><?= __('开始时间') ?></th>
                    <td><?= h($projectSchedule->start_time) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('结束时间') ?></th>
                    <td><?= h($projectSchedule->end_time) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('创建时间') ?></th>
                    <td><?= h($projectSchedule->created) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('更新时间') ?></th>
                    <td><?= h($projectSchedule->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
    <?php if (!empty($projectSchedule->project_issues)): ?>
    <div class="related">
        <div class="x_panel">
            <div class="x_title">
                <h4><?= __('Related Project Issues') ?></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th scope="col"><?= __('Id') ?></th>
                        <th scope="col"><?= __('Issue') ?></th>
                        <th scope="col"><?= __('User Id') ?></th>
                        <th scope="col"><?= __('State') ?></th>
                        <th scope="col"><?= __('Project Issue Solution Id') ?></th>
                        <th scope="col"><?= __('Created') ?></th>
                        <th scope="col"><?= __('Modified') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php foreach ($projectSchedule->project_issues as $projectIssues): ?>
                    <tr>
                        <td><?= h($projectIssues->id) ?></td>
                        <td><?= h($projectIssues->issue) ?></td>
                        <td><?= h($projectIssues->user_id) ?></td>
                        <td><?= h($projectIssues->state) ?></td>
                        <td><?= h($projectIssues->project_issue_solution_id) ?></td>
                        <td><?= h($projectIssues->created) ?></td>
                        <td><?= h($projectIssues->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['controller' => 'ProjectIssues', 'action' => 'view', $projectIssues->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectIssues', 'action' => 'edit', $projectIssues->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectIssues', 'action' => 'delete', $projectIssues->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssues->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (!empty($projectSchedule->project_progresses)): ?>
    <div class="related">
        <div class="x_panel">
            <div class="x_title">
                <h4><?= __('进度列表') ?></h4>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content"> 
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th scope="col" style="width: 15%"><?= __('Id') ?></th>
                        <th scope="col"><?= __('内容') ?></th>
                        <th scope="col"><?= __('附件') ?></th>
                        <th scope="col"><?= __('创建时间') ?></th>
                    </tr>
                    <?php foreach ($projectSchedule->project_progresses as $projectProgresses): ?>
                    <tr>
                        <td><?= h($projectProgresses->id) ?></td>
                        <td><?= h($projectProgresses->content) ?></td>
                        <td>
                        <?php if ($projectProgresses->attachment): ?>
                        <?= $projectProgresses->attachment ?>    
                        <?php endif ?>
                        </td>
                        <td><?= h($projectProgresses->created) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
