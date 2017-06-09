<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('流水列表'), ['action' => 'index']) ?></li>        
    </ul>
</nav>
<div class="finances form large-10 medium-9 columns content">
    <h3>
      <label>当前账户余额：</label><strong><?= $balance->balance ?>元</strong>
    </h3>
    <?= $this->Form->create($finance,['enctype' => "multipart/form-data"]) ?>
    <fieldset>
        <legend><?= __('新增') ?></legend>
        <?php
            echo $this->Form->control('payee_id', ['type' => 'hidden', 'value' => isset($task) && $task ? $task->payee['id'] : '']);
            echo $this->Form->control('task_id', ['type' => 'hidden', 'value' => isset($task) && $task ? $task->id : '']);
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('payee_type', ['type' => 'radio', 'default' => 0, 'options' => [0 => '公司外部', 1 => '公司内部'], 'label' => '收款人类型', 'value' =>  isset($task) && $task ? 1 : 0]);
        ?>
        <div class="input text required">
            <label for="">收款人</label>
            <input type="text" name="payee_0" id="payee-0" <?php if (isset($task) && $task): ?>style="display: none"<?php endif ?>>
            <input type="text" name="payee_1" id="payee-1" <?php if (!isset($task) || !$task): ?>style="display: none"<?php else: ?>value="<?= $task->payee['username']?>"<?php endif ?>>
        </div>
        <?php 
            echo $this->Form->control('amount',['max' => $balance->balance, 'min' => 1, 'label' => '金额', 'value' =>  isset($task) && $task ? $task->finance_apply['amount'] : '']);
            echo $this->Form->control('detail', ['type' => 'textarea', 'label' => '明细', 'value' =>  isset($task) && $task ? $task->finance_apply['content'] : '']);
            echo $this->Form->control('finance_type_id', ['options' => $financeTypes, 'empty' => '请选择', 'label' => '交易方式']);
        ?>
        <div class="input file">
            <label>凭证</label>
            <input type="text" id="receipt" readonly value="<?= $finance->receipt ?>" name="receipt">
            <a class="btn btn-warning" data-toggle="modal" data-target="#uploadModal">上传</a>            
        </div>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary','pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="uploadModalLabel">上传凭证</h4>
            </div>            
            <div class="modal-body">
                <input type="file" id="file" name="attachment" style="display: block;">               
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
  var url = window.location.origin + '/finances/get-users/';
  $('#payee-1').autocomplete({
    serviceUrl: url,
    onSelect: function(suggestion) {
        $('#payee-id').val(suggestion.data);
    },
    onInvalidateSelection: function() {
      $(this).val('');
      $('#payee-id').val('');
    }
  });
  $('#payee-type-0').on('click',function(){
    $('#payee-0').show();
    $('#payee-1').hide();
  });
  $('#payee-type-1').on('click',function(){
    $('#payee-1').show();
    $('#payee-0').hide();
  });
  $('#attachment').on('click',function(){
      $('#upload').attr('disabled', false);
  });
  $('#upload').on('click', function(){               
      var formData = new FormData(),
          success  = $('#uploadSuccess'),
          error = $('#uploadError');
      formData.append('path', "receipts");
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
                  $('#receipt').val(data.url);
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
  $('#submit').on('click', function(){               
      if($('input:radio[name="payee_type"]:checked').val() == 1 && $('#payee-id').val() == 0){
        new PNotify({
            title: '錯誤',
            text: '若收款人选择公司内部员工，请正确填写收款人',
            type: 'error',
            styling: 'bootstrap3',
            delay: 3000,
            width:'280px'
        });
        return false;
      }
  });
</script> 
<?= $this->end() ?>