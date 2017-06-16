<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($customer_id != 0): ?>
        <li><?= $this->Html->link(__($customer->name), ['controller' => 'Customers', 'action' => 'view',$customer_id ? $customer_id : 0]) ?></li>         
        <?php endif ?>
           
        <li><?= $this->Html->link(__('收益列表'), ['action' => 'index',$customer_id ? $customer_id : 0]) ?></li>        
    </ul>
</nav>
<div class="customerIncomes form large-10 medium-9 columns content">
    <?= $this->Form->create($customerIncome) ?>
    <fieldset>
        <legend><?= __('新增收益') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $customer_id]);
            if ($customer_id == 0) {
                echo $this->Form->control('customer', ['type' => 'text', 'required' => true, 'label' => '客户']);
            }
            
            echo $this->Form->control('amount',['label' => '金额']);
            echo $this->Form->control('detail', ['type' => 'textarea', 'label' => '明细']);
            echo $this->Form->control('finance_type_id', ['options' => $financeTypes, 'empty' => '请选择', 'label' => '交易方式']);
        ?>
        <div class="input file">
            <label>凭证</label>
            <input type="text" id="receipt" readonly value="<?= $customerIncome->receipt ?>" name="receipt">
            <a class="btn btn-warning" data-toggle="modal" data-target="#uploadModal">上传</a>            
        </div>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
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
  $(function(){
    <?php if($customer_id == 0) :?>
    var url = window.location.origin + '/customerIncomes/get-customers/';
    $('#customer').autocomplete({
      serviceUrl: url,
      onSelect: function(suggestion) {
          $('#customer-id').val(suggestion.data);
      },
      onInvalidateSelection: function() {
        $('#customer-id').val('');
      }
    });
    <?php endif ;?>
    $('#file').on('click',function(){
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
                console.log(data.responseText);
            }
        });
    });
    $('#submit').on('click', function(){               
        if($('#customer-id').val() == 0){
          new PNotify({
              title: '錯誤',
              text: '请正确填写客户名称',
              type: 'error',
              styling: 'bootstrap3',
              delay: 3000,
              width:'280px'
          });
          return false;
        }
    });
  });
</script> 
<?= $this->end() ?>