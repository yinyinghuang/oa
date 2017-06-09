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
<div class="finances index large-10 medium-9 columns content">
		<div class="clearfix"></div>
		<table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="visible-lg visible-md"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= __('审批人') ?></th>
                <th scope="col"><?= $this->Paginator->sort('金额') ?></th>
                <th scope="col"><?= __('原因') ?></th>
                <th scope="col" class="visible-lg"><?= $this->Paginator->sort('创建时间') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($financeApplies as $financeApply): ?>
            <tr>
                <td class="visible-lg visible-md"><?= $this->Number->format($financeApply->id) ?></td>
                <td><?= $financeApply->user['username'] ?></td>
                <td><?= $this->Number->format($financeApply->amount) ?></td>
                <td><?= h($financeApply->content) ?></td>
                <td class="visible-lg"><?= h($financeApply->created) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('提醒'), ['controller' => 'Tasks', 'action' => 'remind', $financeApply->task_id]) ?>
                    <?= $this->Form->postLink(__('删除'), ['controller' => 'FinanceApplies', 'action' => 'delete', $financeApply->id], ['confirm' => __('Are you sure you want to delete # {0}?', $financeApply->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
		
    <div class="row">
    	<div class="col-md-12 col-sm-12 col-xs-12">
    		<div class="x_panel">
    			<div class="x_title">
    				<h2>申请经费<small></small></h2>
    				<ul class="nav navbar-right panel_toolbox"></ul>
    				<div class="clearfix"></div>
    			</div>	    	
		    	<div class="x_content">
		    		
		    		<form action="<?= $this->Url->build(['controller' => 'FinanceApplies', 'action' => 'add'])?>" method="post" class="form-horizontal group-border-dashed">
		    			<input type="hidden" name="approver" id="approver">
		    			<input type="hidden" name="user_id" value="<?= $this->request->session()->read('Auth')['User']['id'] ?>">
		    			<div class="form-group required">
		    				<label class="control-label col-md-3 col-sm-3 col-xs-12">审批人</label>
		    				<div class="col-md-6 col-sm-6 col-xs-12"><input type="text" required id="auto"></div>
		    			</div>
		    			<div class="form-group required">
		    				<label class="control-label col-md-3 col-sm-3 col-xs-12">申请金额</label>
		    				<div class="col-md-6 col-sm-6 col-xs-12"><input type="number" required name="amount"></div>
		    			</div>
              <div class="form-group required">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">申请原因</label>
                <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" required name="content"></div>
              </div>
		    			<div class="form-group">
		    				<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"><button class="btn btn-primary" id="submit">提交</button></div>		    				
		    			</div>
		    		</form>
		    	</div>
	    	</div>
    	</div>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
  $('#submit').on('click',function(){
  	if($('#approver').val() == ''){
  		new PNotify({
  		    title: '錯誤',
  		    text: '请正确填写审批人',
  		    type: 'error',
  		    styling: 'bootstrap3',
  		    delay: 3000,
  		    width:'280px'
  		});
  		return false;
  	}
  });
  var url = window.location.origin + '/finances/get-users/?list=<?= $approverList ?>';
  $('#auto').autocomplete({
    serviceUrl: url,
    onSelect: function(suggestion) {
        $('#approver').val(suggestion.data);
        $(this).val(suggestion.value);
    },
    onInvalidateSelection: function() {
      $(this).val('');
      $('#approver').val('');
    }
  });
	

</script> 
<?= $this->end() ?>