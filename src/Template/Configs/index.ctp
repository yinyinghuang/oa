<style type="text/css">
    table{table-layout: auto;width: auto;}
    table td{word-break: normal;}
</style>
<div class="">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>設定 <small></small></h2>
          <ul class="nav navbar-right panel_toolbox">
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <form action="/configs/add" method="post">
            <div class="form-group">
              <label>上班时间</label>
              <div class="form-control">
                  <label> <input type="checkbox" name="weekdays[]" value=1>星期一</label>
                  <label> <input type="checkbox" name="weekdays[]" value=2>星期二</label>
                  <label> <input type="checkbox" name="weekdays[]" value=3>星期三</label>
                  <label> <input type="checkbox" name="weekdays[]" value=4>星期四</label>
                  <label> <input type="checkbox" name="weekdays[]" value=5>星期五</label>
                  <label> <input type="checkbox" name="weekdays[]" value=6>星期六</label>
                  <label> <input type="checkbox" name="weekdays[]" value=7>星期日</label>
              </div>
            </div>
            <div class="form-group">
              <label>法定节假日</label>
              <div id="calendar">
                 
              </div>
            </div>   
            <div class="clearfix"></div>                    
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="submit">儲存</button>
                </div>
            </div>             
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-fade in" id="modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">
                    节假日
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="index" value="">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="min_date" class="col-sm-4 control-label">名称</label>
                        <div class="col-sm-7">
                            <input name="name" type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_date" class="col-sm-4 control-label">类型</label>
                        <div class="col-sm-7">
                            <select name="type" id="type" required> 
                                <option value="0" selected>法定节假</option>
                                <option value="1">上班</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min_date" class="col-sm-4 control-label">日期</label>
                        <div class="col-sm-7">
                            <div class="input-group input-daterange" data-provide="datepicker">
                                <input name="start_date" type="text" class="form-control">
                                <span class="input-group-addon">至</span>
                                <input name="end_date" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="save-event">提交</button>
            </div>
        </div>
    </div>
  </div>
</div>
<?php $this->start('css'); ?>
  <?php echo $this->Html->css("datepicker/bootstrap-datepicker.min.css"); ?>
  <?php echo $this->Html->css("bootstrap-year-calendar/bootstrap-year-calendar.css"); ?>
<?php $this->end(); ?>
<?= $this->start('script') ?>
<!-- summernote-->
<?php echo $this->Html->script("bootstrap-year-calendar/bootstrap-year-calendar.js"); ?>
<?php echo $this->Html->script("datepicker/bootstrap-datepicker.min.js"); ?>
<script>
    $(function () {
        var currentYear = new Date().getFullYear()
			holidayType = ['法定节假日', '上班'];

        $('#calendar').calendar({ 
			overlap : false,
            style : 'background',
            enableContextMenu: true,
            enableRangeSelection: true,
            contextMenuItems:[
                {
                    text: 'Update',
                    click: editEvent
                },
                {
                    text: 'Delete',
                    click: deleteEvent
                }
            ],
            selectRange: function(e) {
                editEvent(e);
            },
            mouseOnDay: function(e) {
                if(e.events.length > 0) {
                    var content = '';
                    
                    for(var i in e.events) {
                        content += '<div class="tooltip-content">'
                                        + '<div class="name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                        + '<div class="type">' + holidayType[e.events[i].type] + '</div>'
                                    + '</div>';
                    }
                
                    $(e.element).popover({ 
                        trigger: 'manual',
                        container: 'body',
                        html:true,
                        content: content
                    });
                    
                    $(e.element).popover('show');
                }
            },
            mouseOutDay: function(e) {
                if(e.events.length > 0) {
                    $(e.element).popover('hide');
                }
            },
            dayContextMenu: function(e) {
                $(e.element).popover('hide');
            },
            dataSource: [
                <?php foreach ($holidays as $holiday): ?>
                {
                    id: '<?= $holiday['id'] ?>',
                    name: '<?= $holiday['name'] ?>',
                    type: '<?= $holiday['type'] ?>',
                    startDate: new Date(currentYear, <?= $holiday['start_month'] ?>, <?= $holiday['start_day'] ?>),
                    endDate: new Date(currentYear, <?= $holiday['end_month'] ?>, <?= $holiday['end_day'] ?>)
                },    
                <?php endforeach ?>
            ]
        });
        
        $('#save-event').click(function() {
            saveEvent();
        });
    });
    function editEvent(event) {
        $('#modal input[name="index"]').val(event ? event.id : '');
        $('#modal input[name="name"]').val(event ? event.name : '');
        $('#type').val(event ? event.type : 0);
        $('#modal input[name="start_date"]').datepicker('update', event ? event.startDate : '');
        $('#modal input[name="end_date"]').datepicker('update', event ? event.endDate : '');
        $('#modal').modal();
    }

    function deleteEvent(event) {
        var dataSource = $('#calendar').data('calendar').getDataSource();
        $.ajax({
            type : 'post',
            url : '/configs/delete-holiday',
            data : {id : event.id},
            success : function(data){
                if (data == 1) {
                    
                    for(var i in dataSource) {
                        if(dataSource[i].id == event.id) {
                            dataSource.splice(i, 1); 
                            break;
                        }
                    }
                    $('#calendar').data('calendar').setDataSource(dataSource);
                }
            },
            error : function(data){
                console.log(data);
            }
        });
        
        
       
    }

    function saveEvent() {
        var event = {
            id: $('#modal input[name="index"]').val(),
            name: $('#modal input[name="name"]').val(),
            type: $('#type').val(),
            startDate: $('#modal input[name="start_date"]').datepicker('getDate'),
            endDate: $('#modal input[name="end_date"]').datepicker('getDate')
        }
        var flag = false;
        if(event.name == ''){
            flag = true;
            new PNotify({
                title: '錯誤',
                text: '请填写名称',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
            
        } else if(event.type == null){
            flag = true;
            new PNotify({
                title: '錯誤',
                text: '请选择类型',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
        } else if(event.startDate == '' || event.endDate == ''){
            flag = true;
            new PNotify({
                title: '錯誤',
                text: '请选择时间',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
        }
        if(flag) return false;
        $.ajax({
            type : 'post',
            url : '/configs/save-holiday',
            data : event,
            success : function(data){
                if (data == 1) {
                    var dataSource = $('#calendar').data('calendar').getDataSource();

                    if(event.id) {
                        for(var i in dataSource) {
                            if(dataSource[i].id == event.id) {
                                dataSource[i].name = event.name;
                                dataSource[i].type = event.type;
                                dataSource[i].startDate = event.startDate;
                                dataSource[i].endDate = event.endDate;
                            }
                        }
                    }
                    else
                    {
                        var newId = 0;
                        for(var i in dataSource) {
                            if(dataSource[i].id > newId) {
                                newId = dataSource[i].id;
                            }
                        }
                        
                        newId++;
                        event.id = newId;
                    
                        dataSource.push(event);
                    }
                    
                    $('#calendar').data('calendar').setDataSource(dataSource);
                }
            },
            error : function(data){
                console.log(data);
            }
        });
        
        
        $('#modal').modal('hide');
    }
</script>
<?= $this->end() ?>