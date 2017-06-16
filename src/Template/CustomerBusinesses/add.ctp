<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="customerBusinesses form large-12 medium-12 columns content">
    <?= $this->Form->create($customerBusiness) ?>
    <fieldset>
        <legend><?= __('新增日志') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('customer_id', ['type' => 'hidden', 'value' => $customer_id]);
            echo $this->Form->control('content', ['type' => 'textarea', 'label' => '内容']);
        ?>
        <div class="input form-group" style="margin-top: 8px;">
            <label class="col-md-2 col-xs-12">活動日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div> 
        </div>
        <div class="clearfix"></div>
        <div class="input form-group">
            <input type="checkbox" name="notice" id="notice">
            <label for="notice">通知</label>
        </div>
        <div class="input form-group" style="display: none;" id="recipient-field">
            <input type="hidden" id="recipientIds">
            <label for="recipient">通知对象</label>
            <input type="text" name="recipient" id="recipient">
            <div id="recipients"></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
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
            'timePicker' : true,
            'timePicker12Hour' : false
          }, function(start, end, label) {
        });

        $('input[name="notice"]').on('change', function(){
            if(this.checked) {
                $('#recipient-field').slideDown();
            } else {
                $('#recipient-field').slideUp();
            }
        });
        
        var url = window.location.origin + '/customers/get-users/',
            recipients = $('#recipients');

        $('#recipient').autocomplete({
          serviceUrl: url,
          onSelect: function(suggestion) {
            var recipientIds = $('#recipientIds');
            recipientIds.val(recipientIds.val() + suggestion.data + ',');
            recipients.append('<span><label class="label">'+suggestion.value+'</label><i class="fa fa-trash" style="margin-left:6px;" onClick="deleteReci(this,'+suggestion.data+')"></i></span>');
            this.value = ''
          }
        });
    });
    function deleteReci(node,id){
        var recipientIds = $('#recipientIds'),
            ids = recipientIds.val().split(',');
        ids.forEach(function(value,index){
            if(value == id){
                ids.splice(index,1);
                $(node).parent('span').remove();
                recipientIds.val(ids);
                return;
            }
        });
    }
</script>
<?= $this->end() ?>