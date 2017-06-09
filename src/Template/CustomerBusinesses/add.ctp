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
        <div class="input form-group">
            <label class="col-md-2 col-xs-12">活動日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div> 
        </div>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary', 'pull-right']]) ?>
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
    })
</script>
<?= $this->end() ?>