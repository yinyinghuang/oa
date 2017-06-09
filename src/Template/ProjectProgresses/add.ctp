<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('返回'), ['controller' => 'ProjectSchedules','action' => 'view',$project_schedule_id]) ?></li>
    </ul>
</nav>
<div class="projectProgresses form large-10 medium-9 columns content">
    <?= $this->Form->create($projectProgress) ?>
    <fieldset>
        <legend><?= __('添加进展') ?></legend>
        <?php
            echo $this->Form->control('project_schedule_id', ['type' => 'hidden','value' => $project_schedule_id]);
            echo $this->Form->control('progress', ['type' => 'hidden']);
            echo $this->Form->control('content',['label' => '内容','type' => 'textarea']);
        ?>
        <div class="input required range form-group" style="padding-bottom: 4px;">
            <label class="control-label col-md-2 col-sm-3 col-xs-12">进度</label>
            <div class="col-md-6 col-sm-8 col-xs-9">
                <input type="range" max="100" min="0" step="5" oninput="showValue(this)" onchange="showValue(this)" value="<?= $projectSchedule->progress?>">
            </div>
            <div class="col-md-2 col-sm-4 col-xs-3">
                <output class="form-control" id="progressOuput"><?= $projectSchedule->progress?>%</output>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="input file">
            <label>附件</label>
            <input type="text" id="attachment" name="attachment" readonly="readonly">
            <a class="btn btn-warning" data-toggle="modal" data-target="#uploadModal">上传</a>            
        </div>
        
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
<?= $this->start('script') ?>
<script type="text/javascript">
  $(function(){
    $('#submit').on('click',function(){
      if($('#progress').val() <= <?= $projectSchedule->progress?>){
          new PNotify({
              title: '錯誤',
              text: '请正确填写进度,必须大于<?= $projectSchedule->progress?>%',
              type: 'error',
              styling: 'bootstrap3',
              delay: 3000,
              width:'280px'
          });
          return false;
      }
    });
    $('#file').on('click',function(){
        $('#upload').attr('disabled', false);
    });    
    $('#upload').on('click', function(){               
        var formData = new FormData(),
            success  = $('#uploadSuccess'),
            error = $('#uploadError');
        formData.append('path', "projects/progresses/attachments");
        formData.append('attachment', $('#file')[0].files[0]);
        $.ajax({
            type : 'post',
            url : '<?= $this->Url->build(['controller' => 'App', 'action' => 'saveAttachment']) ?>',
            data : formData,
            cache: false,
            processData: false,
            contentType: false,
            success : function(data){
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
  })
  var output = document.getElementById('progressOuput'),
      input = document.getElementById('progress');
  function showValue(node){
    output.value = node.value + '%';
    input.value = node.value;
  }
    

</script> 
<?= $this->end() ?>