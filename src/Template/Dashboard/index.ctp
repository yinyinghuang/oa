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
<!-- <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h4>最近任务<?php if ($backlogCount): ?><i class="badge badge-danger"><?= $backlogCount?></i><?php endif ?> </h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-md visible-lg">
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
                        <td><?= $this->Html->link($task->item, $task->deal['url']) ?> </td>
                        <td><?= $this->Html->link(__($task->operator['username']), ['controller' => 'Users', 'action' => 'view', $task->operator['id']]) ?></td>
                        <td><?= h($task->modified) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="hidden-md hidden-lg">
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
</div> -->
<div class="col-md-6 col-sm-6 col-xs-12">   
    <div class="x_panel">
        <div class="x_title">
            <h4>待办事项</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="calendar-header">
                <div class="pull-right form-inline">
                    <div class="btn-group" style="width: 100%;padding: 0  0 10px">
                        <span class="event event-warning" style="display: inline-block;"></span><span style="font-weight: 600">项目审核</span>
                        <span class="event event-success" style="display: inline-block;"></span><span style="font-weight: 600">项目计划</span>
                        <span class="event event-special" style="display: inline-block;"></span><span style="font-weight: 600">客户交易</span>
                        <span class="event event-important" style="display: inline-block;"></span><span style="font-weight: 600">经费审核</span>
                        <span class="event event-info" style="display: inline-block;"></span><span style="font-weight: 600">备忘录</span>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-primary" data-calendar-nav="prev"><i class="fa fa-angle-left"></i></button>
                        <button class="btn btn-default" data-calendar-nav="today">今天</button>
                        <button class="btn btn-primary" data-calendar-nav="next"><i class="fa fa-angle-right"></i></button>
                    </div>
                    <div class="btn-group">
                        <button class="btn btn-warning" data-calendar-view="year">年</button>
                        <button class="btn btn-warning active" data-calendar-view="month">月</button>
                        <button class="btn btn-warning" data-calendar-view="week">周</button>
                        <button class="btn btn-warning" data-calendar-view="day">日</button>
                    </div>
                </div>
                <h3><?= date('F') . ' ' . date('Y') ?></h3>
                <div class="clearfix"></div>
            </div>
            <div id="calendar"></div>
        </div>
        <?php if ($countProjects > 5): ?>
           <a class="btn btn-primary pull-right" href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>">更多</a> 
        <?php endif ?>
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
            <table cellpadding="0" cellspacing="0" class="visible-md visible-lg">
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
            <div class="hidden-md hidden-lg">
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
            <h4>参与项目</h4>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <table cellpadding="0" cellspacing="0" class="visible-md visible-lg">
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
            <div class="hidden-md hidden-lg">
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
    <div class="hidden" data-toggle="modal" data-target="#task-modal" id="modal-trigger">开始</div>
    <div class="modal fade" id="task-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3>备忘录</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="newTask">
                        <input type="hidden" name="user_id" value="<?= $this->request->session()->read('Auth')['User']['id'] ?>">
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">名称</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" required id="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">描述</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="descp" id="" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">日期</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <input type="text" name="start_time" required readonly="readonly" class="form-control datetimepicker" id="start-time">
                                    <span class="input-group-addon">至</span>
                                    <input type="text" name="end_time" required readonly="readonly" class="form-control datetimepicker" id="end-time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div id="uploadSuccess" class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12"></div>
                            <div id="uploadError" class="col-md-offset-3 col-sm-offset-3 col-md-9 col-sm-9 col-xs-12"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" data-dismiss="modal" class="btn">关闭</a>
                    <button type="button" class="btn btn-primary" id="upload">上传</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->start('css') ?>
<?= $this->Html->css('../js/vendors/bootstrap-calendar/css/calendar.css') ?>
<?= $this->end() ?>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<?= $this->Html->script('vendors/underscore/underscore.js') ?>
<?= $this->Html->script('vendors/bootstrap-calendar/js/calendar.js') ?>
<script type="text/javascript">
  $(function(){
    $('#checked').on('click', function(){
        $('#state').val(2);
    });
    $('#rejected').on('click', function(){
        $('#state').val(0);
    });
    $('.datetimepicker').daterangepicker({
        "calender_style" : "picker_3",
        "singleDatePicker" : true,
        "format" : "YYYY-MM-DD",
        'minDate' : moment(),
      }, function(start, end, label) {
    });
    var options = {
            events_source: '/dashboard/get-task',
            view: 'month',
            tmpl_path: '/js/vendors/bootstrap-calendar/tmpls/',
            view: 'day',
            tmpl_cache: false,
            time_start: '09:00',
            time_end: '22:00',
            time_split: '60',
            display_week_numbers: false,
            weekbox: false,
            first_day: 1,
            // modal: "#events-modal",
            onAfterEventsLoad: function(events) {
                if(!events) {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function(key, val) {
                    $(document.createElement('li'))
                        .html('<a href="' + val.url + '">' + val.title + '</a>')
                        .appendTo(list);
                });
            },
            onAfterViewLoad: function(view) {
                $('.calendar-header h3').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };

    var calendar = $('#calendar').calendar(options);
    $('.btn-group button[data-calendar-nav]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.navigate($this.data('calendar-nav'));
        });
    });

    $('.btn-group button[data-calendar-view]').each(function() {
        var $this = $(this);
        $this.click(function() {
            calendar.view($this.data('calendar-view'));
        });
    });
    
    //PC右键，移动长按 新建备忘录
    var timeOutEvent = 0;
    $('.cal-cell1').on({
        contextmenu : addTask,
        touchstart : function(e){
            timeOutEvent = setTimeout(addTask,1000);
            // e.preventDefault();
        },
        touchmove : function(e){
            clearTimeout(timeOutEvent); 
            timeOutEvent = 0;
        },
        touchend : function(e){
            clearTimeout(timeOutEvent); 
            timeOutEvent = 0;
        }

    });
    function addTask(){
        timeOutEvent = 0; 
        $('#modal-trigger').click();
        $('#name').focus();
        return false;
    }
    $('#upload').on('click', function(){ 
        if ($('#start-time').val() > $('#end-time').val()) {
            new PNotify({
                title: '錯誤',
                text: '开始时间不能晚于结束时间',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
            return false;
        }              
        var formData = $('#newTask').serialize(),
            success  = $('#uploadSuccess'),
            error = $('#uploadError'),
            data = {};
        formData = formData.split('&');

        formData.forEach(function(value){
            value = value.split('=');
            if(value) {
                data[value[0]] = value[1];
            }
        });

        $.ajax({
            type : 'post',
            url : '/tasks/add-note',
            data : data,
            success : function(data){
                if(data == 1){
                    success.html('备忘录添加成功');
                    error.html('');
                    setTimeout(function(){
                        $('#close').click();
                    },1000);
                }else{
                    success.html('');
                    error.html('备忘录添加失败，请重试');
                }
            },
            error : function(data){
                alert(data.responseText);
            }
        });
    });

  });
</script> 
<?= $this->end() ?>