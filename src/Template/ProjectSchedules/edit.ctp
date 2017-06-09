<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__($projectSchedule->project->title), ['controller' => 'Projects', 'action' => 'view', $projectSchedule->project->id]) ?></li>
        <li><?= $this->Html->link(__('计划列表'), ['action' => 'index', $projectSchedule->project_id]) ?></li>
        <li><?= $this->Form->postLink(
                __('删除'),
                ['action' => 'delete', $projectSchedule->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $projectSchedule->id)]
            )
        ?></li>
    </ul>
</nav>
<div class="projectSchedules form large-10 medium-9 columns content">
    <?= $this->Form->create($projectSchedule) ?>
    <fieldset>
        <legend><?= __('编辑计划') ?></legend>
        <?php
            echo $this->Form->control('project_id', ['type' => 'hidden', 'value' => $projectSchedule->project_id]);
            echo $this->Form->control('state', ['type' => 'hidden', 'value' => 0]);
            echo $this->Form->control('title', ['label' => '计划名称']);
            echo $this->Form->control('brief', ['type' => 'textarea', 'label' => '工作内容']);
            echo $this->Form->control('participant_id', ['type' => 'hidden','value' => $projectSchedule->user_id]);
            echo $this->Form->control('participant', ['label' => '参与人', 'required' => true,'value' => $projectSchedule->user['username']]);
        ?>
        <div class="input required">
            <label class="col-md-2 col-xs-12">计划日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($projectSchedule->start_time) ? $projectSchedule->start_time : ''?>">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($projectSchedule->end_time) ? $projectSchedule->end_time : ''?>">
                </div>
            </div> 
            <div class="clearfix"></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('提交'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
     $(document).ready(function() {
        //datatimepicker
        $('.datetimepicker').daterangepicker({
            "calender_style": "picker_3",
            "singleDatePicker": true,
            "format" : "YYYY-MM-DD HH:mm",
          }, function(start, end, label) {
        });

        var url = window.location.origin + '/projects/get-users/';
        $('#participant').autocomplete({
          serviceUrl: url,
          onSelect: function(suggestion) {
              $(this).parent('div').prev('input').val(suggestion.data);
          },
          onInvalidateSelection: function() {
              $(this).val('').parent('div').prev('input').val('');
          }
        });
        $('#submit').on('click', function(){
            var value = $('#participant-id').val();
            if(value == ''){
                new PNotify({
                    title: '錯誤',
                    text: '计划' + i + '的负责人填写不正确',
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 3000,
                    width:'280px'
                });
                $('#participant-' + i).focus();
                return false;                    
            }            
        });
    })
</script>
<?= $this->end() ?>