<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tasks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Task'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Finance Applies'), ['controller' => 'FinanceApplies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Finance Apply'), ['controller' => 'FinanceApplies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Issue Solutions'), ['controller' => 'ProjectIssueSolutions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue Solution'), ['controller' => 'ProjectIssueSolutions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Issues'), ['controller' => 'ProjectIssues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Issue'), ['controller' => 'ProjectIssues', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Progresses'), ['controller' => 'ProjectProgresses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Progress'), ['controller' => 'ProjectProgresses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Project Schedules'), ['controller' => 'ProjectSchedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project Schedule'), ['controller' => 'ProjectSchedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tasks view large-9 medium-8 columns content">
    <h3><?= h($task->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $task->has('user') ? $this->Html->link($task->user->username, ['controller' => 'Users', 'action' => 'view', $task->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Controller') ?></th>
            <td><?= h($task->controller) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($task->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Itemid') ?></th>
            <td><?= $this->Number->format($task->itemid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $this->Number->format($task->state) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Finance Applies') ?></h4>
        <?php if (!empty($task->finance_applies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Approver') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->finance_applies as $financeApplies): ?>
            <tr>
                <td><?= h($financeApplies->id) ?></td>
                <td><?= h($financeApplies->task_id) ?></td>
                <td><?= h($financeApplies->user_id) ?></td>
                <td><?= h($financeApplies->approver) ?></td>
                <td><?= h($financeApplies->amount) ?></td>
                <td><?= h($financeApplies->created) ?></td>
                <td><?= h($financeApplies->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FinanceApplies', 'action' => 'view', $financeApplies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FinanceApplies', 'action' => 'edit', $financeApplies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FinanceApplies', 'action' => 'delete', $financeApplies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeApplies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Issue Solutions') ?></h4>
        <?php if (!empty($task->project_issue_solutions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Issues Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Solution') ?></th>
                <th scope="col"><?= __('Attachment') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->project_issue_solutions as $projectIssueSolutions): ?>
            <tr>
                <td><?= h($projectIssueSolutions->id) ?></td>
                <td><?= h($projectIssueSolutions->task_id) ?></td>
                <td><?= h($projectIssueSolutions->project_issues_id) ?></td>
                <td><?= h($projectIssueSolutions->user_id) ?></td>
                <td><?= h($projectIssueSolutions->solution) ?></td>
                <td><?= h($projectIssueSolutions->attachment) ?></td>
                <td><?= h($projectIssueSolutions->created) ?></td>
                <td><?= h($projectIssueSolutions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectIssueSolutions', 'action' => 'view', $projectIssueSolutions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectIssueSolutions', 'action' => 'edit', $projectIssueSolutions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectIssueSolutions', 'action' => 'delete', $projectIssueSolutions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectIssueSolutions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Issues') ?></h4>
        <?php if (!empty($task->project_issues)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Schedule Id') ?></th>
                <th scope="col"><?= __('Issue') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Project Issue Solution Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->project_issues as $projectIssues): ?>
            <tr>
                <td><?= h($projectIssues->id) ?></td>
                <td><?= h($projectIssues->task_id) ?></td>
                <td><?= h($projectIssues->project_schedule_id) ?></td>
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
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Progresses') ?></h4>
        <?php if (!empty($task->project_progresses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Schedule Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Progress') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->project_progresses as $projectProgresses): ?>
            <tr>
                <td><?= h($projectProgresses->id) ?></td>
                <td><?= h($projectProgresses->task_id) ?></td>
                <td><?= h($projectProgresses->project_schedule_id) ?></td>
                <td><?= h($projectProgresses->content) ?></td>
                <td><?= h($projectProgresses->progress) ?></td>
                <td><?= h($projectProgresses->created) ?></td>
                <td><?= h($projectProgresses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectProgresses', 'action' => 'view', $projectProgresses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectProgresses', 'action' => 'edit', $projectProgresses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectProgresses', 'action' => 'delete', $projectProgresses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectProgresses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Project Schedules') ?></h4>
        <?php if (!empty($task->project_schedules)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Project Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Breif') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Start Time') ?></th>
                <th scope="col"><?= __('End Time') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->project_schedules as $projectSchedules): ?>
            <tr>
                <td><?= h($projectSchedules->id) ?></td>
                <td><?= h($projectSchedules->task_id) ?></td>
                <td><?= h($projectSchedules->project_id) ?></td>
                <td><?= h($projectSchedules->title) ?></td>
                <td><?= h($projectSchedules->breif) ?></td>
                <td><?= h($projectSchedules->user_id) ?></td>
                <td><?= h($projectSchedules->state) ?></td>
                <td><?= h($projectSchedules->start_time) ?></td>
                <td><?= h($projectSchedules->end_time) ?></td>
                <td><?= h($projectSchedules->created) ?></td>
                <td><?= h($projectSchedules->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ProjectSchedules', 'action' => 'view', $projectSchedules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ProjectSchedules', 'action' => 'edit', $projectSchedules->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ProjectSchedules', 'action' => 'delete', $projectSchedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedules->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($task->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Task Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Participants') ?></th>
                <th scope="col"><?= __('Brief') ?></th>
                <th scope="col"><?= __('State') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('End Date') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($task->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->task_id) ?></td>
                <td><?= h($projects->title) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->participants) ?></td>
                <td><?= h($projects->brief) ?></td>
                <td><?= h($projects->state) ?></td>
                <td><?= h($projects->start_date) ?></td>
                <td><?= h($projects->end_date) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
