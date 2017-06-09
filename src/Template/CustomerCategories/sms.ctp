<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('发送记录'), ['controller' => 'SmsDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('短信模板'), ['controller' => 'SmsTemplates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('客户分类列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customers form large-10 medium-9 columns content">
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>发送短信 <small></small></h2>
          <ul class="nav navbar-right panel_toolbox">
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <br />
          <?php echo $this->Form->create('Application', array('class' => 'form-horizontal group-border-dashed', 'type' => 'file')); ?>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">选择分类</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php  
                    echo $this->Form->control('customer_category_id', ['type' => 'hidden', 'id' => 'parent-id','value' => $id]);
                    foreach ($customerCategories as $value) {
                        echo $this->Form->select('customer_category', $value->options , ['empty' => '请选择', 'class' => 'parent_id','default' => $value->id]);
                    }
                  ?>
              </div>
            </div>
            <div class="form-group required">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">选择模板</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              	  <input type="hidden" name="sms_template_id" id="sms-template-id" value="<?= $smsTemplate ? $smsTemplate->id : ''?>">
                  <input type="text" id="sms-template" value="<?= $smsTemplate ? $smsTemplate->name : ''?>">
              </div>
            </div>
            <div class="form-group" id="content-fields" <?php if (!$smsTemplate): ?>style="display: none;"<?php endif ?>>
            	<label class="control-label col-md-3 col-sm-3 col-xs-12">模板内容</label>
				<div class="col-md-6 col-sm-6 col-xs-12"><div class="form-control" id="content" style="height: auto;word-break: break-all;"><?= $smsTemplate ? $smsTemplate->content : ''?></div></div>
				<?php if ($smsTemplate): ?>
					<?php if ($smsTemplate->count > 70): ?>
						<div class="col-md-3 col-sm-3 col-xs-12" id="count" <?php if ($smsTemplate->count > 70): ?>style="color: red;"<?php endif ?> >总共<?= $smsTemplate->count?>字，短信条数<?= ceil($smsTemplate->count/70) ?>条</div>
					<?php else: ?>
						<div class="col-md-3 col-sm-3 col-xs-12" id="count">总共<?= $smsTemplate->count ?>字</div>
					<?php endif ?>	
				<?php else: ?>
					<div class="col-md-3 col-sm-3 col-xs-12" id="count"></div>
				<?php endif ?>
            </div> 
            <div id="variables-fields">
            <?php if ($smsTemplate): ?>
            	<?php foreach ($smsTemplate->variables as $variable): ?>
            		<div class="form-group required">
            		  <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $variable?></label>
            		  <div class="col-md-6 col-sm-6 col-xs-12">
            		  	  <input type="text" name="<?= $variable?>" onBlur="refresh(this)" maxlength="15">
            		  </div>
            		</div>
            	<?php endforeach ?>
            <?php endif ?>
            	
            </div>
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="submit" id="submit">发送</button>
                </div>
            </div>             
          <?php echo $this->Form->end(); ?> 
        </div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
    	var url = window.location.origin + '/sms-templates/get-templates/';
    	$('#sms-template').autocomplete({
    	  serviceUrl: url,
    	  onSelect: function(suggestion) {
    	      $('#sms-template-id').val(suggestion.data);
    	      var content = $('#content'),
    	      	  html = '';
    	      suggestion.variables.forEach(function(value){
    	      	html += '<div class="form-group required"><label class="control-label col-md-3 col-sm-3 col-xs-12">' + value + '</label><div class="col-md-6 col-sm-6 col-xs-12"><input type="text" name="' + value + '" required onBlur="refresh(this)" maxlength="15"></div></div>';
    	      });
    	      content.html(suggestion.content).parent('div');
    	      $('#content-fields').slideDown();
    	      $('#count').text('总共' + content.text().length + '字');
    	      $('#variables-fields').html(html);
    	  },
    	  onInvalidateSelection: function() {
    	      $('#sms-template-id').val('');
    	      $('#variables-fields').html('');
    	      $('#content-fields').hide();
    	  }
    	});
        $('.parent_id').on('change', function(){
        	loadChilds(this);
        });
        $('#submit').on('click', function(){
        	var flag = true;
          if($('#parent-id').val() == 0) {
            new PNotify({
                title: '錯誤',
                text: '请选择客户类型',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
            flag = false;
          }
          if($('#sms-template-id').val() == 0) {
            new PNotify({
                title: '錯誤',
                text: '请正确选择模板',
                type: 'error',
                styling: 'bootstrap3',
                delay: 3000,
                width:'280px'
            });
            flag = false;
          }
          if(!flag) return false;
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
                        var html = '<select class="parent_id"><option value="" onChang(this)>请选择</option>';
                        for (var i in data.child) {
                            html += '<option value="' + i + '">' + data.child[i] + '</option>';
                        }
                        html += '</select>';
                        html = $(html);
                        $(that).after(html);                            
                    }
                }
            });
        }else{
          a.href = a.text = '';
          example.hide();
          parent_id.val('');
        }
    }

    function refresh(node) {
    	if (node.value != '') {
    		var content = $('#content'),
    			variable = $('#variable-' + node.name),
    			count = $('#count');

    		variable.text(node.value);
    		var len = content.text().length;
    		if( len> 70) {
    			count.text('总共' + len + '字,短信条数' + Math.ceil(len/70) +'条').css('color','red');
    		} else{
    			count.text('总共' + len + '字');
    		}
    	}

    }
</script>
<?= $this->end() ?>