<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Customer Incomes'), ['action' => 'customerIncomes', $customer_id]) ?></li>        
    </ul>
</nav>
<div class="finances form large-9 medium-8 columns content">
    <?= $this->Form->create($finance, ['enctype' => "multipart/form-data"]) ?>
    <fieldset>
        <legend><?= __('Add Finance') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $customer_id]);
            echo $this->Form->control('amount');
            echo $this->Form->control('detail', ['type' => 'textarea']);
            echo $this->Form->control('finance_type_id', ['options' => $financeTypes, 'empty' => '请选择']);
        ?>
        <div class="input file">
            <label>凭证</label>
            <input type="text" id="receipt" readonly value="<?= $finance->receipt ?>" name="receipt">
            <a class="btn btn-warning" data-toggle="modal" data-target="#uploadModal">上传</a>            
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary','pull-right']]) ?>
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
                <button type="button" class="btn btn-primary" id="submit">上传</button>
            </div>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
  $(function(){
    $('#attachment').on('click',function(){
        $('#submit').attr('disabled', false);
    });
    $('#submit').on('click', function(){               
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
                    $('#submit').attr('disabled', true);
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
                console.log(data.responseText);
            }
        });
    });
  });
</script> 
<?= $this->end() ?>