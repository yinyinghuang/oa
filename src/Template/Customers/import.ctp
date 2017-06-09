<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('客户列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customers form large-10 medium-9 columns content">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>导入客户 <small></small></h2>
          <ul class="nav navbar-right panel_toolbox">
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <?php echo $this->Form->create('Application', array('class' => 'form-horizontal group-border-dashed', 'type' => 'file')); ?>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">选择分类</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php  
                    echo $this->Form->control('customer_category_id', ['type' => 'hidden', 'id' => 'parent-id']);
                    echo $this->Form->input('customer_category', ['options' => $customerCategories, 'empty' => '请选择', 'class' => 'parent_id','label' => false, 'div' =>false]);
                  ?>
              </div>
            </div>
            <div class="form-group" id="example" style="display: none">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">下载范本</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php echo $this->Html->link('下载 import_customers.xls', '/files/customer_excels/import_bookings.xls', array('class' => 'form-control'));?>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">上传 Excel 文件 (.xls or .xlsx)</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php echo $this->Form->input("File.import_file", array('label' => false, 'div' => false, 'class' => "form-control", 'type' => 'file', 'accept' => '.xls,.xlsx'));?>
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="submit" id="submit">导入</button>
                    <button class="btn btn-default" type="button" onclick="window.location.href='<?= $this->Url->build(['controller' => 'Customers', 'action' => 'index']) ?>'">取消</button>
                </div>
            </div>             
          <?php echo $this->Form->end(); ?> 

          <div class="alert alert-info">客户类型的额外字段中必填字段请确认已填上，否自导入不成功</div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
          loadChilds(this);
        });
        $('#submit').on('click', function(){
          if($('#parent-id').val() === '') {
            new PNotify({
                title: '錯誤',
                text: '请选择客户类型',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
            return false;
          }
        });
    });
    function loadChilds(node){
        var example = $('#example'),
            a = example.find('a')[0],
            value = node.value,
            parent_id = $('#parent-id');
        if (node.value == 0 && $(node).prev('select').length > 0) {
            parent_id.val($(node).prev('select').val());
        } else {
             parent_id.val(node.value);
        }
        
        $(node).nextAll('select').remove();
        if(value !== ''){
            var that = node;
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build(['controller' => 'CustomerCategories','action' => 'loadChilds'])?>',
                data : {
                    parent_id : node.value
                },
                success : function(data){      
                    data = JSON.parse(data);        
                    if (data.child.length != 0) { 
                        var html = '<select class="parent_id" onChange="loadChilds(this)"><option value="">请选择</option>';
                        for (var i in data.child) {
                            html += '<option value="' + i + '">' + data.child[i] + '</option>';
                        }
                        html += '</select>';
                        html = $(html);
                        $(that).after(html);                            
                    }
                    if (value != 0){
                      a.href = '/files/customer_excels/import_customers_' + value + '.xls';
                      a.text = '下载 import_customers_' + value + '.xls';
                      example.show();
                      parent_id.val(value);
                    } else if(value == 0 && $(that).prev('select').length > 0){
                      value = $(that).prev('select').val();
                      a.href = '/files/customer_excels/import_customers_' + value + '.xls';
                      a.text = '下载 import_customers_' + value + '.xls';
                      example.show();
                      parent_id.val($(that).prev('select').val());
                    }
                }
            });
        }else{
          a.href = a.text = '';
          example.hide();
          parent_id.val('');
        }
    }
</script>
<?= $this->end() ?>