<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('删除'),
                ['action' => 'delete', $project->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $project->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('项目列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="projects form large-10 medium-9 columns content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('编辑项目') ?></legend>
        <?php
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => count($project->project_schedules)]);
            echo $this->Form->control('title',['label' => '项目名称']);
            echo $this->Form->control('brief',['label' => '项目内容','type' => 'textarea', 'class' => 'editor']);
        ?>
        <div class="input required">
            <label class="col-md-2 col-xs-12">项目日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($project->start_time) ? $project->start_time : ''?>">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($project->end_time) ? $project->end_time : ''?>">
                </div>
            </div> 
            <div class="clearfix"></div>
        </div>
        <input type="hidden" id="auditor" name="auditor" value="<?= $project->auditor?>">
        <div class="input textarea required">
            <label for="">审核人</label>
            <input type="text" id="auditorInput" value="<?= $project->auditorInput ?>">
        </div>
        <div class="input file">
            <label>凭证</label>
            <input type="text" id="attachment" readonly value="<?= $project->attachment ?>" name="attachment"  readonly="readonly">
            <a class="btn btn-warning" data-toggle="modal" data-target="#uploadModal">上传</a>            
        </div>
        <div class="ln_solid"></div>
        <legend><?= __('项目计划表') ?></legend>
        <?php foreach ($project->project_schedules as $key => $schedule): ?>
            <?php
            $k = $key + 1;
            echo '<div id="add-' . $k . '">';
            echo $this->Form->control('schedule_id_' . $k,['value' => $schedule->id, 'type' => 'hidden']);
            echo $this->Form->control('title_' . $k,['label' => '计划名' . $k . '称', 'required' => true,'value' => $schedule->title]);
            echo $this->Form->control('brief_' . $k,['label' => '工作内容','type' => 'textarea', 'required' => true,'value' => $schedule->brief]);
            echo $this->Form->control('participant_id_' . $k, ['type' => 'hidden','value' => $schedule->user_id]);
            echo $this->Form->control('participant_' . $k, ['label' => '参与人', 'required' => true,'value' => $schedule->user['username']]); 
            echo '</div>';
            ?>
            <div class="input required">
                <label class="col-md-2 col-xs-12">项目日期</label>
                <div class="col-md-6 col-xs-12">
                    <div class="input-group">
                        <input type="text" name="start_time_<?= $k?>" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($schedule->start_time) ? $schedule->start_time : ''?>">
                        <span class="input-group-addon">至</span>
                        <input type="text" name="end_time_<?= $k?>" class="form-control datetimepicker" readonly="readonly" required value="<?= isset($schedule->end_time) ? $schedule->end_time : ''?>">
                    </div>
                </div> 
                <div class="clearfix"></div>
            </div>
            <a class="btn btn-danger del" onClick="deleteSchedule(this)">删除</a>
            <div class="ln_solid">
            </div>
        <?php endforeach ?>
        <a class="btn btn-warning" id="add">新增计划</a>
    </fieldset>
    <?= $this->Form->button(__('提交'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="uploadModalLabel">上传附件</h4>
            </div>            
            <div class="modal-body">
                <input type="file" id="file" style="display: block;">               
                <div id="uploadSuccess"></div>
                <div id="uploadError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="upload">上传</button>
            </div>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php $this->start('css'); ?>
  <?php echo $this->Html->css("summernote/summernote.css"); ?>
<?php $this->end(); ?>
<?= $this->start('script') ?>
<!-- summernote-->
<?php echo $this->Html->script("summernote/dist/summernote.min.js"); ?>
<script type="text/javascript">
     $(document).ready(function() {
        $('.editor').summernote({
            height: "200px",
            minHeight: "100px",
            maxHeight: "900px",
        });
        //datatimepicker
        $('.datetimepicker').daterangepicker({
            "calender_style": "picker_3",
            "singleDatePicker": true,
            "format" : "YYYY-MM-DD",
          }, function(start, end, label) {
        });

        $('#file').on('click',function(){
            $('#upload').attr('disabled', false);
        });    
        $('#upload').on('click', function(){               
            var formData = new FormData(),
                success  = $('#uploadSuccess'),
                error = $('#uploadError');
            formData.append('path', "projects/attachments");
            formData.append('attachment', $('#file')[0].files[0]);
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build(['controller' => 'App', 'action' => 'saveAttachment']) ?>',
                data : formData,
                cache: false,
                processData: false,
                contentType: false,
                success : function(data){console.log(data);
                    data = JSON.parse(data);
                    if(data.result){
                        $('#attachment').val(data.url);
                        success.html(data.html);
                        $('#upload').attr('disabled', true);
                        error.html('');
                        setTimeout(function(){
                            $('#close').click();
                        },1000);
                    }else{
                        success.html('');
                        error.html(data.error);
                    }
                },
                error : function(data){
                    alert(data.responseText);
                }
            });
        });

        var add = $('#add');
        add.on('click', function(){
            var num = $('#num'),
                i = num.val() * 1 + 1,
                html = '<div id="add-' + i + '"><input type="hidden" name="schedule_id_'+i+'" value="" class="schedule_id"><div class="input text required"><label for="title-' + i + '">计划' + i + '名称</label><input type="text" name="title_' + i + '" id="title-' + i + '" required /></div><div class="input textarea required"><label for="brief-' + i + '">工作内容</label><textarea name="brief_' + i + '" id="brief-' + i + '" rows="5" required></textarea></div><input type="hidden" name="participant_id_' + i + '" id="participant-id-' + i + '"/><div class="input text required"><label for="participant-' + i + '">参与人</label><input type="text" name="participant_' + i + '" id="participant-' + i + '" required/></div><div class="input required"><label class="col-md-2 col-xs-12">计划日期</label><div class="col-md-6 col-xs-12">    <div class="input-group"><input type="text" name="start_time_' + i + '" class="form-control datetimepicker" readonly="readonly" required><span class="input-group-addon">至</span><input type="text" name="end_time_' + i + '" class="form-control datetimepicker" readonly="readonly" required></div></div><div class="clearfix"></div></div><a class="btn btn-danger" id="del" onClick="deleteSchedule(this)">删除</a><div class="ln_solid"></div></div>',
                del = '';
            add.before(html);

            $('#participant-' + i).autocomplete({
              serviceUrl: url,
              onSelect: function(suggestion) {
                  $(this).parent('div').prev('input').val(suggestion.data);
              },
              onInvalidateSelection: function() {
                  $(this).val('').parent('div').prev('input').val('');
              }
            });
            $('.datetimepicker').daterangepicker({
                "calender_style": "picker_3",
                "singleDatePicker": true,
                "format" : "YYYY-MM-DD",
              }, function(start, end, label) {
            });
            num.val(i);
        });

        var url = window.location.origin + '/projects/get-users/';
        $('#participant-1').autocomplete({
          serviceUrl: url,
          onSelect: function(suggestion) {
              $(this).parent('div').prev('input').val(suggestion.data);
          },
          onInvalidateSelection: function() {
              $(this).val('').parent('div').prev('input').val('');
          }
        });
        
        $('#auditorInput').autocomplete({
          serviceUrl: url + '/projects/get-users/?type=auditor',
          onSelect: function(suggestion) {
              $('#auditor').val(suggestion.data);
          },
          onInvalidateSelection: function() {
              $(this).val('');
              $('#auditor').val('');
          }
        });
        $('#submit').on('click', function(){
            var num = $('#num').val(),
                flag = false,
                start_time_p = $('#start-time').val(),
                end_time_p = $('#end-time').val();
            for (var i = 1; i <= num; i++) {
                if (!document.getElementById('participant-id-' + i)) continue;
                var value = $('#participant-id-' + i).val();
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
                    flag = true;                   
                }
                if (start_time_p > $('#start-time-' + i).val()) {
                    new PNotify({
                        title: '錯誤',
                        text: '计划' + i + '开始时间早于项目开始时间，请重新填写',
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000,
                        width:'280px'
                    });
                    $('#start-time-' + i).focus();
                    flag = true;
                }
                if (end_time_p < $('#end-time-' + i).val()) {
                    new PNotify({
                        title: '錯誤',
                        text: '计划' + i + '结束时间晚于项目开始时间，请重新填写',
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000,
                        width:'280px'
                    });
                    $('#end-time-' + i).focus();
                    flag = true;
                }
            }
            if (flag) return false;
        });
    });

     function deleteSchedule(node){
         var num = $('#num'),
             i = num.val() * 1,
             id = $(node).siblings('.schedule_id')[0].value,
             parent =  $(node).parent('div');
         if(confirm('确定要删除此计划？')){
             if (id !== '') {
                 $.ajax({
                     type : 'post',
                     url : '<?= $this->Url->build(['action' => 'deleteSchedule'])?>',
                     data : {
                         id : id
                     },
                     success : function(data){
                         if(data == 1){
                             parent.remove();
                         }else {
                             alert('删除失败，请重试');
                         }
                     }
                 });
             }else{
                 $(node).parent('div').remove();
             }
         }                
         
     }
</script>
<?= $this->end() ?>