<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="customerBusinesses form large-12 medium-12 columns content">
    <?= $this->Form->create($customerBusiness) ?>
    <fieldset>
        <legend><?= __('编辑日志') ?></legend>
        <?php
            echo $this->Form->control('content', ['type' => 'textarea', 'label' => '内容']);
        ?>
        <div class="input form-group">
            <label class="col-md-2 col-xs-12">活動日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_time" value="<?= $customerBusiness->start_time ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_time" value="<?= $customerBusiness->end_time ?>"  class="form-control datetimepicker" readonly="readonly">
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