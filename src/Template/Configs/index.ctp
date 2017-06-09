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
          <?php echo $this->Form->create('Application', array('class' => 'group-border-dashed', 'type' => 'file')); ?>
            <div class="form-group">
              <label>商店名稱</label>
              <div>
                  <?= $this->Form->input('store_name', ['class' => 'form-control', 'label' => false, 'value' => '']) ?>
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
          <?php echo $this->Form->end(); ?> 
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-fade in" id="event-modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">
                    节假日
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="event-index" value="">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">名称</label>
                        <div class="col-sm-7">
                            <input name="event-name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="min-date" class="col-sm-4 control-label">日期</label>
                        <div class="col-sm-7">
                            <div class="input-group input-daterange" data-provide="datepicker">
                                <input name="event-start-date" type="text" class="form-control">
                                <span class="input-group-addon">至</span>
                                <input name="event-end-date" type="text" class="form-control">
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
        var currentYear = new Date().getFullYear();

        $('#calendar').calendar({ 
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
                editEvent({ startDate: e.startDate, endDate: e.endDate });
            },
            mouseOnDay: function(e) {
                if(e.events.length > 0) {
                    var content = '';
                    
                    for(var i in e.events) {
                        content += '<div class="event-tooltip-content">'
                                        + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                        + '<div class="event-location">' + e.events[i].location + '</div>'
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
                {
                    id: 0,
                    name: 'Google I/O',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 4, 28),
                    endDate: new Date(currentYear, 4, 29)
                },
                {
                    id: 1,
                    name: 'Microsoft Convergence',
                    location: 'New Orleans, LA',
                    startDate: new Date(currentYear, 2, 16),
                    endDate: new Date(currentYear, 2, 19)
                },
                {
                    id: 2,
                    name: 'Microsoft Build Developer Conference',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 3, 29),
                    endDate: new Date(currentYear, 4, 1)
                },
                {
                    id: 3,
                    name: 'Apple Special Event',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 8, 1),
                    endDate: new Date(currentYear, 8, 1)
                },
                {
                    id: 4,
                    name: 'Apple Keynote',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 8, 9),
                    endDate: new Date(currentYear, 8, 9)
                },
                {
                    id: 5,
                    name: 'Chrome Developer Summit',
                    location: 'Mountain View, CA',
                    startDate: new Date(currentYear, 10, 17),
                    endDate: new Date(currentYear, 10, 18)
                },
                {
                    id: 6,
                    name: 'F8 2015',
                    location: 'San Francisco, CA',
                    startDate: new Date(currentYear, 2, 25),
                    endDate: new Date(currentYear, 2, 26)
                },
                {
                    id: 7,
                    name: 'Yahoo Mobile Developer Conference',
                    location: 'New York',
                    startDate: new Date(currentYear, 7, 25),
                    endDate: new Date(currentYear, 7, 26)
                },
                {
                    id: 8,
                    name: 'Android Developer Conference',
                    location: 'Santa Clara, CA',
                    startDate: new Date(currentYear, 11, 1),
                    endDate: new Date(currentYear, 11, 4)
                },
                {
                    id: 9,
                    name: 'LA Tech Summit',
                    location: 'Los Angeles, CA',
                    startDate: new Date(currentYear, 10, 17),
                    endDate: new Date(currentYear, 10, 17)
                }
            ]
        });
        
        $('#save-event').click(function() {
            saveEvent();
        });
    });
    function editEvent(event) {
        $('#event-modal input[name="event-index"]').val(event ? event.id : '');
        $('#event-modal input[name="event-name"]').val(event ? event.name : '');
        $('#event-modal input[name="event-location"]').val(event ? event.location : '');
        $('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
        $('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
        $('#event-modal').modal();
    }

    function deleteEvent(event) {
        var dataSource = $('#calendar').data('calendar').getDataSource();

        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource.splice(i, 1); 
                break;
            }
        }
        
        $('#calendar').data('calendar').setDataSource(dataSource);
    }

    function saveEvent() {
        var event = {
            id: $('#event-modal input[name="event-index"]').val(),
            name: $('#event-modal input[name="event-name"]').val(),
            location: $('#event-modal input[name="event-location"]').val(),
            startDate: $('#event-modal input[name="event-start-date"]').datepicker('getDate'),
            endDate: $('#event-modal input[name="event-end-date"]').datepicker('getDate')
        }
        
        var dataSource = $('#calendar').data('calendar').getDataSource();

        if(event.id) {
            for(var i in dataSource) {
                if(dataSource[i].id == event.id) {
                    dataSource[i].name = event.name;
                    dataSource[i].location = event.location;
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
        $('#event-modal').modal('hide');
    }
</script>
<?= $this->end() ?>